import axios from "axios";

const prompt = "How many users?";

async function run() {
  const llmRes = await axios.post("http://localhost:11434/api/generate", {
    model: "llama3",
    temperature: 0,
    prompt: `Return ONLY JSON:
{"tool":"get_users"|"none"}

User: ${prompt}`,
    stream: false
  });

  let decision;
  try {
    decision = JSON.parse(llmRes.data.response.trim());
  } catch {
    decision = { tool: "none" };
  }

  let toolResult = null;

  if (decision.tool === "get_users") {
    const res = await axios.get("http://localhost:3001/tools/get_users");
    toolResult = res.data;
  }

  const finalRes = await axios.post("http://localhost:11434/api/generate", {
    model: "llama3",
    temperature: 0,
    prompt: `
User: ${prompt}
Tool: ${JSON.stringify(toolResult)}

RULES:
If tool is null → say "0 users"
Else → return exact number only
`,
    stream: false
  });

  console.log(finalRes.data.response.trim());
}

run();