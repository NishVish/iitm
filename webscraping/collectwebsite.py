import json
import csv
import os
import time
from ddgs import DDGS
INPUT_FILE = "data.json"
OUTPUT_FILE = "companies_with_websites.csv"


# ---------- Load JSON ----------
def load_data():
    with open(INPUT_FILE, "r", encoding="utf-8") as f:
        return json.load(f)


# ---------- Check bad domains ----------
BAD_KEYWORDS = [
    "linkedin", "crunchbase", "facebook", "wikipedia",
    "yelp", "bloomberg", "zoominfo", "dnb.com"
]


def is_valid(url):
    if not url:
        return False
    url_lower = url.lower()
    return not any(bad in url_lower for bad in BAD_KEYWORDS)


# ---------- Search website ----------
def get_website(company_name, country):
    query = f"{company_name} official website {country}"

    try:
        with DDGS() as ddgs:
            results = ddgs.text(query, max_results=5)

            for r in results:
                url = r.get("href")

                if is_valid(url):
                    return url

            # fallback
            if results:
                return results[0].get("href")

    except Exception as e:
        print(f"Search error for {company_name}: {e}")

    return None


# ---------- Load already processed (resume support) ----------
def load_existing_ids():
    if not os.path.exists(OUTPUT_FILE):
        return set()

    ids = set()
    with open(OUTPUT_FILE, "r", encoding="utf-8") as f:
        reader = csv.DictReader(f)
        for row in reader:
            ids.add(row["id"])
    return ids


# ---------- Create CSV if not exists ----------
def init_csv():
    if not os.path.exists(OUTPUT_FILE):
        with open(OUTPUT_FILE, "w", newline="", encoding="utf-8") as f:
            writer = csv.writer(f)
            writer.writerow(["id", "name", "country", "website"])


# ---------- Main ----------
def main():
    data = load_data()
    processed_ids = load_existing_ids()
    init_csv()

    print(f"Total records: {len(data)}")
    print(f"Already processed: {len(processed_ids)}")

    for i, item in enumerate(data):
        company_id = str(item.get("id"))
        name = item.get("name")
        country = item.get("country")

        if company_id in processed_ids:
            continue

        print(f"[{i+1}/{len(data)}] Searching: {name}")

        website = get_website(name, country)

        # append immediately (safe)
        with open(OUTPUT_FILE, "a", newline="", encoding="utf-8") as f:
            writer = csv.writer(f)
            writer.writerow([company_id, name, country, website])

        time.sleep(0.2)  # light delay to avoid blocking


if __name__ == "__main__":
    main()