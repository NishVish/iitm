import React, { useState, useEffect } from "react";

// Add these to your index.css or a <style> tag in your component
const profileStyles = {
    container: {
        fontFamily: "'Plus Jakarta Sans', sans-serif",
        padding: "40px 20px 100px 20px", // Extra bottom padding for your BottomNav
        maxWidth: "1100px",
        margin: "auto",
        backgroundColor: "#fbfcfe",
        minHeight: "100vh",
    },
    hero: {
        background: "#fff",
        borderRadius: "32px",
        padding: "40px",
        display: "flex",
        alignItems: "center",
        gap: "30px",
        boxShadow: "0 10px 40px -15px rgba(0,0,0,0.05)",
        marginBottom: "30px",
        border: "1px solid #f1f5f9",
    },
    avatar: (color) => ({
        width: "120px",
        height: "120px",
        borderRadius: "40px",
        background: color || "linear-gradient(135deg, #4f46e5, #818cf8)",
        color: "white",
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        fontSize: "44px",
        fontWeight: "800",
        boxShadow: "0 15px 30px -10px rgba(79, 70, 229, 0.3)",
        objectFit: "cover",
        cursor: "pointer"
    }),
    bentoGrid: {
        display: "grid",
        gridTemplateColumns: "repeat(auto-fit, minmax(300px, 1fr))",
        gap: "20px",
    },
    card: (isLarge, isLogout) => ({
        background: isLogout ? "#fff1f0" : (isLarge ? "linear-gradient(135deg, #4f46e5, #6366f1)" : "#fff"),
        color: isLarge || isLogout ? (isLogout ? "#ff4d4f" : "#fff") : "#475569",
        padding: "28px",
        borderRadius: "28px",
        border: isLogout ? "1px solid #ffa39e" : "1px solid #f1f5f9",
        gridColumn: isLarge ? "span 2" : "span 1",
        transition: "all 0.3s ease",
        cursor: "pointer",
    })
};

const ProfilePage = () => {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Simulate fetching your dataUrl
        // In production, use: fetch('/userdata').then(res => res.json()).then(data => setUser(data))
        setTimeout(() => {
            setUser({
                contact: {
                    name: "Alex Rivera",
                    designation: "Chief Technology Officer",
                    email: "alex.r@nexus.com",
                    mobile: "+1 (555) 000-1234",
                    city: "San Francisco",
                    state: "California",
                    image: null // null triggers initials
                },
                company: {
                    company_name: "Nexus Systems Intl.",
                    database_name: "NODE_US_01"
                }
            });
            setLoading(false);
        }, 1000);
    }, []);

    if (loading) return <div style={{ padding: "50px", textAlign: "center" }}>Loading Universe...</div>;

    const getInitials = (name) => {
        const parts = name.trim().split(" ");
        return parts.length > 1 ? (parts[0][0] + parts[parts.length - 1][0]).toUpperCase() : parts[0][0].toUpperCase();
    };

    return (
        <div style={profileStyles.container}>
            {/* Hero Section */}
            <div style={profileStyles.hero} className="profile-hero-mobile">
                <div style={profileStyles.avatar()}>
                    {user.contact.image ? (
                        <img src={user.contact.image} alt="Profile" style={profileStyles.avatar()} />
                    ) : (
                        getInitials(user.contact.name)
                    )}
                </div>

                <div style={{ flex: 1 }}>
                    <h1 style={{ margin: 0, fontSize: "32px", color: "#0f172a" }}>{user.contact.name}</h1>
                    <p style={{ color: "#4f46e5", fontWeight: "700", textTransform: "uppercase", margin: "5px 0" }}>
                        {user.contact.designation}
                    </p>
                    <div style={{ display: "flex", gap: "10px", flexWrap: "wrap", marginTop: "15px" }}>
                        <Pill icon="fa-envelope" text={user.contact.email} />
                        <Pill icon="fa-phone" text={user.contact.mobile} />
                    </div>
                </div>
            </div>

            {/* Bento Grid */}
            <div style={profileStyles.bentoGrid}>
                <div style={profileStyles.card(true, false)}>
                    <IconBox icon="fa-building" light />
                    <Label text="Primary Organization" light />
                    <div style={{ fontSize: "24px", fontWeight: "700" }}>{user.company.company_name}</div>
                </div>

                <div style={profileStyles.card(false, false)}>
                    <IconBox icon="fa-database" />
                    <Label text="System Node" />
                    <div style={{ fontSize: "18px", fontWeight: "700" }}>{user.company.database_name}</div>
                </div>

                <div style={profileStyles.card(false, false)}>
                    <IconBox icon="fa-location-dot" />
                    <Label text="Location" />
                    <div style={{ fontSize: "18px", fontWeight: "700" }}>{user.contact.city}, {user.contact.state}</div>
                </div>

                <a href="/logout" style={{ textDecoration: "none" }}>
                    <div style={profileStyles.card(false, true)}>
                        <IconBox icon="fa-power-off" danger />
                        <Label text="Security" />
                        <div style={{ fontSize: "18px", fontWeight: "700" }}>Terminate Session</div>
                    </div>
                </a>
            </div>
        </div>
    );
};

// Sub-components for cleaner code
const Pill = ({ icon, text }) => (
    <div style={{ background: "#eef2ff", color: "#4f46e5", padding: "8px 15px", borderRadius: "12px", fontSize: "13px", fontWeight: "600", display: "flex", alignItems: "center", gap: "8px" }}>
        <i className={`fa-solid ${icon}`}></i> {text}
    </div>
);

const Label = ({ text, light }) => (
    <div style={{ fontSize: "11px", textTransform: "uppercase", letterSpacing: "1px", fontWeight: "800", marginBottom: "8px", opacity: light ? 0.8 : 0.5 }}>
        {text}
    </div>
);

const IconBox = ({ icon, light, danger }) => (
    <div style={{
        width: "40px", height: "40px", borderRadius: "12px", display: "flex", alignItems: "center", justifyContent: "center", marginBottom: "15px",
        background: light ? "rgba(255,255,255,0.2)" : (danger ? "rgba(255,77,79,0.1)" : "#f8fafc"),
        color: light ? "white" : (danger ? "#ff4d4f" : "#4f46e5")
    }}>
        <i className={`fa-solid ${icon}`}></i>
    </div>
);

export default ProfilePage;