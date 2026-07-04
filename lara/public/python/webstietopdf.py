#!/usr/bin/env python3

"""
Usage:
    pip install playwright
    playwright install chromium

    python webstietopdf.py https://iitmindia.com/ci/lara output.pdf
"""

import sys
from playwright.sync_api import sync_playwright


def website_to_pdf(url: str, output: str):
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)

        page = browser.new_page(
            viewport={"width": 1440, "height": 900}
        )

        page.goto(url, wait_until="networkidle", timeout=120000)

        # Lazy loading support
        previous_height = 0

        while True:
            height = page.evaluate("document.body.scrollHeight")

            if height == previous_height:
                break

            previous_height = height

            page.evaluate("window.scrollTo(0, document.body.scrollHeight)")
            page.wait_for_timeout(1000)

        page.evaluate("window.scrollTo(0, 0)")
        page.wait_for_timeout(1000)

        page.pdf(
            path=output,
            format="A4",
            print_background=True,
            margin={
                "top": "10mm",
                "bottom": "10mm",
                "left": "10mm",
                "right": "10mm",
            },
        )

        browser.close()


if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Usage:")
        print("python website_to_pdf.py <url> <output.pdf>")
        sys.exit(1)

    website_to_pdf(sys.argv[1], sys.argv[2])