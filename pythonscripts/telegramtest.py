import requests
import time

# -----------------------------
# Configuration
# -----------------------------

with open("telegramtoken.txt", "r", encoding="utf-8") as f:
    BOT_TOKEN = f.read().strip()

BASE_URL = f"https://api.telegram.org/bot{BOT_TOKEN}"

# Your local AI/agent API
AGENT_URL = "http://127.0.0.1:1234/agent"


# -----------------------------
# Telegram functions
# -----------------------------

def get_updates(offset=None):
    params = {
        "timeout": 30
    }

    if offset is not None:
        params["offset"] = offset

    response = requests.get(
        f"{BASE_URL}/getUpdates",
        params=params,
        timeout=35
    )

    response.raise_for_status()
    return response.json()


def send_message(chat_id, text):
    response = requests.post(
        f"{BASE_URL}/sendMessage",
        data={
            "chat_id": chat_id,
            "text": text
        },
        timeout=10
    )

    response.raise_for_status()
    return response.json()


def delete_webhook():
    """
    Remove any Telegram webhook so getUpdates polling can work.
    """
    try:
        response = requests.post(
            f"{BASE_URL}/deleteWebhook",
            json={
                "drop_pending_updates": False
            },
            timeout=10
        )

        response.raise_for_status()

        result = response.json()
        print("Webhook:", result)

        return result

    except Exception as e:
        print("Webhook error:", e)
        return None


# -----------------------------
# AI / Local Agent function
# -----------------------------

def ask_ai(user_message):
    """
    Send the Telegram user's message to your local agent API.

    Equivalent to:

        Http::timeout(120)->post(
            'http://127.0.0.1:1234/agent',
            [
                'message' => $request->message,
            ]
        );
    """

    try:
        response = requests.post(
            AGENT_URL,
            json={
                "message": user_message
            },
            timeout=120
        )

        response.raise_for_status()

        # Try JSON response first
        try:
            data = response.json()
        except ValueError:
            # If your API returns plain text
            return response.text.strip()

        # -----------------------------------------
        # Adjust these depending on your API output
        # -----------------------------------------

        if isinstance(data, dict):

            # Common response formats
            if "message" in data:
                return str(data["message"])

            if "response" in data:
                return str(data["response"])

            if "reply" in data:
                return str(data["reply"])

            if "answer" in data:
                return str(data["answer"])

            # If API returns {"data": "..."}
            if "data" in data:
                if isinstance(data["data"], str):
                    return data["data"]

                if isinstance(data["data"], dict):
                    for key in ["message", "response", "reply", "answer"]:
                        if key in data["data"]:
                            return str(data["data"][key])

            # Fallback: return JSON
            return str(data)

        # If JSON response is a string/list/etc.
        return str(data)

    except requests.exceptions.Timeout:
        return "Sorry, the AI agent took too long to respond."

    except requests.exceptions.ConnectionError:
        return (
            "Sorry, I cannot connect to the local AI agent. "
            "Please make sure the agent is running at "
            f"{AGENT_URL}"
        )

    except requests.exceptions.HTTPError as e:
        print("Agent HTTP error:", e)

        try:
            print("Agent response:", response.text)
        except Exception:
            pass

        return "Sorry, the AI agent returned an error."

    except Exception as e:
        print("Agent error:", e)
        return "Sorry, something went wrong while processing your message."


# -----------------------------
# Main loop
# -----------------------------

print("🤖 Starting Telegram bot...")

# Remove webhook if one exists.
delete_webhook()

offset = None

print("🤖 Bot is running...")


while True:

    try:

        result = get_updates(offset)

        if not result.get("ok"):
            print("Telegram error:", result)

            # Telegram 409 means another getUpdates
            # process is currently using this bot token.
            if result.get("error_code") == 409:
                print(
                    "⚠️ Another bot instance is using this Telegram token."
                )
                print(
                    "Stop the other bot process before continuing."
                )

                time.sleep(5)
                continue

            time.sleep(2)
            continue

        for update in result.get("result", []):

            # Move offset forward so we don't process
            # the same message again.
            offset = update["update_id"] + 1

            message = update.get("message")

            if not message:
                continue

            chat_id = message["chat"]["id"]

            user_text = message.get("text")

            # Ignore messages without text
            if not user_text:
                continue

            print()
            print("--------------------------------")
            print(f"👤 User: {user_text}")
            print("🤔 Thinking...")

            # -------------------------
            # Send to local AI agent
            # -------------------------

            reply = ask_ai(user_text)

            print(f"🤖 Reply: {reply}")

            # -------------------------
            # Send response to Telegram
            # -------------------------

            if reply:

                # Telegram has a message length limit.
                # Split very long AI responses.
                max_length = 4000

                for i in range(0, len(reply), max_length):

                    chunk = reply[i:i + max_length]

                    send_message(
                        chat_id,
                        chunk
                    )

            print("--------------------------------")


    except requests.exceptions.Timeout:
        print("⏱️ Telegram request timed out. Retrying...")
        time.sleep(2)

    except requests.exceptions.ConnectionError:
        print("🌐 Connection error. Retrying...")
        time.sleep(3)

    except KeyboardInterrupt:
        print()
        print("🛑 Bot stopped.")
        break

    except Exception as e:
        print("❌ Error:", e)
        time.sleep(3)