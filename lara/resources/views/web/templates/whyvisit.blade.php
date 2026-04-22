<div class="expo-container">
    <section class="expo-section">

        <div class="expo-header">
            <h1>Why Visit IITM</h1>
            <p>India's Premier Travel & Tourism Exhibition</p>
        </div>

        <div class="expo-grid">
            <div class="expo-card">

                <div class="expo-card-header">
                    <span class="expo-badge">B2B Section</span>
                    <h2>Trade Visitors</h2>
                </div>

                <ul class="expo-list">
                    <li>Showcase products & services to a highly targeted travel trade audience.</li>
                    <li>Build and strengthen long-term business relationships.</li>
                    <li>Connect with 2,400+ exhibitors and 22,000+ trade visitors across 39 countries.</li>
                    <li>Generate qualified leads and expand your global business network.</li>
                    <li>Gain insights into market trends, competition, and industry opportunities.</li>
                    <li>Network directly with key decision-makers and industry experts.</li>
                </ul>

                <a href="#hero" class="expo-btn">REGISTER AS TRADE VISITOR</a>
            </div>
        </div>

    </section>

    <style>
        :root {
            --iitm-text: #AA2324;
            --iitm-background: #ffffff;
            --iitm-text2: #ffffff;
            --iitm-background2: #AA2324;
        }

        .expo-container {
            margin-top: 63px;
            padding: 0 15px;
        }

        .expo-section {
            background: linear-gradient(135deg,
                var(--iitm-background2),
                var(--iitm-text)
            );

            border-radius: 16px;
            padding: 60px 20px;
            font-family: 'Inter', sans-serif;
            color: var(--iitm-text2);
        }

        .expo-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .expo-header h1 {
            font-size: 2.4rem;
            margin: 0;
            color: var(--iitm-background);
        }

        .expo-header p {
            color: var(--iitm-background);
            opacity: 0.8;
            margin-top: 5px;
        }

        .expo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: auto;
        }

        .expo-card {
            background: var(--iitm-background);
            color: var(--iitm-text);
            padding: 25px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
        }

        .expo-badge {
            background: var(--iitm-background2);
            color: var(--iitm-text2);
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 800;
        }

        .expo-card h2 {
            margin: 10px 0;
            color: var(--iitm-text);
        }

        .expo-list {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .expo-list li {
            padding-left: 20px;
            margin-bottom: 10px;
            position: relative;
            font-size: 0.95rem;
            color: var(--iitm-text);
            opacity: 0.85;
        }

        .expo-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--iitm-background2);
        }

        .expo-btn {
            margin-top: 20px;
            text-align: center;
            background: var(--iitm-background2);
            color: var(--iitm-text2);
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .expo-btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .expo-header h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</div>