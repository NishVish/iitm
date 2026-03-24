import React, { useState, useEffect } from "react";

function Header() {
    const [nextEvent, setNextEvent] = useState(null);
    const [timeLeft, setTimeLeft] = useState({ d: "--", h: "--", m: "--" });

    useEffect(() => {
        fetch("http://localhost:8000/api/events/upcoming")
            .then(res => res.json())
            .then(res => {
                if (res.data && res.data.length > 0) {
                    setNextEvent(res.data[0]);
                }
            })
            .catch(err => console.error("Error loading events:", err));
    }, []);

    useEffect(() => {
        if (!nextEvent || !nextEvent.start_date) return;

        const updateCountdown = () => {
            const eventDate = new Date(nextEvent.start_date).getTime();
            const now = new Date().getTime();
            const diff = eventDate - now;

            if (diff <= 0) {
                setTimeLeft({ d: "00", h: "00", m: "00" });
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

            setTimeLeft({
                d: String(days).padStart(2, '0'),
                h: String(hours).padStart(2, '0'),
                m: String(mins).padStart(2, '0')
            });
        };

        updateCountdown();
        const timer = setInterval(updateCountdown, 60000);
        return () => clearInterval(timer);
    }, [nextEvent]);

    // Helper to format the date range string like "19-20 Mar"
    const formatDateRange = () => {
        if (!nextEvent?.start_date) return "TBA";
        const start = new Date(nextEvent.start_date);
        const end = new Date(nextEvent.end_date);
        const options = { day: '2-digit' };
        const monthOptions = { day: '2-digit', month: 'short' };
        return `${start.toLocaleDateString('en-GB', options)}-${end.toLocaleDateString('en-GB', monthOptions)}`;
    };

    // --- STYLES (Converted from your CSS) ---
    const headerStyle = {
        background: "#a82324",
        padding: "60px 24px 80px 24px",
        borderBottomLeftRadius: "40px",
        borderBottomRightRadius: "40px",
        color: "white",
        display: "flex",
        justifyContent: "space-between",
        alignItems: "center"
    };

    const eventDetailsStyle = { display: "flex", flexDirection: "column", fontFamily: "system-ui, sans-serif" };
    const eventValueStyle = { fontSize: "1.8rem", fontWeight: "600", color: "white" };
    const eventLabelStyle = { fontSize: "1rem", color: "rgba(255,255,255,0.6)", letterSpacing: "0.5px" };

    const statsContainerStyle = { padding: "0 20px", marginTop: "-45px" };
    const statsCardStyle = {
        background: "rgba(255, 255, 255, 0.95)",
        backdropFilter: "blur(10px)",
        borderRadius: "25px",
        padding: "20px 10px",
        display: "flex",
        justifyContent: "space-around",
        boxShadow: "0 15px 35px rgba(168, 35, 36, 0.15)",
        border: "1px solid rgba(255, 255, 255, 0.5)"
    };

    const statItemStyle = { textAlign: "center", flex: 1, display: "flex", flexDirection: "column" };
    const statValueStyle = { fontWeight: "800", fontSize: "24px", color: "#a82324" };
    const statLabelStyle = { fontSize: "10px", color: "#7f8c8d", marginTop: "6px", fontWeight: "700", textTransform: "uppercase" };

    return (
        <>
            <div style={headerStyle}>
                <div style={{ width: "60px" }}>
                    <img
                        src="https://iitmindia.com/reg/iitm_chennai/logo.png"
                        alt="Logo"
                        style={{ width: "100%", filter: "brightness(0) invert(1)" }}
                    />
                </div>

                <div style={eventDetailsStyle}>
                    <span style={eventValueStyle}>{nextEvent?.name || "Loading..."}</span>
                    <span style={eventLabelStyle}>
                        Next Event || {formatDateRange()}
                    </span>
                </div>
                <div style={{ width: "40px" }}></div> {/* Spacer */}
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