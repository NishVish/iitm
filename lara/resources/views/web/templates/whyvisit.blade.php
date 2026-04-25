<style>
    :root {
        --iitm-red: #AA2324;
        --white: #ffffff;
    }

    .expo-container {
        position: relative;
        overflow: hidden;
        font-family: Inter, sans-serif;
    }

    /* Ambient moving light background */
    .expo-container::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 20% 30%, rgba(170, 35, 36, 0.25), transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.12), transparent 55%);
        animation: floatGlow 8s ease-in-out infinite alternate;
        z-index: 0;
    }

    @keyframes floatGlow {
        from {
            transform: scale(1);
        }

        to {
            transform: scale(1.08);
        }
    }

    .expo-section {
        position: relative;
        z-index: 2;
        padding: 70px 20px;
        color: white;
    }

    /* Header feels floating, not boxed */
    .expo-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .expo-header h1 {
        font-size: clamp(28px, 4vw, 42px);
        margin: 0;
        font-weight: 900;
        letter-spacing: -1px;
    }

    .expo-header p {
        opacity: 0.8;
        margin-top: 10px;
        font-size: 16px;
    }

    .expo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 25px;
        max-width: 1100px;
        margin: auto;
    }

    /* Glass floating card (not boxed) */
    .expo-card {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 18px;
        padding: 30px;
        color: white;
        position: relative;
        overflow: hidden;
        transition: 0.3s ease;
    }

    .expo-card:hover {
        transform: translateY(-6px);
        background: rgba(255, 255, 255, 0.12);
    }

    .expo-badge {
        display: inline-block;
        background: rgba(170, 35, 36, 0.9);
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .expo-card h2 {
        margin: 10px 0 20px;
        font-size: 24px;
    }

    .expo-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .expo-list li {
        padding-left: 20px;
        margin-bottom: 12px;
        position: relative;
        opacity: 0.9;
        line-height: 1.5;
    }

    .expo-list li::before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #FFD700;
    }

    /* Button feels premium */
    .expo-btn {
        margin-top: 25px;
        display: inline-block;
        width: 100%;
        text-align: center;
        background: linear-gradient(135deg, #AA2324, #7a1a1a);
        color: white;
        padding: 14px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: 0.3s ease;
    }

    .expo-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    @media (max-width: 768px) {
        .expo-section {
            padding: 40px 10px;
        }
    }
</style>
<div class="expo-container">

    <section class="expo-section">

        <div class="expo-header">
            <h1>Why Visit IITM</h1>
            <p>India's Premier Travel & Tourism Exhibition</p>
        </div>

        <div class="expo-grid">

            <div class="expo-card">
                <span class="expo-badge">B2B Section</span>
                <h2>Benefits for Trade Visitors</h2>

                <ul class="expo-list">
                    <li>Get access to a massive audience at one place for showcasing your products, services, and new
                        launches.</li>

                    <li>Strengthen existing business relationships and build new partnerships.</li>

                    <li>Participate in India’s largest travel exhibition with 2469+ exhibitors and 22,000+ trade
                        visitors from 39 countries and 36 Indian states/UTs.</li>

                    <li>Create new market opportunities and connect with travel businesses, suppliers, and buyers.</li>

                    <li>Understand your market position, competition, challenges, and growth potential more effectively.
                    </li>

                    <li>Engage with potential customers and businesses under one roof for direct networking.</li>

                    <li>Enhance and develop your brand presence in the global travel community.</li>

                    <li>Explore opportunities to conduct business at an international level.</li>

                    <li>Generate new sales leads and expand business reach.</li>

                    <li>Network with key decision-makers and industry experts.</li>

                    <li>Gain insights into industry trends and strengthen market intelligence.</li>
                </ul>

                <a href="#hero" class="expo-btn">
                    REGISTER AS TRADE VISITOR
                </a>
            </div>

        </div>

    </section>

</div>