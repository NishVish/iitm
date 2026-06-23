from flask import Flask, jsonify, render_template_string
import requests
import xml.etree.ElementTree as ET
import json
import os
import threading
import time
import random
import string

app = Flask(__name__)

DATA_FILE = "data.json"
URL = "https://live.messebackend.aws.corussoft.de/webservice/search"

HEADERS = {
    "user-agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36",
    "content-type": "application/x-www-form-urlencoded; charset=UTF-8",
    "referer": "https://www.itb.com/"
}

# Advanced Global tracking state
PROGRESS = {
    "is_running": False,
    "current_letter": "Starting...",
    "current_start_row": 0,
    "total_saved": 0
}
def scrape_all_background():
    global PROGRESS
    PROGRESS["is_running"] = True
    PROGRESS["total_saved"] = 0

    all_orgs = []
    seen_ids = set()
    page_size = 500

    for current_char in string.ascii_lowercase:
        PROGRESS["current_letter"] = current_char.upper()
        start = 0

        while True:
            PROGRESS["current_start_row"] = start

            payload = {
                "topic": "2023_itb",
                "subject": "search",
                "os": "web",
                "lang": "en",
                "filterlist": "entity_orga",
                "startresultrow": str(start),
                "numresultrows": str(page_size),
                "order": "lexic",
                "searchterm": current_char
            }

            try:
                r = requests.post(URL, data=payload, headers=HEADERS, timeout=30)
                if r.status_code != 200:
                    print(f"Error status {r.status_code} on letter {current_char}")
                    break

                root = ET.fromstring(r.text)
                orgs = root.findall(".//organization")

                if not orgs:
                    break

                new_additions = 0
                for o in orgs:
                    org_id = o.attrib.get("id")
                    if org_id and org_id not in seen_ids:
                        seen_ids.add(org_id)
                        all_orgs.append({
                            "id": org_id,
                            "name": o.attrib.get("name"),
                            "country": o.attrib.get("countryCode"),
                            "initials": o.attrib.get("initials")
                        })
                        new_additions += 1

                PROGRESS["total_saved"] = len(all_orgs)
                print(f"Letter [{current_char.upper()}] Row Offset {start}: Found {len(orgs)} (Added {new_additions} unique). Total collected: {len(all_orgs)}")

                # Only a short page reliably means "end of results for this letter".
                # The 'entities' attribute reflects this page's size, not the total
                # match count, so using it to stop was cutting every letter off at
                # exactly page_size (500).
                if len(orgs) < page_size:
                    break

                # Full page but nothing new added -> server isn't actually advancing
                # with startresultrow (some backends ignore it). Bail instead of
                # looping forever re-fetching the same page.
                if new_additions == 0:
                    print(f"Letter [{current_char.upper()}]: offset {start} returned no new ids, pagination not advancing. Stopping letter.")
                    break

                start += page_size
                time.sleep(random.uniform(0.3, 0.8))

            except Exception as e:
                print(f"Exception during processing letter {current_char}: {e}")
                break

        time.sleep(random.uniform(1.0, 2.0))

    with open(DATA_FILE, "w", encoding="utf-8") as f:
        json.dump(all_orgs, f, indent=2, ensure_ascii=False)

    PROGRESS["is_running"] = False

@app.route("/scrape")
def run_scrape():
    if PROGRESS["is_running"]:
        return jsonify({"status": "already running", "count": PROGRESS["total_saved"]})
    
    threading.Thread(target=scrape_all_background).start()
    return jsonify({"status": "started"})


@app.route("/status")
def get_status():
    return jsonify(PROGRESS)


@app.route("/data")
def get_data():
    if not os.path.exists(DATA_FILE):
        return jsonify([])
    with open(DATA_FILE, "r", encoding="utf-8") as f:
        return jsonify(json.load(f))


@app.route("/")
def ui():
    html = """
    <html>
    <head>
        <title>ITB Deep Scraper Panel</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .panel { margin-bottom: 20px; padding: 15px; background: #f4f4f4; border: 1px solid #ddd; border-radius: 5px; }
            table { border-collapse: collapse; width: 100%; margin-top: 15px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background: #222; color: white; }
            tr:nth-child(even){background-color: #f9f9f9;}
            button { padding: 10px 15px; font-weight: bold; cursor: pointer; }
            #status { font-weight: bold; color: #d9534f; }
        </style>
    </head>
    <body>

    <h2>ITB Exhaustive Deep Scraper Loop</h2>

    <div class="panel">
        <button onclick="runScrape()">Start Deep Alphabetical Sequence</button>
        <button onclick="loadData()">Refresh Table from File</button>
        <p>System Status: <span id="status">Idle</span></p>
    </div>

    <table id="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Country</th>
                <th>Initials</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
    let runner = null;

    async function runScrape(){
        document.getElementById("status").innerText = "Initializing sequence loops...";
        await fetch('/scrape');
        if(!runner) {
            runner = setInterval(updateProgress, 1000);
        }
    }

    async function updateProgress() {
        let res = await fetch('/status');
        let data = await res.json();
        
        if (data.is_running) {
            document.getElementById("status").style.color = "#f0ad4e";
            document.getElementById("status").innerText = 
                `RUNNING | Letter index: ${data.current_letter} | Offset position: ${data.current_start_row} | Unique records gathered: ${data.total_saved}`;
        } else {
            clearInterval(runner);
            runner = null;
            document.getElementById("status").style.color = "#5cb85c";
            document.getElementById("status").innerText = 
                `SUCCESS: Sequence complete. Total of ${data.total_saved} combined entries saved into data.json!`;
            loadData();
        }
    }

    async function loadData(){
        let res = await fetch('/data');
        let data = await res.json();
        let tbody = document.querySelector("tbody");
        tbody.innerHTML = "";

        if(!data.length) {
            tbody.innerHTML = "<tr><td colspan='4'>No items to render yet. Start the script loop above.</td></tr>";
            return;
        }

        let chunk = "";
        data.forEach(item => {
            chunk += `<tr>
                <td>${item.id || ''}</td>
                <td>${item.name || ''}</td>
                <td>${item.country || ''}</td>
                <td>${item.initials || ''}</td>
            </tr>`;
        });
        tbody.innerHTML = chunk;
    }
    </script>
    </body>
    </html>
    """
    return render_template_string(html)


if __name__ == "__main__":
    app.run(debug=True)