<div class="portal-container">
    <style>
        :root {
            --iitm-text: #AA2324;
            --iitm-background: #ffffff;
            --iitm-text2: #ffffff;
            --iitm-background2: #AA2324;
        }

        .portal-container {
            width: 100%;
            min-height: 70vh;
            display: flex;
            justify-content: center;
            align-items: center;

            background: radial-gradient(circle at top left,
                var(--iitm-background),
                var(--iitm-background2)
            );

            box-sizing: border-box;
        }

        .portal-card {
            width: 100%;
            max-width: 1100px;

            background: linear-gradient(135deg,
                var(--iitm-background2),
                var(--iitm-text)
            );

            color: var(--iitm-text2);
            font-family: 'Inter', system-ui, sans-serif;
            padding: 40px;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
        }

        /* .glow {
            position: absolute;
            width: 300px;
            height: 300px;

            background: radial-gradient(circle,
                var(--iitm-background2),
                transparent 70%
            );

            border-radius: 50%;
            pointer-events: none;
            transform: translate(-50%, -50%);
            top: 0;
            left: 0;
        } */

        h2 {
            margin: 0 0 16px;
            font-size: 42px;
            font-weight: 800;

            background: linear-gradient(to right,
                var(--iitm-text2),
                var(--iitm-background)
            );

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .description {
            font-size: 18px;
            line-height: 1.6;
            color: var(--iitm-background);
            max-width: 700px;
        }

        .sub-text {
            margin-top: 10px;
            font-size: 14px;
            color: var(--iitm-background);
            opacity: 0.8;
            max-width: 600px;
        }

        .urgency {
            margin-top: 18px;
            font-size: 15px;
            color: var(--iitm-background2);
            font-weight: 600;
        }

        .features {
            margin-top: 24px;
            font-size: 16px;
            line-height: 1.9;
            color: var(--iitm-text2);
        }

        .portal-register-btn {
            display: inline-block;
            margin-top: 28px;
            padding: 14px 28px;

            background: var(--iitm-background2);
            color: var(--iitm-text2);

            border-radius: 12px;
            text-decoration: none;
            font-weight: 800;
            font-size: 16px;
            transition: 0.25s ease;
            position: relative;
            z-index: 2;
        }

        .portal-register-btn:hover {
            opacity: 0.9;
            transform: translateY(-3px);
        }

        .portal-card::before {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;

            background: radial-gradient(circle,
                var(--iitm-background2),
                transparent 60%
            );

            top: -180px;
            right: -180px;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(25px); }
        }

        @media (max-width: 768px) {
            .portal-card {
                padding: 25px;
            }

            h2 {
                font-size: 28px;
            }

            .features {
                font-size: 14px;
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

        @include('web.templates.whyvisit')
    </div>

    <script>
        const card = document.getElementById("card");
        const glow = document.getElementById("glow");
        const urgencyText = document.getElementById("urgencyText");

        // card.addEventListener("mousemove", (e) => {
        //     const rect = card.getBoundingClientRect();
        //     glow.style.left = (e.clientX - rect.left) + "px";
        //     glow.style.top = (e.clientY - rect.top) + "px";
        // });

        setInterval(() => {
            let dots = (urgencyText.textContent.match(/\./g) || []).length;
            dots = (dots + 1) % 4;
            urgencyText.textContent =
                "⚡ Limited visitor passes available" + ".".repeat(dots);
        }, 500);
    </script>
</div>