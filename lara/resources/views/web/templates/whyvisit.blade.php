<div class="container" style="margin-top: 100px;">

    <div id="iitm-wrapper">

        <!-- HEADER REMOVED -->

        <section class="why-visit-container">
            <div class="main-title">
                <h1>Why Visit IITM</h1>
                <p>India's Premier Travel & Tourism Exhibition</p>
            </div>

            <div class="visitor-grid">
                <div class="v-card trade">
                    <div class="v-tag">B2B Section</div>
                    <h2>Benefits for Trade Visitors</h2>
                    <ul>
                        <li>Mass audience platform for showcasing existing & new products.</li>
                        <li>Strengthen existing business relationships and build new ones.</li>
                        <li>Access to 2469+ Exhibitors and 22000+ Trade Visitors.</li>
                        <li>Establish contacts with global businesses, partners, and buyers.</li>
                        <li>Generate new sales leads and network with industry experts.</li>
                    </ul>
                    <a href="#hero" class="iitm-btn">REGISTER FOR TRADE VISITOR</a>
                </div>

                <div class="v-card general">
                    <div class="v-tag">Enthusiasts</div>
                    <h2>General Visitors Benefits</h2>
                    <ul>
                        <li>Learn about the latest developments in travel and tourism.</li>
                        <li>Get exclusive offers and deals on travel packages.</li>
                        <li>Experience live demonstrations and product launches.</li>
                        <li>Explore and enhance your passion for travelling.</li>
                        <li>Meet and network with the wider travel community.</li>
                    </ul>
                    <a href="/register-general" class="iitm-btn">REGISTER FOR GENERAL VISITOR</a>
                </div>
            </div>
        </section>

        <style>
            #iitm-wrapper {
                font-family: 'Roboto', sans-serif;
                background: #f8fafc;
                margin: 0;
                padding: 0;
            }

            .why-visit-container {
                padding: 60px 5%;
                max-width: 1200px;
                margin: 0 auto;
            }

            .main-title {
                text-align: center;
                margin-bottom: 50px;
            }

            .main-title h1 {
                font-size: 3rem;
                color: #0f172a;
                margin-bottom: 10px;
            }

            .visitor-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 30px;
            }

            .v-card {
                background: white;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
                border: 1px solid #e2e8f0;
                display: flex;
                flex-direction: column;
            }

            .v-tag {
                background: #fbbf24;
                display: inline-block;
                width: fit-content;
                padding: 4px 12px;
                border-radius: 5px;
                font-size: 12px;
                font-weight: 800;
                margin-bottom: 15px;
            }

            .v-card h2 {
                color: #0f172a;
                margin-bottom: 20px;
            }

            .v-card ul {
                padding: 0;
                list-style: none;
                flex-grow: 1;
            }

            .v-card ul li {
                padding-left: 25px;
                position: relative;
                margin-bottom: 12px;
                color: #475569;
                line-height: 1.5;
            }

            .v-card ul li::before {
                content: '✓';
                position: absolute;
                left: 0;
                color: #fbbf24;
                font-weight: bold;
            }

            .iitm-btn {
                display: block;
                text-align: center;
                background: #0f172a;
                color: white !important;
                padding: 15px;
                border-radius: 10px;
                text-decoration: none;
                font-weight: 700;
                margin-top: 25px;
                transition: 0.3s;
            }

            .v-card.general .iitm-btn {
                background: #0284c7;
            }

            .iitm-btn:hover {
                transform: translateY(-3px);
                opacity: 0.9;
            }
        </style>

    </div>

</div>