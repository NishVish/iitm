<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stats + Growth Chart</title>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #fafafa;
        }

        /* ===== STATS SECTION ===== */
        .stats-wrapper {
            background-color: #ffffff;
            padding: 30px 10px;
            text-align: center;
            border-bottom: 1px solid #eee;
            perspective: 1000px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stat-card {
            background: #ffffff;
            padding: 40px 15px;
            border-radius: 6px;
            opacity: 0;
            transform: translateY(30px);
            transition: 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .stats-wrapper.is-visible .stat-card {
            opacity: 1;
            transform: translateY(0);
        }

        .stat-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .stat-num-wrap {
            font-family: Georgia, serif;
            font-size: 3rem;
        }

        .count-me {
            color: #aa2324;
        }

        .plus-sign {
            color: #aa2324;
        }

        .stat-label {
            color: #666;
            text-transform: uppercase;
            font-size: 0.75rem;
            margin-top: 10px;
        }

        /* ===== CHART SECTION ===== */
        .chart-section {
            max-width: 900px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .chart-title {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>

    <!-- ===== STATS ===== -->
    <div class="stats-wrapper" id="stats-scroll-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-num-wrap">
                    <span class="count-me" data-target="50000">0</span>+
                </div>
                <div class="stat-label">Annual Visitors</div>
            </div>

            <div class="stat-card">
                <div class="stat-num-wrap">
                    <span class="count-me" data-target="3500">0</span>+
                </div>
                <div class="stat-label">Exhibitors</div>
            </div>

            <div class="stat-card">
                <div class="stat-num-wrap">
                    <span class="count-me" data-target="25">0</span>+
                </div>
                <div class="stat-label">States Represented</div>
            </div>

            <div class="stat-card">
                <div class="stat-num-wrap">
                    <span class="count-me" data-target="23">0</span>+
                </div>
                <div class="stat-label">Trade Shows</div>
            </div>
        </div>
    </div>

    <!-- ===== LINE CHART ===== -->
    <div class="chart-section">
        <div class="chart-title">Growth by Year (2022–2025)</div>
        <canvas id="growthChart"></canvas>
    </div>

    <script>
        /* ===== COUNTER ANIMATION ===== */
        const counters = document.querySelectorAll('.count-me');
        const section = document.getElementById('stats-scroll-section');

        let triggered = false;

        const animateCounters = () => {
            counters.forEach(counter => {
                const target = +counter.dataset.target;
                let count = 0;
                const step = target / 100;

                const update = () => {
                    count += step;
                    if (count < target) {
                        counter.innerText = Math.floor(count);
                        requestAnimationFrame(update);
                    } else {
                        counter.innerText = target.toLocaleString();
                    }
                };

                update();
            });
        };

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !triggered) {
                    section.classList.add('is-visible');
                    animateCounters();
                    triggered = true;
                }
            });
        }, { threshold: 0.3 });

        observer.observe(section);

        /* ===== LINE CHART ===== */
        const ctx = document.getElementById('growthChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['2022', '2023', '2024', '2025'],
                datasets: [{
                    label: 'Visitors Growth',
                    data: [12000, 18000, 26000, 40000],
                    borderColor: '#aa2324',
                    backgroundColor: 'rgba(170,35,36,0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointBackgroundColor: '#aa2324'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>