const express = require('express');
const router = express.Router();

/**
 * --- Route 1: Get all events ---
 * This will automatically work regardless of column names,
 * by selecting all columns and returning as-is.
 */
router.get('/events', (req, res) => {
    const db = req.db;

    // Fetch all events safely
    const query = "SELECT * FROM events";

    db.query(query, (err, results) => {
        if (err) {
            console.error("❌ Error fetching events:", err);
            return res.status(500).json({
                success: false,
                message: err.message
            });
        }

        res.status(200).json({
            success: true,
            count: results.length,
            data: results
        });
    });
});

/**
 * --- Route 2: Query Runner (POST /query) ---
 * For development/testing only. Executes any SQL query sent in JSON body.
 * WARNING: This is dangerous for production.
 */
router.post('/query', (req, res) => {
    const db = req.db;
    const { sql } = req.body;

    if (!sql) {
        return res.status(400).json({
            success: false,
            message: "No SQL query provided"
        });
    }

    db.query(sql, (err, results) => {
        if (err) {
            console.error("❌ SQL Error:", err);
            return res.status(500).json({
                success: false,
                message: err.message
            });
        }

        res.status(200).json({
            success: true,
            count: Array.isArray(results) ? results.length : 0,
            data: results
        });
    });
});

module.exports = router;