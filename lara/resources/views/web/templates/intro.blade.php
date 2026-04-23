<section class="iitm-about-section">
    <style>
        .iitm-about-section {
            padding: 100px 20px;
            background: #ffffff;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        .iitm-about-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 60px;
        }

        /* The Visual "Heritage" Side */
        .iitm-about-visual {
            flex: 1;
            position: relative;
            display: flex;
            justify-content: center;
        }

        .image-stack {
            position: relative;
            width: 100%;
            max-width: 450px;
            height: 550px;
        }

        .main-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
            box-shadow: 20px 20px 0px #aa2324;
            /* Brand Red Offset */
        }

        .experience-badge {
            position: absolute;
            bottom: -30px;
            right: -30px;
            background: #111;
            color: #fff;
            padding: 30px;
            border-radius: 4px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .experience-badge .years {
            font-family: Georgia, serif;
            font-size: 3rem;
            display: block;
            line-height: 1;
            color: #aa2324;
        }

        .experience-badge .text {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
        }

        /* The "Content" Side */
        .iitm-about-content {
            flex: 1;
            text-align: left;
        }

        .iitm-tagline {
            color: #aa2324;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 0.85rem;
            margin-bottom: 15px;
            display: block;
        }

        .iitm-about-content h2 {
            font-family: Georgia, serif;
            font-size: 3rem;
            color: #111;
            line-height: 1.2;
            margin-bottom: 25px;
        }

        .iitm-about-content p {
            color: #555;
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 25px;
        }

        /* Feature Grid for the "If you strive..." section */
        .iitm-benefit-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 40px;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .benefit-icon {
            width: 12px;
            height: 12px;
            background: #aa2324;
            margin-top: 8px;
            flex-shrink: 0;
        }

        .benefit-text {
            font-size: 0.95rem;
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
                margin-bottom: 60px;
            }

            .benefit-item {
                justify-content: center;
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