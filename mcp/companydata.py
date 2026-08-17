import re
import pandas as pd
import requests
from bs4 import BeautifulSoup
from ddgs import DDGS
from concurrent.futures import ThreadPoolExecutor, as_completed
from urllib.parse import urljoin

EMAIL_PATTERN = r"[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}"

companies = [
    "HOTEL ARASAN SAPTHAGIRI",
"AIRFIT HOLIDAYS PVT LTD",
"TRIP TREK HOLIDAYS",
"HYDERABAD ADVENTURE CLUB",
"ANNA MARIA TRAVELS & TOURS PTY LTD",
"DAYASAKTI TRAVEL AND TOURS",
"GEO TOURS",
"HM TOURISM",
"LUXARA HOLIDAYS",
"ONESTEPS TOUR & HOLIDAYS",
"BOUNDLESS JOURNEY",
"SARA TOURISM",
"ANDAMAN DESTINATIONS",
"RADVIKA TOUR AND TRAVEL",
"A S TOURS AND TRAVELS",
"PAISA FARM STAY",
"PONDY OCEAN PARK",
"WANDERLUST TRAVEL PLANNER",
"TRABLISS HOLIDAYS",
"MJT TOURS AND TRAVELS",
"KAIKAATTI TOURSS",
"TERN VOYAGES PRIVATE LIMITED",
"D & D TRANSPORTS",
"MARVEL AIR TRAVELS",
"NEON LEISURES PRIVATE LIMITED",
"POOJA TRAVELS",
"VIBES LANKA TRAVELS & TOURS",
"ECO STAY",
"BAGSANDMAPS TRAVEL LLP",
"INDIAN HOTELS COMPANY LIMITED",
"URP HOLIDAYS & VACATIONS",
"TRAVELSUDEUP",
"DLH TRAVEL CAFE",
"THE LEELA",
"DREAMCREW",
"SEVEN HILLS HOTEL",
"KSP HOLIDAYS",
"FLYWALKSAIL EXPERIENCES",
"GLOBAL ASIA JOURNEY",
"VETRI TOURS N TRAVELS",
"HAPPY HOLIDAYERS",
"TRAVELSIDEUP",
"YAZHSTRIPS",
"GOVINDAM RETREAT",
"HIMALAYAN CHAIN RESORTS PVT.LTD",
"YANA TRIPS",
"YEAR ROUND HOLIDAYS INDIA",
"BOOKING JUNCTION PVT LTD",
"GEO VISITS TOURISM EXPERTS",
"ANDAMAN CONSORTIA",
"PARAKKAT NATURE HOTEL & RESORTS",
"LE ROYAL MERIDIEN",
"ARUN TRAVELS",
"VISITSMILES TRAVEL COMAPNY",
"MAMA HOLIDAYS",
"SMILE IT TOURS AND TRAVELS",
"EXCLUSIVE TRAVELS",
"Axisrooms",
"STAYZ ROYALE",
"TRAVEL MONKEY",
"SMY HOLIDAYZ",
"VMS TRAVELS",
"YAS WINGS TRAVELS",
"H&S TOURS AND TRAVELS",
"YELLOW RIBBON TRAVELS",
"BIRDING SRI LANKA TRAVELS PVT LTD",
"ASPIRE HOLIDAYS",
"SUPER TRAVELS",
"TIME TO TRAVEL MUNNAR OFFICE",
"DIRA HOLIDAYS",
"SBLT TOURS AND TRAVELS PVT LTD",
"INDIA TOURISM",
"SESA TOURS",
"RKN BEACH RESORT",
"RADVIKA TOUR TRAVELS",
"SAVERA HOTEL",
"RK TOURISM",
"YES HOLIDAYS",
"SOTC TRAVEL LDT",
"MAHADEV KAILASH YATRA",
"EXODUS EXPEDITIONS",
"ROUNDTRIP.IN LLP",
"YATRABAY",
"A2A HOLIDAYS",
"AKIL TOURS AND EVENTS PVT LTD",
"AMSTOURSANDTRAVELS",
"BHAVANI TRAVELS",
"BLUESANDVOYAGES",
"BMK HAPPY JOURNEY TOURS PRIVATE LIMITED",
"BREVISTAY HOSPITALITY PVT LTD",
"BSB INNOVATIONS",
"CLICKS HOLIDAY",
"CROWN TOURS",
"EMPEROR TRAVELINE",
"FLYCO TRAVEL AND TOURS",
"HOTEL ANITHA PARTHIBAN",
"IMMANUEL HOLIDAYS",
"ISLAND TOURS AND TRAVELS",
"JOTHI TRAVELS",
"JVS WORLD TOURS",
"KAVYA TRANSPORT SERVICES",
"KIKI TRAVEKS",
"LEGSGO HOLIDAYS",
"MADRAS TRAVEL HOUSE",
"MIRACLE TRAVELS",
"RAINBOW AIR TRAVELS & TOURS",
"RAMADA CHENNAI EGMORE",
"RC TOURS & TRAVELS",
"RIBEN EXPLORES",
"RKS AIR TOURS AND TRAVELS",
"SALAMAT TRAVELS",
"SANGAMIZH LIYA HOLIDAYS",
"SARASWATHI TRAVEL AGENCIES",
"SIVAKAMATCHI TRAVELS",
"SUNDARAMANITRAVELS",
"TERNS TOURS AND TRAVELS",
"THINK TRAVELS",
"TRAVEL BRIGHT",
"TRAVELEXON",
"TRIPBYGENIE",
"VACATION WORLD",
"VIVEGAN TRAVELS",
"WRONGTURNCLUB",
"Lehkanya Getaway",
]

session = requests.Session()
session.headers.update({
    "User-Agent": "Mozilla/5.0"
})


def search_website(company):
    try:
        with DDGS() as ddgs:
            results = ddgs.text(
                f"{company} official website",
                max_results=5
            )

            for r in results:
                url = r.get("href") or r.get("url")
                if url and url.startswith("http"):
                    return url
    except Exception:
        pass

    return None


def extract_email(url):
    try:
        r = session.get(url, timeout=10)
        soup = BeautifulSoup(r.text, "html.parser")

        # page text
        emails = set(re.findall(EMAIL_PATTERN, soup.get_text()))
        if emails:
            return list(emails)[0]

        # HTML source
        emails = set(re.findall(EMAIL_PATTERN, r.text))
        if emails:
            return list(emails)[0]

        # mailto:
        for a in soup.select("a[href^='mailto:']"):
            return a["href"].replace("mailto:", "").split("?")[0]

        # contact page
        for a in soup.find_all("a", href=True):
            href = a["href"]

            if "contact" in href.lower():
                contact = urljoin(url, href)

                try:
                    rr = session.get(contact, timeout=10)

                    emails = set(re.findall(EMAIL_PATTERN, rr.text))
                    if emails:
                        return list(emails)[0]

                except Exception:
                    pass

    except Exception:
        pass

    return None


def process_company(company):
    print("Searching:", company)

    website = search_website(company)

    email = None

    if website:
        email = extract_email(website)

    return {
        "Company": company,
        "Website": website,
        "Email": email
    }


rows = []

with ThreadPoolExecutor(max_workers=10) as executor:

    futures = [executor.submit(process_company, c) for c in companies]

    for future in as_completed(futures):
        rows.append(future.result())


df = pd.DataFrame(rows)

df.to_excel("company_emails.xlsx", index=False)

print(df)