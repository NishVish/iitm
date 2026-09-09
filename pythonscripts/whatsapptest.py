import requests

# =========================
# CONFIGURATION
# =========================

ACCESS_TOKEN = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY5ZjMyNDBjOTUzNWQ4MGUxYzhmYmViMSIsIm5hbWUiOiJTcGhlcmUgVHJhdmVsbWVkaWEiLCJhcHBOYW1lIjoiQWlTZW5zeSIsImNsaWVudElkIjoiNjlmMzI0MGM5NTM1ZDgwZTFjOGZiZWFjIiwiYWN0aXZlUGxhbiI6IkJBU0lDX01PTlRITFkiLCJpYXQiOjE3Nzc3MTcyNTR9.wph-Nd8_G9TiWbrruT-ns9U9dPiip9gGN5sC_nEPFaY"
PHONE_NUMBER_ID = "7022543619"
TO_PHONE_NUMBER = "7909075195"  # Recipient's WhatsApp number, country code included

# =========================
# SEND MESSAGE
# =========================

url = f"https://graph.facebook.com/v23.0/{PHONE_NUMBER_ID}/messages"

headers = {
    "Authorization": f"Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
}

payload = {
    "messaging_product": "whatsapp",
    "to": TO_PHONE_NUMBER,
    "type": "text",
    "text": {
        "body": "Hello! 👋 WhatsApp API test from Python."
    }
}

response = requests.post(
    url,
    headers=headers,
    json=payload
)

print("Status:", response.status_code)
print("Response:")
print(response.text)
