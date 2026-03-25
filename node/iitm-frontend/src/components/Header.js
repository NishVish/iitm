import React, { useState, useEffect } from "react";

function Header() {
    const [nextEvent, setNextEvent] = useState(null);
    const [timeLeft, setTimeLeft] = useState({ d: "--", h: "--", m: "--" });

    useEffect(() => {
        fetch("http://localhost:8000/api/events/upcoming")
            .then((res) => res.json())
            .then((res) => {
                if (res.data?.length) setNextEvent(res.data[0]);
            })
            .catch((err) => console.error("Error loading events:", err));
    }, []);

    useEffect(() => {
        if (!nextEvent?.start_date) return;

        const updateCountdown = () => {
            const diff = new Date(nextEvent.start_date) - new Date();
            if (diff <= 0) return setTimeLeft({ d: "00", h: "00", m: "00" });

            setTimeLeft({
                d: String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, "0"),
                h: String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, "0"),
                m: String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, "0"),
            });
        };

        updateCountdown();
        const timer = setInterval(updateCountdown, 60000);
        return () => clearInterval(timer);
    }, [nextEvent]);

    const formatDateRange = () => {
        if (!nextEvent?.start_date) return "TBA";
        const start = new Date(nextEvent.start_date);
        const end = new Date(nextEvent.end_date);
        return `${start.getDate()}-${end.getDate()} ${end.toLocaleString("en-GB", { month: "short" })}`;
    };

    const headerStyle = {
        background: "#a82324",
        padding: "40px 20px 30px 20px", // reduced top & bottom padding
        borderBottomLeftRadius: "30px",
        borderBottomRightRadius: "30px",
        color: "white",
        display: "flex",
        justifyContent: "space-between",
        alignItems: "center",
        position: "relative",
    };

    const statsContainerStyle = {
        position: "relative",
        top: "-20px", // slightly less floating
        padding: "0 20px",
        maxWidth: "1000px",
        margin: "0 auto",
    };

    const statsCardStyle = {
        background: "rgba(255, 255, 255, 0.95)",
        backdropFilter: "blur(8px)",
        borderRadius: "20px",
        padding: "12px 8px", // smaller padding
        display: "flex",
        justifyContent: "space-around",
        boxShadow: "0 10px 20px rgba(168, 35, 36, 0.1)",
        border: "1px solid rgba(255, 255, 255, 0.5)",
    };

    const statItemStyle = {
        textAlign: "center",
        flex: 1,
        display: "flex",
        flexDirection: "column",
    };

    const statValueStyle = {
        fontWeight: "700",
        fontSize: "20px", // smaller number
        color: "#a82324",
    };

    const statLabelStyle = {
        fontSize: "9px", // smaller label
        color: "#7f8c8d",
        marginTop: "4px",
        fontWeight: "600",
        textTransform: "uppercase",
    };

    return (
        <>
            <div style={headerStyle}>
                <div style={{ width: "50px" }}>
                    <img
                        src="https://iitmindia.com/reg/iitm_chennai/logo.png"
                        alt="Logo"
                        style={{ width: "100%", filter: "brightness(0) invert(1)" }}
                    />
                </div>

                <div style={{ display: "flex", flexDirection: "column", fontFamily: "system-ui, sans-serif" }}>
                    <span style={{ fontSize: "1.5rem", fontWeight: "600", color: "white" }}>
                        {nextEvent?.name || "Loading..."}
                    </span>
                    <span style={{ fontSize: "0.9rem", color: "rgba(255,255,255,0.7)", letterSpacing: "0.5px" }}>
                        Next Event || {formatDateRange()}
                    </span>
                </div>

                <div style={{ width: "30px" }}></div>
            </div>

            <div style={statsContainerStyle}>
                <div style={statsCardStyle}>
                    <div style={statItemStyle}>
                        <span style={statValueStyle}>{timeLeft.d}</span>
                        <span style={statLabelStyle}>Days</span>
                    </div>
                    <div style={{ width: 1, background: "rgba(168, 35, 36, 0.1)" }}></div>
                    <div style={statItemStyle}>
                        <span style={statValueStyle}>{timeLeft.h}</span>
                        <span style={statLabelStyle}>Hours</span>
                    </div>
                    <div style={{ width: 1, background: "rgba(168, 35, 36, 0.1)" }}></div>
                    <div style={statItemStyle}>
                        <span style={statValueStyle}>{timeLeft.m}</span>
                        <span style={statLabelStyle}>Mins</span>
                    </div>
                </div>
            </div>
        </>
    );
}

export default Header;