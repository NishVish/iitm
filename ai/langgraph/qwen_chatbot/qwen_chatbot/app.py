
from flask import Flask, render_template, request, jsonify
import requests

app = Flask(__name__)

# Ollama API
OLLAMA_URL = "http://localhost:11434/api/chat"

# Qwen model
MODEL = "qwen5.7b"


@app.route("/")
def home():
    return render_template("index.html")


@app.route("/chat", methods=["POST"])
def chat():

    data = request.get_json()

    user_message = data.get("message", "").strip()

    if not user_message:
        return jsonify({
            "response": "Please enter a message."
        })


    try:

        response = requests.post(
            OLLAMA_URL,

            json={
                "model": MODEL,

                "messages": [
                    {
                        "role": "user",
                        "content": user_message
                    }
                ],

                "stream": False
            },

            timeout=300
        )


        response.raise_for_status()

        result = response.json()

        answer = result["message"]["content"]


        return jsonify({
            "response": answer
        })


    except Exception as e:

        return jsonify({
            "response": f"Error connecting to Qwen: {e}"
        }), 500


if __name__ == "__main__":

    app.run(
        host="0.0.0.0",
        port=8080,
        debug=False,
        use_reloader=False
    )
