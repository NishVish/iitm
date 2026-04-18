<div class="stats-wrapper" id="stats-scroll-section">
    <style>
        /* 1. Reset & Layout */
        .stats-wrapper {
            background-color: #0a0a0b;
            /* Matte Dark */
            padding: 100px 20px;
            font-family: 'Inter', -apple-system, sans-serif;
            text-align: center;
            overflow: hidden;
        }

        .stats-title {
            color: #ffffff;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 60px;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* 2. Matte Card Design (No Glass) */
        .stat-card {
            background: #141417;
            border: 1px solid #26262b;
            padding: 45px 30px;
            border-radius: 12px;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.7s cubic-bezier(0.2, 1, 0.3, 1);
        }

        .stat-num-wrap {
            font-size: 3rem;
            font-weight: 800;
            color: #00f5ff;
            /* Cyan highlight */
            margin-bottom: 10px;
            display: block;
        }

        .stat-label {
            color: #8e8e93;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1.5px;
            font-weight: 600;
        }

        /* 3. Animation Triggers */
        .stats-wrapper.is-visible .stats-title {
            opacity: 1;
            transform: translateY(0);
        }

        .stats-wrapper.is-visible .stat-card {
            opacity: 1;
            transform: translateY(0);
        }

        /* Staggered Entry */
        .stats-wrapper.is-visible .stat-card:nth-child(1) {
            transition-delay: 0.1s;
        }

        .stats-wrapper.is-visible .stat-card:nth-child(2) {
            transition-delay: 0.2s;
        }

        .stats-wrapper.is-visible .stat-card:nth-child(3) {
            transition-delay: 0.3s;
        }

        .stats-wrapper.is-visible .stat-card:nth-child(4) {
            transition-delay: 0.4s;
        }
    </style>

    <h3 class="stats-title">Key Performance Highlights</h3>

    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-num-wrap"><span class="count-me" data-target="40000">0</span>+</span>
            <div class="stat-label">Annual Visitors</div>
        </div>
        <div class="stat-card">
            <span class="stat-num-wrap"><span class="count-me" data-target="2500">0</span>+</span>
            <div class="stat-label">Exhibitors</div>
        </div>
        <div class="stat-card">
            <span class="stat-num-wrap"><span class="count-me" data-target="25">0</span>+</span>
            <div class="stat-label">States Represented</div>
        </div>
        <div class="stat-card">
            <span class="stat-num-wrap"><span class="count-me" data-target="23">0</span>+</span>
            <div class="stat-label">Annual Trade Shows</div>
        </div>
    </div>

    <script>
        (function () {
            const section = document.getElementById('stats-scroll-section');
            const counters = document.querySelectorAll('.count-me');
            let hasRun = false;

            const startCounting = () => {
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    const duration = 2000; // 2 seconds animation
                    const increment = target / (duration / 16);

                    const updateCount = () => {
                        const current = +counter.innerText.replace(/,/g, '');
                        if (current < target) {
                            const nextValue = Math.ceil(current + increment);
                            counter.innerText = (nextValue > target ? target : nextValue).toLocaleString();
                            requestAnimationFrame(updateCount);
                        } else {
                            counter.innerText = target.toLocaleString();
                        }
                    };
                    updateCount();
                });
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !hasRun) {
                        section.classList.add('is-visible');
                        startCounting();
                        hasRun = true; // Prevent re-triggering
                    }
                });
            }, { threshold: 0.3 });

            observer.observe(section);
        })();
    </script>
</div>