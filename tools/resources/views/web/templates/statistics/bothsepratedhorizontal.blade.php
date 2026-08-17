<div style="max-width:1200px;margin:30px auto;font-family:sans-serif;">

    <!-- Exhibitor -->
    <div class="chart-row">
        <div class="chart-note">
            <h4>Exhibitor Insights</h4>
            <p><strong>Avg YoY Growth:</strong> <span id="exhibitorGrowth"></span>%</p>
            <p>Steady exhibitor participation with strong projected growth through 2026-27.</p>
        </div>
        <div class="chart-container">
            <canvas id="exhibitorChart" height="120"></canvas>
        </div>


    </div>

    <!-- Visitor -->
    <div class="chart-row">
        <div class="chart-note">
            <h4>Visitor Insights</h4>
            <p><strong>Avg YoY Growth:</strong> <span id="visitorGrowth"></span>%</p>
            <p>Visitor turnout continues to increase, indicating rising industry engagement.</p>
        </div>
        <div class="chart-container">
            <canvas id="visitorChart" height="120"></canvas>
        </div>


    </div>

</div>

<style>
    .chart-row {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 40px;
    }

    .chart-container {
        flex: 3;
        min-width: 0;
    }

    .chart-note {
        flex: 1;
        min-width: 250px;
        padding: 16px;
        background: #f8f9fa;
        border-left: 4px solid #aa2324;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
    }

    .chart-note h4 {
        margin: 0 0 10px;
        color: #aa2324;
    }

    .chart-note p {
        margin: 6px 0;
        line-height: 1.5;
    }

    @media (max-width:768px) {
        .chart-row {
            flex-direction: column;
        }

        .chart-note {
            width: 100%;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.addEventListener('load', function () {

        const labels = ['2015-16', '2016-17', '2017-18', '2018-19', '2019-21', '2021-22', '2022-23', '2023-24', '2024-25', '2025-26', '2026-27(Projected)'];
        const exhibitors = [900, 950, 1100, 1400, 1100, 1150, 1250, 1450, 2100, 2350, 2550];
        const visitors = [11000, 14000, 15500, 19000, 13500, 15000, 16000, 17000, 20000, 24000, 27000];

        const calcAvgGrowth = (data) => {
            let rates = [];
            for (let i = 1; i < data.length; i++) {
                rates.push(((data[i] - data[i - 1]) / data[i - 1]) * 100);
            }
            return (rates.reduce((a, b) => a + b, 0) / rates.length).toFixed(2);
        };

        const exhibitorGrowth = calcAvgGrowth(exhibitors);
        const visitorGrowth = calcAvgGrowth(visitors);

        document.getElementById('exhibitorGrowth').textContent = exhibitorGrowth;
        document.getElementById('visitorGrowth').textContent = visitorGrowth;

        const threedBarPlugin = {
            id: 'threedBar',
            afterDatasetsDraw(chart) {
                const { ctx } = chart;
                chart.data.datasets.forEach((dataset) => {
                    const meta = chart.getDatasetMeta(0);

                    meta.data.forEach((bar, index) => {
                        const { x, y, base, width } = bar.getProps(['x', 'y', 'base', 'width'], true);
                        const halfWidth = width / 2;
                        const depth = 10;

                        const isLast = index === dataset.data.length - 1;

                        let mainColor, sideColor, topColor;

                        if (isLast) {
                            mainColor = '#9ca3af';
                            sideColor = '#4b5563';
                            topColor = '#6b7280';
                        } else {
                            mainColor = chart.canvas.id === 'exhibitorChart' ? '#aa2324' : '#fbbf24';
                            sideColor = chart.canvas.id === 'exhibitorChart' ? '#6d1a1a' : '#b45309';
                            topColor = chart.canvas.id === 'exhibitorChart' ? '#c53030' : '#fcd34d';
                        }

                        ctx.fillStyle = mainColor;
                        ctx.fillRect(x - halfWidth, y, width, base - y);

                        ctx.beginPath();
                        ctx.fillStyle = sideColor;
                        ctx.moveTo(x + halfWidth, y);
                        ctx.lineTo(x + halfWidth + depth, y - depth);
                        ctx.lineTo(x + halfWidth + depth, base - depth);
                        ctx.lineTo(x + halfWidth, base);
                        ctx.fill();

                        ctx.beginPath();
                        ctx.fillStyle = topColor;
                        ctx.moveTo(x - halfWidth, y);
                        ctx.lineTo(x - halfWidth + depth, y - depth);
                        ctx.lineTo(x + halfWidth + depth, y - depth);
                        ctx.lineTo(x + halfWidth, y);
                        ctx.fill();
                    });
                });
            }
        };

        const valueLabelPlugin = {
            id: 'valueLabel',
            afterDatasetsDraw(chart) {
                const { ctx } = chart;
                const meta = chart.getDatasetMeta(0);

                meta.data.forEach((bar, index) => {
                    const { x, y } = bar.getProps(['x', 'y'], true);

                    ctx.save();
                    ctx.fillStyle = '#000';
                    ctx.font = 'bold 12px Arial';
                    ctx.textAlign = 'center';
                    ctx.fillText(chart.data.datasets[0].data[index], x + 5, y - 15);
                    ctx.restore();
                });
            }
        };

        const options = (title) => ({
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: title
                    }
                }
            }
        });

        new Chart(document.getElementById('exhibitorChart'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    data: exhibitors,
                    backgroundColor: 'transparent'
                }]
            },
            options: options('No. of Exhibitors'),
            plugins: [threedBarPlugin, valueLabelPlugin]
        });

        new Chart(document.getElementById('visitorChart'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    data: visitors,
                    backgroundColor: 'transparent'
                }]
            },
            options: options('No. of Visitors'),
            plugins: [threedBarPlugin, valueLabelPlugin]
        });

    });
</script>