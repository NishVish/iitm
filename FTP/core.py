import os
import socket
import io
import base64
import qrcode
import platform
import subprocess
from flask import Flask

# ==========================
# Flask App
# ==========================
app = Flask(__name__)
app.secret_key = "secret123"

# ==========================
# BASE CONFIG
# ==========================
BASE_DIR = os.path.dirname(os.path.abspath(__file__))

DEPARTMENTS = {
    "sales": {
        "password": "1234",
        "folder": os.path.join(BASE_DIR, "sales_files")
    },
    "hr": {
        "password": "hrpass",
        "folder": os.path.join(BASE_DIR, "hr_files")
    }
}

for dept in DEPARTMENTS.values():
    os.makedirs(dept["folder"], exist_ok=True)

# ==========================
# UTILITIES
# ==========================
def get_local_ip():
    s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    try:
        s.connect(("10.255.255.255", 1))
        ip = s.getsockname()[0]
    except:
        ip = "127.0.0.1"
    finally:
        s.close()
    return ip


def generate_qr_base64(link):
    img = qrcode.make(link)
    buf = io.BytesIO()
    img.save(buf, format="PNG")
    buf.seek(0)
    return base64.b64encode(buf.read()).decode()


def open_directory(path):
    try:
        if platform.system() == "Windows":
            os.startfile(path)
        elif platform.system() == "Darwin":
            subprocess.Popen(["open", path])
        else:
            subprocess.Popen(["xdg-open", path])
    except:
        pass