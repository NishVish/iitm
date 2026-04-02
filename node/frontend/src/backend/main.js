import React, { useState, useEffect } from "react";

// --- MAIN COMPONENT ---
export default function BackendApp() {
    const [tables, setTables] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    // 1. FETCH DATA FROM BACKEND
    useEffect(() => {
        fetch("http://localhost:8000/backend/tables", {
            method: "GET",
            // CRITICAL: This sends the session cookie so the backend knows who you are
            credentials: "include",
            headers: { "Accept": "application/json" }
        })
            .then((res) => {
                if (res.status === 401) throw new Error("Session Expired. Please login again.");
                return res.json();
            })
            .then((data) => {
                if (data.success) {
                    setTables(data.tables);
                } else {
                    setError(data.message);
                }
            })
            .catch((err) => setError(err.message))
            .finally(() => setLoading(false));
    }, []);

    // --- 2. INLINE STYLES (To keep it in one file) ---
    const styles = {
        container: {
            padding: "20px",
            fontFamily: "sans-serif",
            backgroundColor: "#f8f9fa",
            minHeight: "100vh",
            paddingBottom: "80px" // Space for BottomNav
        },
        header: { color: "#333", borderBottom: "2px solid #007bff", paddingBottom: "10px" },
        card: {
            background: "white",
            margin: "10px 0",
            padding: "15px",
            borderRadius: "10px",
            boxShadow: "0 2px 4px rgba(0,0,0,0.1)",
            display: "flex",
            alignItems: "center",
            gap: "15px"
        },
        icon: {
            background: "#e7f1ff",
            color: "#007bff",
            padding: "10px",
            borderRadius: "8px",
            fontWeight: "bold"
        },
        nav: {
            position: "fixed",
            bottom: 0,
            left: 0,
            width: "100%",
            height: "60px",
            background: "white",
            display: "flex",
            justifyContent: "space-around",
            alignItems: "center",
            borderTop: "1px solid #ddd",
            boxShadow: "0 -2px 10px rgba(0,0,0,0.05)"
        }
    };

    // --- 3. RENDER LOGIC ---
    return (
        <div style={styles.container}>
            <h2 style={styles.header}>Database Explorer</h2>

            {loading && <p>Searching for tables...</p>}

            {error && (
                <div style={{ color: "red", background: "#fee", padding: "10px", borderRadius: "5px" }}>
                    <strong>Error:</strong> {error}
                    <br />
                    <a href="http://localhost:8000/backend/login" style={{ color: "#007bff" }}>Go to Login Page</a>
                </div>
            )}

            {!loading && !error && (
                <div>
                    <p>Total Tables found: <strong>{tables.length}</strong></p>
                    {tables.map((name, i) => (
                        <div key={i} style={styles.card}>
                            <div style={styles.icon}>DB</div>
                            <span style={{ fontSize: "1.1rem", color: "#444" }}>{name}</span>
                        </div>
                    ))}
                </div>
            )}

            {/* INLINE BOTTOM NAVIGATION */}
            <div style={styles.nav}>
                <span>🏠 Home</span>
                <span>📅 Cal</span>
                <span>⚙️ Setup</span>
                <span>👤 User</span>
            </div>
        </div>
    );
}