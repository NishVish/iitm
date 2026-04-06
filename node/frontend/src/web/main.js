import React, { useState } from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Header from "./components/header";
import Home from "./pages/home";
import Stall from "./pages/stall";
import Event from "./pages/eventlist";
import Register from "./pages/register";
import Footer from "./components/footer";

const WebApp = () => {
    const [darkMode, setDarkMode] = useState(false);

    return React.createElement(Router, null,
        React.createElement("div", {
            className: `${darkMode ? "bg-gray-900 text-white" : "bg-gray-50 text-gray-900"} min-h-screen transition-colors duration-500 font-sans`
        },
            // 1. Header
            React.createElement(Header, { darkMode: darkMode, setDarkMode: setDarkMode }),

            // 2. Main Content Area
            React.createElement("main", { className: "container mx-auto py-8" },
                React.createElement(Routes, null,
                    // Main Home Route
                    React.createElement(Route, {
                        path: "/",
                        element: React.createElement(Home, { darkMode: darkMode })
                    }),

                    // Stall Route
                    React.createElement(Route, {
                        path: "/stall",
                        element: React.createElement(Stall, null)
                    }),

                    // Event List Route (Fixed variable name to match import)
                    React.createElement(Route, {
                        path: "/events",
                        element: React.createElement(Event, null)
                    }),

                    // Register Route (Fixed variable name to match import)
                    React.createElement(Route, {
                        path: "/register",
                        element: React.createElement(Register, null)
                    })
                ),

                // This renders the Stall component on EVERY page below the route content
                // React.createElement(Stall, { darkMode: darkMode })
            ),

            // 3. Footer
            React.createElement(Footer, null)
        )
    );
};

export default WebApp;