<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITM | Select Participation</title>

    <style>
        :root {
            --iitm-red: #AA2D2C;
            --white: #FFFFFF;
            --text: #2b2b2b;
            --bg: linear-gradient(135deg, #f6f7fb, #eef1f5);
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            padding: 14px;
            text-align: center;
            border-bottom: 2px solid rgba(170, 45, 44, 0.15);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        header img {
            height: 44px;
        }

        .hero {
            text-align: center;
            padding: 35px 15px 10px;
        }

        .hero h1 {
            margin: 0;
            font-size: 2rem;
            color: var(--iitm-red);
            letter-spacing: 1px;
        }

        .hero p {
            margin-top: 6px;
            color: #666;
            font-size: 1rem;
        }

        .question-box {
            max-width: 900px;
            margin: 10px auto 0;
            background: rgba(255, 255, 255, 0.92);
            padding: 20px;
            border-radius: 14px;
            box-shadow: var(--shadow);
        }

        .question-box h3 {
            margin-top: 0;
            color: var(--iitm-red);
            text-align: center;
        }

        .question-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 14px;
            margin-top: 15px;
        }

        .question-item {
            background: #fafafa;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 14px;
        }

        .question-item strong {
            color: var(--iitm-red);
            display: block;
            margin-bottom: 6px;
        }

        .options-container {
            display: flex;
            gap: 28px;
            justify-content: center;
            align-items: stretch;
            padding: 30px 20px;
            flex-wrap: wrap;
        }

        .card {
            width: 340px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(6px);
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 40px rgba(170, 45, 44, 0.15);
        }

        .card-image {
            height: 150px;
            background-size: cover;
            background-position: center;
        }

        .ex-img {
            background-image: url('https://iitmindia.com/assets/crowd/2.jpg');
        }

        .vis-img {
            background-image: url('https://iitmindia.com/assets/crowd/3.png');
        }

        .card-content {
            padding: 22px;
            text-align: center;
        }

        .card-content h2 {
            margin: 0;
            font-size: 1.5rem;
            color: var(--iitm-red);
        }

        .card-content p {
            margin: 10px 0 18px;
            font-size: 0.92rem;
            color: #555;
            min-height: 45px;
        }

        .benefits {
            text-align: left;
            margin: 15px 0 20px;
            padding-left: 18px;
            color: #555;
            font-size: 0.9rem;
        }

        .benefits li {
            margin-bottom: 8px;
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 12px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            transition: 0.25s ease;
            letter-spacing: 0.4px;
        }

        .btn-red {
            background: var(--iitm-red);
            color: #fff;
            box-shadow: 0 6px 15px rgba(170, 45, 44, 0.25);
        }

        .btn-white {
            background: #fff;
            color: var(--iitm-red);
            border: 2px solid var(--iitm-red);
        }

        .btn:hover {
            transform: scale(1.03);
            filter: brightness(1.05);
        }

        footer {
            margin-top: auto;
            padding: 14px;
            text-align: center;
            font-size: 0.8rem;
            color: #888;
            background: rgba(255, 255, 255, 0.7);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 768px) {
            .options-container {
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 92%;
                max-width: 360px;
            }

            .question-box {
                width: 92%;
            }
        }
    </style>
</head>

<body>

    <header>
        <img src="https://iitmindia.com/assets/iitm3.png" alt="IITM Logo">
    </header>

    <div class="hero">
        <h1>Welcome to IITM India 2026</h1>
        <p>Your gateway to the vast Indian Travel & Tourism Market. Select your method of participation below to get
            started.</p>
    </div>

    <!-- Question Guide -->

    <div class="options-container">

        <div class="card">
            <div class="card-image ex-img"></div>

            <div class="card-content">
                <h2>Exhibitor</h2>

                <p>Book a stall and showcase your brand to global travel trade leaders.</p>

                <ul class="benefits">
                    <li>Promote your products & services</li>
                    <li>Meet travel buyers and partners</li>
                    <li>Increase brand visibility</li>
                    <li>Generate business leads</li>
                </ul>

                <a href="https://iitmindia.com/exhibitor/" class="btn btn-red">
                    Buy a Stall
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-image vis-img"></div>

            <div class="card-content">
                <h2>Visitor</h2>

                <p>Network with exhibitors and explore destinations and business opportunities.</p>

                <ul class="benefits">
                    <li>Explore travel destinations & offers</li>
                    <li>Connect with industry professionals</li>
                    <li>Discover new business opportunities</li>
                    <li>Attend networking sessions</li>
                </ul>

                <a href="https://iitmindia.com/trade-visitor2/#:~:text=Trade Visitor Registration"
                    class="btn btn-white">
                    Get Entry Badge </a>
            </div>
        </div>

    </div>

    @include('web.templates.eventlist');

    @include('web.templates.otp');


</body>

</html>