import React from "react";
import { motion } from "framer-motion";

const Header = ({ darkMode, setDarkMode }) => {
    return React.createElement("header", { className: "relative" },
        // Navigation
        React.createElement("nav", {
            className: `fixed w-full z-50 px-8 py-4 flex justify-between items-center backdrop-blur-md ${darkMode ? "bg-gray-900/80" : "bg-white/80"
                } border-b border-gray-200/20`
        },
            React.createElement(motion.h1, {
                initial: { x: -20, opacity: 0 },
                animate: { x: 0, opacity: 1 },
                className: "text-2xl font-black tracking-tighter",
                style: { color: "#AA2324" } // ✅ header text color
            }, "IITM"),
            React.createElement("div", { className: "flex items-center gap-6" },
                React.createElement("button", {
                    onClick: () => setDarkMode(!darkMode),
                    className: "p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:scale-110 transition"
                }, darkMode ? "☀️" : "🌙"),
                React.createElement("button", {
                    className: "text-white px-6 py-2 rounded-full font-bold hover:shadow-lg transition-all",
                    style: { backgroundColor: "#AA2324", boxShadow: "0 10px 20px rgba(170, 35, 36, 0.5)" } // ✅ button color + shadow
                }, "Get Started")
            )
        ),
        // Hero Section

    );
};

export default Header;