from db_connection import get_connection


def count_companies():
    """
    Return the total number of companies.
    """

    conn = get_connection()

    try:
        cursor = conn.cursor()

        cursor.execute(
            "SELECT COUNT(*) FROM company_data"
        )

        result = cursor.fetchone()

        return result[0]

    finally:
        cursor.close()
        conn.close()
