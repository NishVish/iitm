<section id="matte-client-section">
    <style>
        #matte-client-section {
            background-color: #0a0a0b;
            padding: 60px 0;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        /* Divider Label */
        .client-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin-bottom: 40px;
            padding: 0 20px;
        }

        .client-divider::before,
        .client-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #1f1f23;
        }

        .client-divider:not(:empty)::before {
            margin-right: .25em;
        }

        .client-divider:not(:empty)::after {
            margin-left: .25em;
        }

        .client-label {
            color: #8e8e93;
            font-size: 0.75rem;
            letter-spacing: 3px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 0 15px;
        }

        /* The Slider Track */
        .client-slider {
            width: 100%;
            height: 100px;
            position: relative;
            display: flex;
            align-items: center;
        }

        .client-track {
            display: flex;
            width: calc(250px * 18);
            /* Adjust based on logo count x 2 */
            animation: scroll-left 40s linear infinite;
        }

        .client-track:hover {
            animation-play-state: paused;
        }

        .slide {
            width: 250px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 20px;
        }

        .slide img {
            max-width: 140px;
            max-height: 60px;
            filter: grayscale(100%) brightness(0.8) invert(1);
            /* Forces logos to look uniform white on dark */
            transition: all 0.3s ease;
            opacity: 0.6;
        }

        .slide img:hover {
            filter: grayscale(0%) brightness(1) invert(0);
            /* Pops color on hover */
            opacity: 1;
            transform: scale(1.1);
        }

        /* Animation */
        @keyframes scroll-left {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(-250px * 9));
            }

            /* Half of total width */
        }
    </style>

    <div class="client-divider">
        <span class="client-label">OUR CLIENTS & PARTNERS</span>
    </div>

    <div class="client-slider">
        <div class="client-track">
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/Bihar-300x300-1-1.jpg"
                    alt="Bihar"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/odisha-300x300-1-1.jpg"
                    alt="Odisha"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/Karnataka-thegem-person-1.jpg"
                    alt="Karnataka"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/gujarat-300x300-1-1.jpg"
                    alt="Gujarat"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/Delhi-300x300-1-1.jpg"
                    alt="Delhi"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/Kerala-thegem-person-1.jpg"
                    alt="Kerala"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2026/04/Maharashtra-Tourism-Logo.png"
                    alt="Maharashtra"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/Dubai-thegem-person-1.jpg"
                    alt="Dubai"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/Egypt-thegem-person-1.jpg"
                    alt="Egypt"></div>

            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/Bihar-300x300-1-1.jpg"
                    alt="Bihar"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/odisha-300x300-1-1.jpg"
                    alt="Odisha"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/Karnataka-thegem-person-1.jpg"
                    alt="Karnataka"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/gujarat-300x300-1-1.jpg"
                    alt="Gujarat"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/Delhi-300x300-1-1.jpg"
                    alt="Delhi"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/Kerala-thegem-person-1.jpg"
                    alt="Kerala"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2026/04/Maharashtra-Tourism-Logo.png"
                    alt="Maharashtra"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/Dubai-thegem-person-1.jpg"
                    alt="Dubai"></div>
            <div class="slide"><img src="https://iitmindia.com/wp-content/uploads/2023/01/Egypt-thegem-person-1.jpg"
                    alt="Egypt"></div>
        </div>
    </div>
</section>