<div class="stats-wrapper" id="stats-scroll-section">
    <style>
        .stats-wrapper {
            background-color: #ffffff;
            padding: 10px 5px;
            font-family: 'Inter', sans-serif;
            text-align: center;
            overflow: hidden;
            position: relative;
            border-bottom: 1px solid #eee;
            perspective: 1000px;
            /* needed for tilt effect */
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stat-card {
            background: #ffffff;
            padding: 20px 9px;
            border-radius: 6px;
            opacity: 0;
            transform: translateY(30px);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease, opacity 0.6s ease;
            position: relative;
            will-change: transform;
        }

        .stats-wrapper.is-visible .stat-card {
            opacity: 1;
            transform: translateY(0);
        }

        /* hover glow + lift */
        .stat-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-color: #e6e6e6;
        }

        /* top highlight line */
        .stat-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 50%;
            width: 0%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #aa2324, transparent);
            transform: translateX(-50%);
            transition: width 0.4s ease;
        }

        .stat-card:hover::before {
            width: 80%;
        }

        .stat-num-wrap {
            font-family: Georgia, serif;
            font-size: 2.2rem;
            color: #111;
            display: flex;
            justify-content: center;
            align-items: baseline;
            line-height: 1;
            font-variant-numeric: tabular-nums;
        }

        .count-me {
            color: #aa2324;
            min-width: 1.2ch;
            display: inline-block;
            text-align: right;
        }

        .plus-sign {
            color: #aa2324;
            margin-left: 2px;
            font-size: 2.5rem;
        }

        .stat-label {
            color: #666;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 2px;
            font-weight: 700;
            margin-top: 15px;
        }

        /* pulse animation */
        @keyframes pulsePop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }

            100% {
                transform: scale(1);
            }
        }

        .stat-card.pulse {
            animation: pulsePop 0.4s ease;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stat-num-wrap {
                font-size: 2.5rem;
            }
        }
    </style>

    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-num-wrap">
                <span class="count-me" data-target="24000">0</span>
                <span class="plus-sign">+</span>
            </span>
            <div class="stat-label">Annual Visitors</div>
        </div>

        <div class="stat-card">
            <span class="stat-num-wrap">
                <span class="count-me" data-target="2000">0</span>
                <span class="plus-sign">+</span>
            </span>
            <div class="stat-label">Exhibitors</div>
        </div>

        <div class="stat-card">
            <span class="stat-num-wrap">
                <span class="count-me" data-target="24">0</span>
                <span class="plus-sign">+</span>
            </span>
            <div class="stat-label">States Represented</div>
        </div>

        <div class="stat-card">
            <span class="stat-num-wrap">
                <span class="count-me" data-target="8">0</span>
                <span class="plus-sign">+</span>
            </span>
            <div class="stat-label">Annual Trade Shows</div>
        </div>
        <div class="stat-card">
            <span class="stat-num-wrap">
                <span class="count-me" data-target="15">0</span>
                <span class="plus-sign">+</span>
            </span>
            <div class="stat-label">Country Represented</div>
        </div>
    </div>

    <script>
        (function () {
            const section = document.getElementById('stats-scroll-section');
            const counters = document.querySelectorAll('.count-me');
            const cards = document.querySelectorAll('.stat-card');
            let hasTriggered = false;

            const runCounterAnimation = () => {
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    const duration = 2000;
                    let startTime = null;

                    const easeOutQuart = t => 1 - (--t) * t * t * t;

                    const update = (timestamp) => {
                        if (!startTime) startTime = timestamp;
                        const progress = Math.min((timestamp - startTime) / duration, 1);

                        counter.innerText = Math.round(target * easeOutQuart(progress));

                        if (progress < 1) {
                            requestAnimationFrame(update);
                        } else {
                            counter.innerText = target.toLocaleString();

                            // pulse effect on finish
                            const card = counter.closest('.stat-card');
                            card.classList.add('pulse');

                            setTimeout(() => {
                                card.classList.remove('pulse');
                            }, 400);
                        }
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
            }, { threshold: 0.2 });

            observer.observe(section);

            // ✨ 3D tilt effect
            cards.forEach(card => {
                const strength = 8;

                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;

                    const rotateX = ((y - centerY) / centerY) * -strength;
                    const rotateY = ((x - centerX) / centerX) * strength;

                    card.style.transform = `
                        translateY(-6px)
                        rotateX(${rotateX}deg)
                        rotateY(${rotateY}deg)
                        scale(1.02)
                    `;
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = '';
                });
            });

        })();
    </script>
</div>