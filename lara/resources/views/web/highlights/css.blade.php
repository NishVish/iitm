<style>
    :root {
        --bg-dark: #050505;
        --accent: #ff3e3e;
        --card-width: 340px;
        --card-height: 480px;
    }

    .immersive-slider-section {
        background: var(--bg-dark);
        color: white;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        overflow: hidden;
        position: relative;
    }

    /* Floating ambient light blobs */
    .immersive-slider-section::before,
    .immersive-slider-section::after {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 62, 62, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
        pointer-events: none;
    }

    .immersive-slider-section::before {
        top: -100px;
        left: -100px;
    }

    .immersive-slider-section::after {
        bottom: -100px;
        right: -100px;
    }

    .slider-viewport {
        position: relative;
        width: 100%;
        perspective: 2000px;
        /* Stronger 3D depth */
        z-index: 1;
    }

    .slider-track {
        display: flex;
        align-items: center;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        transform-style: preserve-3d;
        padding: 60px 0;
    }

    .slider-item {
        min-width: var(--card-width);
        height: var(--card-height);
        margin: 0 30px;
        border-radius: 30px;
        position: relative;
        transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        transform: rotateY(45deg) scale(0.8);
        filter: brightness(0.3) blur(2px);
        transform-style: preserve-3d;
        cursor: pointer;
    }

    /* Reflection Effect */
    .slider-item::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: 0;
        width: 100%;
        height: 40%;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.1), transparent);
        transform: scaleY(-1);
        opacity: 0.2;
        pointer-events: none;
    }

    .slider-item.active {
        transform: rotateY(0deg) scale(1.1);
        filter: brightness(1) blur(0px);
        z-index: 10;
        box-shadow: 0 30px 100px rgba(0, 0, 0, 0.8), 0 0 40px rgba(255, 62, 62, 0.3);
    }

    /* Previous/Next items tilting towards center */
    .slider-item.prev {
        transform: rotateY(30deg) scale(0.9);
        filter: brightness(0.6);
    }

    .slider-item.next {
        transform: rotateY(-30deg) scale(0.9);
        filter: brightness(0.6);
    }

    .slider-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 30px;
        pointer-events: none;
    }

    .slider-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 40px 25px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.95), transparent);
        border-bottom-left-radius: 30px;
        border-bottom-right-radius: 30px;
        opacity: 0;
        transform: translateY(20px);
        transition: 0.5s 0.3s ease;
    }

    .slider-item.active .slider-caption {
        opacity: 1;
        transform: translateY(0);
    }

    .slider-caption h4 {
        margin: 0;
        font-size: 1.2rem;
        background: linear-gradient(45deg, #fff, #aaa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-align: center;
    }

    .nav-controls {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 30px;
        margin-top: 50px;
    }

    .nav-btn {
        background: none;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.5rem;
    }

    .nav-btn:hover {
        background: white;
        color: black;
        transform: scale(1.1);
    }

    .progress-dots {
        display: flex;
        gap: 10px;
    }

    .dot {
        width: 8px;
        height: 8px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transition: 0.3s;
    }

    .dot.active {
        width: 30px;
        background: var(--accent);
        border-radius: 10px;
    }
</style>