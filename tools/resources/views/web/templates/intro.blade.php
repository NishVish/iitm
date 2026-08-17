<section class="iitm-about-section">
    <style>
        .iitm-about-section {
            padding: 50px 20px;
            /* reduced height */
            background: #ffffff;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        .iitm-about-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 50px;
            /* slightly reduced */
        }

        .iitm-about-visual {
            flex: 1;
            position: relative;
            display: flex;
            justify-content: center;
        }

        .image-stack {
            position: relative;
            width: 100%;
            max-width: 420px;
            height: 480px;
            /* reduced height */
        }

        .main-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
            box-shadow: 16px 16px 0px #aa2324;
        }

        .experience-badge {
            position: absolute;
            bottom: -25px;
            right: -25px;
            background: #111;
            color: #fff;
            padding: 22px;
            /* slightly reduced */
            border-radius: 4px;
            text-align: center;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
        }

        .experience-badge .years {
            font-family: Georgia, serif;
            font-size: 2.4rem;
            /* reduced */
            display: block;
            line-height: 1;
            color: #aa2324;
        }

        .experience-badge .text {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
        }

        .iitm-about-content {
            flex: 1;
            text-align: left;
        }

        .iitm-tagline {
            color: #aa2324;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 0.8rem;
            margin-bottom: 12px;
            display: block;
        }

        .iitm-about-content h2 {
            font-family: Georgia, serif;
            font-size: 2.4rem;
            /* reduced */
            color: #111;
            line-height: 1.2;
            margin-bottom: 18px;
        }

        .iitm-about-content p {
            color: #555;
            font-size: 1rem;
            /* reduced */
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .iitm-benefit-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            /* reduced */
            margin-top: 30px;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .benefit-icon {
            width: 10px;
            height: 10px;
            background: #aa2324;
            margin-top: 7px;
            flex-shrink: 0;
        }

        .benefit-text {
            font-size: 0.9rem;
            font-weight: 600;
            color: #222;
        }

        @media (max-width: 992px) {
            .iitm-about-container {
                flex-direction: column;
                text-align: center;
            }

            .iitm-about-content {
                text-align: center;
            }

            .iitm-about-visual {
                margin-bottom: 40px;
            }

            .iitm-benefit-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="iitm-about-container">
        <div class="iitm-about-visual">
            <div class="image-stack">
                <img src="{{ url('public/assets/5.jpg') }}" class="main-img" alt="Exhibition Hall">
                <div class="experience-badge">
                    <span class="years">25+</span>
                    <span class="text">Years of<br>Legacy</span>
                </div>
            </div>
        </div>

        <div class="iitm-about-content">
            <span class="iitm-tagline">About IITM India</span>
            <h2>Strengthening the <span style="color:#aa2324">Travel Community</span> Since 1998</h2>

            <p>
                IITM is a pioneer in travel-trade exhibitions, facilitating a platform for enthusiasts and experts of
                the global travel community to meet, showcase, and trade the future of travel services.
            </p>

            <p>
                We provide the catalyst to accelerate your business by bridging the gap between potential collaborators
                and premium customers across India’s major metropolitan hubs.
            </p>

            <div class="iitm-benefit-grid">
                <div class="benefit-item">
                    <div class="benefit-icon"></div>
                    <div class="benefit-text">Connect with Industry Leaders</div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon"></div>
                    <div class="benefit-text">Reinforce Brand Presence</div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon"></div>
                    <div class="benefit-text">Escalate Market Visibility</div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon"></div>
                    <div class="benefit-text">Establish New Partnerships</div>
                </div>
            </div>
        </div>
    </div>
</section>