<style>
    :root {
        --accent-cyan: #00f5ff;
        --accent-pink: #ff00d4;
        --accent-yellow: #ffe600;
        --glass: rgba(255, 255, 255, 0.05);
    }

    body {
        margin: 0;
        background-color: #050505;
        color: #fff;
        font-family: 'Inter', sans-serif;
    }

    /* HERO */
    .hero-promo {
        height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: radial-gradient(circle at center, #111 0%, #000 100%);
        position: relative;
        overflow: hidden;
        padding-top: 60px;
    }

    .media-tag {
        display: block;
        margin-bottom: 15px;
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--accent-pink);
    }

    .hero-content h1 {
        font-size: clamp(2.5rem, 8vw, 5rem);
        font-weight: 900;
        text-transform: uppercase;
        line-height: 0.9;
        margin-bottom: 30px;
        background: linear-gradient(to bottom, #fff 50%, #888);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* DESCRIPTION (removed inline style) */
    .hero-description {
        color: #aaa;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 35px;
        line-height: 1.6;
    }

    /* STATS */
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        background: var(--glass);
        backdrop-filter: blur(10px);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 40px 0;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--accent-yellow);
    }

    .stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #888;
        letter-spacing: 1px;
    }
</style>

<div class="promotion-page">

    <!-- HERO -->
    <section class="hero-promo">
        <div class="hero-content">

            <span class="media-tag">2026 Pan-India Exhibition Series</span>

            <h1>
                Connecting the <br>
                Travel Ecosystem
            </h1>

            <p class="hero-description">
                The premier media and networking platform for tourism professionals across 9 major business hubs.
            </p>

        </div>
    </section>

    <!-- STATS -->
    <section class="stats-bar">
        <div class="stat-item">
            <span class="stat-number">500+</span>
            <span class="stat-label">Exhibitors</span>
        </div>

        <div class="stat-item">
            <span class="stat-number">9</span>
            <span class="stat-label">Major Cities</span>
        </div>

        <div class="stat-item">
            <span class="stat-number">50K+</span>
            <span class="stat-label">Expected Buyers</span>
        </div>

        <div class="stat-item">
            <span class="stat-number">B2B</span>
            <span class="stat-label">Media Reach</span>
        </div>
    </section>

    <!-- GRID -->
    <section class="promo-section">
        @include('web.templates.cities')
        @include('web.participant.exhibiting.video')
    </section>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const video = document.getElementById('promoVideo');
        if (video) {
            video.playbackRate = 0.5;
        }
    });
</script>