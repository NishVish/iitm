import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";

import BottomNav from "./components/BottomNav";
// import Footer from "./components/Footer";

import Home from "./pages/Home";
import Calendar from "./pages/Calendar";
import Layout from "./pages/Layout";
import Profile from "./pages/Profile";
import Register from "./pages/Register";

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/home" element={<Home />} />
        <Route path="/calendar" element={<Calendar />} />
        <Route path="/layout" element={<Layout />} />
        <Route path="/profile" element={<Profile />} />
        <Route path="/register" element={<Register />} />
        <Route path="*" element={<Home />} /> {/* fallback */}
      </Routes>
      <BottomNav />
      {/* <Footer /> */}
    </Router>
  );
}

export default App;