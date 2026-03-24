import React, { useState, useEffect } from "react";

const EventCalendar = () => {
    const [events, setEvents] = useState([]);
    const [loading, setLoading] = useState(true);
    const [status, setStatus] = useState("Fetching showtimes...");

    useEffect(() => {
        // Updated fetch to hit your full local URL
        fetch("http://localhost:8000/api/events/upcoming")
            .then((res) => res.json())
            .then((json) => {
                // ✅ FIX: Access json.data because your API returns { status, count, data }
                if (json.status === "success" && json.data.length > 0) {
                    setEvents(json.data);
                    setStatus(`${json.count} Global Events Found`);
                } else {
                    setEvents([]);
                    setStatus("No Scheduled Events");
                }
                setLoading(false);
            })
            .catch((err) => {
                console.error("Fetch error:", err);
                setStatus("Connection Error");
                setLoading(false);
            });
    }, []);

    const containerStyle = {
        backgroundColor: "#f8fafc",
        fontFamily: "'Plus Jakarta Sans', sans-serif",
        padding: "40px 20px 120px 20px", // Extra bottom padding so it doesn't hide behind Nav
        minHeight: "100vh",
    };

    return (
        <div style={containerStyle}>
            <div style={{ maxWidth: "850px", margin: "0 auto" }}>
                {/* Header */}
                <div style={{ marginBottom: "30px" }}>
                    <h1 style={{ fontSize: "32px", fontWeight: "800", letterSpacing: "-1px", margin: 0 }}>
                        Upcoming Events
                    </h1>
                    <div style={{
                        display: "inline-block", marginTop: "10px", padding: "6px 16px",
                        background: "#e0e7ff", color: "#4f46e5", borderRadius: "100px",
                        fontSize: "13px", fontWeight: "700"
                    }}>
                        {status}
                    </div>
                </div>

                {/* List */}
                <div style={{ display: "flex", flexDirection: "column", gap: "20px" }}>
                    {loading ? (
                        <div style={{ textAlign: "center", padding: "50px", opacity: 0.5 }}>Loading events...</div>
                    ) : events.length > 0 ? (
                        events.map((event) => <EventCard key={event.event_id} event={event} />)
                    ) : (
                        <div style={{ textAlign: "center", padding: "50px", opacity: 0.5 }}>
                            No upcoming shows found.
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
};

const EventCard = ({ event }) => {
    const [isHovered, setIsHovered] = useState(false);

    // ✅ Clean up Date logic (Prevents 1899 dates from looking weird if they slip through)
    const dateObj = new Date(event.start_date);
    const isInvalidDate = dateObj.getFullYear() <= 1900;
    const day = isInvalidDate ? "--" : dateObj.getDate();
    const month = isInvalidDate ? "TBA" : dateObj.toLocaleString("default", { month: "short" });

    const cardStyle = {
        background: "#ffffff",
        display: "flex",
        alignItems: "center",
        padding: "24px",
        borderRadius: "24px",
        border: `1px solid ${isHovered ? "#4f46e5" : "#e2e8f0"}`,
        transform: isHovered ? "translateX(10px)" : "translateX(0)",
        boxShadow: isHovered ? "0 20px 25px -5px rgba(0, 0, 0, 0.05)" : "none",
        transition: "all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)",
        cursor: "pointer",
    };

    return (
        <div
            style={cardStyle}
            onMouseEnter={() => setIsHovered(true)}
            onMouseLeave={() => setIsHovered(false)}
        >
            {/* Date Badge */}
            <div style={{
                background: isHovered ? "#4f46e5" : "#f1f5f9",
                color: isHovered ? "white" : "#0f172a",
                minWidth: "80px", height: "90px", borderRadius: "20px",
                display: "flex", flexDirection: "column", alignItems: "center",
                justifyContent: "center", marginRight: "24px", transition: "0.3s"
            }}>
                <span style={{ fontSize: "28px", fontWeight: "800", lineHeight: 1 }}>{day}</span>
                <span style={{ fontSize: "12px", fontWeight: "700", textTransform: "uppercase", marginTop: "4px" }}>{month}</span>
            </div>

            {/* Content */}
            <div style={{ flexGrow: 1 }}>
                <h3 style={{ margin: "0 0 8px 0", fontSize: "20px", fontWeight: "700" }}>
                    {event.name || "Unnamed Event"}
                </h3>
                <p style={{ margin: 0, color: "#64748b", fontSize: "14px", display: "flex", alignItems: "center", gap: "8px" }}>
                    <i className="fa-solid fa-location-dot"></i> {event.venue_details || "Venue TBA"}
                </p>
            </div>

            {/* Actions */}
            <div style={{ display: "flex", alignItems: "center", gap: "15px" }}>
                <a
                    href={`/stalls/book/${event.event_id}`}
                    style={{
                        background: "#10b981", color: "white", padding: "12px 24px",
                        borderRadius: "14px", fontSize: "14px", fontWeight: "700",
                        textDecoration: "none", transition: "0.3s",
                        boxShadow: "0 4px 10px rgba(16, 185, 129, 0.2)"
                    }}
                >
                    Book Stall
                </a>
                <div style={{
                    width: "48px", height: "48px",
                    color: isHovered ? "white" : "#0f172a", borderRadius: "50%",
                    display: "flex", alignItems: "center", justifyContent: "center",
                    backgroundColor: isHovered ? "#4f46e5" : "#f1f5f9",
                    transform: isHovered ? "rotate(-45deg)" : "none", transition: "0.3s"
                }}>
                    <i className="fa-solid fa-arrow-right"></i>
                </div>
            </div>
        </div>
    );
};

export default EventCalendar;