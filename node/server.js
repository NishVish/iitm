const express = require("express");
const cors = require("cors");
const path = require("path");
const session = require("express-session"); // <--- ADD THIS LINE!

const app = express();

// --- 1. MIDDLEWARE ---
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(cors({
    origin: "http://localhost:3000", // Allow your React port
    credentials: true                // ALLOW cookies to pass through
}));
// --- 2. SESSION SETUP ---
// This MUST be defined before your routes
app.use(session({
    secret: 'any_secret_key',
    resave: false,
    saveUninitialized: false,
    cookie: { secure: false }
}));

// --- 3. IMPORT & USE ROUTES ---
const webRoutes = require("./web/web");
const mobileRoutes = require("./mobile/mobile");
const backendRoutes = require("./backend/backend");

app.use("/", webRoutes);
app.use("/mobile", mobileRoutes);
app.use("/backend", backendRoutes);

// ... rest of your code (static files, port, etc.)
const PORT = process.env.PORT || 8000;
app.listen(PORT, () => {
    console.log(`🚀 Server running on http://localhost:${PORT}`);
});