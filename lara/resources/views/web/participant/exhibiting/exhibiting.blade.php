<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;1,600&family=Inter:wght@300;400;700;900&display=swap');

    :root {
        --iitm-red: #aa2324;
        --iitm-gold: #c5a059;
        --iitm-black: #0a0a0a;
        --iitm-white: #ffffff;
    }

    body {
        margin: 0;
        background-color: var(--iitm-black);
        color: var(--iitm-white);
        font-family: 'Inter', sans-serif;
    }

    /* --- BACKGROUND IMAGE LAYER --- */
    .iitm-bg-layer {
        position: fixed;
        inset: 0;
        z-index: -1;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8)),
            url('public/assets/4.jpg') no-repeat center center;
        background-size: cover;
        transition: opacity 0.8s ease, transform 1.2s ease;
    }

    .bg-hidden {
        opacity: 0;
        transform: scale(1.1);
    }

    /* --- HERO CONTENT --- */
    .hero-promo {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0 20px;
    }

    .media-tag {
        display: inline-block;
        margin-bottom: 25px;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 6px;
        text-transform: uppercase;
        color: var(--iitm-gold);
        position: relative;
    }

    .media-tag::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 25%;
        width: 50%;
        height: 2px;
        background: var(--iitm-red);
    }

    .hero-content h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(3rem, 10vw, 7rem);
        line-height: 0.85;
        margin-bottom: 35px;
        font-weight: 600;
    }

    .hero-content h1 em {
        font-style: italic;
        color: var(--iitm-white);
    }

    .hero-content h1 span {
        display: block;
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-style: normal;
        color: var(--iitm-red);
        text-transform: uppercase;
        letter-spacing: -2px;
    }

    .hero-description {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.15rem;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.8;
        font-weight: 300;
    }

    /* --- COMPACT STATS (IITM STYLE) --- */
    .stats-bar {
        background: rgba(10, 10, 10, 0.8);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-top: 1px solid rgba(197, 160, 89, 0.2);
        /* Gold subtle tint */
        padding: 50px 0;
        display: flex;
        justify-content: center;
    }

    .stats-inner {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        max-width: 1200px;
        width: 100%;
        text-align: center;
    }

    /* Target the highlights include specifically */
    .stat-number {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3.5rem;
        color: var(--iitm-gold);
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: var(--iitm-red);
        font-weight: 800;
    }
</style>

<div class="promotion-page">

    <div class="iitm-bg-layer" id="iitmBg"></div>

    <section class="hero-promo">
        <div class="hero-content">
            <span class="media-tag">Pan-India Series 2026</span>
            <h1>
                <em>Connecting the</em><br>
                <span>Travel Ecosystem</span>
            </h1>
            <p class="hero-description">
                India's premier networking platform, bridging the gap between global exhibitors and the travel trade
                community across 9 major business hubs.
            </p>
        </div>
    </section>

    @include('web.templates.statistics.internalkpi')
    <div style="background-color: white; color: black; padding: 20px;">
        <style>
            .white-box {
                background-color: white;
                color: black;
                padding: 20px;
            }
        </style>

        <div class="white-box">
            This section is white
        </div>
        <!-- @include('web.templates.whyexhibit') -->
        <div>
            <div class="shecdule">

                <div id="scheduel_heading">Shecdule</div>

                <style>
                    .shecdule {
                        width: 100%;
                        height: 100%;
                        background-color: #ffffffff;
                    }

                    #scheduel_heading {
                        text-align: center;
                        margin: none !important;
                        color: #000;
                        font-size: 2rem;
                        font-weight: 700;
                    }
                </style>
                <div class="row">
                    <div class="col-md-12">
                        @include('web.templates.cities')
                    </div>
                </div>
            </div>
        </div>

        <div>
            @include('web.participant.exhibiting.hook')
        </div>

        <div>
            <!-- @include('web.participant.exhibiting.video') -->
        </div>


        <div>
            @include('web.templates.whyexhibit')
        </div>


    </div>

</div>

<script>
    window.addEventListener('scroll', () => {
        const bg = document.getElementById('iitmBg');
        const scrollPos = window.scrollY;

        // Hide background when user scrolls down
        if (scrollPos > 120) {
            bg.classList.add('bg-hidden');
        } else {
            bg.classList.remove('bg-hidden');
        }
    });
</script>