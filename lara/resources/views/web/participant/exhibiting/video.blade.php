{{-- Video CTA --}}
<div class="cta-video-section">
    <video autoplay muted loop playsinline class="cta-video-bg" id="promoVideo">
        <source src="{{ asset('public/session/default/video_fixed.mp4') }}" type="video/mp4">
    </video>

    <div class="cta-overlay"></div>

    <div class="cta-content-box">
        <h2>Ready to showcase your destination?</h2>

        <a href="{{ url('/stalldemo') }}" class="main-cta">Book Your Stall Now</a>
        <p class="cta-subtext">Limited premium slots available for the 2026 series.</p>
    </div>
</div>

<style>
    /* Video CTA Section */
    .cta-video-section {
        position: relative;
        width: 100%;
        height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-top: 80px;
        border-radius: 30px;
    }

    .cta-video-bg {
        position: absolute;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        transform: translate(-50%, -50%);
        z-index: 1;
        object-fit: cover;
    }

    .cta-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.65);
        z-index: 2;
    }

    .cta-content-box {
        position: relative;
        z-index: 3;
        text-align: center;
        padding: 40px;
    }

    .cta-content-box h2 {
        font-size: clamp(1.8rem, 4vw, 3rem);
        font-weight: 900;
        margin-bottom: 25px;
        text-transform: uppercase;
    }

    .main-cta {
        padding: 18px 45px;
        font-size: 1.1rem;
        font-weight: 800;
        background: #fff;
        color: #000;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: 0.3s;
        text-transform: uppercase;
    }

    .main-cta:hover {
        background: var(--accent-cyan);
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 245, 255, 0.4);
    }

    .cta-subtext {
        margin-top: 20px;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.6);
    }
</style>