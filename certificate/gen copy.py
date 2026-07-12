from PIL import Image, ImageDraw, ImageFont
import os
import re

# ==========================
# CONFIGURATION
# ==========================

TEMPLATE = "template.jpg"
FONT_PATH = "NovaQuinta_PERSONAL_USE_ONLY.otf"
# Fallback font for numbers (Arial is standard on Windows/Mac, use 'DejaVuSans.ttf' on Linux if needed)
NUMBER_FONT_PATH = "arial.ttf" 
OUTPUT_DIR = "certificates"

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

# Font size control
MAX_FONT_SIZE = 90
MIN_FONT_SIZE = 25

# Available text area
MAX_TEXT_WIDTH_PERCENT = 0.75


# ==========================

def get_text_segments(text):
    """Splits text into chunks of digits and non-digits."""
    return [chunk for chunk in re.split(r'(\d+)', text) if chunk]

def measure_mixed_text(segments, font_path, num_font_path, font_size, draw):
    """Calculates the total width and max height of mixed text segments."""
    main_font = ImageFont.truetype(font_path, font_size)
    num_font = ImageFont.truetype(num_font_path, font_size)
    
    total_width = 0
    max_height = 0
    segment_data = []
    
    for segment in segments:
        # Choose font based on whether the segment is numeric
        current_font = num_font if segment.isdigit() else main_font
        bbox = draw.textbbox((0, 0), segment, font=current_font)
        
        w = bbox[2] - bbox[0]
        h = bbox[3] - bbox[1]
        
        segment_data.append((segment, current_font, w))
        total_width += w
        if h > max_height:
            max_height = h
            
    return total_width, max_height, segment_data


def draw_centered_text(
    draw,
    text,
    center_x,
    center_y,
    font_path,
    num_font_path,
    max_width,
    max_font_size,
    min_font_size,
    fill,
):
    segments = get_text_segments(text)
    font_size = max_font_size

    # Loop to find the right font size that fits the width constraint
    while font_size >= min_font_size:
        total_width, text_height, segment_data = measure_mixed_text(
            segments, font_path, num_font_path, font_size, draw
        )
        if total_width <= max_width:
            break
        font_size -= 2

    print(f"{text} => {font_size}px")

    # Start drawing from the left-bound of the calculated centered block
    current_x = center_x - (total_width / 2)
    start_y = center_y - (text_height / 2)

    for segment, font, w in segment_data:
        draw.text(
            (current_x, start_y),
            segment,
            font=font,
            fill=fill,
        )
        current_x += w # Move cursor forward for the next segment


os.makedirs(OUTPUT_DIR, exist_ok=True)


for name in names:

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
        num_font_path=NUMBER_FONT_PATH,
        max_width=max_width,
        max_font_size=MAX_FONT_SIZE,
        min_font_size=MIN_FONT_SIZE,
        fill=TEXT_COLOR,
    )


    filename = "".join(
        c for c in name if c.isalnum() or c in (" ", "_", "-")
    ).rstrip()


    img.save(
        os.path.join(OUTPUT_DIR, f"{filename}.jpg"),
        quality=100
    )


print(f"Generated {len(names)} certificates in '{OUTPUT_DIR}'")