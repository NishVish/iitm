<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Network Event Experience</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #111;
            color: white;
            overflow-x: hidden;

        }

        /* HEADER + FOOTER */
        .header-bar,
        .footer-bar {
            display: block;
            position: fixed;
            left: 0;
            width: 100%;
            z-index: 1000;
            pointer-events: auto;
        }

        .header-bar {
            height: 120px;

        }

        .footer-bar {
            height: 160px;


        }

        .footer-bar {
            display: flex;
            align-items: center;
            /* Vertically centers everything in the bar */
            justify-content: space-between;
            /* Keeps buttons at edges */
            width: 100%;
            padding: 0 60px;
            /* Increased padding for better look */
            bottom: 0;
            position: fixed;
            z-index: 1001;
            height: 100px;
            /* Reduced height, 160px is very tall for a bar */
        }

        .header-bar {
            top: 0;
            background: linear-gradient(to bottom, rgba(24, 24, 24, 0.9), rgba(255, 255, 255, 0));
        }

        .footer-bar {
            bottom: 0;
            background: linear-gradient(to top, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0));
        }

        /* LOADER */
        .loader {
            position: fixed;
            inset: 0;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }

        .loader.hide {
            opacity: 0;
            visibility: hidden;
        }

        .loader h1 {
            font-size: 44px;
            font-weight: 900;
            text-align: center;
            background: linear-gradient(90deg, #00f5ff, #ff00d4, #ffe600);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        /* MAIN */
        .container {
            display: flex;
        }

        .left {
            width: 50%;
            height: 100vh;
            position: sticky;
            top: 0;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .right {
            width: 50%;
        }

        section {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            border-bottom: 1px solid #222;
            padding: 40px;
        }

        .s1 {
            background: #1a1a1a;
        }

        .s2 {
            background: #222;
        }

        .s3 {
            background: #2a2a2a;
        }

        .s4 {
            background: #333;
        }

        /* HEADER CONTENT LAYOUT */
        .header-content {
            height: 100%;
            display: flex;
            flex-direction: row;
            align-items: center;

            justify-content: flex-start;
            /* keep logo left */
            position: relative;
            padding: 0 40px;
            /* gives same breathing space both sides */

            /* needed for true center title */
        }

        /* LOGO stays left */
        .logo {
            height: 80px;
            opacity: 0.8;
        }

        /* TITLE stays perfectly centered */
        .title {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 80px;
            font-weight: 900;
            letter-spacing: 3px;
            text-transform: uppercase;

            background: linear-gradient(90deg, #00f5ff, #ff00d4, #ffe600);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

            text-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header-bar">
        <div class="header-content">
            <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" class="logo" />
            <h1 class="title">Studio View</h1>
        </div>
    </div>
    <!-- LOADER -->
    <div class="loader" id="loader">
        <h1 id="loaderText">Loading...</h1>
    </div>

    <div class="container">

        <!-- LEFT -->
        <div class="left">
            <img id="frame" src="public/exhibitor/3d/default/frame_0000.png" />
        </div>

        <!-- RIGHT -->
        <div class="right">
            <section class="s1">Section 1</section>
            <section class="s2">Section 2</section>
            <section class="s3">Section 3</section>
            <section class="s4">Section 4</section>
        </div>

    </div>
    <!-- FOOTER -->
    <div class="footer-bar">

        <!-- SECTION 1 -->
        <div class="footer-left">
            <button class="sq-btn">4 SM²</button>
            <button class="sq-btn">6 SM²</button>
            <button class="sq-btn">9 SM²</button>
        </div>

        <!-- SECTION 2 (MIDDLE) -->
        <div class="footer-middle">
            <label for="companyUpload" class="upload-box">
                📤 Upload your company photo
            </label>

            <input id="companyUpload" type="file" accept="image/*" style="display:none;">
        </div>
        <style>
            .upload-box {
                cursor: pointer;
                display: inline-block;
            }
        </style>

        <!-- SECTION 3 -->
        <div class="footer-right">
            <button class="cta-btn">Ready to Promote & Grow</button>
        </div>

    </div>

    <style>
        .footer-left,
        .footer-right {
            pointer-events: auto;
            display: flex;
            gap: 15px;
            /* Adds space between the small buttons */
            align-items: center;
        }

        /* SMALL BUTTONS */
        .sq-btn {
            height: 38px;
            padding: 0 14px;
            font-size: 13px;
            font-weight: 600;

            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;

            cursor: pointer;
        }

        /* MAIN CTA */
        .cta-btn {
            height: 42px;
            padding: 0 18px;

            font-size: 13px;
            font-weight: 700;

            background: #000;
            color: #fff;

            border-radius: 10px;
            border: none;

            cursor: pointer;
        }
    </style>
    <script>
        const img = document.getElementById("frame");
        const loader = document.getElementById("loader");
        const loaderText = document.getElementById("loaderText");

        const punchlines = [
            "Connect. Create. Collaborate.",
            "Networking powers success.",
            "Where connections grow.",
            "Ideas meet opportunity."
        ];

        let i = 0;

        function runLoader() {
            const interval = setInterval(() => {

                loaderText.style.opacity = 0;
                loaderText.style.transform = "scale(0.95)";

                setTimeout(() => {
                    loaderText.textContent = punchlines[i];
                    loaderText.style.opacity = 1;
                    loaderText.style.transform = "scale(1)";
                    i++;

                    if (i >= punchlines.length) {
                        clearInterval(interval);

                        setTimeout(() => {
                            loader.classList.add("hide");
                        }, 400);
                    }

                }, 150);

            }, 1);
        }

        window.addEventListener("load", runLoader);

        const basePath = "public/exhibitor/3d/default/frame_";
        const framesPerSection = 5;
        let currentFrame = -1;

        for (let i = 0; i < 20; i++) {
            const preload = new Image();
            const frame = String(i).padStart(4, "0");
            preload.src = `${basePath}${frame}.png`;
        }

        function getSectionIndex(scrollY) {
            return Math.floor(scrollY / window.innerHeight);
        }

        window.addEventListener("scroll", () => {

            const scrollY = window.scrollY;

            const sectionIndex = Math.min(3, Math.max(0, getSectionIndex(scrollY)));

            const sectionStartFrame = sectionIndex * framesPerSection;
            const sectionEndFrame = sectionStartFrame + framesPerSection - 1;

            const sectionScroll = scrollY % window.innerHeight;
            const progress = sectionScroll / window.innerHeight;

            let frame = Math.floor(sectionStartFrame + progress * framesPerSection);

            frame = Math.max(sectionStartFrame, Math.min(frame, sectionEndFrame));

            if (frame !== currentFrame) {
                const frameStr = String(frame).padStart(4, "0");
                img.src = `${basePath}${frameStr}.png`;
                currentFrame = frame;
            }

        });
    </script>

</body>

</html>