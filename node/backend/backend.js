const express = require("express");
const router = express.Router();
const mysql = require("mysql2/promise");

const dbConfig = {
    host: "localhost",
    port: 3306,
    user: "root",
    password: "",
    database: "iitminda_testing_server",
};

// Middleware: Check if Super User
const authorizeSuperUser = (req, res, next) => {
    if (!req.session || !req.session.user || req.session.user.type !== 'super') {
        if (req.headers.accept && req.headers.accept.includes("text/html")) {
            return res.redirect("/backend/login");
        }
        return res.status(401).json({ success: false, message: "Unauthorized" });
    }
    next();
};

// GET: The Login Page
router.get("/login", (req, res) => {
    res.send(`
        <body style="font-family:sans-serif; display:flex; justify-content:center; align-items:center; height:100vh;">
            <form action="/backend/login" method="POST" style="border:1px solid #ccc; padding:30px; border-radius:10px;">
                <h2>Admin Login</h2>
                <input type="text" name="username" placeholder="Username" required style="display:block; margin-bottom:10px; padding:8px; width:200px;">
                <input type="password" name="password" placeholder="Password" required style="display:block; margin-bottom:10px; padding:8px; width:200px;">
                <button type="submit" style="width:100%; padding:10px; background:#007bff; color:white; border:none; cursor:pointer;">Login</button>
            </form>
        </body>
    `);
});
router.post("/login", (req, res) => {
    // 1. Print what was typed to the terminal
    console.log("Login Attempt with:", req.body);

    const { username, password } = req.body;

    // 2. Only check if they actually typed SOMETHING
    if (!username || !password) {
        return res.send("<h1>Error</h1><p>Please type something in both boxes.</p><a href='/backend/login'>Back</a>");
    }

    // 3. START SESSION (Accepts any random username/password)
    req.session.user = {
        username: username,
        type: "super" // We still give them 'super' type so they can see the tables
    };

    console.log(`Session started for: ${username}`);

    // 4. Redirect to the protected tables
    return res.redirect("http://localhost:3000/backend");
});

// router.post("/login", (req, res) => {
//     const { username, password } = req.body; // req.body is now defined thanks to urlencoded!

//     if (username === "admin" && password === "1234") {
//         req.session.user = { username: "admin", type: "super" };
//         return res.redirect("/backend/tables");
//     }
//     res.send("<h1>Invalid Login</h1><a href='/backend/login'>Try again</a>");
// });

// GET: The Protected Table List
router.get("/tables", authorizeSuperUser, async (req, res) => {
    let connection;
    try {
        connection = await mysql.createConnection(dbConfig);
        const [rows] = await connection.execute("SHOW TABLES");
        const tableNames = rows.map(row => Object.values(row));

        res.json({
            success: true,
            user: req.session.user.username,
            tables: tableNames
        });
    } catch (err) {
        res.status(500).json({ success: false, error: err.message });
    } finally {
        if (connection) await connection.end();
    }
});

module.exports = router;