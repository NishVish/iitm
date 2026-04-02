import React from "react";
import ReactDOM from "react-dom/client";
import MobileApp from "./mobile/main";
import WebApp from "./web/main";
import BackendApp from "./backend/main";

const root = ReactDOM.createRoot(document.getElementById("root"));
const path = window.location.pathname;

let App;

if (path.startsWith("/backend")) {
    App = BackendApp;
} else if (path.startsWith("/mobile")) {
    App = MobileApp;
} else {
    App = WebApp;
}

root.render(React.createElement(App));