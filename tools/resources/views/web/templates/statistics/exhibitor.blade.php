<canvas id="growthChart" height="120"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = ['2015', '2017', '2019', '2022', '2023', '2024', '2025', '2026'];
    const dataValues = [845, 980, 1120, 1150, 1350, 1520, 1850, 2100];

    // Calculate YoY growth rates
    let growthRates = [];
    for (let i = 1; i < dataValues.length; i++) {
        let growth = ((dataValues[i] - dataValues[i - 1]) / dataValues[i - 1]) * 100;
        growthRates.push(growth);
    }

    // Average YoY Growth
    const avgGrowth = (growthRates.reduce((a, b) => a + b, 0) / growthRates.length).toFixed(2);

    // Plugin to display text on chart
    const growthTextPlugin = {
        id: 'growthText',
        afterDraw(chart) {
            const { ctx, chartArea: { top, right } } = chart;
            ctx.save();
            ctx.font = 'bold 14px Arial';
            ctx.fillStyle = '#333';
            ctx.fillText(`Avg YoY Growth: ${avgGrowth}%`, right - 200, top + 20);
        }
    };

    const ctx = document.getElementById('growthChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'No. of Exhibitors',
                data: dataValues,
                backgroundColor: '#aa2324'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return `Exhibitors: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'No. of Exhibitors'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Year'
                    }
                }
            }
        },
        plugins: [growthTextPlugin]
    });
</script>