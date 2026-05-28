import { McpServer } from "@modelcontextprotocol/sdk/server/mcp.js";
import { StdioServerTransport } from "@modelcontextprotocol/sdk/server/stdio.js";
import axios from "axios";

const server = new McpServer({
  name: "laravel-mcp",
  version: "1.0.0",
});

// ✅ TOOL: get_users
server.tool(
  "get_users",
  "Fetch users from Laravel /userdata API",
  {},
  async () => {
    const res = await axios.get("http://127.0.0.1:8000/userdata");

    return {
      content: [
        {
          type: "text",
          text: JSON.stringify(res.data, null, 2),
        },
      ],
    };
  }
);

const transport = new StdioServerTransport();
await server.connect(transport);