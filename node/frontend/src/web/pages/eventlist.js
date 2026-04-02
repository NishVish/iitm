import React, { useState, useMemo } from "react";
import { motion, AnimatePresence } from "framer-motion";

const EventList = ({ darkMode }) => {
    const cities = ["Mumbai", "Delhi", "Bengaluru", "Hyderabad", "Ahmedabad", "Chennai", "Kolkata", "Surat", "Pune"];

    const allEvents = [
        { id: 1, city: "Mumbai", title: "Bollywood Tech Summit", date: "April 10, 2026", location: "Juhu, Mumbai", type: "Tech", image: "🎬", color: "from-orange-500 to-red-600" },
        { id: 2, city: "Mumbai", title: "Finance Expo", date: "May 12, 2026", location: "BKC, Mumbai", type: "Finance", image: "💰", color: "from-blue-500 to-indigo-600" },
        { id: 3, city: "Bengaluru", title: "Garden City Startup Fest", date: "June 05, 2026", location: "Indiranagar, BLR", type: "Startup", image: "🦄", color: "from-green-400 to-cyan-500" },
        { id: 4, city: "Delhi", title: "Heritage Food Walk", date: "July 01, 2026", location: "Chandni Chowk, Delhi", type: "Food", image: "🥘", color: "from-yellow-500 to-orange-600" },
        // ... Add more events for other cities as needed
    ];

    const [activeCity, setActiveCity] = useState("Mumbai");
    const [currentIndex, setCurrentIndex] = useState(0);

    // Filter events based on selected city
    const filteredEvents = useMemo(() =>
        allEvents.filter(event => event.city === activeCity),
        [activeCity]);

    const nextEvent = () => {
        setCurrentIndex((prev) => (prev + 1) % filteredEvents.length);
    };

    const prevEvent = () => {
        setCurrentIndex((prev) => (prev - 1 + filteredEvents.length) % filteredEvents.length);
    };

    const currentEvent = filteredEvents[currentIndex];

    return (
        <section className={`py-12 px-6 max-w-5xl mx-auto ${darkMode ? "text-white" : "text-gray-900"}`}>

            {/* 9 City Buttons */}
            <div className="flex flex-wrap justify-center gap-3 mb-12">
                {cities.map((city) => (
                    <button
                        key={city}
                        onClick={() => {
                            setActiveCity(city);
                            setCurrentIndex(0);
                        }}
                        className={`px-5 py-2 rounded-full font-bold text-sm transition-all border-2 ${activeCity === city
                                ? "bg-blue-500 border-blue-500 text-white shadow-lg scale-110"
                                : `${darkMode ? "border-gray-700 hover:border-gray-500" : "border-gray-200 hover:border-blue-200"}`
                            }`}
                    >
                        {city}
                    </button>
                ))}
            </div>

            {/* Single Big Card Area */}
            <div className="relative min-h-[500px] flex items-center justify-center">
                <AnimatePresence mode="wait">
                    {filteredEvents.length > 0 ? (
                        <motion.div
                            key={currentEvent.id}
                            initial={{ opacity: 0, x: 50 }}
                            animate={{ opacity: 1, x: 0 }}
                            exit={{ opacity: 0, x: -50 }}
                            className={`w-full max-w-2xl overflow-hidden rounded-[3rem] border transition-all shadow-2xl ${darkMode ? "bg-gray-800 border-gray-700" : "bg-white border-gray-100"
                                }`}
                        >
                            {/* Visual Header */}
                            <div className={`h-48 bg-gradient-to-r ${currentEvent.color} flex items-center justify-center text-7xl`}>
                                <span>{currentEvent.image}</span>
                            </div>

                            {/* Content */}
                            <div className="p-10 text-center">
                                <span className="inline-block px-4 py-1 rounded-full bg-blue-500/10 text-blue-500 text-xs font-black uppercase mb-4">
                                    {currentEvent.type} • {currentEvent.city}
                                </span>
                                <h3 className="text-4xl font-black mb-4">{currentEvent.title}</h3>
                                <p className="opacity-60 text-lg mb-2 font-bold">{currentEvent.date}</p>
                                <p className="opacity-50 flex items-center justify-center gap-2 mb-8">
                                    <span>📍</span> {currentEvent.location}
                                </p>

                                <button className="w-full py-5 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-black text-lg shadow-xl transition-all">
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

                {/* Navigation Buttons (Only show if multiple events exist) */}
                {filteredEvents.length > 1 && (
                    <>
                        <button
                            onClick={prevEvent}
                            className="absolute left-0 md:-left-16 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white shadow-xl text-black flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all"
                        >
                            ←
                        </button>
                        <button
                            onClick={nextEvent}
                            className="absolute right-0 md:-right-16 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white shadow-xl text-black flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all"
                        >
                            →
                        </button>
                    </>
                )}
            </div>

            {/* Intuitive Redirect */}
            <div className="mt-12 text-center">
                <p className="text-sm opacity-40">
                    Not finding what you need in {activeCity}?
                    <button className="ml-2 underline font-bold hover:text-blue-500">I am confused, help me find!</button>
                </p>
            </div>
        </section>
    );
};

export default EventList;