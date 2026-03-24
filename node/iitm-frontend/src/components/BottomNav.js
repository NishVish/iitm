import React from "react";

function BottomNav({ active }) {
    const navItems = [
        { id: "home", label: "Home", icon: "home", link: "/home" },
        { id: "cities", label: "Cities", icon: "explore", link: "/cities" },
        { id: "chat", label: "Chat", icon: "chat_bubble", link: "/chat" },
        { id: "profile", label: "Profile", icon: "person", link: "/profile" },
    ];

    const navWrapperStyle = {
        position: "fixed",
        bottom: 0,
        left: 0,
        right: 0,
        width: "100%",
        display: "flex",
        justifyContent: "space-around",
        // This makes the top and bottom padding equal (12px)
        padding: "12px 0",
        background: "rgba(255, 255, 255, 0.95)",
        backdropFilter: "blur(15px)",
        boxShadow: "0 -4px 20px rgba(0,0,0,0.06)",
        borderTop: "1px solid #f1f2f6",
        zIndex: 1000,
    };

    const itemStyle = (isActive) => ({
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        justifyContent: "center",
        textDecoration: "none",
        flex: 1, // Equally distribute space
        transition: "all 0.2s ease",
        color: isActive ? "#a82324" : "#94a3b8",
        gap: "4px",
    });

    return (
        <div style={navWrapperStyle}>
            {navItems.map((item) => {
                const isActive = active === item.id;
                return (
                    <a key={item.id} href={item.link} style={itemStyle(isActive)}>
                        <span
                            className="material-icons-round"
                            style={{
                                fontSize: "26px", // Slightly larger for better tap targets
                                transform: isActive ? "translateY(-2px)" : "translateY(0)",
                                transition: "transform 0.2s ease",
                            }}
                        >
                            {item.icon}
                        </span>
                        <span style={{
                            fontSize: "10px",
                            fontWeight: isActive ? "700" : "500",
                            letterSpacing: "0.02em",
                            textTransform: "uppercase" // Makes it look cleaner in a stuck bar
                        }}>
                            {item.label}
                        </span>

                        {/* Active Indicator Line */}
                        {isActive && (
                            <div style={{
                                width: "4px",
                                height: "4px",
                                borderRadius: "50%",
                                backgroundColor: "#a82324",
                                marginTop: "2px"
                            }} />
                        )}
                    </a>
                );
            })}
        </div>
    );
}

export default BottomNav;