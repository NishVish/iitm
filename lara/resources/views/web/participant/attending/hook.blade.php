<div class="portal-container">
    <style>
        :root {
            --iitm-red: #AA2324;
            --iitm-white: #ffffff;
            --iitm-gradient: linear-gradient(135deg, #AA2324, #7a1a1a);
        }

        .portal-container {
            width: 100%;
            min-height: 60vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /* background: #f4f4f4; */
            /* Neutral outer background to make the card pop */
            padding: 20px;
            box-sizing: border-box;
        }

        .portal-card {
            width: 100%;
            max-width: 1000px;
            background: rgba(0, 0, 0, 0.5);
            color: var(--iitm-white);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            padding: 50px;
            border-radius: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(170, 35, 36, 0.3);
        }

        /* The dynamic spotlight effect */
        .glow {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: 1;
        }

        h2 {
            margin: 0 0 20px;
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 800;
            letter-spacing: -1px;
            position: relative;
            z-index: 2;
        }

        .description {
            font-size: 20px;
            line-height: 1.5;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.95);
            position: relative;
            z-index: 2;
        }

        .urgency {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 25px;
            backdrop-filter: blur(4px);
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 30px;
            position: relative;
            z-index: 2;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .portal-card {
                padding: 30px;
            }

            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="portal-card" id="card">
        <div class="glow" id="glow"></div>

        <div class="urgency" id="urgencyText">
            ⚡ Visitor passes available...
        </div>

        <h2>Visitor Portal</h2>

        <p class="description">
            Explore the most influential gatherings in the <br>
            <strong style="color: #FFD700;">Hospitality & Travel Industry</strong>.
        </p>

        <div class="features">
            <div class="feature-item">🚀 Discover top events</div>
            <div class="feature-item">🎯 Connect with leaders</div>
            <div class="feature-item">📈 Premium networking</div>
        </div>

        <div style="margin-top: 40px; position: relative; z-index: 2;">
            @include('web.templates.whyvisit')
        </div>
    </div>

    <script>
        const card = document.getElementById("card");
        const glow = document.getElementById("glow");
        const urgencyText = document.getElementById("urgencyText");

        // Subtle spotlight follows mouse
        card.addEventListener("mousemove", (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            glow.style.left = `${x}px`;
            glow.style.top = `${y}px`;
        });

        // Animated ellipsis for urgency
        let dots = 0;
        setInterval(() => {
            dots = (dots + 1) % 4;
            urgencyText.textContent = `⚡ Visitor passes available${'.'.repeat(dots)}`;
        }, 600);
    </script>
</div>