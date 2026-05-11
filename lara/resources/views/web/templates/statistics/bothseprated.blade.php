<div style="max-width: 900px; margin: 30px auto; font-family: sans-serif;">
    <canvas id="exhibitorChart" height="120"></canvas>
    <br><br>
    <canvas id="visitorChart" height="120"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.addEventListener('load', function () {

        const labels = ['2015-16', '2016-17', '2017-18', '2018-19', '2019-21', '2021-22', '2022-23', '2023-24', '2024-25', '2025-26', '2026-27(P)'];
        const exhibitors = [900, 950, 1100, 1400, 1200, 1100, 1250, 1450, 2100, 2350, 2550];
        const visitors = [11000, 14000, 12000, 20000, 15000, 15000, 20000, 17000, 20000, 24000, 27000];

        // Calculation helper
        const calcAvgGrowth = (data) => {
            let rates = [];
            for (let i = 1; i < data.length; i++) {
                rates.push(((data[i] - data[i - 1]) / data[i - 1]) * 100);
            }
            return (rates.reduce((a, b) => a + b, 0) / rates.length).toFixed(2);
        };

        const exhibitorGrowth = calcAvgGrowth(exhibitors);
        const visitorGrowth = calcAvgGrowth(visitors);

        const threedBarPlugin = {
            id: 'threedBar',
            afterDatasetsDraw(chart) {
                const { ctx } = chart;
                chart.data.datasets.forEach((dataset, i) => {
                    const meta = chart.getDatasetMeta(i);
                    meta.data.forEach((bar, index) => {
                        const { x, y, base, width } = bar.getProps(['x', 'y', 'base', 'width'], true);
                        const halfWidth = width / 2;
                        const depth = 10;
                        if (y === base) return;

                        const isLast = index === dataset.data.length - 1;
                        let mainColor, sideColor, topColor;

                        if (isLast) {
                            mainColor = '#9ca3af'; sideColor = '#4b5563'; topColor = '#6b7280';
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
                chart.data.datasets.forEach((dataset, i) => {
                    const meta = chart.getDatasetMeta(i);
                    meta.data.forEach((bar, index) => {
                        const props = bar.getProps(['x', 'y'], true);
                        ctx.save();
                        ctx.fillStyle = '#000';
                        ctx.font = 'bold 12px Arial';
                        ctx.textAlign = 'center';
                        ctx.fillText(dataset.data[index], props.x + 5, props.y - 15);
                        ctx.restore();
                    });
                });
            }
        };

        const growthTextPlugin = {
            id: 'growthText',
            afterDraw(chart) {
                const { ctx } = chart;
                const growthVal = chart.canvas.id === 'exhibitorChart' ? exhibitorGrowth : visitorGrowth;
                ctx.save();
                ctx.font = 'bold 14px Arial';
                ctx.fillStyle = '#333';
                ctx.fillText(`Avg YoY Growth: ${growthVal}%`, 60, 20);
                ctx.restore();
            }
        };

        const getOptions = (titleText) => ({
            responsive: true,
            layout: { padding: { top: 30 } },
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: titleText, font: { size: 14, weight: 'bold' } }
                }
            }
        });

        new Chart(document.getElementById('exhibitorChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{ data: exhibitors, backgroundColor: 'transparent' }]
            },
            options: getOptions('No. of Exhibitors'),
            plugins: [threedBarPlugin, valueLabelPlugin, growthTextPlugin]
        });

        new Chart(document.getElementById('visitorChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{ data: visitors, backgroundColor: 'transparent' }]
            },
            options: getOptions('No. of Visitors'),
            plugins: [threedBarPlugin, valueLabelPlugin, growthTextPlugin]
        });
    });
</script>