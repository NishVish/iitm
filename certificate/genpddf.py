from PIL import Image, ImageDraw, ImageFont
import os

# ==========================
# CONFIGURATION
# ==========================

TEMPLATE = "template.jpg"
FONT_PATH = "NovaQuinta_PERSONAL_USE_ONLY.otf"

OUTPUT_DIR = "certificates"
PDF_FILE = "certificates.pdf"


# names =
names = [
    "Bergamont Hotels",
    "Bhubaneswar Travel Mart",
    "Breeze Residency (A unit of Jenny's Hotel Pvt. Ltd.)",
    "Delhi Tourism",
    "Destiny - The Farmstay",
    "Eden Villa",
    # "Go4Explore",
        # "Rajasthan B2B Hub",
        # "Tour 2 Odisha",

    "Gobindgarh Fort",
    "Govindam Retreat Pvt. Ltd.",
    "Heritage River Journeys",
    "Hidden India Tours",
    "Himpushp Tours & Travels",
    "Hotel C-Park Inn & Hotel Grand Park Inn",
    "Hotel Durene",
    "Hotel Ruby",
    "Hotel Surguru",
    "HRT Vacations Pvt. Ltd.",
    "JC Residency",
    "JCR Cab & Car Rental",
    "Kanawas",
    "Lama Expeditions Holidays",
    "Leikyrpad Resort",
    "Maharaja India Tours and Events",
    "Marriott Shillong",
    "Odisha Holidays",
    "Odisha Vacations Services Pvt. Ltd.",
    "Om Leisure Holidays Pvt. Ltd.",
    "Pannu Car Rentals Pvt. Ltd.",
    "Patra Travels Pvt. Ltd.",
    "Pinkcity Holidays Tour and Travels",
    # "Rajasthan B2B Hub",
        # "Tour 2 Odisha",
"Minerva group Hotels & Restarant’s",
    "Rajasthan Visits",
    "Ravi Travels and Tourism",
    # "RAVI TRAVELS AND TOURISM",
    "Regalia Grand Amritsar",
    "Regency Tours Pvt. Ltd.",
    "Rio Grande",
    "RSD Travels",
    "Rupal Residency",
    "Saatvik Holidays",
    "Sankalp Tours & Travels",
    "Seven Hills Leisure & Resorts Ltd.",
    "Shri Madan Nikhileshwar Travels",
    "Siddhi Kalyani",
    "Swosti Premium",
    "Swosti Travels",
    "Tea Country",
    "The Ambience Hotel",
    "Toshali Resorts International",
    "Toshali Tours & Travels",
    # "Tour 2 Odisha",
    "Travel with AJ Voyages Pvt. Ltd.",
    "Tropical Vacations",
    "Vinayak Tours & Travels",
    "Walk With Nine Lives",
    "Whispering Palms Jaipur",
    "World Leisure and Travel Services",
    "World of Wilders",
    "Year Round Holidays",
]

TEXT_COLOR = (0, 0, 0)

X_PERCENT = 0.50
Y_PERCENT = 0.375

MAX_FONT_SIZE = 90
MIN_FONT_SIZE = 25

MAX_TEXT_WIDTH_PERCENT = 0.75


# ==========================


def draw_centered_text(
    draw,
    text,
    center_x,
    center_y,
    font_path,
    max_width,
    max_font_size,
    min_font_size,
    fill
):

    font_size = max_font_size

    while font_size >= min_font_size:

        font = ImageFont.truetype(font_path, font_size)

        bbox = draw.textbbox((0, 0), text, font=font)

        text_width = bbox[2] - bbox[0]
        text_height = bbox[3] - bbox[1]

        if text_width <= max_width:
            break

        font_size -= 2


    draw.text(
        (
            center_x - text_width / 2,
            center_y - text_height / 2
        ),
        text,
        font=font,
        fill=fill
    )



os.makedirs(OUTPUT_DIR, exist_ok=True)


pdf_images = []


for name in names:

    img = Image.open(TEMPLATE).convert("RGB")

    draw = ImageDraw.Draw(img)

    width, height = img.size

    center_x = width * X_PERCENT
    center_y = height * Y_PERCENT

    max_width = width * MAX_TEXT_WIDTH_PERCENT


    draw_centered_text(
        draw,
        name,
        center_x,
        center_y,
        FONT_PATH,
        max_width,
        MAX_FONT_SIZE,
        MIN_FONT_SIZE,
        TEXT_COLOR
    )


    filename = "".join(
        c for c in name if c.isalnum() or c in (" ", "_", "-")
    ).rstrip()


    jpg_path = os.path.join(
        OUTPUT_DIR,
        f"{filename}.jpg"
    )


    img.save(
        jpg_path,
        quality=100
    )


    # Add image for PDF
    pdf_images.append(img)


# ==========================
# CREATE PDF
# ==========================

if pdf_images:

    pdf_images[0].save(
        PDF_FILE,
        save_all=True,
        append_images=pdf_images[1:],
        resolution=300
    )


print(f"Generated {len(names)} certificates")
print(f"PDF created: {PDF_FILE}")