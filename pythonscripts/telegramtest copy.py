import requests
import time

# -----------------------------
# Configuration
# -----------------------------

with open("telegramtoken.txt", "r", encoding="utf-8") as f:
    BOT_TOKEN = f.read().strip()

BASE_URL = f"https://api.telegram.org/bot{BOT_TOKEN}"

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

    return response.json()


# -----------------------------
# AI function
# -----------------------------

def ask_ai(user_message):
    # For now, fake AI response
    # We'll connect your AI API here next.
    return f"I received your message: {user_message}"


# -----------------------------
# Main loop
# -----------------------------

print("🤖 Bot is running...")

offset = None

while True:

    try:
        result = get_updates(offset)

        if not result.get("ok"):
            print("Telegram error:", result)
            time.sleep(2)
            continue

        for update in result["result"]:

            # Move offset forward so we don't process
            # the same message again.
            offset = update["update_id"] + 1

            message = update.get("message")

            if not message:
                continue

            chat_id = message["chat"]["id"]
            user_text = message.get("text")

            if not user_text:
                continue

            print(f"User: {user_text}")

            # -------------------------
            # AI THINKING
            # -------------------------

            print("🤔 Thinking...")

            reply = ask_ai(user_text)

            print(f"🤖 Reply: {reply}")

            # -------------------------
            # Send response
            # -------------------------

            send_message(chat_id, reply)

    except Exception as e:
        print("Error:", e)
        time.sleep(3)


# i have a mysqlserver running on port 3306 at localhost with username 'root' and no password