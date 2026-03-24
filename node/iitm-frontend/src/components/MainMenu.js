import React from "react";

const MainMenu = () => {
    const menuItems = [
        { label: "Event List", sub: "View upcoming shows", icon: "event_available", color: "#4834d4", link: "/calendar" },
        { label: "Scan Leads", sub: "Capture visitor info", icon: "qr_code_scanner", color: "#eb4d4b", link: "#" },
        { label: "Stall Booking", sub: "Reserve your space", icon: "confirmation_number", color: "#6ab04c", link: "#" },
        { label: "B2B Meetings", sub: "Networking schedule", icon: "groups", color: "#f0932b", link: "#" },
        { label: "Floor Plan", sub: "Download layouts", icon: "file_download", color: "#22a6b3", link: "/layout" },
        { label: "E-Badge", sub: "Digital entry pass", icon: "badge", color: "#be2edd", link: "#" },
    ];

    const containerStyle = {
        display: "grid",
        gridTemplateColumns: "repeat(2, 1fr)", // Force 2 columns like a mobile dashboard
        gap: "12px",
        padding: "16px",
        backgroundColor: "#f5f6fa",
        minHeight: "100vh",
        fontFamily: "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif",
    };

    const cardStyle = {
        backgroundColor: "#ffffff",
        borderRadius: "16px",
        padding: "20px 12px",
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        textAlign: "center",
        textDecoration: "none",
        boxShadow: "0 2px 8px rgba(0,0,0,0.04)",
        transition: "transform 0.1s ease, background-color 0.1s ease",
        border: "1px solid #f0f0f0",
    };

    const iconBoxStyle = (color) => ({
        width: "48px",
        height: "48px",
        borderRadius: "12px",
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        marginBottom: "12px",
        background: `${color}10`, // Subtle tinted background
        color: color,
    });

    return (
        <div style={containerStyle}>
            {menuItems.map((item, index) => (
                <a
                    key={index}
                    href={item.link}
                    style={cardStyle}
                    // Simple scale effect on tap/click
                    onMouseDown={(e) => e.currentTarget.style.transform = "scale(0.96)"}
                    onMouseUp={(e) => e.currentTarget.style.transform = "scale(1)"}
                >
                    <div style={iconBoxStyle(item.color)}>
                        <span className="material-icons-round" style={{ fontSize: "24px" }}>
                            {item.icon}
                        </span>
                    </div>

                    <span style={{
                        fontWeight: "700",
                        fontSize: "0.95rem",
                        color: "#2f3640",
                        display: "block",
                        marginBottom: "4px"
                    }}>
                        {item.label}
                    </span>

                    <span style={{
                        fontSize: "0.75rem",
                        color: "#7f8c8d",
                        lineHeight: "1.2"
                    }}>
                        {item.sub}
                    </span>
                </a>
            ))}
        </div>
    );
};

export default MainMenu;