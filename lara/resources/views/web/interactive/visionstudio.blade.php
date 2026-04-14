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
            top: 0;
            background: linear-gradient(to bottom, rgba(24, 24, 24, 0.9), rgba(255, 255, 255, 0));
        }

        .footer-bar {
            height: 100px;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0 60px;
            z-index: 1001;
            background: linear-gradient(to top, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0));
        }

        /* HEADER CONTENT */
        .header-content {
            height: 100%;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            position: relative;
            padding: 0 40px;
        }

        .logo {
            height: 80px;
            opacity: 0.8;
        }

        .title {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            /* Centers perfectly in the 120px header */

            /* RESPONSIVE FONT SIZE */
            /* Min: 1.2rem, Scalable: 3vw, Max: 2.5rem */
            font-size: clamp(1.2rem, 3vw, 2.5rem);

            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
            white-space: nowrap;

            /* GRADIENT TEXT */
            background: linear-gradient(90deg, #00f5ff, #ff00d4, #ffe600);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

            /* Clean up any leftover behavior */
            margin: 0;
            padding: 0;
            line-height: 1;
        }

        /* Ensure the logo doesn't crush the title on small screens */
        @media (max-width: 600px) {
            .logo {
                height: 50px;
                /* Shrink logo on mobile */
            }

            .title {
                font-size: 1rem;
                /* Fallback for very small screens */
            }
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

        /* FOOTER */
        .footer-left,
        .footer-right {
            display: flex;
            gap: 15px;
            align-items: center;
        }

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
</head>

<body>
    @include('web.loading')
    <!-- HEADER -->
    <div class="header-bar">
        <div class="header-content">
            <a href="{{ route('session.clear') }}" onclick="return confirm('Reset all session data?')">
                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" class="logo" />
            </a>

            <div class="title">

                <a href="{{ route('reload') }}"> REload</a>


                Studio View
            </div>
        </div>
    </div>

    <!-- MAIN -->
    <div class="container">

        <div class="left">
            <img id="frame" src="{{ $framePath . '0000.png' }}" />
        </div>

        <div class="right">
            <section class="s1">Section 1</section>
            <section class="s2">Section 2</section>
            <section class="s3">Section 3</section>
            <section class="s4">Section 4</section>
        </div>

    </div>

    <!-- FOOTER -->
    <div class="footer-bar">
        <div class="footer-left">
            <button class="sq-btn">4 SM²</button>
            <button class="sq-btn">6 SM²</button>
            <button class="sq-btn">9 SM²</button>
        </div>

        <!-- <img src="http://localhost/iitm/lara/public/session/6934/logo.png" alt=""> -->

        <div class="footer-middle" onclick="document.getElementById('logo-upload').click();" style="cursor: pointer;">

            @if($img)
                        <div class="logo-container">
                            <?php
                $baseurl = url('/');
                            ?>

                            <!-- <p>{{ $baseurl }}/public/session/{{ $userid }}/logo.png</p> -->

                            <img src="{{ $baseurl }}/public/session/{{ $userid }}/logo.png" alt="Studio Logo"
                                style="max-height: 40px; width: auto; display: block; margin: 0 auto;">
                        </div>
            @else
                <div class="title">
                    Studio View
                </div>
            @endif

            <form id="logoForm" action="{{ route('upload.logo') }}" method="POST" enctype="multipart/form-data"
                style="display: none;">
                @csrf
                <input type="hidden" name="userid" value="{{ session('userid') }}">
                <input type="file" name="logo" id="logo-upload" accept="image/*"
                    onchange="document.getElementById('logoForm').submit();">
            </form>

        </div>

        <script>

        </script>

        <div class="footer-right">
            <button class="cta-btn">Ready to Promote & Grow</button>
        </div>
    </div>

    <script>
        const img = document.getElementById("frame");

        let imagep = @json($img);
        let userid = @json($userid);

        let basePath;

        if (imagep) {
            basePath = @json($framePath);
        } else {
            basePath = @json($framePath);
        }

        console.log(basePath);

        const framesPerSection = 5;
        let currentFrame = -1;

        for (let i = 0; i < 20; i++) {
            const preload = new Image();
            const frame = String(i).padStart(4, "0");
            preload.src = `${basePath}${frame}.png`;

            console.log(preload.scr);
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