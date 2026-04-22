<div id="iitm-hero">
    <style>
        #iitm-hero {
            width: 100%;
            height: 85vh;
            /* Optimized height for focus */
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7)),
                url('https://plus.unsplash.com/premium_photo-1685199652070-bbb3f17b2eda?q=80&w=735&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #ffffff;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .glass-container {
            max-width: 900px;
            padding: 60px 40px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .logo-box {
            margin-bottom: 30px;
        }

        .logo-box img {
            height: 60px;
            /* Adjust based on your logo aspect ratio */
            filter: drop-shadow(0 0 8px rgba(0, 0, 0, 0.3));
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin: 0 0 20px;
            letter-spacing: -1.5px;
            line-height: 1.1;
        }

        .intro-text {
            font-size: 1.25rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.85);
            max-width: 700px;
            margin: 0 auto 40px;
            font-weight: 400;
        }

        .cta-group {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .main-btn {
            padding: 14px 32px;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 50px;
            text-decoration: none;
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-gold {
            background: #fbbf24;
            color: #0f172a;
        }

        .btn-outline {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .main-btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
            border-color: #fff;
        }

        /* Responsive Fixes */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }

            .intro-text {
                font-size: 1.1rem;
            }

            .cta-group {
                flex-direction: column;
            }
        }
    </style>

    <div class="glass-container">
        <div class="logo-box">
            <img src="http://iitmindia.com/assets/iitm2.png">
        </div>

        <h1 class="hero-title">Experience the Best of Travel Industry</h1>

        <p class="intro-text">
            IITM is India's premier platform for travel-trade exhibitions, fostering
            meaningful B2B and B2C interactions across major metropolitan hubs.
        </p>

        <div class="cta-group">
            <a href="#register" class="main-btn btn-gold">Get Visitor Pass</a>
            <a href="#events" class="main-btn btn-outline">Explore Exhibitions</a>
        </div>
    </div>
</div>