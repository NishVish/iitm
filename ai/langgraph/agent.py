import asyncio
import logging
import threading
import time
from pathlib import Path

from flask import Flask, request, jsonify
from langchain_core.messages import AIMessage, HumanMessage, ToolMessage
from langchain_mcp_adapters.client import MultiServerMCPClient
from langchain_ollama import ChatOllama
from langgraph.prebuilt import create_react_agent


# ============================================================
# FLASK
# ============================================================

app = Flask(__name__)


# ============================================================
# CONFIG
# ============================================================

MODEL = "qwen2.5:7b"
OLLAMA_BASE_URL = "http://127.0.0.1:11434"

MCP_SERVER_PATH = Path(__file__).resolve().parent / "mcp_server.py"

SIMPLE_CACHE_TTL_SECONDS = 20


# ============================================================
# LOGGING
# ============================================================

logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s [%(levelname)s] %(message)s",
)

log = logging.getLogger("ishan_agent")


# ============================================================
# SYSTEM PROMPT
# ============================================================

SYSTEM_PROMPT = """
You are Ishan Agent, a helpful business data assistant.

You have access to a MySQL company database through MCP tools.

Available tools may include:
- describe_schema
- run_select_query
- list_tables
- describe_table
- search_companies

IMPORTANT DATABASE RULES:

1. Use database tools whenever the user's question requires
   company/business database information.

2. Never guess database numbers.

3. Never assume a table name exists.

4. If you do not know which table contains the required data,
   first use list_tables, describe_schema, or describe_table.

5. For counting, grouping, aggregation, DISTINCT counts,
   filtering, or advanced database questions, use
   run_select_query.

6. For normal company searches, prefer search_companies.

7. If a SQL query fails because a table or column does not
   exist, inspect the schema and retry using the correct
   table/column.

8. Only perform read-only database operations.

9. Never invent information.

ANSWER RULES:

- Answer in plain natural English.
- Never show SQL.
- Never show JSON.
- Never mention MCP.
- Never mention internal tool names.
- Never expose internal implementation details.
- For simple count questions, give the count directly.
- If no records are found, clearly say that no matching
  records were found.
"""


# ============================================================
# PERSISTENT ASYNC EVENT LOOP
# ============================================================
#
# IMPORTANT:
#
# We do NOT use asyncio.run() for every operation.
#
# The MCP client, LangGraph agent, Ollama client and their
# underlying httpx connections all live on ONE persistent
# asyncio event loop.
#
# This avoids:
#
# RuntimeError: Event loop is closed
#
# on Windows / Python 3.10.
# ============================================================

_async_loop = None
_async_thread = None
_async_ready = threading.Event()
_async_start_lock = threading.Lock()


def _async_loop_worker():
    """
    Runs one permanent asyncio event loop in a background thread.
    """

    global _async_loop

    loop = asyncio.new_event_loop()

    asyncio.set_event_loop(loop)

    _async_loop = loop

    log.info(
        "ASYNC EVENT LOOP STARTED: %s",
        threading.current_thread().name,
    )

    _async_ready.set()

    try:
        loop.run_forever()

    finally:
        log.info("ASYNC EVENT LOOP STOPPING")

        pending = asyncio.all_tasks(loop)

        if pending:
            log.info(
                "CANCELLING %d PENDING ASYNC TASK(S)",
                len(pending),
            )

            for task in pending:
                task.cancel()

            loop.run_until_complete(
                asyncio.gather(
                    *pending,
                    return_exceptions=True,
                )
            )

        loop.run_until_complete(
            loop.shutdown_asyncgens()
        )

        loop.close()

        log.info("ASYNC EVENT LOOP CLOSED")


def start_async_loop():
    """
    Start the permanent asyncio loop exactly once.
    """

    global _async_thread

    if (
        _async_loop is not None
        and _async_loop.is_running()
    ):
        return

    with _async_start_lock:

        if (
            _async_loop is not None
            and _async_loop.is_running()
        ):
            return

        _async_ready.clear()

        _async_thread = threading.Thread(
            target=_async_loop_worker,
            name="IshanAsyncLoop",
            daemon=True,
        )

        _async_thread.start()

        if not _async_ready.wait(timeout=10):

            raise RuntimeError(
                "Failed to start asyncio event loop."
            )


def run_async(coro, timeout=None):
    """
    Execute a coroutine on the permanent asyncio event loop.

    Flask's synchronous request thread can safely call this.
    """

    start_async_loop()

    if _async_loop is None:
        raise RuntimeError(
            "Async event loop was not initialized."
        )

    if not _async_loop.is_running():
        raise RuntimeError(
            "Async event loop is not running."
        )

    future = asyncio.run_coroutine_threadsafe(
        coro,
        _async_loop,
    )

    return future.result(timeout=timeout)


# ============================================================
# CACHE
# ============================================================

_cache_lock = threading.Lock()

_response_cache = {}


# ============================================================
# MCP / AGENT
# ============================================================

_mcp_client = None
_agent_executor = None

_agent_initialized = False
_agent_init_lock = asyncio.Lock()


# ============================================================
# INITIALIZE AGENT
# ============================================================

async def init_agent():
    """
    Initialize MCP + Ollama + LangGraph.

    IMPORTANT:
    This function MUST execute on the permanent asyncio loop.
    """

    global _mcp_client
    global _agent_executor
    global _agent_initialized

    async with _agent_init_lock:

        if _agent_initialized:
            return

        log.info("=" * 60)
        log.info("INITIALIZING ISHAN AGENT")
        log.info("MCP SERVER: %s", MCP_SERVER_PATH)
        log.info("OLLAMA URL: %s", OLLAMA_BASE_URL)
        log.info("MODEL: %s", MODEL)
        log.info("=" * 60)

        if not MCP_SERVER_PATH.exists():

            raise FileNotFoundError(
                f"MCP server not found: {MCP_SERVER_PATH}"
            )

        # ----------------------------------------------------
        # MCP CLIENT
        # ----------------------------------------------------

        _mcp_client = MultiServerMCPClient(
            {
                "mysql-company-db": {
                    "command": "python",
                    "args": [
                        str(MCP_SERVER_PATH)
                    ],
                    "transport": "stdio",
                }
            }
        )

        tools = await _mcp_client.get_tools()

        log.info(
            "MCP TOOLS LOADED: %s",
            [tool.name for tool in tools],
        )

        # ----------------------------------------------------
        # OLLAMA
        # ----------------------------------------------------

        llm = ChatOllama(
            model=MODEL,
            base_url=OLLAMA_BASE_URL,
            temperature=0,
        )

        # ----------------------------------------------------
        # LANGGRAPH
        # ----------------------------------------------------

        _agent_executor = create_react_agent(
            llm,
            tools,
            prompt=SYSTEM_PROMPT,
        )

        _agent_initialized = True

        log.info("=" * 60)
        log.info("ISHAN AGENT READY")
        log.info("=" * 60)


# ============================================================
# RUN AGENT
# ============================================================

async def _run_agent_async(
    user_message: str,
) -> dict:

    await init_agent()

    log.info("=" * 60)
    log.info("USER INPUT: %s", user_message)
    log.info("=" * 60)

    result = await _agent_executor.ainvoke(
        {
            "messages": [
                HumanMessage(
                    content=user_message
                )
            ]
        }
    )

    messages = result.get(
        "messages",
        [],
    )

    tool_calls_used = []

    # --------------------------------------------------------
    # LOG TOOL CALLS
    # --------------------------------------------------------

    for msg in messages:

        if isinstance(msg, ToolMessage):

            tool_name = getattr(
                msg,
                "name",
                None,
            ) or "unknown"

            log.info(
                "MCP TOOL: %s",
                tool_name,
            )

            log.info(
                "TOOL RESULT: %s",
                msg.content,
            )

            tool_calls_used.append(
                {
                    "tool": tool_name,
                    "result": msg.content,
                }
            )

    # --------------------------------------------------------
    # FIND FINAL AI MESSAGE
    # --------------------------------------------------------

    final_message = None

    for msg in reversed(messages):

        if (
            isinstance(msg, AIMessage)
            and msg.content
        ):

            final_message = msg
            break

    if final_message is None:

        raise ValueError(
            "Agent finished without producing "
            "a final answer."
        )

    final_answer = final_message.content

    # --------------------------------------------------------
    # NORMALIZE STRUCTURED CONTENT
    # --------------------------------------------------------

    if isinstance(final_answer, list):

        text_parts = []

        for item in final_answer:

            if isinstance(item, dict):

                text = item.get(
                    "text",
                    "",
                )

                if text:
                    text_parts.append(
                        str(text)
                    )

            elif isinstance(item, str):

                text_parts.append(item)

        final_answer = " ".join(
            text_parts
        )

    final_answer = str(
        final_answer
    ).strip()

    if not final_answer:

        raise ValueError(
            "Agent returned an empty answer."
        )

    log.info(
        "ISHAN REPLY: %s",
        final_answer,
    )

    log.info("=" * 60)

    return {
        "response": final_answer,
        "tool_calls": tool_calls_used,
    }


def run_agent(user_message: str) -> dict:
    """
    Synchronous wrapper used by Flask.

    The actual async work happens on the permanent
    asyncio event loop.
    """

    return run_async(
        _run_agent_async(user_message),
        timeout=300,
    )


# ============================================================
# HTTP ENDPOINT
# ============================================================

@app.route(
    "/agent",
    methods=["POST"],
)
def agent():

    data = request.get_json(
        silent=True,
    )

    if not data:

        return jsonify(
            {
                "success": False,
                "error": "Invalid JSON request.",
            }
        ), 400

    if "message" not in data:

        return jsonify(
            {
                "success": False,
                "error": "message is required",
            }
        ), 400

    user_message = str(
        data["message"]
    ).strip()

    if not user_message:

        return jsonify(
            {
                "success": False,
                "error": "message cannot be empty",
            }
        ), 400

    debug = (
        request.args.get(
            "debug",
            "0",
        ) == "1"
    )

    cache_key = user_message.lower()

    log.info("=" * 60)
    log.info("HTTP REQUEST /agent")
    log.info("USER INPUT: %s", user_message)
    log.info("=" * 60)

    # --------------------------------------------------------
    # CACHE
    # --------------------------------------------------------

    with _cache_lock:

        cached = _response_cache.get(
            cache_key
        )

        if cached:

            timestamp, result = cached

            if (
                time.time() - timestamp
                < SIMPLE_CACHE_TTL_SECONDS
            ):

                log.info("CACHE HIT")

                payload = {
                    "success": True,
                    "response": result[
                        "response"
                    ],
                }

                if debug:

                    payload[
                        "tool_calls"
                    ] = result[
                        "tool_calls"
                    ]

                return jsonify(
                    payload
                )

            else:

                _response_cache.pop(
                    cache_key,
                    None,
                )

    # --------------------------------------------------------
    # RUN AGENT
    # --------------------------------------------------------

    try:

        result = run_agent(
            user_message
        )

        with _cache_lock:

            _response_cache[
                cache_key
            ] = (
                time.time(),
                result,
            )

        payload = {
            "success": True,
            "response": result[
                "response"
            ],
        }

        if debug:

            payload[
                "tool_calls"
            ] = result[
                "tool_calls"
            ]

        log.info(
            "HTTP RESPONSE SUCCESS"
        )

        return jsonify(
            payload
        )

    except Exception as e:

        log.exception(
            "AGENT ERROR"
        )

        return jsonify(
            {
                "success": False,
                "error": str(e),
            }
        ), 500


# ============================================================
# START SERVER
# ============================================================

if __name__ == "__main__":

    log.info("=" * 60)
    log.info("STARTING ISHAN AGENT")
    log.info("=" * 60)

    log.info(
        "MODEL  : %s",
        MODEL,
    )

    log.info(
        "OLLAMA : %s",
        OLLAMA_BASE_URL,
    )

    log.info(
        "MCP    : %s",
        MCP_SERVER_PATH,
    )

    log.info(
        "AGENT  : http://127.0.0.1:1234/agent",
    )

    log.info("=" * 60)

    # --------------------------------------------------------
    # Start ONE permanent asyncio loop.
    # --------------------------------------------------------

    start_async_loop()

    # --------------------------------------------------------
    # Initialize MCP + Ollama + LangGraph ON THAT LOOP.
    # --------------------------------------------------------

    run_async(
        init_agent(),
        timeout=120,
    )

    # --------------------------------------------------------
    # Start Flask.
    #
    # IMPORTANT:
    # use_reloader=False prevents Flask from starting a
    # second process/thread and creating duplicate MCP clients.
    # --------------------------------------------------------

    app.run(
        host="127.0.0.1",
        port=1234,
        debug=False,
        use_reloader=False,
        threaded=True,
    )
