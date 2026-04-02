import React, { useState, useEffect } from "react";

const ProfilePage = () => {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Mock fetching user data
        setTimeout(() => {
            setUser({
                contact: {
                    name: "Alex Rivera",
                    designation: "Chief Technology Officer",
                    email: "alex.r@nexus.com",
                    mobile: "+1 (555) 000-1234",
                    city: "San Francisco",
                    state: "California",
                    image: null
                },
                company: {
                    company_name: "Nexus Systems Intl.",
                    database_name: "NODE_US_01"
                }
            });
            setLoading(false);
        }, 1000);
    }, []);

    if (loading) return <div style={{ padding: 50, textAlign: "center", fontFamily: "sans-serif" }}>Loading...</div>;

    const getInitials = (name) => {
        const parts = name.trim().split(" ");
        return parts.length > 1
            ? (parts[0][0] + parts[parts.length - 1][0]).toUpperCase()
            : parts[0][0].toUpperCase();
    };

    return (
        <>
            <style>
                {`
                .profile-container {
                    font-family: 'Plus Jakarta Sans', sans-serif;
                    max-width: 1100px;
                    margin: auto;
                    background-color: #fbfcfe;
                    min-height: 100vh;
                    
                    /* FIXED SPACING FOR YOUR NAVIGATION */
                    padding: 5x;
                    padding-bottom: 120px; /* Lifts content above bottom nav */
                    box-sizing: border-box;
                }

                .bento-grid {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 15px;
                }

                .card-large { grid-column: span 2; }
                .card-small { grid-column: span 1; }

                @media (max-width: 600px) {
                    .bento-grid { grid-template-columns: 1fr; }
                    .card-large, .card-small { grid-column: span 1; }
                    .pill-container { flex-direction: column; width: 100%; }
                    .pill { width: 100%; justify-content: center; }
                    
                    /* Mobile Specific Spacing */
                    .profile-container {
                        // padding-top: 80px; 
                        padding-bottom: 110px;
                    }
                }
                `}
            </style>

            <div className="profile-container">
                {/* Hero Section */}
                <div style={heroStyle}>
                    <div style={avatarStyle}>
                        {user.contact.image ? <img src={user.contact.image} alt="Profile" style={{ width: "100%", height: "100%", borderRadius: "50%" }} /> : getInitials(user.contact.name)}
                    </div>
                    <div style={{ textAlign: "center" }}>
                        <h1 style={{ margin: 0, fontSize: "24px", color: "#0f172a" }}>{user.contact.name}</h1>
                        <p style={designationStyle}>{user.contact.designation}</p>
                        <div className="pill-container" style={{ display: "flex", flexWrap: "wrap", justifyContent: "center", gap: "10px", marginTop: "15px" }}>
                            <div className="pill" style={pillStyle}><i className="fa-solid fa-envelope"></i> {user.contact.email}</div>
                            <div className="pill" style={pillStyle}><i className="fa-solid fa-phone"></i> {user.contact.mobile}</div>
                        </div>
                    </div>
                </div>

                {/* Bento Grid */}
                <div className="bento-grid">
                    <div className="card-large" style={cardStyle(true)}>
                        <div style={iconBox(true)}><i className="fa-solid fa-building"></i></div>
                        <div style={labelStyle(true)}>Primary Organization</div>
                        <div style={{ fontSize: "20px", fontWeight: 700 }}>{user.company.company_name}</div>
                    </div>

                    <div className="card-small" style={cardStyle()}>
                        <div style={iconBox()}><i className="fa-solid fa-database"></i></div>
                        <div style={labelStyle()}>System Node</div>
                        <div style={{ fontSize: "16px", fontWeight: 700 }}>{user.company.database_name}</div>
                    </div>

                    <div className="card-small" style={cardStyle()}>
                        <div style={iconBox()}><i className="fa-solid fa-location-dot"></i></div>
                        <div style={labelStyle()}>Location</div>
                        <div style={{ fontSize: "16px", fontWeight: 700 }}>{user.contact.city}, {user.contact.state}</div>
                    </div>

                    <a href="/logout" className="card-large" style={{ textDecoration: "none" }}>
                        <div style={cardStyle(false, true)}>
                            <div style={iconBox(false, true)}><i className="fa-solid fa-power-off"></i></div>
                            <div style={labelStyle()}>Security</div>
                            <div style={{ fontSize: "16px", fontWeight: 700 }}>Terminate Session</div>
                        </div>
                    </a>
                </div>
            </div>
        </>
    );
};

/* --- CLEANER STYLE OBJECTS --- */

const heroStyle = {
    background: "#fff",
    borderRadius: "24px",
    padding: "40px 20px",
    display: "flex",
    flexDirection: "column",
    alignItems: "center",
    gap: "15px",
    boxShadow: "0 10px 30px -10px rgba(0,0,0,0.05)",
    marginBottom: "20px",
    border: "1px solid #f1f5f9",
};

const avatarStyle = {
    width: "100px",
    height: "100px",
    borderRadius: "50%",
    background: "linear-gradient(135deg, #4f46e5, #818cf8)",
    color: "white",
    display: "flex",
    alignItems: "center",
    justifyContent: "center",
    fontSize: "32px",
    fontWeight: "800",
};

const designationStyle = {
    color: "#4f46e5",
    fontWeight: 700,
    textTransform: "uppercase",
    margin: "5px 0",
    fontSize: "11px",
    letterSpacing: "1px"
};

const pillStyle = {
    background: "#eef2ff",
    color: "#4f46e5",
    padding: "10px 16px",
    borderRadius: "14px",
    fontSize: "13px",
    fontWeight: "600",
    display: "flex",
    alignItems: "center",
    gap: "8px",
};

const cardStyle = (isLarge = false, isLogout = false) => ({
    background: isLogout ? "#fff1f0" : isLarge ? "linear-gradient(135deg, #4f46e5, #6366f1)" : "#fff",
    color: isLarge || isLogout ? (isLogout ? "#ff4d4f" : "#fff") : "#475569",
    padding: "24px",
    borderRadius: "24px",
    border: isLogout ? "1px solid #ffa39e" : "1px solid #f1f5f9",
    display: "flex",
    flexDirection: "column",
    boxShadow: "0 4px 6px -1px rgba(0, 0, 0, 0.05)",
});

const iconBox = (light = false, danger = false) => ({
    width: "42px",
    height: "42px",
    borderRadius: "12px",
    display: "flex",
    alignItems: "center",
    justifyContent: "center",
    marginBottom: "15px",
    background: light ? "rgba(255,255,255,0.2)" : danger ? "rgba(255,77,79,0.1)" : "#f8fafc",
    color: light ? "white" : danger ? "#ff4d4f" : "#4f46e5",
});

const labelStyle = (light = false) => ({
    fontSize: "10px",
    textTransform: "uppercase",
    letterSpacing: "1px",
    fontWeight: "800",
    marginBottom: "6px",
    opacity: light ? 0.8 : 0.5,
});

export default ProfilePage;