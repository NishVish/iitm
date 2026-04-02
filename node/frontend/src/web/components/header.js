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
                className: "text-2xl font-black tracking-tighter text-blue-500"
            }, "VANTAGE"),
            React.createElement("div", { className: "flex items-center gap-6" },
                React.createElement("button", {
                    onClick: () => setDarkMode(!darkMode),
                    className: "p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:scale-110 transition"
                }, darkMode ? "☀️" : "🌙"),
                React.createElement("button", {
                    className: "bg-blue-600 text-white px-6 py-2 rounded-full font-bold hover:shadow-lg hover:shadow-blue-500/50 transition-all"
                }, "Get Started")
            )
        ),
        // Hero Section
        React.createElement("div", { className: "relative pt-32 pb-20 px-8 overflow-hidden" },
            React.createElement(motion.div, {
                initial: { y: 50, opacity: 0 },
                animate: { y: 0, opacity: 1 },
                transition: { duration: 0.8 },
                className: "relative z-10 text-center"
            },
                React.createElement("span", { className: "text-blue-500 font-bold tracking-widest uppercase text-sm" }, "Beyond Boundaries"),
                React.createElement("h2", { className: "text-6xl md:text-8xl font-extrabold mt-4 mb-6 tracking-tight" },
                    "Design. ",
                    React.createElement("span", { className: "text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600" }, "Build."),
                    " Scale."
                ),
                React.createElement("p", { className: "text-xl opacity-70 max-w-xl mx-auto mb-8" },
                    "The next generation of exhibition organizing. We don't just host events; we build immersive ecosystems."
                )
            ),
            // Animated Background
            React.createElement(motion.div, {
                animate: { rotate: 360 },
                transition: { duration: 20, repeat: Infinity, ease: "linear" },
                className: "absolute -top-20 -right-20 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"
            })
        )
    );
};

export default Header;