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
</style>


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
            display: block;
            max-width: auto;
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