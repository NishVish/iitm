from PIL import Image, ImageDraw, ImageFont
import os

# ==========================
# CONFIGURATION
# ==========================

TEMPLATE = "template.jpg"
FONT_PATH = "NovaQuinta_PERSONAL_USE_ONLY.otf"

OUTPUT_DIR = "certificates_pdf"

names = [
    'Accessible Adventure Pvt Ltd',
    'Affinity Journey Pvt Ltd',
    'Andaman Make My Journey',
    'Andamanexperts.Com',
    'Andamans Tour',
    'Andromeda Tours And Travels',
    'Balaji Diyo Tours And Travels',
    'Balib2B.Com (Pt. Divi Bali Tours)',
    'Bhutan Tourism Corporation Ltd',
    'Booking Junction Pvt Ltd',
    'C M Holidays (Corbett Master)',
    'Eco House Boat',
    'Exotic Bali Destination',
    'Fly Dheera',
    'G D Dmc',
    'Gcs Group',
    'Grand Tour - China',
    'Gujarat Holidays And Cars',
    'Himachal Travel Delight - Dmc North India',
    'Hotel Sonar Bangla',
    'Jaigon Tours & Travels - Bhutan B2B.Com',
    'Journeys Express',
    'Matrix Cellular International Services Pvt Ltd',
    'Migrate Tourism Private Limited',
    'Mission Nepal Holidays Pvt Ltd',
    'Mountain Tiger Nepal',
    'Nandan Retreat',
    'Olivia Alleppey, Owned By Olivia Hospitalities Pvt Ltd',
    'Radha Krishna Holidays Pvt Ltd',
    'Ren Tours & Treks',
    'Royal Sunshine Hospitality',
    'Sembark Travel Software',
    'Shanvi Hospitality',
    'Sri Nithi Travels - Andaman Dmc',
    'The Golden Saffron',
    'Tiqi Travel',
    'Toursup Holidays Pvt Ltd',
    'Travel Gypsy Pvt Ltd',
    'Travelogy',
    'Tripjyada Pvt Ltd',
    'Tripperjee - Northeast Dmc',
    'Vacation Adda Llp',
    'Winterfeel Hotels And Resorts Limited',
]


TEXT_COLOR = (0, 0, 0)

X_PERCENT = 0.50
Y_PERCENT = 0.375

MAX_FONT_SIZE = 120
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
    fill,
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


    print(f"{text} -> {font_size}px")


    draw.text(
        (
            center_x - text_width / 2,
            center_y - text_height / 2,
        ),
        text,
        font=font,
        fill=fill,
    )



# ==========================
# GENERATE PDF CERTIFICATES
# ==========================

os.makedirs(OUTPUT_DIR, exist_ok=True)


for name in names:

    if not name.strip():
        continue

    img = Image.open(TEMPLATE).convert("RGB")

    draw = ImageDraw.Draw(img)

    width, height = img.size

    center_x = width * X_PERCENT
    center_y = height * Y_PERCENT

    max_width = width * MAX_TEXT_WIDTH_PERCENT


    draw_centered_text(
        draw=draw,
        text=name,
        center_x=center_x,
        center_y=center_y,
        font_path=FONT_PATH,
        max_width=max_width,
        max_font_size=MAX_FONT_SIZE,
        min_font_size=MIN_FONT_SIZE,
        fill=TEXT_COLOR,
    )


    filename = "".join(
        c for c in name if c.isalnum() or c in (" ", "_", "-")
    ).rstrip()


    pdf_path = os.path.join(
        OUTPUT_DIR,
        f"{filename}.pdf"
    )


    img.save(
        pdf_path,
        "PDF",
        resolution=100.0
    )


print(f"Generated certificates in '{OUTPUT_DIR}'")