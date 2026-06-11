<style>
    .hero-exhibit {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 80px 10%;
        min-height: 50vh;

        background:
            linear-gradient(to top right, rgba(170, 45, 44, 0.85), rgba(148, 148, 148, 0.41)),
            url('public/assets/key_highlights/7.jpg') no-repeat center center;

        background-size: cover;
        color: white;
        gap: 40px;
    }

    .hero-content {
        max-width: 600px;
    }

    .hero-content h1 {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-family: 'Cormorant Garamond', serif;
        margin-bottom: 15px;
        line-height: 1.1;
        color: white;
    }

    .hero-content p {
        font-size: 1.1rem;
        line-height: 1.6;
        opacity: 0.85;
        margin-bottom: 25px;
    }

    .hero-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-primary {
        background: #ffffffff !important;
        color: #aa2324 !important;
        padding: 12px 22px;
        border: none;
        cursor: pointer;
        font-weight: 700;
        text-transform: uppercase;
    }

    .btn-secondary {
        border: 1px solid #c5a059;
        background: #ffffffff !important;
        color: #aa2324 !important;
        padding: 12px 22px;
        cursor: pointer;
        font-weight: 700;
        text-transform: uppercase;
    }

    .hero-image {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .hero-image img {
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    }
</style>

<section class="hero-exhibit">

    <!-- LEFT CONTENT -->
    <div class="hero-content">
        <h1>Showcase Your Brand at IITM 2026</h1>

        <p>
            Join India’s premier travel trade exhibition connecting global exhibitors,
            tourism boards, and business leaders across major cities.
        </p>

        <div class="hero-buttons">
            <button class="btn-primary">Book a Stall</button>
            <button class="btn-secondary">Download Brochure</button>
        </div>
    </div>

    <!-- RIGHT IMAGE -->
    <div class="hero-image">
        <img src="public/assets/key_highlights/7.jpg" alt="Exhibition Preview">
        <div class="image-overlay"></div>
        <style>
            .hero-image {
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .hero-image img {
                max-width: 100%;
                border-radius: 10px;
                display: block;
            }

            /* Whitish overlay */
            .image-overlay {
                position: absolute;
                inset: 0;
                background: rgba(255, 255, 255, 0.17);
                /* adjust opacity */
                border-radius: 10px;
                pointer-events: none;
            }
        </style>
    </div>

</section>