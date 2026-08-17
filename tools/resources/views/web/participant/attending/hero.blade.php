<style>
    .hero-exhibit {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 80px 10%;
        min-height: 50vh;

        background:
            linear-gradient(to top left, rgba(170, 45, 44, 0.85), rgba(148, 148, 148, 0.41)),
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
        background: #ffffff !important;
        color: #aa2324 !important;
        padding: 12px 22px;
        border: none;
        cursor: pointer;
        font-weight: 700;
        text-transform: uppercase;
    }

    .btn-secondary {
        border: 1px solid #c5a059;
        background: #ffffff !important;
        color: #aa2324 !important;
        padding: 12px 22px;
        cursor: pointer;
        font-weight: 700;
        text-transform: uppercase;
    }

    .hero-image {
        flex: 1;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .hero-image img {
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        display: block;
    }

    .image-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.17);
        border-radius: 10px;
        pointer-events: none;
    }
</style>

<section class="hero-exhibit">

    <div class="hero-image">
        <img src="public/assets/key_highlights/7.jpg" alt="Exhibition Preview">
        <div class="image-overlay"></div>
    </div>

    <div class="hero-content">
        <h1>Visit IITM 2026 in India’s Top Cities</h1>
        <p>
            Discover India’s premier travel trade exhibition across major cities, connecting tourism boards,
            destinations, and global travel brands.
        </p>

        <div class="hero-buttons">
            <button class="btn-primary">Register -></button>
        </div>
    </div>

</section>
<!-- 
<h1>Visit IITM 2026 Across India’s Leading Travel Cities</h1>

        <p>
            Discover India’s premier travel trade exhibition as it travels across major cities,
            bringing together tourism boards, destinations, hospitality brands, and travel innovators.
            Explore new destinations, industry insights, and global tourism opportunities at IITM 2026.
        </p>

        <div class="hero-buttons">
            <button class="btn-primary">Plan Your Visit</button>
            <button class="btn-secondary">View Schedule</button>
        </div> -->