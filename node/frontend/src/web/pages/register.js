import React, { useState } from "react";
import { motion } from "framer-motion";

const Register = ({ darkMode }) => {
    // Input style helper for consistency
    const inputClass = `w-full p-4 rounded-xl border transition-all outline-none focus:ring-2 focus:ring-blue-500 ${darkMode ? "bg-gray-800 border-gray-700 text-white" : "bg-white border-gray-200 text-gray-900"
        }`;

    return React.createElement("div", { className: "min-h-screen py-20 px-8" },
        React.createElement("div", { className: "max-w-2xl mx-auto" },
            // Header Section
            React.createElement("div", { className: "text-center mb-12" },
                React.createElement(motion.h1, {
                    initial: { opacity: 0, y: -20 },
                    animate: { opacity: 1, y: 0 },
                    className: "text-4xl font-black mb-4"
                }, "Event Registration"),
                React.createElement("p", { className: "opacity-60" }, "Join our next global event. Fill out the details below to secure your spot.")
            ),

            // Main Form Card
            React.createElement(motion.div, {
                initial: { opacity: 0, scale: 0.95 },
                animate: { opacity: 1, scale: 1 },
                className: `p-8 md:p-12 rounded-3xl shadow-2xl border ${darkMode ? "bg-gray-900/50 border-gray-800" : "bg-white border-gray-100"
                    }`
            },
                React.createElement("form", { className: "space-y-6" },
                    // Name Fields
                    React.createElement("div", { className: "grid md:grid-cols-2 gap-6" },
                        React.createElement("div", null,
                            React.createElement("label", { className: "block mb-2 font-semibold text-sm" }, "First Name"),
                            React.createElement("input", { type: "text", placeholder: "Jane", className: inputClass })
                        ),
                        React.createElement("div", null,
                            React.createElement("label", { className: "block mb-2 font-semibold text-sm" }, "Last Name"),
                            React.createElement("input", { type: "text", placeholder: "Doe", className: inputClass })
                        )
                    ),

                    // Contact Info
                    React.createElement("div", null,
                        React.createElement("label", { className: "block mb-2 font-semibold text-sm" }, "Email Address"),
                        React.createElement("input", { type: "email", placeholder: "jane@company.com", className: inputClass })
                    ),

                    // Selection Dropdown (Event Type)
                    React.createElement("div", null,
                        React.createElement("label", { className: "block mb-2 font-semibold text-sm" }, "Registration Type"),
                        React.createElement("select", { className: inputClass },
                            React.createElement("option", null, "Attendee"),
                            React.createElement("option", null, "Exhibitor / Stall Owner"),
                            React.createElement("option", null, "Speaker"),
                            React.createElement("option", null, "Media / Press")
                        )
                    ),

                    // Additional Requirements
                    React.createElement("div", null,
                        React.createElement("label", { className: "block mb-2 font-semibold text-sm" }, "Special Requirements"),
                        React.createElement("textarea", {
                            rows: 4,
                            placeholder: "Dietary restrictions, accessibility needs, etc.",
                            className: inputClass
                        })
                    ),

                    // Submit Button
                    React.createElement(motion.button, {
                        whileHover: { scale: 1.02 },
                        whileTap: { scale: 0.98 },
                        type: "submit",
                        className: "w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-xl transition-all"
                    }, "Complete Registration")
                )
            ),

            // Help Footer
            React.createElement("p", { className: "text-center mt-8 text-sm opacity-50" },
                "Already registered? ",
                React.createElement("a", { href: "#", className: "text-blue-500 hover:underline" }, "Check your status")
            )
        )
    );
};

export default Register;