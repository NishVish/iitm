<div class="stats-wrapper" id="stats-scroll-section">
    <style>
        .stats-wrapper {
            background-color: #0a0a0b;
            padding: 15px 5px;
            font-family: 'Inter', sans-serif;
            text-align: center;
            overflow: hidden;
            position: relative;
        }

        /* Ambient Glows */
        .stats-wrapper::before,
        .stats-wrapper::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, color-mix(in srgb, var(--iitm-background2), transparent 85%) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        .stats-wrapper::before {
            top: -10%;
            left: -5%;
        }

        .stats-wrapper::after {
            bottom: -10%;
            right: -5%;
        }

        .stats-grid {
            display: grid;
            /* Forced 4 columns */
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            padding: 20px;
        }

        /* Mobile adjustment: 4 columns on a phone is too small, 2x2 is better */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stat-num-wrap {
                font-size: 2.2rem !important;
            }
        }

        .stat-card {
            background: #111114;
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 40px 15px;
            border-radius: 20px;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: visible;
            cursor: default;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            inset: -1px;
            padding: 2px;
            border-radius: 20px;
            background: conic-gradient(from 0deg at 50% 50%, transparent 0deg, transparent 280deg, var(--iitm-background2) 360deg);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0.5;
            animation: rotate-beam 4s linear infinite;
            pointer-events: none;
        }

        @keyframes rotate-beam {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .stats-wrapper.is-visible .stat-card {
            opacity: 1;
            transform: translateY(0);
        }

        .stats-wrapper.is-visible .stat-card:nth-child(n) {
            transition-delay: calc(var(--delay) * 0.1s);
        }

        .stat-card:hover {
            transform: translateY(-10px) scale(1.03);
            background: #16161a;
            box-shadow: 0 20px 40px -10px color-mix(in srgb, var(--iitm-background2), transparent 80%);
            z-index: 10;
        }

        .stat-num-wrap {
            font-size: 3rem;
            font-weight: 900;
            color: #ffffff;
            margin-bottom: 10px;
            display: block;
            line-height: 1.1;
            letter-spacing: -1px;
            text-shadow: 0 0 20px color-mix(in srgb, var(--iitm-background2), transparent 60%);
        }

        .count-me {
            background: linear-gradient(to bottom, #ffffff, var(--iitm-background2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            padding: 0 2px;
        }

        .stat-label {
            color: #94a3b8;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1.5px;
            font-weight: 700;
            line-height: 1.3;
        }
    </style>

    <div class="stats-grid">
        <div class="stat-card" style="--delay: 1">
            <span class="stat-num-wrap"><span class="count-me" data-target="40000">0</span>+</span>
            <div class="stat-label">Annual Visitors</div>
        </div>
        <div class="stat-card" style="--delay: 2">
            <span class="stat-num-wrap"><span class="count-me" data-target="2500">0</span>+</span>
            <div class="stat-label">Exhibitors</div>
        </div>
        <div class="stat-card" style="--delay: 3">
            <span class="stat-num-wrap"><span class="count-me" data-target="25">0</span>+</span>
            <div class="stat-label">States Represented</div>
        </div>
        <div class="stat-card" style="--delay: 4">
            <span class="stat-num-wrap"><span class="count-me" data-target="23">0</span>+</span>
            <div class="stat-label">Annual Trade Shows</div>
        </div>
    </div>

    <script>
        (function () {
            const section = document.getElementById('stats-scroll-section');
            const counters = document.querySelectorAll('.count-me');
            let hasTriggered = false;

            const runCounterAnimation = () => {
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    const duration = 2000;
                    let startTime = null;
                    const easeOutExpo = t => t === 1 ? 1 : 1 - Math.pow(2, -10 * t);

                    const update = (timestamp) => {
                        if (!startTime) startTime = timestamp;
                        const progress = Math.min((timestamp - startTime) / duration, 1);
                        counter.innerText = Math.round(target * easeOutExpo(progress)).toLocaleString();
                        if (progress < 1) requestAnimationFrame(update);
                        else counter.innerText = target.toLocaleString();
                    };
                    requestAnimationFrame(update);
                });
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !hasTriggered) {
                        section.classList.add('is-visible');
                        runCounterAnimation();
                        hasTriggered = true;
                        observer.unobserve(section);
                    }
                });
            }, { threshold: 0.15 });

            observer.observe(section);
        })();
    </script>
</div>