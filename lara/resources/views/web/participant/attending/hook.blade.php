<div class="portal-container">
    <style>
        .portal-container {
            width: 100vw;
            height: 70vh;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: radial-gradient(circle at top left, #1e293b, #0f172a);
            overflow: hidden;
        }

        .portal-card {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            color: #ffffff;
            font-family: 'Inter', system-ui, sans-serif;
            border: none;
            text-align: left;
            padding: 60px;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        .glow {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(251, 191, 36, 0.18), transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            transform: translate(-50%, -50%);
        }

        h2 {
            margin: 0 0 20px;
            font-size: 42px;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(to right, #ffffff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .description {
            font-size: 18px;
            line-height: 1.6;
            color: #cbd5e1;
            max-width: 700px;
        }

        .sub-text {
            margin-top: 10px;
            font-size: 14px;
            color: #94a3b8;
            max-width: 600px;
        }

        .urgency {
            margin-top: 20px;
            font-size: 15px;
            color: #fbbf24;
            font-weight: 600;
        }

        .features {
            margin-top: 30px;
            font-size: 16px;
            line-height: 2;
        }

        .portal-register-btn {
            display: inline-block;
            margin-top: 40px;
            padding: 16px 34px;
            background: #fbbf24;
            color: #0f172a;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 800;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .portal-register-btn:hover {
            background: #f59e0b;
            transform: translateY(-3px);
        }

        .portal-card::before {
            content: "";
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15), transparent 60%);
            top: -200px;
            right: -200px;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(30px);
            }
        }
    </style>

    <div class="portal-card" id="card">
        <div class="glow" id="glow"></div>

        <h2>Visitor Portal</h2>

        <p class="description">
            Explore the most influential gatherings in the <b>Hospitality & Travel Industry</b>.
        </p>

        <p class="sub-text">
            Discover events, connect with exhibitors, and experience world-class networking opportunities.
        </p>

        <p class="urgency" id="urgencyText">
            ⚡ Limited visitor passes available...
        </p>

        <div class="features">
            🚀 Discover top events<br />
            🎯 Connect with industry leaders<br />
            📈 Experience premium networking
        </div>

        <a href="#hero" class="portal-register-btn">
            Get Visitor Pass
        </a>
    </div>

    <script>
        const card = document.getElementById("card");
        const glow = document.getElementById("glow");
        const urgencyText = document.getElementById("urgencyText");

        card.addEventListener("mousemove", (e) => {
            const rect = card.getBoundingClientRect();
            glow.style.left = (e.clientX - rect.left) + "px";
            glow.style.top = (e.clientY - rect.top) + "px";
        });

        let dots = 0;
        setInterval(() => {
            dots = (dots + 1) % 4;
            urgencyText.textContent =
                "⚡ Limited visitor passes available" + ".".repeat(dots);
        }, 500);
    </script>
</div>