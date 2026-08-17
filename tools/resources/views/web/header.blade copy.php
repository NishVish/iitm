<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed Interface with Nav</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #000;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
            height: 3500px;
            /* Scroll runway */
        }

        /* ===== PERMANENT FIXED UI WRAPPER ===== */
        .fixed-ui-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 1;
            display: flex;
            flex-direction: column;
        }

        /* 1. ANIMATED HEADER */
        header {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 160px;
            background: linear-gradient(270deg, #AA2324, #ff4d4d, #AA2324);
            background-size: 400% 400%;
            animation: gradientMove 8s ease infinite;
            flex-shrink: 0;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* 2. NAVIGATION BAR (RESTORED) */
        nav {
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: center;
            gap: 50px;
            padding: 18px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 14px;
        }

        /* 3. ZOOMED VIDEO CONTAINER */
        .video-container {
            position: relative;
            flex-grow: 1;
            /* Fills the space between Nav and Countdown */
            overflow: hidden;
            background: #000;
        }

        .video-container iframe {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            opacity: 0.8;
        }

        /* 4. COUNTDOWN BAR */
        .countdown-bar {
            height: 140px;
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            border-top: 2px solid #ff4d4d;
            flex-shrink: 0;
        }

        #num {
            font-size: 100px;
            font-weight: 900;
            color: #ff4d4d;
            text-shadow: 0 0 20px rgba(255, 77, 77, 0.5);
        }

        /* ===== SECTION 2 (REVEAL LAYER) ===== */
        .section-2 {
            position: relative;
            margin-top: 2500px;
            /* The distance the user must scroll */
            height: 1100vh;
            background: #fff;
            color: #000;
            z-index: 10;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 -30px 60px rgba(0, 0, 0, 1);
        }
    </style>
</head>

<body>

    <div class="fixed-ui-wrapper">
        <header>
            <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" height="100">
        </header>

        <nav>
            <a href="#">Home</a>
            <a href="#">Enquiry</a>
            <a href="#">Why Choose</a>
        </nav>

        <div class="video-container">
            <iframe
                src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&mute=1&controls=0&loop=1&playlist=dQw4w9WgXcQ"></iframe>
        </div>

        <div class="countdown-bar">
            <div id="num">10</div>
        </div>
    </div>

    <style>
        /* The hidden sticky header */
        #section-2-sticky-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #ffffff;
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
            text-align: center;
            z-index: 9999;

            /* Start hidden */
            opacity: 0;
            visibility: hidden;
            transform: translateY(-20px);
            transition: all 0.4s ease-in-out;
        }

        /* Shown state triggered by JS */
        #section-2-sticky-header.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    </style>

    <div id="section-2-sticky-header">
        <strong>Section 2 Navigation</strong>
    </div>

    <div class="section-2" id="next-section">
        <div style="text-align: center; padding: 100px 0; min-height: 100vh; background-color: #f9f9f9;">
            <h1 style="font-size: 60px;">Section 2</h1>
            <p style="font-size: 18px;">Unlock successful.</p>
        </div>
    </div>

    <script>
        (function () {
            const header = document.getElementById('section-2-sticky-header');
            const triggerSection = document.getElementById('next-section');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    // If Section 2 hits the top of the viewport
                    if (entry.isIntersecting) {
                        header.classList.add('active');
                    } else {
                        header.classList.remove('active');
                    }
                });
            }, {
                // Adjust rootMargin to trigger exactly when the section top hits the screen top
                rootMargin: "0px 0px -100% 0px",
                threshold: 0
            });

            observer.observe(triggerSection);
        })();
    </script>

    <script>
        const numDisplay = document.getElementById('num');
        const maxSteps = 10;
        const pixelsPerStep = 200;

        window.addEventListener('scroll', () => {
            const currentScroll = window.scrollY;
            let number = maxSteps - Math.floor(currentScroll / pixelsPerStep);

            if (number < 0) number = 0;
            if (number > 10) number = 10;

            numDisplay.textContent = number;

            if (number === 0) {
                numDisplay.style.color = "#00ff00";
            } else {
                numDisplay.style.color = "#ff4d4d";
            }
        });
    </script>
</body>

</html>