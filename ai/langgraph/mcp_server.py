import json
import logging
import re
from typing import Optional

from mcp.server.fastmcp import FastMCP
from db_connection import get_connection


# ============================================================
# LOGGING
# ============================================================

logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s [MCP] %(message)s",
)

log = logging.getLogger("mysql_mcp_server")


# ============================================================
# MCP SERVER
# ============================================================

mcp = FastMCP("mysql-company-db")


# ============================================================
# CONFIGURATION
# ============================================================

MAX_ROWS = 500
DEFAULT_ROWS = 20

# Only expose these tables to the AI.
# Add more tables here when needed.
ALLOWED_TABLES = {
    "company_data",
}

# Columns that Qwen is allowed to search/return.
# This prevents accidental access to columns you don't want
# exposed through the MCP server.
COMPANY_COLUMNS = {
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
}


# ============================================================
# SQL SAFETY
# ============================================================

FORBIDDEN_PATTERN = re.compile(
    r"""
    \b(
        insert|
        update|
        delete|
        drop|
        alter|
        truncate|
        create|
        replace|
        grant|
        revoke|
        into|
        outfile|
        dumpfile|
        load_file|
        information_schema|
        performance_schema|
        mysql|
        sys|
        sleep|
        benchmark
    )\b
    """,
    re.IGNORECASE | re.VERBOSE,
)

MULTI_STATEMENT_PATTERN = re.compile(r";\s*\S+", re.IGNORECASE)

DANGEROUS_COMMENT_PATTERN = re.compile(
    r"(--|/\*|\*/|#)",
    re.IGNORECASE,
)


def _validate_limit(limit: int) -> int:
    """
    Keep result size under control.
    """
    try:
        limit = int(limit)
    except (TypeError, ValueError):
        limit = DEFAULT_ROWS

    if limit < 1:
        limit = 1

    if limit > MAX_ROWS:
        limit = MAX_ROWS

    return limit


def _enforce_select_only(query: str) -> str:
    """
    Validate a SQL query before execution.

    This is an additional application-level safety layer.
    The actual database user should ALSO have SELECT-only
    permissions.
    """

    if not isinstance(query, str):
        raise ValueError("Query must be a string.")

    clean = query.strip()

    if not clean:
        raise ValueError("Query cannot be empty.")

    # Remove one trailing semicolon.
    clean = clean.rstrip(";").strip()

    # Must begin with SELECT.
    if not re.match(r"^select\b", clean, re.IGNORECASE):
        raise ValueError("Only SELECT queries are allowed.")

    # Block multiple statements.
    if MULTI_STATEMENT_PATTERN.search(clean):
        raise ValueError("Multiple SQL statements are not allowed.")

    # Block dangerous SQL keywords.
    if FORBIDDEN_PATTERN.search(clean):
        raise ValueError("Unsafe SQL query blocked.")

    # Block comments.
    if DANGEROUS_COMMENT_PATTERN.search(clean):
        raise ValueError("SQL comments are not allowed.")

    # Basic protection against SELECT ... FOR UPDATE.
    if re.search(r"\bfor\s+update\b", clean, re.IGNORECASE):
        raise ValueError("FOR UPDATE is not allowed.")

    return clean


def _add_safe_limit(query: str, limit: int = MAX_ROWS) -> str:
    """
    Add a maximum LIMIT.

    If the query already contains LIMIT, replace it with our
    maximum allowed limit rather than trusting the model.
    """

    limit = _validate_limit(limit)

    # Replace existing LIMIT.
    query = re.sub(
        r"\blimit\s+\d+(\s*,\s*\d+)?\s*$",
        f"LIMIT {limit}",
        query,
        flags=re.IGNORECASE,
    )

    # Add LIMIT if absent.
    if not re.search(r"\blimit\b", query, re.IGNORECASE):
        query = f"{query} LIMIT {limit}"

    return query


# ============================================================
# DATABASE HELPERS
# ============================================================

def _get_connection():
    """
    Get a database connection.

    Your existing db_connection.py should provide:

        def get_connection():
            ...
    """
    return get_connection()


def _close_database(db, cursor):
    """
    Safely close cursor and connection.
    """

    try:
        if cursor is not None:
            cursor.close()
    except Exception:
        pass

    try:
        if db is not None:
            db.close()
    except Exception:
        pass


# ============================================================
# TOOL 1: LIST TABLES
# ============================================================

@mcp.tool()
def list_tables() -> str:
    """
    List database tables that are available to the AI.

    Use this before querying an unfamiliar database.
    """

    return json.dumps(
        {
            "tables": sorted(ALLOWED_TABLES)
        },
        ensure_ascii=False,
    )


# ============================================================
# TOOL 2: DESCRIBE TABLE
# ============================================================

@mcp.tool()
def describe_table(table_name: str) -> str:
    """
    Describe an allowed database table.

    Returns column names, data types, NULL information,
    keys and default values.
    """

    if not isinstance(table_name, str):
        return json.dumps({
            "error": "table_name must be a string."
        })

    table_name = table_name.strip()

    if table_name not in ALLOWED_TABLES:
        return json.dumps({
            "error": f"Table '{table_name}' is not available."
        })

    db = None
    cursor = None

    try:
        db = _get_connection()

        cursor = db.cursor(dictionary=True)

        # table_name has already been checked against the
        # hard-coded allow-list.
        cursor.execute(
            f"DESCRIBE `{table_name}`"
        )

        rows = cursor.fetchall()

        return json.dumps(
            rows,
            default=str,
            ensure_ascii=False,
        )

    except Exception as e:
        log.exception("DESCRIBE TABLE ERROR")

        return json.dumps({
            "error": str(e)
        })

    finally:
        _close_database(db, cursor)


# ============================================================
# TOOL 3: SCHEMA OVERVIEW
# ============================================================

@mcp.tool()
def describe_schema() -> str:
    """
    Return a compact overview of the available database schema.

    Useful for an AI model before generating SQL.
    """

    db = None
    cursor = None

    try:
        db = _get_connection()
        cursor = db.cursor(dictionary=True)

        schema = {}

        for table_name in sorted(ALLOWED_TABLES):

            cursor.execute(
                f"DESCRIBE `{table_name}`"
            )

            columns = cursor.fetchall()

            schema[table_name] = [
                {
                    "name": row["Field"],
                    "type": row["Type"],
                    "nullable": row["Null"],
                    "key": row["Key"],
                }
                for row in columns
                if row["Field"] in COMPANY_COLUMNS
            ]

        return json.dumps(
            schema,
            default=str,
            ensure_ascii=False,
        )

    except Exception as e:
        log.exception("SCHEMA ERROR")

        return json.dumps({
            "error": str(e)
        })

    finally:
        _close_database(db, cursor)


# ============================================================
# TOOL 4: SEARCH COMPANIES
# ============================================================

@mcp.tool()
def search_companies(
    company_name: Optional[str] = None,
    city: Optional[str] = None,
    state: Optional[str] = None,
    country: Optional[str] = None,
    category: Optional[str] = None,
    subcategory: Optional[str] = None,
    active_only: bool = True,
    min_staff: Optional[int] = None,
    max_staff: Optional[int] = None,
    limit: int = DEFAULT_ROWS,
) -> str:
    """
    Search companies using structured filters.

    This is the preferred tool for normal company searches.

    Examples:

    Search Bangalore companies:
        city="Bangalore"

    Search manufacturing companies in Karnataka:
        state="Karnataka"
        category="Manufacturing"

    Search companies with more than 100 employees:
        min_staff=100

    Search by company name:
        company_name="ABC"

    Results are limited to 500 rows.
    """

    limit = _validate_limit(limit)

    conditions = []
    params = []

    # --------------------------------------------------------
    # Company name
    # --------------------------------------------------------

    if company_name:
        company_name = company_name.strip()

        if company_name:
            conditions.append(
                "company_name LIKE %s"
            )

            params.append(
                f"%{company_name}%"
            )

    # --------------------------------------------------------
    # City
    # --------------------------------------------------------

    if city:
        city = city.strip()

        if city:
            conditions.append(
                "city LIKE %s"
            )

            params.append(
                f"%{city}%"
            )

    # --------------------------------------------------------
    # State
    # --------------------------------------------------------

    if state:
        state = state.strip()

        if state:
            conditions.append(
                "state LIKE %s"
            )

            params.append(
                f"%{state}%"
            )

    # --------------------------------------------------------
    # Country
    # --------------------------------------------------------

    if country:
        country = country.strip()

        if country:
            conditions.append(
                "country LIKE %s"
            )

            params.append(
                f"%{country}%"
            )

    # --------------------------------------------------------
    # Category
    # --------------------------------------------------------

    if category:
        category = category.strip()

        if category:
            conditions.append(
                "category LIKE %s"
            )

            params.append(
                f"%{category}%"
            )

    # --------------------------------------------------------
    # Subcategory
    # --------------------------------------------------------

    if subcategory:
        subcategory = subcategory.strip()

        if subcategory:
            conditions.append(
                "subcategory LIKE %s"
            )

            params.append(
                f"%{subcategory}%"
            )

    # --------------------------------------------------------
    # Active companies
    # --------------------------------------------------------

    if active_only:
        conditions.append(
            "active_inactive = %s"
        )

        params.append("Active")

    # --------------------------------------------------------
    # Minimum staff
    # --------------------------------------------------------

    if min_staff is not None:

        try:
            min_staff = int(min_staff)

            if min_staff < 0:
                raise ValueError

        except (TypeError, ValueError):
            return json.dumps({
                "error": "min_staff must be a non-negative integer."
            })

        conditions.append(
            "total_staff >= %s"
        )

        params.append(min_staff)

    # --------------------------------------------------------
    # Maximum staff
    # --------------------------------------------------------

    if max_staff is not None:

        try:
            max_staff = int(max_staff)

            if max_staff < 0:
                raise ValueError

        except (TypeError, ValueError):
            return json.dumps({
                "error": "max_staff must be a non-negative integer."
            })

        conditions.append(
            "total_staff <= %s"
        )

        params.append(max_staff)

    # --------------------------------------------------------
    # Build query
    # --------------------------------------------------------

    query = """
        SELECT
            id,
            company_id,
            company_name,
            category,
            subcategory,
            address,
            city,
            pincode,
            state,
            country,
            website,
            phone,
            gst_number,
            sales_person,
            active_inactive,
            total_staff,
            branch_offices,
            created_at,
            updated_at
        FROM company_data
    """

    if conditions:
        query += "\nWHERE " + "\nAND ".join(conditions)

    query += "\nORDER BY company_name ASC"

    query += f"\nLIMIT {limit}"

    log.info(
        "SEARCH COMPANIES | filters=%s | limit=%d",
        conditions,
        limit,
    )

    db = None
    cursor = None

    try:

        db = _get_connection()

        cursor = db.cursor(dictionary=True)

        cursor.execute(
            query,
            tuple(params),
        )

        rows = cursor.fetchall()

        log.info(
            "SEARCH RESULT | rows=%d",
            len(rows),
        )

        return json.dumps(
            {
                "count": len(rows),
                "results": rows,
            },
            default=str,
            ensure_ascii=False,
        )

    except Exception as e:

        log.exception(
            "SEARCH COMPANIES ERROR"
        )

        return json.dumps({
            "error": str(e)
        })

    finally:

        _close_database(
            db,
            cursor,
        )


# ============================================================
# TOOL 5: GENERIC READ-ONLY SQL
# ============================================================

@mcp.tool()
def run_select_query(
    query: str,
    limit: int = MAX_ROWS,
) -> str:
    """
    Execute a read-only SELECT query.

    Use search_companies() for normal company searches.

    Use this tool only when a custom SQL query is required,
    such as aggregation, grouping, counting or advanced
    filtering.

    Only SELECT statements are allowed.
    Results are forcibly limited to 500 rows.
    """

    try:

        safe_query = _enforce_select_only(
            query
        )

        safe_query = _add_safe_limit(
            safe_query,
            limit,
        )

    except ValueError as e:

        log.warning(
            "QUERY REJECTED | query=%s | reason=%s",
            query,
            e,
        )

        return json.dumps({
            "error": str(e)
        })

    log.info(
        "EXECUTING SQL: %s",
        safe_query,
    )

    db = None
    cursor = None

    try:

        db = _get_connection()

        cursor = db.cursor(
            dictionary=True
        )

        cursor.execute(
            safe_query
        )

        rows = cursor.fetchall()

        log.info(
            "ROWS RETURNED: %d",
            len(rows),
        )

        return json.dumps(
            {
                "count": len(rows),
                "results": rows,
            },
            default=str,
            ensure_ascii=False,
        )

    except Exception as e:

        log.exception(
            "DATABASE ERROR"
        )

        return json.dumps({
            "error": str(e)
        })

    finally:

        _close_database(
            db,
            cursor,
        )


# ============================================================
# SERVER START
# ============================================================

if __name__ == "__main__":

    log.info(
        "Starting MySQL Company MCP Server..."
    )

    mcp.run(
        transport="stdio"
    )
