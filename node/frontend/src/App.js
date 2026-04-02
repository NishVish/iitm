import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";

// Import version-specific apps
import WebApp from "./web/main";
import MobileApp from "./mobile/main";
import BackendApp from "./backend/main";

function App() {
  return (
    <Router>
      <Routes>
        {/* Base paths for each version */}
        <Route path="/web/*" element={<WebApp />} />
        <Route path="/mobile/*" element={<MobileApp />} />
        <Route path="/backend/*" element={<BackendApp />} />

        {/* Optional: root redirect */}
        <Route path="*" element={<MobileApp />} />
      </Routes>
    </Router>
  );
}

export default App;