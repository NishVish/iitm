import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Home from "./pages/Home";
import BottomNav from "./components/BottomNav"; // Adjust path if needed

function MobileApp() {
  return React.createElement(
    Router,
    null,
    React.createElement(
      "div",
      { className: "mobile-container" },
      // 1. The Main Content (Routes)
      React.createElement(
        Routes,
        null,
        React.createElement(Route, {
          path: "/home",
          element: React.createElement(Home, null)
        }),
        React.createElement(Route, {
          path: "*",
          element: React.createElement(Home, null)
        })
      ),
      // 2. The Navigation Bar (Always visible)
      React.createElement(BottomNav, null)
    )
  );
}

export default MobileApp;