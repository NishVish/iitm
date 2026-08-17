<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');

    .interactive-wrap {
        width: 100%;
        display: flex;
        justify-content: center;
        padding: 60px 20px;
        background: radial-gradient(circle at center, rgba(170, 35, 36, 0.03) 0%, transparent 70%);
        font-family: 'Inter', sans-serif;
    }

    .interactive-box {
        text-align: center;
        max-width: 800px;
        padding: 50px 40px;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(170, 35, 36, 0.1);
        border-radius: 24px;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        cursor: default;
    }

    /* 🔥 Animated Top Line with Glow */
    .interactive-line {
        width: 40px;
        height: 4px;
        background: #AA2324;
        margin: 0 auto 24px;
        border-radius: 999px;
        position: relative;
        box-shadow: 0 0 0 rgba(170, 35, 36, 0);
        transition: all 0.5s ease;
    }

    /* 💎 Dynamic Heading */
    .interactive-title {
        font-size: 36px;
        font-weight: 900;
        color: #1a1a1a;
        margin: 0;
        line-height: 1.2;
        transition: all 0.4s ease;
    }

    /* Subtle Red Accent in Title */
    .title-accent {
        color: #AA2324;
        position: relative;
        display: inline-block;
    }

    /* Description */
    .interactive-text {
        margin-top: 20px;
        font-size: 16px;
        color: #666;
        line-height: 1.8;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        opacity: 0.8;
        transition: all 0.4s ease;
    }

    /* 🚀 SUPER COOL HOVER EFFECTS */
    .interactive-box:hover {
        transform: translateY(-10px);
        background: #fff;
        border-color: rgba(170, 35, 36, 0.3);
        box-shadow: 0 20px 40px rgba(170, 35, 36, 0.08);
    }

    .interactive-box:hover .interactive-line {
        width: 100px;
        box-shadow: 0 0 15px rgba(170, 35, 36, 0.5);
    }

    .interactive-box:hover .interactive-title {
        color: #000;
        transform: scale(1.02);
    }

    .interactive-box:hover .interactive-text {
        opacity: 1;
        color: #333;
    }

    /* Mobile tweak */
    @media (max-width: 768px) {
        .interactive-title {
            font-size: 28px;
        }

        .interactive-box {
            padding: 30px 20px;
        }
    }
</style>

<div class="interactive-wrap">
    <div class="interactive-box">

        <div class="interactive-line"></div>

        <h3 class="interactive-title">
            A Marketplace that Satisfies all your
            <span class="title-accent">Business Needs</span>
        </h3>

        <p class="interactive-text">
            Persistently striving to strengthen the travel & tourism community through India's largest trade platform.
        </p>

    </div>
</div>