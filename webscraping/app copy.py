from flask import Flask, jsonify, render_template_string
import requests
import xml.etree.ElementTree as ET
import json
import os

app = Flask(__name__)

DATA_FILE = "data.json"
URL = "https://live.messebackend.aws.corussoft.de/webservice/search"

HEADERS = {
    "user-agent": "Mozilla/5.0",
    "content-type": "application/x-www-form-urlencoded; charset=UTF-8",
    "referer": "https://www.itb.com/"
}

def scrape_all():
    all_orgs = []
    start = 0
    page_size =5605

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

        r = requests.post(URL, data=payload, headers=HEADERS)

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

        start += page_size

        print("Fetched:", len(all_orgs))

        if start >= int(root.attrib.get("entities", 0)):
            break

    return all_orgs


@app.route("/scrape")
def run_scrape():
    data = scrape_all()

    with open(DATA_FILE, "w", encoding="utf-8") as f:
        json.dump(data, f, indent=2, ensure_ascii=False)

    return jsonify({
        "status": "done",
        "count": len(data)
    })


@app.route("/data")
def get_data():
    if not os.path.exists(DATA_FILE):
        return jsonify({"error": "No data found. Run /scrape first."})

    with open(DATA_FILE, "r", encoding="utf-8") as f:
        return jsonify(json.load(f))


@app.route("/")
def ui():
    html = """
    <html>
    <head>
        <title>ITB Exhibitors</title>
        <style>
            body { font-family: Arial; margin: 20px; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #ddd; padding: 8px; }
            th { background: #333; color: white; }
            tr:nth-child(even){background-color: #f2f2f2;}
        </style>
    </head>
    <body>

    <h2>ITB Exhibitors Dashboard</h2>

    <button onclick="loadData()">Load Data</button>
    <button onclick="runScrape()">Scrape Again</button>

    <p id="status"></p>

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
    async function loadData(){
        let res = await fetch('/data');
        let data = await res.json();

        let tbody = document.querySelector("tbody");
        tbody.innerHTML = "";

        data.forEach(item => {
            let row = `<tr>
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>${item.country}</td>
                <td>${item.initials}</td>
            </tr>`;
            tbody.innerHTML += row;
        });

        document.getElementById("status").innerText =
            "Loaded " + data.length + " records";
    }

    async function runScrape(){
        document.getElementById("status").innerText = "Scraping...";
        let res = await fetch('/scrape');
        let data = await res.json();
        document.getElementById("status").innerText =
            "Scraped " + data.count + " records";
        loadData();
    }
    </script>

    </body>
    </html>
    """
    return render_template_string(html)


if __name__ == "__main__":
    app.run(debug=True)