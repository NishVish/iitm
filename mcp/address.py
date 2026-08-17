import re
import time
import requests
import pandas as pd
from bs4 import BeautifulSoup
from ddgs import DDGS
from geopy.geocoders import Nominatim
from concurrent.futures import ThreadPoolExecutor, as_completed

companies = [
    "Vintage Tours",
"DORYLAION",
"Zutrula",
"SM TOURS AND TRAVEL",
"Jambudvipa Tours",
"Royal Arabian Destination Management",
"Flyglobaltour",
"Padma Tours and Travels",
"HOTEL ARASAN SAPTHAGIRI",
"AIRFIT HOLIDAYS PVT LTD",
"TRIP TREK HOLIDAYS",
"HYDERABAD ADVENTURE CLUB",
"ANNA MARIA TRAVELS & TOURS PTY LTD",
"ANNA MARIA TRAVELS & TOURS PTY LTD",
"DAYASAKTI TRAVEL AND TOURS",
"GEO TOURS",
"GEO TOURS",
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
"WANDERLUST TRAVEL PLANNER",
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
"VIBES LANKA TRAVELS & TOURS",
"VIBES LANKA TRAVELS & TOURS",
"ECO STAY",
"BAGSANDMAPS TRAVEL LLP",
"BAGSANDMAPS TRAVEL LLP",
"BAGSANDMAPS TRAVEL LLP",
"INDIAN HOTELS COMPANY LIMITED",
"ASIA TRIP MATE",
"URP HOLIDAYS & VACATIONS",
"TRAVELSUDEUP",
"TRAVELSUDEUP",
"DLH TRAVEL CAFE",
"THE LEELA",
"THE LEELA",
"DREAMCREW",
"DREAMCREW",
"SEVEN HILLS HOTEL",
"KSP HOLIDAYS",
"FLYWALKSAIL EXPERIENCES",
"KSP HOLIDAYS",
"GLOBAL ASIA JOURNEY",
"VETRI TOURS N TRAVELS",
"HAPPY HOLIDAYERS",
"TRAVELSIDEUP",
"YAZHSTRIPS",
"GOVINDAM RETREAT",
"HIMALAYAN CHAIN RESORTS PVT.LTD",
"YANA TRIPS",
"YEAR ROUND HOLIDAYS INDIA",
"YEAR ROUND HOLIDAYS INDIA",
"BOOKING JUNCTION PVT LTD",
"YEAR ROUND HOLIDAYS INDIA",
"GEO VISITS TOURISM EXPERTS",
"GEO VISITS TOURISM EXPERTS",
"ANDAMAN CONSORTIA",
"ANDAMAN CONSORTIA",
"PARAKKAT NATURE HOTEL & RESORTS",
"PARAKKAT NATURE HOTEL & RESORTS",
"Guest Hives",
"Guest Hives",
"VIET DAN TRAVEL",
"Oscar Holidays SDN BHD",
"Yaadhum Oore Holidays Private Limited",
"Commutec",
"Kaikaatti Tourss",
"Scoot",
"VAANZO TOURS AND TRAVELS",
"Holidays 360",
"Jiris holidays",
"Naveen Travel Make ",
"Shinewel Holidays",
"SVT Holidays Private Limited",
"The Postcard Hotel",
"LE ROYAL MERIDIEN",
"ARUN TRAVELS",
"VISITSMILES TRAVEL COMAPNY",
"MAMA HOLIDAYS",
"SMILE IT TOURS AND TRAVELS",
"EXCLUSIVE TRAVELS",
"Axisrooms",
"STAYZ ROYALE",
"Yolo yatra tours and travels",
"TRAVEL MONKEY",
"SMY HOLIDAYZ",
"VMS TRAVELS",
"Raj Brothers Travels",
"YAS WINGS TRAVELS",
"H&S TOURS AND TRAVELS",
"YELLOW RIBBON TRAVELS",
"BIRDING SRI LANKA TRAVELS PVT LTD",
"ASPIRE HOLIDAYS",
"SUPER TRAVELS",
"TIME TO TRAVEL MUNNAR OFFICE",
"DIRA HOLIDAYS",
"DIRA HOLIDAYS",
"DIRA HOLIDAYS",
"SBLT TOURS AND TRAVELS PVT LTD",
"INDIA TOURISM",
"Spacex Tours and Travels pvt ltd",
"SESA TOURS",
"RKN BEACH RESORT",
"RADVIKA TOUR TRAVELS",
"RADVIKA TOUR AND TRAVEL",
"Privilege Holidays",
"MULTITRIP HOLIDAY",
"Bhavani travels",
"SAVERA HOTEL",
"SAVERA HOTEL",
"RK TOURISM",
"RK TOURISM",
"YES HOLIDAYS",
"YES HOLIDAYS",
"Viswathi Holidays",
"RK TOURISM",
"SOTC TRAVEL LDT",
"Ananta spa and resort",
"Crush Holidays",
"Refex Group",
"Tripsynow ",
"Radisson Hotel Group ",
"All India E- Tourism ",
"MAHADEV KAILASH YATRA",
"EXODUS EXPEDITIONS",
"Travelonauts Luxury Travel, Leisure &amp; Lifetsyle",
"Anapeal Tours n Travels",
"Oman Air",
"EXPERIENCE HEAVENLY HOLIDAYS",
"ROUNDTRIP.IN LLP",
"ROUNDTRIP.IN LLP",
"YATRABAY",
"J.p.Tours & Travels",
"Aleef Travel Service Pvt Ltd",
"A2A HOLIDAYS",
"AKIL TOURS AND EVENTS PVT LTD",
"AMSTOURSANDTRAVELS",
"BHAVANI TRAVELS",
"BLUESANDVOYAGES",
"BMK HAPPY JOURNEY TOURS PRIVATE LIMITED",
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
"ISLAND TOURS AND TRAVELS",
"ISLAND TOURS AND TRAVELS",
"JOTHI TRAVELS",
"JVS WORLD TOURS",
"KAVYA TRANSPORT SERVICES",
"KIKI TRAVEKS",
"KIKI TRAVEKS",
"LEGSGO HOLIDAYS",
"MADRAS TRAVEL HOUSE",
"MADRAS TRAVEL HOUSE",
"MIRACLE TRAVELS",
"MIRACLE TRAVELS",
"NEW SUN INTERNATIONAL TRAVEL AGENCY",
"RAINBOW AIR TRAVELS & TOURS",
"RAMADA CHENNAI EGMORE",
"RC TOURS & TRAVELS",
"RC TOURS & TRAVELS",
"RIBEN EXPLORES",
"RKS AIR TOURS AND TRAVELS",
"ROUNDTRIP.IN LLP",
"ROUNDTRIP.IN LLP",
"ROUNDTRIP.IN LLP",
"SALAMAT TRAVELS",
"SANGAMIZH LIYA HOLIDAYS",
"SARASWATHI TRAVEL AGENCIES",
"SIVAKAMATCHI TRAVELS",
"SIVAKAMATCHI TRAVELS",
"SUNDARAMANITRAVELS",
"TERNS TOURS AND TRAVELS",
"THINK TRAVELS",
"TRAVEL BRIGHT",
"TRAVEL BRIGHT",
"TRAVELEXON",
"TRIPBYGENIE",
"VACATION WORLD",
"VIVEGAN TRAVELS",
"VIVEGAN TRAVELS",
"WRONGTURNCLUB",
"Lehkanya Getaway",
"Whynottravels",
"The Trip Bridge",
"IG Holidays",
"Lal Travels",
"The Flapper Life",
"SAIBALAJICABS",
]

session = requests.Session()
session.headers.update({
    "User-Agent": "Mozilla/5.0"
})

geolocator = Nominatim(user_agent="company_lookup")


def search_website(company):
    try:
        with DDGS() as ddgs:
            results = list(ddgs.text(f"{company} official website address", max_results=5))

        for r in results:
            url = r.get("href") or r.get("url")
            if url and url.startswith("http"):
                return url
    except Exception:
        pass
    return None


def extract_address(url):
    try:
        r = session.get(url, timeout=10)
        soup = BeautifulSoup(r.text, "html.parser")

        text = soup.get_text(" ", strip=True)

        # Indian PIN
        m = re.search(
            r'([A-Za-z0-9,\-#/() ]+?\d{6})',
            text
        )

        if m:
            return m.group(1).strip()

    except Exception:
        pass

    return None


def geocode(address):

    city = ""
    state = ""
    pin = ""

    try:
        loc = geolocator.geocode(address, addressdetails=True)

        if loc:
            addr = loc.raw["address"]

            city = (
                addr.get("city")
                or addr.get("town")
                or addr.get("village")
                or ""
            )

            state = addr.get("state", "")
            pin = addr.get("postcode", "")

    except Exception:
        pass

    return city, state, pin


def process(company):

    print(company)

    website = search_website(company)

    address = ""
    city = ""
    state = ""
    pin = ""

    if website:
        address = extract_address(website) or ""

    if address:
        city, state, pin = geocode(address)

    return {
        "company_name": company,
        "address": address,
        "city": city,
        "pin": pin,
        "state": state
    }


rows = []

with ThreadPoolExecutor(max_workers=10) as executor:

    futures = [executor.submit(process, c) for c in companies]

    for future in as_completed(futures):
        rows.append(future.result())

df = pd.DataFrame(rows)

df.to_excel("company_addresses.xlsx", index=False)

print(df)