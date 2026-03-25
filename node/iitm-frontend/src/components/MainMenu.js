import React from "react";

const MainMenu = () => {
    const menuItems = [
        { label: "Event List", sub: "Upcoming shows", icon: "event_available", color: "#6c5ce7", link: "/calendar" },
        { label: "Scan Leads", sub: "Visitor info", icon: "qr_code_scanner", color: "#ff7675", link: "#" },
        { label: "Stall Booking", sub: "Reserve space", icon: "confirmation_number", color: "#00b894", link: "#" },
        { label: "B2B Meetings", sub: "Networking", icon: "groups", color: "#fdcb6e", link: "#" },
        { label: "Floor Plan", sub: "Layouts", icon: "file_download", color: "#0984e3", link: "/layout" },
        { label: "E-Badge", sub: "Entry pass", icon: "badge", color: "#e84393", link: "#" },
    ];

    return (
        <div style={styles.container}>
            <style>{hoverEffects}</style>
            <div style={styles.grid}>
                {menuItems.map((item, index) => (
                    <a key={index} href={item.link} style={styles.card} className="menu-card">
                        <div style={{ ...styles.iconBox, background: `${item.color}15`, color: item.color }}>
                            <span className="material-icons-round" style={{ fontSize: "28px" }}>{item.icon}</span>
                        </div>
                        <div style={styles.textContainer}>
                            <span style={styles.label}>{item.label}</span>
                            <span style={styles.sub}>{item.sub}</span>
                        </div>
                        <span className="material-icons-round arrow" style={styles.arrow}>east</span>
                    </a>
                ))}
            </div>
        </div>
    );
};

const hoverEffects = `
.menu-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; }
.menu-card:hover { transform: translateY(-5px); background: #ffffff !important; box-shadow: 0 12px 24px rgba(0,0,0,0.1) !important; border-color: transparent !important; }
.menu-card:active { transform: scale(0.97); }
.arrow { opacity: 0; transform: translateX(-10px); transition: all 0.3s ease; }
.menu-card:hover .arrow { opacity: 0.3; transform: translateX(0); }
`;

const styles = {
    container: {
        padding: "20px",
        fontFamily: "'DM Sans', sans-serif",
        display: "flex",
        justifyContent: "center",
        paddingBottom: "100px",
    },
    grid: {
        display: "grid",
        width: "100%",
        maxWidth: "600px", // mobile-friendly max width
        gridTemplateColumns: "repeat(2, 1fr)", // two items per row
        gap: "20px",
        alignContent: "start",
        alignItems: "start",
    },
    card: {
        background: "rgba(255, 255, 255, 0.85)",
        backdropFilter: "blur(10px)",
        borderRadius: "24px",
        padding: "20px",
        display: "flex",
        alignItems: "center",
        textDecoration: "none",
        border: "1px solid rgba(255, 255, 255, 0.8)",
        boxShadow: "0 4px 8px rgba(0,0,0,0.05)",
    },
    iconBox: {
        width: "56px",
        height: "56px",
        borderRadius: "16px",
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        marginRight: "16px",
        flexShrink: 0,
    },
    textContainer: {
        display: "flex",
        flexDirection: "column",
        flexGrow: 1,
    },
    label: {
        fontWeight: "700",
        fontSize: "1.05rem",
        color: "#1a1a1a",
        marginBottom: "2px",
    },
    sub: {
        fontSize: "0.85rem",
        color: "#636e72",
        fontWeight: "400",
    },
    arrow: {
        fontSize: "20px",
        color: "#000",
    },
};

export default MainMenu;