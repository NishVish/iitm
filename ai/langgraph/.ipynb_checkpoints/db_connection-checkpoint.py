import mysql.connector


DB_CONFIG = {
    "host": "localhost",
    "port": 3306,
    "user": "root",
    "password": "",
    "database": "iitminda_testing_server"
}


def get_connection():
    return mysql.connector.connect(**DB_CONFIG)
