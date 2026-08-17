<style>
    :root {
        --iitm-red: #AA2324;
        --white: #ffffff;
    }

    .main-wrapper {
        width: 100%;
        min-height: 100svh;
        position: relative;
        overflow: hidden;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: white;
        isolation: isolate;
    }

    .bg-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
        pointer-events: none;
        user-select: none;
    }

    .overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.70));
        z-index: 1;
    }

    .content-container {
        position: relative;
        z-index: 2;
        min-height: 100svh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: clamp(40px, 6vw, 80px);
        max-width: 1100px;
        margin: 0 auto;
        box-sizing: border-box;
    }

    .portal-tag {
        font-size: 14px;
        opacity: 0.8;
        margin-bottom: 10px;
    }

    .main-title {
        font-size: clamp(32px, 5vw, 52px);
        font-weight: 800;
        letter-spacing: -1px;
        line-height: 1.1;
    }

    .main-title span {
        color: var(--iitm-red);
        text-shadow: 2px 2px 0px var(--white);
    }

    .main-description {
        margin: 20px 0 40px 0;
        font-size: clamp(16px, 2vw, 20px);
        opacity: 0.9;
        max-width: 700px;
        line-height: 1.5;
    }

    .expo-section {
        padding: 40px 0;
    }

    .expo-header {
        text-align: center;
        margin-bottom: 40px;
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

    .expo-card {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 18px;
        padding: 40px;
        transition: 0.3s ease;
    }

    .expo-card:hover {
        transform: translateY(-6px);
        background: rgba(255, 255, 255, 0.12);
    }

    .expo-badge {
        display: inline-block;
        background: rgba(170, 35, 36, 0.9);
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .expo-card h2 {
        margin: 0 0 20px 0;
        font-size: 24px;
    }

    .expo-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .expo-list li {
        padding-left: 25px;
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
        font-weight: bold;
    }

    .expo-btn {
        margin-top: 30px;
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        text-align: center;
        background: linear-gradient(135deg, #AA2324, #7a1a1a);
        color: white;
        padding: 16px;
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
</style>

<div class="main-wrapper">
    <img src="https://iitmindia.com/assets/creatives/2.jpg" class="bg-image" alt="Background" />
    <div class="overlay"></div>

    <div class="content-container">

        <div class="portal-tag">⚡ Visitor Portal</div>

        <h1 class="main-title">
            A Marketplace that Satisfies all your <span>Business Needs</span>
        </h1>

        <p class="main-description">
            Persistently striving to strengthen the travel & tourism community through India's largest trade platform.
        </p>



    </div>
</div>

@include('web.templates.whyvisit')