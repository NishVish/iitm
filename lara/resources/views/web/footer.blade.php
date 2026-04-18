<footer id="immersive-footer">
    <div class="f-hero-image">
        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80"
            alt="Events">
    </div>

    <div class="f-content-wrapper">
        <div class="f-enquiry-card">
            <div class="f-enquiry-text">
                <h3>Ready to elevate your event?</h3>
                <p>Contact our team for a personalized walkthrough.</p>
            </div>
            <div class="f-enquiry-action">
                <a href="mailto:info@iitmindia.com" class="f-btn">Start an Enquiry</a>
            </div>
        </div>

        <div class="f-big-logo-bg">IITM INDIA</div>

        <div class="f-main-info">
            <div class="f-info-col">
                <p class="f-addr">245, 7th Main Rd, Domlur, Bengaluru, KA 560071</p>
                <p class="f-email">info@iitmindia.com</p>
            </div>

            <div class="f-links-col">
                <a href="#">Features</a>
                <a href="#">Custom Security</a>
                <a href="#">FAQ</a>
                <a href="#">About</a>
            </div>
        </div>

        <div class="f-copyright">
            <p>&copy; 2026 IITM India. All Rights Reserved.</p>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;800&display=swap');

        #immersive-footer {
            --bg: #08080a;
            --accent: #00f5ff;
            background: var(--bg);
            color: #fff;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow: hidden;
            padding-bottom: 40px;
        }

        /* Image Styling */
        .f-hero-image {
            width: 100%;
            height: 350px;
            overflow: hidden;
        }

        .f-hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.8;
            transition: transform 2s ease;
        }

        #immersive-footer:hover .f-hero-image img {
            transform: scale(1.05);
        }

        .f-content-wrapper {
            max-width: 1200px;
            margin: -60px auto 0;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        /* Enquiry Card (Glassmorphism) */
        .f-enquiry-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 80px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
        }

        .f-enquiry-text h3 {
            font-size: 1.8rem;
            margin: 0 0 5px;
            font-weight: 800;
        }

        .f-enquiry-text p {
            color: #888;
            margin: 0;
        }

        .f-btn {
            background: #fff;
            color: #000;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .f-btn:hover {
            background: var(--accent);
            transform: translateY(-3px);
        }

        /* Immersive Logo Background */
        .f-big-logo-bg {
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12vw;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.02);
            white-space: nowrap;
            z-index: -1;
            pointer-events: none;
            letter-spacing: -5px;
            user-select: none;
        }

        /* Main Info Area */
        .f-main-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .f-addr {
            color: #888;
            max-width: 300px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .f-email {
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            color: #fff;
        }

        .f-links-col {
            display: flex;
            gap: 30px;
        }

        .f-links-col a {
            color: #666;
            text-decoration: none;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .f-links-col a:hover {
            color: var(--accent);
        }

        .f-copyright {
            margin-top: 30px;
            text-align: center;
            font-size: 0.75rem;
            color: #444;
            letter-spacing: 1px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .f-enquiry-card {
                flex-direction: column;
                text-align: center;
                gap: 30px;
            }

            .f-main-info {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 40px;
            }

            .f-links-col {
                flex-wrap: wrap;
                justify-content: center;
            }

            .f-big-logo-bg {
                font-size: 18vw;
                bottom: 120px;
            }
        }
    </style>
</footer>