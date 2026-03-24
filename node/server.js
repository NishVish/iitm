const express = require("express");
const mysql = require("mysql2");
const cors = require("cors"); // 1. Import CORS

const app = express();

// 2. USE CORS BEFORE ROUTES
// This tells the browser: "It's okay for port 3000 to talk to me"
app.use(cors());
app.use(express.json());

const dbConfig = {
    // host: "localhost",
    // user: "root",
    // password: "",
    // database: "testing_server"

    host: "21.157.66.148.host.secureserver.net",
    port: 3306,
    user: "iitminda_master",
    password: "gB)%gU}ocn?MCP=} ", // Double check if there's a space at the end!
    database: "iitminda_testing_server",


};
const db = mysql.createConnection(dbConfig);

db.connect((err) => {
    if (err) {
        console.error("❌ MySQL connection failed:", err.message);
    } else {
        console.log("✅ MySQL connected to:", dbConfig.database);
    }
});

// --- ROUTES ---

// 1. Root
app.get("/", (req, res) => {
    res.send("Server is alive! Try /api/db-info or /api/tables");
});

// 2. Database Info
app.get("/api/db-info", (req, res) => {
    res.json({
        database: dbConfig.database,
        user: dbConfig.user,
        status: db.threadId ? "Connected" : "Disconnected"
    });
});

// 3. Show Tables
app.get("/api/tables", (req, res) => {
    db.query("SHOW TABLES", (err, results) => {
        if (err) return res.status(500).json({ error: err.message });

        // This maps the complex object to a simple array of strings
        const tableNames = results.map(row => Object.values(row)[0]);

        res.json({
            database: "testing_server",
            total_tables: tableNames.length,
            tables: tableNames
        });
    });
});

// Helper to keep code DRY (Don't Repeat Yourself)
const runQuery = (sql, res) => {
    db.query(sql, (err, results) => {
        if (err) return res.status(500).json({ status: "error", error: err.message });
        res.json({
            status: "success",
            count: results.length,
            data: results
        });
    });
};

// Now your routes look like this:
app.get("/api/events", (req, res) => {
    runQuery("SELECT * FROM events WHERE start_date IS NOT NULL ORDER BY start_date ASC", res);
});

app.get("/api/events/upcoming", (req, res) => {
    runQuery("SELECT * FROM events WHERE start_date >= CURDATE() ORDER BY start_date ASC", res);
});

// 4. Catch-all (This tells you if you missed the URL)
app.use((req, res) => {
    res.status(404).send(`Route ${req.originalUrl} not found. Try /api/db-info`);
});

app.listen(8000, () => {
    console.log("🚀 Server running on http://localhost:8000");
});