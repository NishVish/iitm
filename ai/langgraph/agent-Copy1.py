import asyncio
import logging
import time
from pathlib import Path

from flask import Flask, request, jsonify
from langchain_core.messages import AIMessage, HumanMessage, ToolMessage
from langchain_mcp_adapters.client import MultiServerMCPClient
from langchain_ollama import ChatOllama
from langgraph.prebuilt import create_react_agent


app = Flask(__name__)

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
# CACHE
# ============================================================

_cache_lock = asyncio.Lock()
_response_cache = {}


# ============================================================
# SYSTEM PROMPT
# ============================================================

SYSTEM_PROMPT = """
You are Ishan Agent, a helpful business data assistant.

You have access to a MySQL company database through MCP tools.

Available tools include:
- describe_schema
- run_select_query
- list_tables
- describe_table
- search_companies

IMPORTANT:

Use the database tools whenever the user's question requires
company data.

Never guess database numbers.

For normal company searches, prefer search_companies.

Use describe_schema or describe_table when you need to
understand the database structure.

Use run_select_query for counting, grouping, aggregation,
or advanced queries.

Only perform read-only database operations.

When answering:

- Answer in plain natural English.
- Never show SQL.
- Never show JSON.
- Never mention MCP.
- Never mention internal tool names.
- Never invent information.
- If no records are found, clearly say that no matching records
  were found.
- For simple count questions, give the count directly.
"""


# ============================================================
# MCP CLIENT
# ============================================================

_mcp_client = MultiServerMCPClient(
    {
        "mysql-company-db": {
            "command": "python",
            "args": [str(MCP_SERVER_PATH)],
            "transport": "stdio",
        }
    }
)


_agent_executor = None


# ============================================================
# INITIALIZE AGENT
# ============================================================

async def init_agent():

    global _agent_executor

    log.info("=" * 60)
    log.info("INITIALIZING ISHAN AGENT")
    log.info("MCP SERVER: %s", MCP_SERVER_PATH)
    log.info("=" * 60)

    tools = await _mcp_client.get_tools()

    log.info(
        "MCP TOOLS LOADED: %s",
        [tool.name for tool in tools],
    )

    llm = ChatOllama(
        model=MODEL,
        base_url=OLLAMA_BASE_URL,
        temperature=0,
    )

    _agent_executor = create_react_agent(
        llm,
        tools,
        prompt=SYSTEM_PROMPT,
    )

    log.info("OLLAMA MODEL: %s", MODEL)
    log.info("AGENT READY")


# ============================================================
# RUN AGENT
# ============================================================

async def run_agent(user_message: str) -> dict:

    if _agent_executor is None:
        await init_agent()

    log.info("=" * 60)
    log.info("USER INPUT: %s", user_message)

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
        []
    )

    tool_calls_used = []

    # --------------------------------------------------------
    # Log tool calls
    # --------------------------------------------------------

    for msg in messages:

        if isinstance(msg, ToolMessage):

            tool_name = getattr(
                msg,
                "name",
                "unknown"
            )

            log.info(
                "MCP TOOL: %s",
                tool_name
            )

            log.info(
                "TOOL RESULT: %s",
                msg.content
            )

            tool_calls_used.append(
                {
                    "tool": tool_name,
                    "result": msg.content,
                }
            )

    # --------------------------------------------------------
    # Get final AI response
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
            "Agent finished without producing a final answer."
        )

    final_answer = final_message.content

    # Some LangChain versions can return structured content.
    if isinstance(final_answer, list):

        final_answer = " ".join(
            item.get("text", "")
            for item in final_answer
            if isinstance(item, dict)
        )

    final_answer = str(
        final_answer
    ).strip()

    log.info(
        "ISHAN REPLY: %s",
        final_answer
    )

    log.info("=" * 60)

    return {
        "response": final_answer,
        "tool_calls": tool_calls_used,
    }


# ============================================================
# HTTP ENDPOINT
# ============================================================

@app.route(
    "/agent",
    methods=["POST"]
)
async def agent():

    data = request.get_json(
        silent=True
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
            "0"
        ) == "1"
    )

    cache_key = user_message.lower()

    log.info(
        "HTTP REQUEST /agent"
    )

    log.info(
        "USER INPUT: %s",
        user_message
    )

    # --------------------------------------------------------
    # CACHE
    # --------------------------------------------------------

    async with _cache_lock:

        cached = _response_cache.get(
            cache_key
        )

        if cached:

            timestamp, result = cached

            if (
                time.time() - timestamp
                < SIMPLE_CACHE_TTL_SECONDS
            ):

                log.info(
                    "CACHE HIT"
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

                return jsonify(
                    payload
                )

    # --------------------------------------------------------
    # RUN AGENT
    # --------------------------------------------------------

    try:

        result = await run_agent(
            user_message
        )

        async with _cache_lock:

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

    asyncio.run(
        init_agent()
    )

    log.info("=" * 60)
    log.info(
        "ISHAN AGENT STARTED"
    )
    log.info(
        "MODEL  : %s",
        MODEL
    )
    log.info(
        "OLLAMA : %s",
        OLLAMA_BASE_URL
    )
    log.info(
        "MCP    : %s",
        MCP_SERVER_PATH
    )
    log.info(
        "AGENT  : http://127.0.0.1:1234/agent"
    )
    log.info("=" * 60)

    app.run(
        host="127.0.0.1",
        port=1234,
        debug=False,
        use_reloader=False,
    )
