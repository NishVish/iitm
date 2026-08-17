from PIL import Image, ImageDraw, ImageFont
import os

# ==========================
# CONFIGURATION
# ==========================
FONT_PATH = "Poppins-Regular.ttf"
# TEMPLATE = "chennaicertificate.jpg"
TEMPLATE = "template.jpg"

OUTPUT_DIR = "certificates"
PDF_FILE = "certificates.pdf"


# names =
names = [

"Holiday Bindas Tour & Travels", ]


TEXT_STROKE_WIDTH = 2
TEXT_STROKE_COLOR = (0, 0, 0)


TEXT_COLOR = (0, 0, 0)

X_PERCENT = 0.50
Y_PERCENT = 0.375

MAX_FONT_SIZE = 90
MIN_FONT_SIZE = 25

MAX_TEXT_WIDTH_PERCENT = 0.75


# ==========================


# def draw_centered_text(
#     draw,
#     text,
#     center_x,
#     center_y,
#     font_path,
#     max_width,
#     max_font_size,
#     min_font_size,
#     fill
# ):

#     font_size = max_font_size

#     while font_size >= min_font_size:

#         font = ImageFont.truetype(font_path, font_size)

#         bbox = draw.textbbox((0, 0), text, font=font)

#         left, top, right, bottom = bbox

#         text_width = right - left
#         text_height = bottom - top

#         x = center_x - text_width / 2 - left
#         y = center_y - text_height / 2 - top

#         draw.text(
#             (x, y),
#             text,
#             font=font,
#             fill=fill,
#             stroke_width=TEXT_STROKE_WIDTH,
#             stroke_fill=TEXT_STROKE_COLOR,
#         )

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

        bbox = draw.textbbox(
            (0, 0),
            text,
            font=font,
            stroke_width=TEXT_STROKE_WIDTH
        )

        left, top, right, bottom = bbox
        text_width = right - left

        if text_width <= max_width:
            break

        font_size -= 2

    draw.text(
        (center_x, center_y+15),
        text,
        font=font,
        fill=fill,
        anchor="mm",
        stroke_width=TEXT_STROKE_WIDTH,
        stroke_fill=TEXT_STROKE_COLOR
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