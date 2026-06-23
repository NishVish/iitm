from flask import Flask, jsonify, render_template_string
import requests
import xml.etree.ElementTree as ET
import json
import os
import threading
import time

app = Flask(__name__)

DATA_FILE = "data.json"
URL = "https://live.messebackend.aws.corussoft.de/webservice/search"

HEADERS = {
    "user-agent": "Mozilla/5.0",
    "content-type": "application/x-www-form-urlencoded; charset=UTF-8",
    "referer": "https://www.itb.com/"
}

# Global tracker for progress monitoring
PROGRESS = {
    "is_running": False,
    "pages_completed": 0,
    "total_saved": 0
}

def scrape_all_background():
    global PROGRESS
    PROGRESS["is_running"] = True
    PROGRESS["pages_completed"] = 0
    PROGRESS["total_saved"] = 0

    all_orgs = []
    start = 0
    page_size = 500  # Set to 500 entries per page

    while True:
        payload = {
            "topic": "2023_itb",
            "subject": "search",
            "os": "web",
            "lang": "en",
            "filterlist": "entity_orga",
            "startresultrow": str(start),
            "numresultrows": str(page_size),
            "order": "lexic"
        }

        try:
            r = requests.post(URL, data=payload, headers=HEADERS, timeout=30)
            if r.status_code != 200:
                break
            
            root = ET.fromstring(r.text)
            orgs = root.findall(".//organization")

            if not orgs:
                break

            for o in orgs:
                all_orgs.append({
                    "id": o.attrib.get("id"),
                    "name": o.attrib.get("name"),
                    "country": o.attrib.get("countryCode"),
                    "initials": o.attrib.get("initials")
                })

            PROGRESS["pages_completed"] += 1
            PROGRESS["total_saved"] = len(all_orgs)

            # Check if we have gathered all records based on total available entities attribute
            total_entities = int(root.attrib.get("entities", 0))
            
            start += page_size
            
            # Print to console for server-side debugging
            print(f"Page {PROGRESS['pages_completed']} fetched. Current total: {len(all_orgs)}")

            if start >= total_entities or len(orgs) < page_size:
                break
                
            # Small courteous delay between page requests
            time.sleep(0.5)

        except Exception as e:
            print(f"Error encountered: {e}")
            break

    # At the very last, write the combined dataset to data.json
    with open(DATA_FILE, "w", encoding="utf-8") as f:
        json.dump(all_orgs, f, indent=2, ensure_ascii=False)

    PROGRESS["is_running"] = False


@app.route("/scrape")
def run_scrape():
    if PROGRESS["is_running"]:
        return jsonify({"status": "already running", "count": PROGRESS["total_saved"]})
    
    # Threading prevents the page request from timing out
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
        <title>ITB Exhibitors</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .control-panel { margin-bottom: 20px; padding: 15px; background: #f7f7f7; border: 1px solid #ddd; border-radius: 4px; }
            table { border-collapse: collapse; width: 100%; margin-top: 15px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background: #333; color: white; }
            tr:nth-child(even){background-color: #f2f2f2;}
            button { padding: 10px 15px; font-size: 14px; cursor: pointer; margin-right: 10px; }
            #status { font-weight: bold; color: #0066cc; }
        </style>
    </head>
    <body>

    <h2>ITB Exhibitors Dashboard</h2>

    <div class="control-panel">
        <button onclick="runScrape()">Scrape in Batches of 500</button>
        <button onclick="loadData()">Load Data From File</button>
        <p id="status">Idle</p>
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
    let intervalId = null;

    async function runScrape(){
        document.getElementById("status").innerText = "Starting scrape session...";
        let res = await fetch('/scrape');
        let data = await res.json();
        
        if(!intervalId) {
            intervalId = setInterval(checkProgress, 1000);
        }
    }

    async function checkProgress() {
        let res = await fetch('/status');
        let progress = await res.json();
        
        if (progress.is_running) {
            document.getElementById("status").innerText = 
                `Scraping... Pages fetched: ${progress.pages_completed} | Records loaded in memory: ${progress.total_saved}`;
        } else {
            clearInterval(intervalId);
            intervalId = null;
            document.getElementById("status").innerText = 
                `Done! Finished combining pages. Total saved to data.json: ${progress.total_saved}`;
            loadData(); // Auto-render the final combined JSON inside the table
        }
    }

    async function loadData(){
        let res = await fetch('/data');
        let data = await res.json();

        let tbody = document.querySelector("tbody");
        tbody.innerHTML = "";

        if(data.length === 0 || data.error) {
            tbody.innerHTML = "<tr><td colspan='4'>No data saved in data.json yet. Click Scrape.</td></tr>";
            return;
        }

        // Display rows inside UI table
        let rowsHtml = "";
        data.forEach(item => {
            rowsHtml += `<tr>
                <td>${item.id || ''}</td>
                <td>${item.name || ''}</td>
                <td>${item.country || ''}</td>
                <td>${item.initials || ''}</td>
            </tr>`;
        });
        tbody.innerHTML = rowsHtml;
    }
    </script>

    </body>
    </html>
    """
    return render_template_string(html)


if __name__ == "__main__":
    app.run(debug=True)