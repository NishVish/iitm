<div style="max-width: 900px; margin: 30px auto; font-family: sans-serif;">
    <canvas id="exhibitorChart" height="120"></canvas>
    <br><br>
    <canvas id="visitorChart" height="120"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.addEventListener('load', function () {

        const labels = [
            '2015-16', '2016-17', '2017-18', '2018-19', '2019-21',
            '2021-22', '2022-23', '2023-24', '2024-25', '2025-26', '2026-27(P)'
        ];

        const exhibitors = [
            900,
            950,
            1100,
            1400,
            1200,
            1100,
            1250,
            1450,
            2100,
            2350,
            2550
        ];

        const visitors = [
            11000,
            14000,
            12000,
            20000,
            15000,
            15000,
            20000,
            17000,
            20000,
            24000,
            27000
        ];

        let growthRates = [];
        for (let i = 1; i < exhibitors.length; i++) {
            growthRates.push(((exhibitors[i] - exhibitors[i - 1]) / exhibitors[i - 1]) * 100);
        }
        const avgGrowth = (growthRates.reduce((a, b) => a + b, 0) / growthRates.length).toFixed(2);

        const threedBarPlugin = {
            id: 'threedBar',
            afterDatasetsDraw(chart) {
                const { ctx } = chart;

                chart.data.datasets.forEach((dataset, i) => {
                    const meta = chart.getDatasetMeta(i);

                    meta.data.forEach((bar, index) => {
                        const props = bar.getProps(['x', 'y', 'base', 'width'], true);
                        const x = props.x;
                        const y = props.y;
                        const base = props.base;
                        const width = props.width;
                        const halfWidth = width / 2;
                        const depth = 10;

                        if (y === base) return;

                        const color = i === 0 ? '#aa2324' : '#fbbf24';

                        ctx.beginPath();
                        ctx.fillStyle = i === 0 ? '#6d1a1a' : '#b45309';
                        ctx.moveTo(x + halfWidth, y);
                        ctx.lineTo(x + halfWidth + depth, y - depth);
                        ctx.lineTo(x + halfWidth + depth, base - depth);
                        ctx.lineTo(x + halfWidth, base);
                        ctx.closePath();
                        ctx.fill();

                        ctx.beginPath();
                        ctx.fillStyle = color;
                        ctx.moveTo(x - halfWidth, y);
                        ctx.lineTo(x - halfWidth + depth, y - depth);
                        ctx.lineTo(x + halfWidth + depth, y - depth);
                        ctx.lineTo(x + halfWidth, y);
                        ctx.closePath();
                        ctx.fill();
                    });
                });
            }
        };

        const valueLabelPlugin = {
            id: 'valueLabel',
            afterDatasetsDraw(chart) {
                const { ctx } = chart;

                chart.data.datasets.forEach((dataset, i) => {
                    const meta = chart.getDatasetMeta(i);

                    meta.data.forEach((bar, index) => {
                        const props = bar.getProps(['x', 'y'], true);

                        ctx.save();
                        ctx.fillStyle = '#000';
                        ctx.font = 'bold 12px Arial';
                        ctx.textAlign = 'center';
                        ctx.fillText(dataset.data[index], props.x, props.y - 10);
                        ctx.restore();
                    });
                });
            }
        };

        const growthTextPlugin = {
            id: 'growthText',
            afterDraw(chart) {
                if (chart.canvas.id !== 'exhibitorChart') return;

                const { ctx, chartArea } = chart;

                ctx.save();
                ctx.font = 'bold 14px Arial';
                ctx.fillStyle = '#333';
                ctx.fillText(`Avg YoY Growth: ${avgGrowth}%`, 40, 20);
                ctx.restore();
            }
        };

        const commonOptions = {
            responsive: true,
            scales: {
                y: { beginAtZero: true },
                x: {}
            },
            plugins: {
                legend: { display: true }
            }
        };

        new Chart(document.getElementById('exhibitorChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Exhibitors',
                    data: exhibitors,
                    backgroundColor: '#aa2324'
                }]
            },
            options: commonOptions,
            plugins: [threedBarPlugin, valueLabelPlugin, growthTextPlugin]
        });

        new Chart(document.getElementById('visitorChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Visitors',
                    data: visitors,
                    backgroundColor: '#fbbf24'
                }]
            },
            options: commonOptions,
            plugins: [threedBarPlugin, valueLabelPlugin]
        });

    });
</script>