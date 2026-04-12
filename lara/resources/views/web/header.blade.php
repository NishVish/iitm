<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Background + Floating Header</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #000;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }

        /* ===== FLOATING HEADER ===== */
        .header {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;

            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            padding: 12px 30px;
            border-radius: 40px;

            display: flex;
            gap: 30px;
        }

        .header a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <!-- 
    <div class="header">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </div> -->
    <!-- VIDEO BACKGROUND -->
    <div class="video-container">
        <video id="bg-video" autoplay muted loop playsinline>
            <source src="https://iitmindia.com/wp-content/uploads/2025/07/Untitled-design-6.mp4" type="video/mp4">
        </video>
    </div>

    <style>
        .video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            z-index: -1;
        }

        .video-container video {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            transform: translate(-50%, -50%);
            object-fit: cover;
            pointer-events: none;

            opacity: 0;
            transition: opacity 3s ease-in-out;
        }

        .video-container video.loaded {
            opacity: 1;
        }
    </style>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const video = document.getElementById('bg-video');

            video.addEventListener('canplay', () => {
                setTimeout(() => {
                    video.classList.add('loaded');
                }, 4000);
            });
        });
    </script>
    <style>
        #sticky-header-2 {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            /* Light solid feel */
            backdrop-filter: blur(10px);
            padding: 15px 0;
            text-align: center;
            z-index: 9999;
            /* Above everything */
            border-bottom: 1px solid #ddd;

            /* Hidden Animation State */
            opacity: 0;
            visibility: hidden;
            transform: translateY(-100%);
            transition: all 0.4s ease-in-out;
        }

        /* Shown State */
        #sticky-header-2.is-active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Change body to allow scrolling */
        body {
            overflow-y: auto !important;
            overflow-x: hidden;
        }
    </style>


    <style>
        .section-1 {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            transition: filter 0.8s ease, opacity 0.8s ease;
            /* Makes the blur/unblur smooth */

        }

        .section-1.idle {
            filter: blur(15px) grayscale(20%);
            /* Blurs and slightly fades color */
            pointer-events: none;
            /* Prevents accidental clicks while blurred */
        }

        /* Animate children only (not container) */
        .section-1>* {
            opacity: 0;
            transform: translateY(40px);
            filter: blur(8px);
            transition: all 0.8s ease;
        }

        /* Visible state */
        .section-1.show>* {
            opacity: 1;
            transform: translateY(0);
            filter: blur(0);
        }

        /* Stagger delays */
        .section-1.show img {
            transition-delay: 0.2s;
        }

        .section-1.show h1 {
            transition-delay: 0.4s;
        }

        .section-1.show p {
            transition-delay: 0.6s;
        }

        .section-1.show div {
            transition-delay: 0.8s;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(35, 166, 213, 0.4);
            filter: brightness(1.1);
        }
    </style>

    <div class="section-1" id="hero">
        <style>
            @keyframes coolGradient {
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
        </style>
        <script>
            const hero = document.getElementById('hero');
            let idleTimer;

            // This function runs every time the mouse moves
            document.addEventListener('mousemove', () => {
                // 1. Remove the blur immediately when movement is detected
                hero.classList.remove('idle');

                // 2. Clear the previous timer
                clearTimeout(idleTimer);

                // 3. Start a new timer for 2 seconds (2000ms)
                idleTimer = setTimeout(() => {
                    hero.classList.add('idle');
                }, 2000);
            });

            // Also remove blur on touch for mobile users
            document.addEventListener('touchstart', () => {
                hero.classList.remove('idle');
            });
        </script>
        <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" width="200px"
            style="display: block; margin: 0 auto; filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));">

        <h1 style="
    text-align: center; 
    font-family: 'Montserrat', sans-serif; /* Recommended modern font */
    font-size: 3rem; 
    margin: 20px 0 10px;
    
    /* Gradient Color Settings */
    background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
    background-size: 400% 400%; /* Important for the movement effect */
    
    /* Clip gradient to text */
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent; 
    
    /* Attach the animation defined in the <style> tag */
    animation: coolGradient 10s ease infinite; 
">
            IITM India Biggest Travel Show
        </h1>

        <p
            style="text-align: center; font-family: 'Arial', sans-serif; color: #555; font-size: 1.1rem; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 30px;">
            Escalate Your Brand Visibility With IITM Exhibition And Event
        </p>

        <div style="text-align: center;">
            <button onclick="location.href='#'" style="
            padding: 12px 28px; 
            background: #23a6d5; 
            color: white; 
            border: none; 
            border-radius: 50px; 
            font-weight: bold; 
            cursor: pointer; 
            box-shadow: 0 4px 15px rgba(35, 166, 213, 0.3); 
            margin-right: 10px; 
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        " onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(35, 166, 213, 0.5)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.2)';">
                Stall Booking
            </button>

            <button onclick="location.href='{{ route('register') }}'" style="
            padding: 12px 28px; 
            background: white; 
            color: #23a6d5; 
            border: 2px solid #23a6d5; 
            border-radius: 50px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: all 0.3s ease;
        " onmouseover="this.style.background='#f0f9ff'; this.style.transform='translateY(-3px)';"
                onmouseout="this.style.background='white'; this.style.transform='translateY(0)';">
                Trade Visitor
            </button>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const section = document.getElementById('hero');

            setTimeout(() => {
                section.classList.add('show');
            }, 3000); // 3 seconds
        });
    </script>

    <div class="section-2" id="next-section">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

            .section-2 {
                min-height: 100vh;
                padding: 80px 20px;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                /* Professional Deep Gradient */
                background: radial-gradient(circle at top left, #1a2a6c, #b21f1f, #fdbb2d);
                background-size: 200% 200%;
                animation: gradientMove 15s ease infinite;
                color: #ffffff;
                line-height: 1.6;
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

            .glass-card {
                max-width: 1000px;
                margin: auto;
                padding: 50px;
                border-radius: 24px;
                background: rgba(255, 255, 255, 0.07);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            }

            .section-header {
                text-align: center;
                margin-bottom: 40px;
            }

            h2 {
                font-size: 2.5rem;
                font-weight: 700;
                letter-spacing: -0.02em;
                margin-bottom: 15px;
                text-transform: uppercase;
            }

            h3 {
                font-size: 1.5rem;
                color: #ffd54f;
                /* Elegant gold accent */
                margin-top: 40px;
                margin-bottom: 20px;
                font-weight: 600;
                border-left: 4px solid #ffd54f;
                padding-left: 15px;
            }

            .intro-text {
                font-size: 1.1rem;
                text-align: center;
                max-width: 700px;
                margin: 0 auto 30px;
                opacity: 0.9;
            }

            .image-container {
                overflow: hidden;
                border-radius: 15px;
                margin: 30px 0;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            }

            .image-hover {
                display: block;
                width: 100%;
                transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
            }

            .image-hover:hover {
                transform: scale(1.03);
            }

            /* Grid for lists */
            .benefits-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 15px;
                list-style: none;
                padding: 0;
            }

            .benefits-grid li {
                background: rgba(255, 255, 255, 0.1);
                padding: 12px 20px;
                border-radius: 10px;
                font-weight: 500;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
            }

            .benefits-grid li::before {
                content: "✓";
                margin-right: 12px;
                color: #ffd54f;
                font-weight: bold;
            }

            .benefits-grid li:hover {
                background: rgba(255, 255, 255, 0.2);
                transform: translateY(-3px);
            }

            .stats {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 20px;
                margin-top: 40px;
            }

            .stat-box {
                text-align: center;
                padding: 25px;
                border-radius: 15px;
                background: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.05);
                transition: all 0.3s ease;
            }

            .stat-box:hover {
                background: rgba(255, 255, 255, 0.15);
                border-color: rgba(255, 255, 255, 0.3);
            }

            .stat-number {
                font-size: 2rem;
                font-weight: 700;
                display: block;
                color: #fff;
            }

            .stat-label {
                font-size: 0.9rem;
                text-transform: uppercase;
                letter-spacing: 1px;
                opacity: 0.8;
                margin-top: 5px;
            }

            .vision-card {
                text-align: center;
                padding: 20px;
                font-style: italic;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                margin-top: 40px;
            }
        </style>

        <div class="glass-card">
            <div class="section-header">
                <h2>Thank You for Your Support</h2>
                <p class="intro-text">
                    IITM is India's premier platform for travel-trade exhibitions, fostering meaningful B2B and B2C
                    interactions across major metropolitan hubs.
                </p>
            </div>

            <div class="image-container">
                <img class="image-hover"
                    src="https://iitmindia.com/wp-content/uploads/2025/11/WhatsApp-Image-2025-11-12-at-3.18.08-PM-1400x1536.jpeg"
                    alt="IITM Event Showcase">
            </div>

            <h3>About IITM India</h3>
            <p>
                As a pioneer in travel exhibitions, we connect global industry professionals, enhance brand visibility,
                and facilitate sustainable business growth within the tourism sector.
            </p>

            <h3>Why Exhibit with Us?</h3>
            <ul class="benefits-grid">
                <li>Mass Audience Reach</li>
                <li>Strong Business Relationships</li>
                <li>Strategic Product Launches</li>
                <li>High-Quality Lead Generation</li>
                <li>Enhanced Global Presence</li>
            </ul>

            <h3>Key Performance Highlights</h3>
            <div class="stats">
                <div class="stat-box">
                    <span class="stat-number">40,000+</span>
                    <div class="stat-label">Annual Visitors</div>
                </div>
                <div class="stat-box">
                    <span class="stat-number">2,500+</span>
                    <div class="stat-label">Exhibitors</div>
                </div>
                <div class="stat-box">
                    <span class="stat-number">25+</span>
                    <div class="stat-label">States Represented</div>
                </div>
                <div class="stat-box">
                    <span class="stat-number">23+</span>
                    <div class="stat-label">Annual Trade Shows</div>
                </div>
            </div>

            <h3>Our Vision</h3>
            <div class="vision-card">
                <p>"To provide a dynamic, world-class platform that accelerates the growth of the travel and tourism
                    industry through excellence in event management."</p>
            </div>

            <h3>Why Visit?</h3>
            <ul class="benefits-grid">
                <li>Engage with Industry Experts</li>
                <li>Analyze Emerging Trends</li>
                <li>Forge Strategic Partnerships</li>
                <li>Direct Access to Sales Leads</li>
                <li>Broad Global Market Exposure</li>
            </ul>
        </div>
    </div>


    <div id="sticky-header-2" class="fancy-header">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');

            /* Base hidden state */
            #sticky-header-2 {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 9999;

                opacity: 0;
                transform: translateY(-40px) scale(0.95);
                pointer-events: none;

                transition: all 0.5s ease;
            }

            /* Visible state (used by BOTH scroll + delay) */
            #sticky-header-2.active {
                opacity: 1;
                transform: translateY(0) scale(1);
                pointer-events: auto;
            }

            /* Initial hidden state */
            .fancy-header {
                opacity: 0;
                transform: translateY(-30px) scale(0.95);
                pointer-events: none;
            }

            /* Visible animation state */
            .fancy-header.show {
                opacity: 1;
                transform: translateY(0) scale(1);
                pointer-events: auto;
            }

            .fancy-header {
                display: flex;
                /* Key centering properties */
                flex-direction: column;
                justify-content: center;
                align-items: center;

                padding: 15px 30px;
                position: sticky;
                top: 0;
                z-index: 1000;
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                font-family: 'Inter', sans-serif;
                transition: all 0.4s ease;
            }

            /* Animated Progress-bar style border */
            .fancy-header::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 3px;
                background: linear-gradient(90deg, #ff6a00, #ee0979, #00c6ff, #ff6a00);
                background-size: 300% 100%;
                animation: borderFlow 8s linear infinite;
            }

            @keyframes borderFlow {
                0% {
                    background-position: 0% 0%;
                }

                100% {
                    background-position: 100% 0%;
                }
            }

            .logo-container {
                margin-bottom: 8px;
                /* Space between logo and text */
                transition: transform 0.3s ease;
            }

            .logo-container:hover {
                transform: scale(1.05);
            }

            .header-text {
                text-align: center;
                font-size: 1.1rem;
                font-weight: 700;
                letter-spacing: 0.5px;
                background: linear-gradient(45deg, #1a1a1a, #444);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                text-transform: uppercase;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .highlight-divider {
                color: #ee0979;
                font-style: normal;
                -webkit-text-fill-color: #ee0979;
                /* Overrides the gradient for the divider */
            }

            /* Mobile Adjustments */
            @media (max-width: 600px) {
                .header-text {
                    font-size: 0.85rem;
                    flex-direction: column;
                    /* Stacks text on very small screens */
                    gap: 2px;
                }

                .highlight-divider {
                    display: none;
                    /* Hide the bar on mobile to save space */
                }
            }
        </style>

        <div class="logo-container">
            <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" height="45" alt="IITM Logo">
        </div>

        <div class="header-text">
            <span>IITM INDIA</span>
            <span class="highlight-divider">|</span>
            <span style="font-weight: 400; text-transform: none; opacity: 0.8;">Connect with your True Potential</span>
        </div>
    </div>

    <script>
        const secondHeader = document.getElementById('sticky-header-2');
        const triggerSection = document.getElementById('next-section');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                // When Section 2 top enters the screen
                if (entry.isIntersecting) {
                    secondHeader.classList.add('is-active');
                } else {
                    // Remove when scrolling back up to Section 1
                    secondHeader.classList.remove('is-active');
                }
            });
        }, {
            rootMargin: "-10% 0px -90% 0px" // Triggers when Section 2 is near the top
        });

        observer.observe(triggerSection);
    </script>

</body>

</html>