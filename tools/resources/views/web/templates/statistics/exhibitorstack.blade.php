<div style="max-width:900px;margin:30px auto;font-family:sans-serif;">

    <!-- Exhibitor -->
    <div class="chart-row">

        <div class="chart-container">
            <canvas id="exhibitorChart" height="120"></canvas>
        </div>


    </div>

</div>
<style>
    .chart-row {
        display: flex;
        flex-direction: column;
        /* 👈 moved text below chart */
        gap: 16px;
        margin-bottom: 30px;
    }

    .chart-container {
        width: 100%;
    }


    @media (max-width:768px) {
        .chart-row {
            flex-direction: column;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.addEventListener('load', function () {

        const labels = ['2015-16', '2016-17', '2017-18', '2018-19', '2019-21', '2021-22', '2022-23', '2023-24', '2024-25', '2025-26', '2026-27(Projected)'];

        const exhibitors = [900, 950, 1100, 1400, 1100, 1150, 1250, 1450, 2100, 2350, 2550];

        const calcAvgGrowth = (data) => {
            let rates = [];
            for (let i = 1; i < data.length; i++) {
                rates.push(((data[i] - data[i - 1]) / data[i - 1]) * 100);
            }
            return (rates.reduce((a, b) => a + b, 0) / rates.length).toFixed(2);
        };

        document.getElementById('exhibitorGrowth').textContent = calcAvgGrowth(exhibitors);

        const threedBarPlugin = {
            id: 'threedBar',
            afterDatasetsDraw(chart) {
                const { ctx } = chart;

                const meta = chart.getDatasetMeta(0);

                meta.data.forEach((bar, index) => {
                    const { x, y, base, width } = bar.getProps(['x', 'y', 'base', 'width'], true);
                    const halfWidth = width / 2;
                    const depth = 10;

                    const isLast = index === chart.data.datasets[0].data.length - 1;

                    let mainColor = isLast ? '#9ca3af' : '#aa2324';
                    let sideColor = isLast ? '#4b5563' : '#6d1a1a';
                    let topColor = isLast ? '#6b7280' : '#c53030';

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

        new Chart(document.getElementById('exhibitorChart'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    data: exhibitors,
                    backgroundColor: 'transparent'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'No. of Exhibitors' }
                    }
                }
            },
            plugins: [threedBarPlugin, valueLabelPlugin]
        });

    });
</script>