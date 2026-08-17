<section class="exhibitor-hub">
    <style>
        .exhibitor-hub {
            padding: 80px 20px;
            background: #0a0a0b;
            font-family: 'Inter', sans-serif;
            color: #fff;
        }

        .hub-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* 1. Header Section */
        .hub-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .hub-header h5 {
            color: var(--accent, #00f5ff);
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .hub-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.2;
        }

        /* 2. Quick Action Cards */
        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 80px;
        }

        .action-card {
            background: #141417;
            border: 1px solid #26262b;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s ease;
            text-decoration: none;
            display: block;
        }

        .action-card:hover {
            transform: translateY(-10px);
            border-color: #00f5ff;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            filter: grayscale(100%);
            transition: 0.4s;
        }

        .action-card:hover .card-img {
            filter: grayscale(0%);
        }

        .card-body {
            padding: 25px;
            text-align: center;
        }

        .card-btn {
            background: transparent;
            color: #fff;
            border: 1px solid #26262b;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .action-card:hover .card-btn {
            background: #00f5ff;
            color: #000;
            border-color: #00f5ff;
        }

        /* 3. Corporate Info (Split Layout) */
        .info-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
            border-top: 1px solid #1f1f23;
            padding-top: 60px;
        }

        .info-text p {
            color: #94a3b8;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        /* Fancy Accordion */
        .matte-accordion {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        details.matte-item {
            background: #141417;
            border: 1px solid #26262b;
            border-radius: 8px;
        }

        summary.matte-item-title {
            padding: 20px;
            list-style: none;
            cursor: pointer;
            font-weight: 700;
            letter-spacing: 1px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        summary.matte-item-title::-webkit-details-marker {
            display: none;
        }

        summary.matte-item-title::after {
            content: '+';
            color: #00f5ff;
            font-size: 1.2rem;
        }

        details[open] summary.matte-item-title::after {
            content: '−';
        }

        .matte-item-content {
            padding: 0 20px 20px;
            color: #94a3b8;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        @media (max-width: 992px) {
            .info-split {
                grid-template-columns: 1fr;
            }

            .hub-header h2 {
                font-size: 1.8rem;
            }
        }
    </style>

    <div class="hub-container">
        <div class="hub-header">
            <h5>Exhibit at IITM</h5>
            <h2>The highest footfall of relevant <span style="color:#00f5ff">Trade Visitors</span></h2>
        </div>

        <div class="action-grid">
            <a href="/exhibit-at-iitm" class="action-card">
                <img src="https://iitmindia.com/wp-content/uploads/2024/04/exhibit-1-1024x1024.jpg" class="card-img"
                    alt="Exhibit">
                <div class="card-body">
                    <button class="card-btn">Exhibit at IITM</button>
                </div>
            </a>
            <a href="/exhibitors-profile" class="action-card">
                <img src="https://iitmindia.com/wp-content/uploads/2024/04/Exhibitor-Profile-1-1024x1024.jpg"
                    class="card-img" alt="Profile">
                <div class="card-body">
                    <button class="card-btn">Exhibitor Profile</button>
                </div>
            </a>
            <a href="/why-exhibit" class="action-card">
                <img src="https://iitmindia.com/wp-content/uploads/2024/04/Why-Exhibit-1-1-1024x1024.jpg"
                    class="card-img" alt="Why">
                <div class="card-body">
                    <button class="card-btn">Why Exhibit?</button>
                </div>
            </a>
        </div>

        <div class="info-split">
            <div class="info-text">
                <p>
                    IITM is India’s largest travel exhibition platform organizing B2B and B2C events across 9 major
                    cities. Supported by State and International Tourism Boards, we unlock inbound and outbound business
                    potential for hoteliers, agents, and promoters globally.
                </p>
            </div>

            <div class="matte-accordion">
                <details class="matte-item" open>
                    <summary class="matte-item-title">Vision</summary>
                    <div class="matte-item-content">
                        We envision building a viable platform for high-end services in the travel industry, managing
                        trade through internationally acclaimed exhibitions.
                    </div>
                </details>

                <details class="matte-item">
                    <summary class="matte-item-title">Mission</summary>
                    <div class="matte-item-content">
                        IITM is dedicated to ensuring a constant flow of knowledge and innovative ideas within the
                        global tourism community.
                    </div>
                </details>

                <details class="matte-item">
                    <summary class="matte-item-title">Who We Are?</summary>
                    <div class="matte-item-content">
                        With over 20 years of experience, we provide an enriching platform for knowledge sharing and
                        strengthening the travel community trade.
                    </div>
                </details>
            </div>
        </div>
    </div>
</section>