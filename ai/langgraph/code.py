
import json
import logging
import re
import time
import requests

from db_connection import get_connection


# ============================================================
# SYSTEM PROMPTS
# ============================================================

SYSTEM_PROMPT = """
You are Ishan Agent.

You have access to a MySQL business database.

Your job is to understand the user's request.

If the user asks for information that must come from the
database, generate a SQL SELECT query.

Return ONLY valid JSON, with no markdown fences and no extra text.

For a database request:

{"action": "sql", "query": "SELECT ..."}

For a normal conversation request:

{"action": "answer", "response": "..."}

DATABASE:

Table: company_data

Columns:
id, company_id, database_name, company_name, category, subcategory,
address, city, pincode, state, country, website, phone, gst_number,
sales_person, active_inactive, created_at, updated_at, last_confirmed_at,
entry_type, pin, travel_segments, meet_profiles, meet_regions,
interested_states, branch_offices, total_staff, association_membership

RULES:

- Database questions require SQL.
- Only generate SELECT queries. Never INSERT/UPDATE/DELETE/DROP/ALTER/TRUNCATE.
- Never invent database results — only use what the database returns to you later.
- Use the actual table and column names.
- Return JSON only.

Example:

User: total number of companies in our database
Return: {"action": "sql", "query": "SELECT COUNT(*) AS total_companies FROM company_data"}
"""

FINAL_ANSWER_SYSTEM_PROMPT = """
You are Ishan Agent speaking directly to a business user.

You will be given the user's original question and the exact data
returned from the database for that question.

Answer in plain, natural English — a normal sentence, not JSON, not
markdown, not code. Do not mention SQL, JSON, tables, columns, or
the database. Do not invent any numbers or facts not present in the
data you were given. If the data is an empty list, say plainly that
no matching records were found.
"""

FORBIDDEN_PATTERN = re.compile(
    r"\b(insert|update|delete|drop|alter|truncate|create|replace|grant|revoke|"
    r"into|outfile|load_file|information_schema)\b",
    re.IGNORECASE,
)
MULTI_STATEMENT_PATTERN = re.compile(r";\s*\S")


# ============================================================
# CALL QWEN
# ============================================================

def ask_qwen(messages):
    response = _session.post(
        OLLAMA_URL,
        json={
            "model": MODEL,
            "messages": messages,
            "stream": False,
            "options": {"temperature": 0},
        },
        timeout=OLLAMA_TIMEOUT_SECONDS,
    )
    print('messages')
    response.raise_for_status()
    return response.json()["message"]["content"].strip()


def extract_json(raw_text):
    text = raw_text.strip()

    fence_match = re.search(r"```(?:json)?\s*(.*?)\s*```", text, re.DOTALL)
    if fence_match:
        text = fence_match.group(1).strip()

    try:
        return json.loads(text)
    except json.JSONDecodeError:
        pass

    brace_match = re.search(r"\{.*\}", text, re.DOTALL)
    if brace_match:
        return json.loads(brace_match.group(0))

    raise ValueError(f"Could not parse JSON from model output: {raw_text!r}")


def unwrap_if_json(text):
    stripped = text.strip()
    if not stripped.startswith("{"):
        return text

    try:
        parsed = extract_json(stripped)
    except (ValueError, json.JSONDecodeError):
        return text

    if isinstance(parsed, dict):
        for key in ("response", "answer", "message"):
            if key in parsed and isinstance(parsed[key], str):
                return parsed[key]

    return text


# ============================================================
# SQL SAFETY + EXECUTION
# ============================================================

def enforce_select_only(query):
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


def execute_sql(query):
    safe_query = enforce_select_only(query)

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
        return rows, safe_query
    finally:
        if cursor:
            cursor.close()
        if db:
            db.close()

