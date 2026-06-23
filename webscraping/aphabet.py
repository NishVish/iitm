from flask import Flask, jsonify, render_template_string
import requests
import xml.etree.ElementTree as ET
import os

app = Flask(__name__)

URL = "https://live.messebackend.aws.corussoft.de/webservice/search"

HEADERS = {
    "user-agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
    "content-type": "application/x-www-form-urlencoded; charset=UTF-8",
    "referer": "https://www.itb.com/",
    "origin": "https://www.itb.com"
}

session = requests.Session()

@app.route("/count/<letter>")
def get_letter_count(letter):
    # Dynamic payload to capture backend's actual entity count mapping
    payload = {
        "topic": "2023_itb",  
        "subject": "search",
        "os": "web",
        "lang": "en",
        "filterlist": "entity_orga",
        "startresultrow": "0",
        "numresultrows": "1",  
        "order": "lexic",
        "searchterm": letter.lower()
    }

    print(f"\n[DEBUG] Outbound Request Sent -> Letter: {letter.upper()}")
    try:
        r = session.post(URL, data=payload, headers=HEADERS, timeout=15)
        
        # Absolute Terminal Printout to view server feedback raw:
        print(f"[DEBUG] Incoming HTTP Status: {r.status_code}")
        print(f"[DEBUG] First 250 chars of response: {r.text[:250].strip()}")
        
        if r.status_code == 200:
            root = ET.fromstring(r.text)
            total_count = int(root.attrib.get("entities", 0))
            print(f"[DEBUG] Extracted total count attribute: {total_count}")
            return jsonify({"letter": letter.upper(), "count": total_count, "status": "success"})
            
    except Exception as e:
        print(f"[DEBUG] Critical Failure: {e}")
        
    return jsonify({"letter": letter.upper(), "count": 0, "status": "failed"})


@app.route("/")
def ui():
    html = """
    <!DOCTYPE html>
    <html>
    <head>
        <title>ITB Alphabet Grid</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; background-color: #fcfcfc; color: #333; }
            .grid-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 15px; max-width: 1000px; }
            .letter-card { background: #ffffff; border: 2px solid #eaeaea; border-radius: 8px; padding: 20px; text-align: center; cursor: pointer; transition: all 0.2s ease-in-out; }
            .letter-card:hover { border-color: #007bff; transform: translateY(-2px); }
            .letter-char { font-size: 28px; font-weight: bold; color: #222; margin-bottom: 5px; }
            .letter-count { font-size: 13px; color: #888; font-weight: 500; }
            .loading { color: #ffc107 !important; }
            .loaded { color: #28a745 !important; font-size: 16px !important; }
            .failed { color: #dc3545 !important; }
        </style>
    </head>
    <body>

    <h2>ITB Directory Alphabet Checker</h2>
    <p>Click any letter block to run an independent web lookup query against the messebackend.</p>

    <div class="grid-container" id="alphabet-grid"></div>

    <script>
    const grid = document.getElementById("alphabet-grid");
    const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");

    alphabet.forEach(letter => {
        let card = document.createElement("div");
        card.className = "letter-card";
        card.setAttribute("onclick", `fetchCount('${letter}')`);
        card.id = `card-${letter}`;
        card.innerHTML = `
            <div class="letter-char">${letter}</div>
            <div class="letter-count" id="count-${letter}">Click to show count</div>
        `;
        grid.appendChild(card);
    });

    async function fetchCount(letter) {
        const countText = document.getElementById(`count-${letter}`);
        countText.innerText = "Loading...";
        countText.className = "letter-count loading";

        try {
            let res = await fetch(`/count/${letter}`);
            let data = await res.json();
            if (data.status === "success") {
                countText.innerText = `${data.count} entries`;
                countText.className = "letter-count loaded";
            } else {
                countText.innerText = "0 entries";
                countText.className = "letter-count failed";
            }
        } catch (err) {
            countText.innerText = "Network Error";
            countText.className = "letter-count failed";
        }
    }
    </script>
    </body>
    </html>
    """
    return render_template_string(html)


if __name__ == "__main__":
    # Changed port to a completely fresh profile (5500) to stop background process conflicts
    # Explicit host binding ensures access from localhost
    app.run(host="127.0.0.1", port=5500, debug=True)