# ============================================================
# MCP SERVER: mysql-company-db
#
# Exposes the company_data MySQL table to any MCP client
# (LangGraph agent, Claude Desktop, etc.) as a small set of
# safe, read-only tools.
#
# Run standalone for testing:
#   python mcp_mysql_server.py
#
# In production it is spawned automatically by the LangGraph
# agent (ishan_agent.py) over stdio — you normally don't run
# this file directly.
# ============================================================

import json
import logging
import re

from mcp.server.fastmcp import FastMCP

from db_connection import get_connection

logging.basicConfig(level=logging.INFO, format="%(asctime)s [MCP] %(message)s")
log = logging.getLogger("mysql_mcp_server")

mcp = FastMCP("mysql-company-db")

SQL_ROW_LIMIT = 500

FORBIDDEN_PATTERN = re.compile(
    r"\b(insert|update|delete|drop|alter|truncate|create|replace|grant|revoke|"
    r"into|outfile|load_file|information_schema)\b",
    re.IGNORECASE,
)
MULTI_STATEMENT_PATTERN = re.compile(r";\s*\S")  # semicolon followed by more code = stacked query

TABLE_SCHEMA = {
    "company_data": [
        "id", "company_id", "database_name", "company_name", "category",
        "subcategory", "address", "city", "pincode", "state", "country",
        "website", "phone", "gst_number", "sales_person", "active_inactive",
        "created_at", "updated_at", "last_confirmed_at", "entry_type", "pin",
        "travel_segments", "meet_profiles", "meet_regions", "interested_states",
        "branch_offices", "total_staff", "association_membership",
    ]
}


def _enforce_select_only(query: str) -> str:
    clean = query.strip().rstrip(";").strip()

    if not clean.lower().startswith("select"):
        raise ValueError("Only SELECT queries are allowed.")

    if MULTI_STATEMENT_PATTERN.search(clean):
        raise ValueError("Stacked/multiple statements are not allowed.")

    if FORBIDDEN_PATTERN.search(clean):
        raise ValueError("Unsafe SQL query blocked.")

    if not re.search(r"\blimit\b", clean, re.IGNORECASE):
        clean = f"{clean} LIMIT {SQL_ROW_LIMIT}"

    return clean


@mcp.tool()
def describe_schema() -> str:
    """
    Return the available table(s) and column names in the company
    database. Call this first if you are unsure what columns exist.
    """
    return json.dumps(TABLE_SCHEMA)


@mcp.tool()
def run_select_query(query: str) -> str:
    """
    Execute a read-only SQL SELECT query against the company database
    and return the matching rows as JSON.

    Rules:
    - Only SELECT statements are allowed (no INSERT/UPDATE/DELETE/DROP/etc).
    - Only one statement per call (no ';' stacked queries).
    - Results are capped at 500 rows; add your own LIMIT/aggregation
      (COUNT, SUM, etc.) if you only need a summary number.

    Returns a JSON array of row objects, e.g. [{"total_companies": 40000}].
    Returns a JSON object with an "error" key if the query is rejected
    or fails.
    """
    try:
        safe_query = _enforce_select_only(query)
    except ValueError as e:
        log.warning("QUERY REJECTED: %s | %s", query, e)
        return json.dumps({"error": str(e)})

    log.info("EXECUTING SQL: %s", safe_query)

    db = None
    cursor = None
    try:
        db = get_connection()
        cursor = db.cursor(dictionary=True)
        cursor.execute(safe_query)
        rows = cursor.fetchall()

        log.info("ROWS RETURNED: %d", len(rows))
        log.info("QUERY RESULT: %s", json.dumps(rows, default=str, indent=2))

        return json.dumps(rows, default=str)

    except Exception as e:
        log.error("DATABASE ERROR: %s", e)
        return json.dumps({"error": str(e)})

    finally:
        if cursor:
            cursor.close()
        if db:
            db.close()


if __name__ == "__main__":
    log.info("Starting MCP server 'mysql-company-db' over stdio...")
    mcp.run(transport="stdio")