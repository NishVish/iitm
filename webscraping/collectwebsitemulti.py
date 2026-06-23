import json
import csv
import os
from ddgs import DDGS
from concurrent.futures import ThreadPoolExecutor, as_completed
import threading

INPUT_FILE = "data.json"
OUTPUT_FILE = "companies_with_websites.csv"

LOCK = threading.Lock()

# ---------- Load JSON ----------
def load_data():
    with open(INPUT_FILE, "r", encoding="utf-8") as f:
        return json.load(f)


# ---------- Bad domains ----------
BAD_KEYWORDS = [
    "linkedin", "crunchbase", "facebook", "wikipedia",
    "yelp", "bloomberg", "zoominfo", "dnb.com"
]


def is_valid(url):
    if not url:
        return False
    url_lower = url.lower()
    return not any(bad in url_lower for bad in BAD_KEYWORDS)


# ---------- Search ----------
def get_website(company_name, country):
    query = f"{company_name} official website {country}"

    try:
        with DDGS() as ddgs:
            results = ddgs.text(query, max_results=5)

            for r in results:
                url = r.get("href")
                if is_valid(url):
                    return url

            if results:
                return results[0].get("href")

    except Exception as e:
        print(f"Error: {company_name} -> {e}")

    return None


# ---------- Load processed IDs ----------
def load_existing_ids():
    if not os.path.exists(OUTPUT_FILE):
        return set()

    ids = set()
    with open(OUTPUT_FILE, "r", encoding="utf-8") as f:
        reader = csv.DictReader(f)
        for row in reader:
            ids.add(row["id"])
    return ids


# ---------- CSV init ----------
def init_csv():
    if not os.path.exists(OUTPUT_FILE):
        with open(OUTPUT_FILE, "w", newline="", encoding="utf-8") as f:
            writer = csv.writer(f)
            writer.writerow(["id", "name", "country", "website"])


# ---------- Worker ----------
def process_company(item):
    company_id = str(item.get("id"))
    name = item.get("name")
    country = item.get("country")

    website = get_website(name, country)

    return {
        "id": company_id,
        "name": name,
        "country": country,
        "website": website
    }


# ---------- Main ----------
def main():
    data = load_data()
    processed_ids = load_existing_ids()
    init_csv()

    # filter already processed
    data = [d for d in data if str(d.get("id")) not in processed_ids]

    print(f"Remaining records: {len(data)}")

    MAX_THREADS = 10  # safe for DDGS

    with ThreadPoolExecutor(max_workers=MAX_THREADS) as executor:
        futures = [executor.submit(process_company, item) for item in data]

        for i, future in enumerate(as_completed(futures)):
            result = future.result()

            # thread-safe write
            with LOCK:
                with open(OUTPUT_FILE, "a", newline="", encoding="utf-8") as f:
                    writer = csv.writer(f)
                    writer.writerow([
                        result["id"],
                        result["name"],
                        result["country"],
                        result["website"]
                    ])

            print(f"[{i+1}/{len(data)}] Done: {result['name']}")


if __name__ == "__main__":
    main()