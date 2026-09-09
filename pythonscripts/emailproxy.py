import asyncio
import logging
import json
import os
import email
from email.policy import default
from datetime import datetime
from threading import Thread
from aiosmtpd.controller import Controller
import aiosmtplib
from flask import Flask, jsonify, render_template_string

# --- CONFIGURATION ---
JSON_FILE = "emails.json"
SMTP_HOST = "127.0.0.1"
SMTP_PORT = 25
FLASK_HOST = "127.0.0.1"
FLASK_PORT = 5000

# True = Send real emails through Gmail | False = Mock mode
SEND_REAL_EMAIL = True  

use =2 
if use==1:
    

    GMAIL_SMTP_SERVER = "smtp.gmail.com"
    GMAIL_SMTP_PORT = 587
    GMAIL_USER = "nishwakarma3@gmail.com"
    GMAIL_APP_PASSWORD = "ljmdfpssnrunmkyz"
else:

    GMAIL_SMTP_SERVER = "smtp.gmail.com"
    GMAIL_SMTP_PORT = 587
    GMAIL_USER = "vishwa@iitmindia.com"
    GMAIL_APP_PASSWORD = "uyrcxqhiwfpnsywq"


logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')

if not os.path.exists(JSON_FILE) or os.stat(JSON_FILE).st_size == 0:
    with open(JSON_FILE, "w") as f:
        json.dump([], f)

def extract_html_body(raw_bytes):
    """Uses Python's core email library to strictly isolate text/html parts"""
    try:
        msg = email.message_from_bytes(raw_bytes, policy=default)
        html_part = msg.get_body(preferencelist=('html',))
        if html_part:
            return html_part.get_content()
        
        # If no strict html tree component was found, walk parts
        for part in msg.walk():
            if part.get_content_type() == "text/html":
                return part.get_content()
            
        # Fallback to plain text part if html is fully missing
        text_part = msg.get_body(preferencelist=('plain',))
        if text_part:
            return f"<pre>{text_part.get_content()}</pre>"
    except Exception as e:
        logging.error(f"Parsing optimization failed: {e}")
        
    return raw_bytes.decode('utf-8', errors='replace')

def save_to_json(sender, recipients, raw_bytes, status):
    try:
        content_text = raw_bytes.decode('utf-8', errors='replace')
        html_body = extract_html_body(raw_bytes)
        
        with open(JSON_FILE, "r+") as f:
            data = json.load(f)
            new_entry = {
                "timestamp": datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
                "from": sender,
                "to": recipients,
                "content": content_text,
                "html_body": html_body,
                "status": status
            }
            data.append(new_entry)
            f.seek(0)
            json.dump(data, f, indent=4)
            f.truncate()
    except Exception as e:
        logging.error(f"Error saving to JSON: {e}")

# --- SMTP SERVER & GMAIL RELAY ---
class GmailForwardingHandler:
    async def handle_DATA(self, server, session, envelope):
        sender = envelope.mail_from
        recipients = envelope.rcpt_tos
        data = envelope.content  

        if not SEND_REAL_EMAIL:
            logging.info(f"--- MOCK MODE ACTIVE (Email not sent) ---")
            save_to_json(sender, recipients, data, "Mocked (Not Sent)")
            return '250 OK'

        logging.info(f"Relaying mail from {sender} to {recipients} via Gmail SMTP...")
        try:
            smtp_client = aiosmtplib.SMTP(
                hostname=GMAIL_SMTP_SERVER, 
                port=GMAIL_SMTP_PORT,
                start_tls=True,
                validate_certs=False
            )
            await smtp_client.connect()
            await smtp_client.login(GMAIL_USER, GMAIL_APP_PASSWORD)
            await smtp_client.sendmail(sender, recipients, data)
            await smtp_client.quit()
            
            logging.info("Email relayed to Gmail successfully!")
            save_to_json(sender, recipients, data, "Sent Successfully")
            return '250 OK'

        except Exception as e:
            error_msg = str(e)
            logging.error(f"CRITICAL RELAY FAILURE: {error_msg}", exc_info=True)
            save_to_json(sender, recipients, data, f"Failed: {error_msg}")
            return '451 Requested action aborted: local error in processing'

async def run_smtp():
    handler = GmailForwardingHandler()
    controller = Controller(handler, hostname=SMTP_HOST, port=SMTP_PORT)
    controller.start()
    try:
        while True:
            await asyncio.sleep(3600)
    except asyncio.CancelledError:
        pass
    finally:
        controller.stop()

def start_smtp_loop():
    asyncio.run(run_smtp())

# --- FLASK SERVER ---
app = Flask(__name__)

HTML_TEMPLATE = """
<!DOCTYPE html>
<html>
<head>
    <title>SMTP Proxy Logs</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f6f9; }
        h1 { color: #333; }
        .card { background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .meta { color: #666; font-size: 0.9em; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #eee; }
        .status { font-weight: bold; padding: 2px 6px; border-radius: 4px; font-size: 0.85em; }
        .status-success { background: #d4edda; color: #155724; }
        .status-failed { background: #f8d7da; color: #721c24; }
        .status-mock { background: #fff3cd; color: #856404; }
        .html-render-window { border: 1px solid #ddd; border-radius: 4px; padding: 15px; background: #fff; min-height: 100px; }
    </style>
</head>
<body>
    <h1>Incoming Mail Logs (HTML Preview Rendered)</h1>
    <div id="logs"></div>

    <script>
        async function loadLogs() {
            try {
                const res = await fetch('/api/emails');
                const data = await res.json();
                const container = document.getElementById('logs');
                
                // Track entries tracking count safely
                const logsData = data.reverse();
                
                container.innerHTML = logsData.map((email, index) => {
                    let statusClass = "status-failed";
                    if (email.status === "Sent Successfully") statusClass = "status-success";
                    if (email.status === "Mocked (Not Sent)") statusClass = "status-mock";
                    
                    return `
                        <div class="card">
                            <div class="meta">
                                <strong>Time:</strong> ${email.timestamp} | 
                                <strong>From:</strong> ${email.from} | 
                                <strong>To:</strong> ${email.to.join(', ')} | 
                                <span class="status ${statusClass}">${email.status}</span>
                            </div>
                            <iframe id="iframe-${index}" class="html-render-window" width="100%" frameborder="0" onload="resizeIframe(this)"></iframe>
                        </div>
                    `;
                }).join('');

                logsData.forEach((email, index) => {
                    const iframe = document.getElementById(`iframe-${index}`);
                    if (iframe) {
                        const doc = iframe.contentWindow.document;
                        doc.open();
                        doc.write(email.html_body || "<p style='color:#999;'>No HTML content found</p>");
                        doc.close();
                    }
                });

            } catch (err) {
                console.error("Error loading logs:", err);
            }
        }

        function resizeIframe(obj) {
            obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
        }

        loadLogs();
        setInterval(loadLogs, 4000);
    </script>
</body>
</html>
"""

@app.route('/')
def home():
    return render_template_string(HTML_TEMPLATE)

@app.route('/api/emails')
def get_emails():
    with open(JSON_FILE, "r") as f:
        return jsonify(json.load(f))

if __name__ == '__main__':
    smtp_thread = Thread(target=start_smtp_loop, daemon=True)
    smtp_thread.start()
    print(f"\n🚀 Dashboard operational: http://{FLASK_HOST}:{FLASK_PORT}\n")
    app.run(host=FLASK_HOST, port=FLASK_PORT, debug=False)