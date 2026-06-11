<style>
    :root {
        --iitm-vp-red: #A62322;
        --iitm-vp-dark-text: #FC8996;
        --iitm-vp-light-text: #555555;
    }

    .iitm-vp-wrapper {
        width: 100%;
        min-height: 100svh;
        position: relative;
        overflow: hidden;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: var(--iitm-vp-dark-text);
        background-color: #e7e7e7ff;
    }

    .iitm-vp-container {
        position: relative;
        min-height: 100svh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: clamp(40px, 6vw, 00px);
        max-width: 1100px;
        margin: 0 auto;
        box-sizing: border-box;
    }

    .iitm-vp-tag {
        font-size: 14px;
        font-weight: 600;
        color: var(--iitm-vp-red);
        margin-bottom: 10px;
    }

    .iitm-vp-title {
        font-size: clamp(32px, 5vw, 52px);
        font-weight: 800;
        letter-spacing: -1px;
        line-height: 1.1;
        color: var(--iitm-vp-dark-text);
    }

    .iitm-vp-title span {
        color: var(--iitm-vp-red);
    }

    .iitm-vp-description {
        margin: 20px 0 40px 0;
        font-size: clamp(16px, 2vw, 20px);
        color: var(--iitm-vp-light-text);
        max-width: 700px;
        line-height: 1.5;
    }

    .iitm-vp-section {
        padding: 40px 0;
    }

    .iitm-vp-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .iitm-vp-header h1 {
        font-size: clamp(28px, 4vw, 42px);
        margin: 0;
        font-weight: 900;
        letter-spacing: -1px;
        color: var(--iitm-vp-red);
    }

    .iitm-vp-header p {
        color: var(--iitm-vp-light-text);
        margin-top: 10px;
        font-size: 16px;
    }

    .iitm-vp-card {
        background: #fdfdfd;
        border: 1px solid rgba(166, 35, 34, 0.2);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border-radius: 18px;
        padding: 40px;
        transition: 0.3s ease;
    }

    .iitm-vp-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(166, 35, 34, 0.1);
    }

    .iitm-vp-badge {
        display: inline-block;
        background: var(--iitm-vp-red);
        color: #ffffff;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .iitm-vp-card h2 {
        margin: 0 0 20px 0;
        font-size: 24px;
        color: var(--iitm-vp-dark-text);
    }

    .iitm-vp-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .iitm-vp-list li {
        padding-left: 25px;
        margin-bottom: 12px;
        position: relative;
        color: var(--iitm-vp-light-text);
        line-height: 1.5;
    }

    .iitm-vp-list li::before {
        content: "✓";
        position: absolute;
        left: 0;
        color: var(--iitm-vp-red);
        font-weight: bold;
    }

    .iitm-vp-btn {
        margin-top: 30px;
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        text-align: center;
        background: var(--iitm-vp-red);
        color: white;
        padding: 16px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: 0.3s ease;
    }

    .iitm-vp-btn:hover {
        transform: translateY(-3px);
        background: #851c1b;
        box-shadow: 0 10px 25px rgba(166, 35, 34, 0.3);
    }
</style>

<div class="iitm-vp-wrapper">
    <div class="iitm-vp-container">

        <section class="iitm-vp-section">
            <div class="iitm-vp-header">
                <h1>Why Visit IITM</h1>
                <p>India's Premier Travel & Tourism Exhibition</p>
            </div>

            <div class="iitm-vp-card">
                <span class="iitm-vp-badge">B2B Section</span>
                <h2>Benefits for Trade Visitors</h2>

                <ul class="iitm-vp-list">
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

                <a href="#hero" class="iitm-vp-btn">REGISTER AS TRADE VISITOR</a>
            </div>
        </section>

    </div>
</div>