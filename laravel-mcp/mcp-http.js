import express from "express";
import axios from "axios";

const app = express();
app.use(express.json());

// 🧠 Home route (THIS gives you a clickable link in browser)
app.get("/", (req, res) => {
  res.json({
    status: "MCP HTTP Bridge Running",
    base_url: "http://localhost:3001",
    tools: {
      get_users: "http://localhost:3001/tools/get_users"
    }
  });
});

// 🧠 TOOL: get_users
app.get("/tools/get_users", async (req, res) => {
  try {
    const result = await axios.get(
      "http://localhost/iitm/lara/mcp/users"
    );

    res.json({
      tool: "get_users",
      laravel_api: "http://localhost/iitm/lara/mcp/users",
      data: result.data
    });

  } catch (err) {
    res.json({
      error: err.message
    });
  }
});

// 🚀 START SERVER
app.listen(3001, () => {
  console.log("=================================");
  console.log(" MCP HTTP Bridge Running");
  console.log(" URL: http://localhost:3001");
  console.log(" Tool: http://localhost:3001/tools/get_users");
  console.log("=================================");
});