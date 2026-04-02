const express = require("express");
const cors = require("cors");
const path = require("path");
const session = require("express-session");
const mysql = require("mysql2"); // ✅ FIX: missing import

const app = express();

// --- 1. MIDDLEWARE ---
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// ✅ FIX: use cors ONLY ONCE
app.use(cors({
    origin: "http://localhost:3000",
    credentials: true
}));

// --- 2. DATABASE CONFIGURATION ---
const dbConfig = {
    host: "21.157.66.148.host.secureserver.net",
    port: 3306,
    user: "iitminda_master",
    password: "gB)%gU}ocn?MCP=}",
    database: "iitminda_testing_server",
};

// ✅ Better: use connection pool instead of single connection
const db = mysql.createPool(dbConfig);

// Test connection
db.getConnection((err, connection) => {
    if (err) {
        console.error("❌ MySQL connection failed:", err.message);
    } else {
        console.log("✅ MySQL connected to:", dbConfig.database);
        connection.release();
    }
});

// --- 3. SESSION SETUP ---
app.use(session({
    secret: 'any_secret_key',
    resave: false,
    saveUninitialized: false,
    cookie: { secure: false } // set true only with HTTPS
}));

// --- 4. MAKE DB AVAILABLE TO ROUTES ---
// ✅ This avoids circular imports
app.use((req, res, next) => {
    req.db = db;
    next();
});

// --- 5. IMPORT ROUTES ---
const webRoutes = require("./web/web");
const mobileRoutes = require("./mobile/mobile");
const backendRoutes = require("./backend/backend");

// --- 6. USE ROUTES ---
app.use("/", webRoutes);
app.use("/mobile", mobileRoutes);
app.use("/backend", backendRoutes);

// --- 7. STATIC FILES (optional) ---
app.use(express.static(path.join(__dirname, "public")));

// --- 8. START SERVER ---
const PORT = process.env.PORT || 8000;
app.listen(PORT, () => {
    console.log(`🚀 Server running on http://localhost:${PORT}`);
});