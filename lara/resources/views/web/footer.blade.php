<footer id="immersive-footer">
    <div class="f-hero-image">
        <div class="f-overlay"></div>
        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80"
            alt="IITM Events">
    </div>

    <div class="f-content-wrapper">
        <div class="f-enquiry-card">
            <div class="f-enquiry-text">
                <h3>Ready to showcase your brand?</h3>
                <p>Connect with India's premier travel trade community.</p>
            </div>
            <div class="f-enquiry-action">
                <a href="mailto:info@iitmindia.com" class="f-btn">Start an Enquiry</a>
            </div>
        </div>

        <div class="f-big-logo-bg">IITM INDIA</div>

        <div class="f-main-info">
            <div class="f-info-col">
                <img src="https://iitmindia.com/assets/iitm3.png" width="120" alt="IITM Logo" class="f-logo">
                <p class="f-addr">245, 7th Main Rd, Domlur, Bengaluru, KA <a href="{{ url('/backend') }}">560071 </a>
                </p>
                <a href="mailto:info@iitmindia.com" class="f-email">info@iitmindia.com</a>
            </div>

            <div class="f-links-col">
                <div class="f-link-group">
                    <a href="#">Events</a>
                    <a href="#">Exhibitors</a>
                    <a href="#">Gallery</a>
                    <a href="#">About Us</a>
                </div>
            </div>
        </div>

        <div class="f-copyright">
            <p>&copy; 2026 IITM India | Sphere Travelmedia & Exhibitions Pvt. Ltd. All Rights Reserved.</p>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap');

        #immersive-footer {
            --iitm-red: #aa2324;
            --iitm-dark: #1a1a1a;
            background: var(--iitm-dark);
            color: #fff;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow: hidden;
            padding-bottom: 40px;
        }

        /* Hero Image with Darker Travel Overlay */
        .f-hero-image {
            width: 100%;
            height: 380px;
            overflow: hidden;
            position: relative;
        }

        .f-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(26, 26, 26, 0.4), rgba(26, 26, 26, 1));
            z-index: 1;
        }

        .f-hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.6;
            filter: grayscale(30%);
            transition: transform 3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        #immersive-footer:hover .f-hero-image img {
            transform: scale(1.08);
        }

        .f-content-wrapper {
            max-width: 1100px;
            margin: -80px auto 0;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        /* Enquiry Card - Formal & Prestigious */
        .f-enquiry-card {
            background: #ffffff;
            border-top: 5px solid var(--iitm-red);
            border-radius: 4px;
            /* Flatter, more formal corners */
            padding: 45px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 80px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .f-enquiry-text h3 {
            font-family: Georgia, serif;
            font-size: 2rem;
            color: #111;
            margin: 0 0 8px;
            font-weight: normal;
        }

        .f-enquiry-text p {
            color: #666;
            font-size: 1.05rem;
            margin: 0;
        }

        .f-btn {
            background: var(--iitm-red);
            color: #fff;
            padding: 16px 36px;
            text-decoration: none;
            border-radius: 2px;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            transition: all 0.3s ease;
        }

        .f-btn:hover {
            background: #8e1d1e;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(170, 35, 36, 0.3);
        }

        /* Large Background Logo */
        .f-big-logo-bg {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10vw;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.03);
            white-space: nowrap;
            z-index: -1;
            pointer-events: none;
            letter-spacing: 10px;
            text-transform: uppercase;
        }

        /* Info Section */
        .f-main-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 50px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .f-logo {
            margin-bottom: 25px;
            /* Makes the logo white for the dark footer */
        }

        .f-addr {
            color: #aaa;
            max-width: 280px;
            line-height: 1.7;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }

        .f-email {
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            color: var(--iitm-red);
            transition: 0.3s;
        }

        .f-email:hover {
            color: #fff;
        }

        .f-links-col {
            display: flex;
            gap: 50px;
            padding-top: 10px;
        }

        .f-link-group a {
            display: block;
            color: #eee;
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 12px;
            transition: 0.3s;
            font-weight: 300;
        }

        .f-link-group a:hover {
            color: var(--iitm-red);
            padding-left: 5px;
        }

        .f-copyright {
            margin-top: 30px;
            text-align: center;
            font-size: 0.7rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .f-enquiry-card {
                flex-direction: column;
                text-align: center;
                gap: 30px;
                padding: 30px;
            }

            .f-enquiry-text h3 {
                font-size: 1.6rem;
            }

            .f-main-info {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 50px;
            }

            .f-addr {
                margin: 0 auto 15px;
            }

            .f-links-col {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</footer>