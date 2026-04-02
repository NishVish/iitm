import React, { useState, useEffect } from "react";
import { motion, AnimatePresence } from "framer-motion";

const EventList = ({ darkMode }) => {
    const allCities = ["Mumbai", "Delhi", "Bengaluru", "Hyderabad", "Ahmedabad", "Chennai", "Kolkata", "Surat", "Pune"];
    const [events, setEvents] = useState([]);
    const [activeCity, setActiveCity] = useState("");
    const [currentIndex, setCurrentIndex] = useState(0);

    // Fetch events from backend
    useEffect(() => {
        const fetchEvents = async () => {
            try {
                const res = await fetch("http://localhost:8000/events");
                const data = await res.json();
                if (data.success) {
                    // Extract city from event name by removing "IITM "
                    const parsedEvents = data.data.map(event => ({
                        ...event,
                        city: event.name ? event.name.replace(/^IITM\s+/i, "") : ""
                    }));

                    setEvents(parsedEvents);

                    // Set the first city with events as active
                    const firstCityWithEvents = allCities.find(city =>
                        parsedEvents.some(event => event.city === city)
                    );
                    setActiveCity(firstCityWithEvents || "");
                    setCurrentIndex(0);
                } else {
                    console.error("Backend error:", data.message);
                }
            } catch (err) {
                console.error("Fetch error:", err);
            }
        };
        fetchEvents();
    }, []);

    // Filter events by active city
    const filteredEvents = events.filter(event => event.city === activeCity);
    const currentEvent = filteredEvents[currentIndex];

    const nextEvent = () => setCurrentIndex((prev) => (prev + 1) % filteredEvents.length);
    const prevEvent = () => setCurrentIndex((prev) => (prev - 1 + filteredEvents.length) % filteredEvents.length);

    return (
        <section className={`py-12 px-6 max-w-5xl mx-auto ${darkMode ? "text-white" : "text-gray-900"}`}>
            {/* City Buttons */}
            <div className="flex flex-wrap justify-center gap-3 mb-12">
                {allCities.map(city => {
                    // Check if city has any events
                    const hasEvents = events.some(event => event.city === city);
                    return (
                        <button
                            key={city}
                            onClick={() => {
                                if (!hasEvents) return;
                                setActiveCity(city);
                                setCurrentIndex(0);
                            }}
                            className={`px-5 py-2 rounded-full font-bold text-sm transition-all border-2 
                                ${activeCity === city
                                    ? "bg-[#AA2324] border-[#AA2324] text-white shadow-lg scale-110"
                                    : hasEvents
                                        ? `${darkMode ? "border-gray-700 hover:border-gray-500" : "border-gray-200 hover:border-gray-300"}"`
                                        : "opacity-40 cursor-not-allowed border-gray-300"}`
                            }
                            disabled={!hasEvents}
                        >
                            {city}
                        </button>
                    );
                })}
            </div>

            {/* Event Card */}
            <div className="relative min-h-[500px] flex items-center justify-center">
                <AnimatePresence mode="wait">
                    {filteredEvents.length > 0 ? (
                        <motion.div
                            key={currentEvent.event_id}
                            initial={{ opacity: 0, x: 50 }}
                            animate={{ opacity: 1, x: 0 }}
                            exit={{ opacity: 0, x: -50 }}
                            className={`w-full max-w-2xl overflow-hidden rounded-[3rem] border transition-all shadow-2xl ${darkMode ? "bg-gray-800 border-gray-700" : "bg-white border-gray-100"}`}
                        >
                            <div className="h-48 bg-[#AA2324]/20 flex items-center justify-center text-7xl">
                                <span>🎉</span>
                            </div>
                            <div className="p-10 text-center">
                                <span className="inline-block px-4 py-1 rounded-full bg-[#AA2324]/10 text-[#AA2324] text-xs font-black uppercase mb-4">
                                    Event • {activeCity}
                                </span>
                                <h3 className="text-4xl font-black mb-4">{currentEvent.name || "Unnamed Event"}</h3>
                                <p className="opacity-60 text-lg mb-2 font-bold">{currentEvent.start_date?.slice(0, 10) || "TBA"}</p>
                                <p className="opacity-50 flex items-center justify-center gap-2 mb-8">
                                    <span>📍</span> {currentEvent.venue_details || "Location TBD"}
                                </p>
                                <button className="w-full py-5 bg-[#AA2324] hover:bg-[#881b1c] text-white rounded-2xl font-black text-lg shadow-xl transition-all">
                                    Book Now
                                </button>
                            </div>
                        </motion.div>
                    ) : (
                        <motion.div className="text-center opacity-40 italic">
                            No events currently scheduled for {activeCity}.
                        </motion.div>
                    )}
                </AnimatePresence>

                {filteredEvents.length > 1 && (
                    <>
                        <button onClick={prevEvent} className="absolute left-0 md:-left-16 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white shadow-xl text-black flex items-center justify-center hover:bg-[#AA2324] hover:text-white transition-all">
                            ←
                        </button>
                        <button onClick={nextEvent} className="absolute right-0 md:-right-16 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white shadow-xl text-black flex items-center justify-center hover:bg-[#AA2324] hover:text-white transition-all">
                            →
                        </button>
                    </>
                )}
            </div>
        </section>
    );
};

export default EventList;