<div class="fancy-about-section">
    <style>
        .fancy-about-section {
            padding: 100px 20px;
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 60px;
            align-items: center;
        }

        /* Left Side: Decorative Branding */
        .about-visual {
            position: relative;
            padding: 20px;
        }

        .about-visual::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 80px;
            height: 80px;
            border-top: 4px solid var(--accent);
            border-left: 4px solid var(--accent);
        }

        .about-visual h3 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1;
            margin: 0;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: -2px;
        }

        .about-visual .sub-text {
            display: block;
            margin-top: 15px;
            font-size: 1rem;
            color: var(--accent);
            font-weight: 600;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        /* Right Side: Content */
        .about-content {
            position: relative;
        }

        .about-p {
            font-size: 1.25rem;
            color: var(--text-muted);
            line-height: 1.8;
            margin-bottom: 30px;
            position: relative;
        }

        /* Highlight feature tags */
        .feature-tags {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .tag {
            background: #1a1a1e;
            border: 1px solid var(--border-color);
            padding: 8px 18px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 700;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .tag:hover {
            border-color: var(--accent);
            color: var(--accent);
            transform: translateY(-3px);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .fancy-about-section {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 40px;
            }

            .about-visual::before {
                left: 50%;
                transform: translateX(-50%);
            }

            .about-visual h3 {
                font-size: 2.5rem;
            }

            .feature-tags {
                justify-content: center;
            }
        }
    </style>

    <div class="about-visual">
        <h3>About<br>IITM India</h3>
        <span class="sub-text">Est. 1998</span>
    </div>

    <div class="about-content">
        <p class="about-p">
            As a <span style="color: #fff; font-weight: 600;">pioneer in travel exhibitions</span>, we connect global
            industry professionals, enhance brand visibility, and facilitate sustainable business growth within the
            tourism sector.
        </p>

        <div class="feature-tags">
            <span class="tag">B2B Networking</span>
            <span class="tag">Global Strategy</span>
            <span class="tag">Market Growth</span>
            <span class="tag">Innovation</span>
        </div>
    </div>
</div>