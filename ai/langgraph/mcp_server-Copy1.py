import json
import logging
import re

from mcp.server.fastmcp import FastMCP
from db_connection import get_connection

logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s [MCP] %(message)s",
)

log = logging.getLogger("mysql_mcp_server")

mcp = FastMCP("mysql-company-db")

SQL_ROW_LIMIT = 500

FORBIDDEN_PATTERN = re.compile(
    r"\b(insert|update|delete|drop|alter|truncate|create|replace|"
    r"grant|revoke|into|outfile|load_file|information_schema)\b",
    re.IGNORECASE,
)

MULTI_STATEMENT_PATTERN = re.compile(r";\s*\S", re.IGNORECASE)

TABLE_SCHEMA = {
    "company_data": [
        "id",
        "company_id",
        "database_name",
        "company_name",
        "category",
        "subcategory",
        "address",
        "city",
        "pincode",
        "state",
        "country",
        "website",
        "phone",
        "gst_number",
        "sales_person",
        "active_inactive",
        "created_at",
        "updated_at",
        "last_confirmed_at",
        "entry_type",
        "pin",
        "travel_segments",
        "meet_profiles",
        "meet_regions",
        "interested_states",
        "branch_offices",
        "total_staff",
        "association_membership",
    ]
}


def _enforce_select_only(query: str) -> str:
    if not isinstance(query, str):
        raise ValueError("Query must be a string.")

    clean = query.strip().rstrip(";").strip()

    if not clean:
        raise ValueError("Query cannot be empty.")

    if not clean.lower().startswith("select"):
        raise ValueError("Only SELECT queries are allowed.")

    if MULTI_STATEMENT_PATTERN.search(clean):
        raise ValueError("Multiple SQL statements are not allowed.")

    if FORBIDDEN_PATTERN.search(clean):
        raise ValueError("Unsafe SQL query blocked.")

    if not re.search(r"\blimit\b", clean, re.IGNORECASE):
        clean = f"{clean} LIMIT {SQL_ROW_LIMIT}"

    return clean


@mcp.tool()
def describe_schema() -> str:
    """
    Return available database tables and columns.
    """
    return json.dumps(TABLE_SCHEMA)


@mcp.tool()
def run_select_query(query: str) -> str:
    """
    Execute a read-only SELECT query against the company database.

    Only SELECT statements are allowed.
    Results are limited to 500 rows unless the query contains LIMIT.
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

        return json.dumps(rows, default=str)

    except Exception as e:
        log.exception("DATABASE ERROR")

        return json.dumps({
            "error": str(e)
        })

    finally:
        if cursor is not None:
            cursor.close()

        if db is not None:
            db.close()


if __name__ == "__main__":
    mcp.run(transport="stdio")
