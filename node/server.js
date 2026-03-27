const express = require("express");
const mysql = require("mysql2");
const path = require("path");
const cors = require("cors");
const fs = require("fs");

const app = express();

// --- 1. MIDDLEWARE ---
app.use(cors());
app.use(express.json());

// --- 2. DATABASE CONFIGURATION ---
const dbConfig = {
    host: "21.157.66.148.host.secureserver.net",
    port: 3306,
    user: "iitminda_master",
    password: "gB)%gU}ocn?MCP=}",
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

// Helper for database queries
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

// --- 3. API ROUTES ---

// Base API route
app.get("/api", (req, res) => {
    res.json({
        message: "API is running!",
        available_routes: [
            "/db-info",
            "/tables",
            "/events",
            "/events/upcoming"
        ]
    });
});

// Database info
app.get("/api/db-info", (req, res) => {
    res.json({
        database: dbConfig.database,
        user: dbConfig.user,
        status: db.threadId ? "Connected" : "Disconnected"
    });
});

// List tables
app.get("/api/tables", (req, res) => {
    db.query("SHOW TABLES", (err, results) => {
        if (err) return res.status(500).json({ error: err.message });
        const tableNames = results.map(row => Object.values(row)[0]);
        res.json({
            database: dbConfig.database,
            total_tables: tableNames.length,
            tables: tableNames
        });
    });
});

// All events
app.get("/api/events", (req, res) => {
    runQuery("SELECT * FROM events WHERE start_date IS NOT NULL ORDER BY start_date ASC", res);
});

// Upcoming events
app.get("/api/events/upcoming", (req, res) => {
    runQuery("SELECT * FROM events WHERE start_date >= CURDATE() ORDER BY start_date ASC", res);
});

// --- 4. SERVE REACT BUILD ---
const buildPath = path.resolve(__dirname, "iitm-frontend", "build");
console.log("Serving React from:", buildPath);

app.use(express.static(buildPath));

// Optional: check build folder contents
app.get("/api/build-check", (req, res) => {
    res.json({
        buildPath,
        exists: fs.existsSync(buildPath),
        indexExists: fs.existsSync(path.join(buildPath, "index.html")),
        files: fs.existsSync(buildPath) ? fs.readdirSync(buildPath) : "folder missing"
    });
});

// --- 5. CATCH-ALL ROUTE ---
// All non-API routes go here
app.get(/^(?!\/api).*/, (req, res) => {
    // Test: send Hello for now
    res.send("Hello, this route works!");
    // Later, uncomment to serve React SPA
    // res.sendFile(path.join(buildPath, "index.html"));
});

// --- 6. START SERVER ---
const PORT = process.env.PORT || 8000;
app.listen(PORT, () => {
    console.log(`🚀 Server running on http://localhost:${PORT}`);
    console.log(`🔗 API Base: http://localhost:${PORT}/api`);
});