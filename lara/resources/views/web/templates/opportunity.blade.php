<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;1,600&family=Inter:wght@300;400;600;800&display=swap');

    :root {
        --iitm-red: #aa2324;
        --iitm-gold: #c5a059;
        --iitm-dark: #0a0a0a;
        --iitm-light: #f9f9f9;
    }

    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: #fff;
        color: var(--iitm-dark);
    }

    /* --- HERO SECTION --- */
    .opp-hero {
        height: 70vh;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-align: center;
        overflow: hidden;
        background: var(--iitm-dark);
    }

    .opp-hero-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8)),
            url('/assets/4.jpg') no-repeat center center;
        background-size: cover;
        z-index: 1;
        transition: transform 2s ease;
    }

    .opp-hero:hover .opp-hero-bg {
        transform: scale(1.05);
    }

    .opp-hero-content {
        position: relative;
        z-index: 10;
        max-width: 900px;
        padding: 20px;
    }

    .opp-label {
        font-size: 0.75rem;
        letter-spacing: 5px;
        text-transform: uppercase;
        color: var(--iitm-gold);
        margin-bottom: 20px;
        display: block;
    }

    .opp-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(3rem, 8vw, 5.5rem);
        line-height: 1;
        margin: 0;
        font-weight: 600;
    }

    .opp-hero h1 em {
        font-style: italic;
        color: var(--iitm-red);
    }

    /* --- OPPORTUNITY GRID --- */
    .opp-grid-section {
        padding: 100px 10%;
        background: #fff;
    }

    .section-title {
        text-align: center;
        margin-bottom: 80px;
    }

    .section-title h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3rem;
        margin: 0;
    }

    .section-title .line {
        width: 60px;
        height: 3px;
        background: var(--iitm-red);
        margin: 20px auto;
    }

    .opp-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 40px;
    }

    .opp-card {
        padding: 50px;
        border: 1px solid #eee;
        transition: all 0.4s ease;
        position: relative;
        background: var(--iitm-light);
    }

    .opp-card:hover {
        background: var(--iitm-dark);
        color: #fff;
        border-color: var(--iitm-dark);
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .opp-card i {
        font-size: 2rem;
        color: var(--iitm-red);
        margin-bottom: 25px;
        display: block;
    }

    .opp-card h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        margin-bottom: 15px;
    }

    .opp-card p {
        font-size: 0.95rem;
        line-height: 1.7;
        color: #666;
        transition: color 0.4s;
    }

    .opp-card:hover p {
        color: rgba(255, 255, 255, 0.7);
    }

    .opp-card .btn-link {
        margin-top: 25px;
        display: inline-block;
        color: var(--iitm-red);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .opp-card:hover .btn-link {
        color: var(--iitm-gold);
    }

    /* --- DARK STATS STRIP --- */
    .opp-stats {
        background: var(--iitm-dark);
        padding: 80px 10%;
        color: #fff;
        display: flex;
        justify-content: space-around;
        text-align: center;
        flex-wrap: wrap;
        gap: 40px;
    }

    .stat-box h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3.5rem;
        color: var(--iitm-gold);
        margin: 0;
    }

    .stat-box span {
        text-transform: uppercase;
        letter-spacing: 3px;
        font-size: 0.7rem;
        color: var(--iitm-red);
        font-weight: 800;
    }

    @media (max-width: 768px) {
        .opp-grid {
            grid-template-columns: 1fr;
        }

        .opp-stats {
            flex-direction: column;
        }
    }
</style>

<div class="opportunities-page">

    <section class="opp-hero">
        <div class="opp-hero-bg"></div>
        <div class="opp-hero-content">
            <span class="opp-label">Unlock Growth</span>
            <h1>World of <em>Opportunities</em></h1>
            <p style="margin-top:20px; font-weight:300; letter-spacing:1px; color:rgba(255,255,255,0.8)">
                Connecting global brands with India's diverse travel market.
            </p>
        </div>
    </section>

    <section class="opp-stats">
        <div class="stat-box">
            <h4>25+</h4>
            <span>Years of Excellence</span>
        </div>
        <div class="stat-box">
            <h4>9</h4>
            <span>Prime Cities</span>
        </div>
        <div class="stat-box">
            <h4>22K+</h4>
            <span>Trade Visitors</span>
        </div>
    </section>

    <section class="opp-grid-section">
        <div class="section-title">
            <h2>Our <em>Core</em> Offerings</h2>
            <div class="line"></div>
        </div>

        <div class="opp-grid">
            <div class="opp-card">
                <h3>Exhibition Space</h3>
                <p>Secure a prime location to showcase your destinations, products, and services to a captive audience
                    of B2B and B2C clients.</p>
                <a href="#" class="btn-link">Learn More →</a>
            </div>

            <div class="opp-card">
                <h3>Sponsorships</h3>
                <p>Elevate your brand authority by becoming a key partner. Gain maximum visibility across our
                    high-traffic marketing channels.</p>
                <a href="#" class="btn-link">View Packages →</a>
            </div>

            <div class="opp-card">
                <h3>B2B Networking</h3>
                <p>Access exclusive conclaves and "speed-dating" style networking events designed to forge long-term
                    business contracts.</p>
                <a href="#" class="btn-link">Request Invite →</a>
            </div>

            <div class="opp-card">
                <h3>Media & PR</h3>
                <p>Leverage our massive media reach to announce launches, share insights, and feature in our annual
                    industry reports.</p>
                <a href="#" class="btn-link">Partner With Us →</a>
            </div>
        </div>
    </section>

</div>