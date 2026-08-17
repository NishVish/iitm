<canvas id="growthChart" height="120"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = ['2015', '2017', '2019', '2022', '2023', '2024', '2025', '2026'];

    const exhibitors = [845, 980, 1120, 1150, 1350, 1520, 1850, 2100];
    const visitors = [8000, 10000, 12000, 14000, 16000, 18000, 20000, 22000];

    // Avg growth calc
    let growthRates = [];
    for (let i = 1; i < exhibitors.length; i++) {
        let growth = ((exhibitors[i] - exhibitors[i - 1]) / exhibitors[i - 1]) * 100;
        growthRates.push(growth);
    }
    const avgGrowth = (growthRates.reduce((a, b) => a + b, 0) / growthRates.length).toFixed(2);

    const growthTextPlugin = {
        id: 'growthText',
        afterDraw(chart) {
            const { ctx, chartArea: { top, right } } = chart;
            ctx.save();
            ctx.font = 'bold 14px Arial';
            ctx.fillStyle = '#333';
            ctx.fillText(`Avg YoY Growth: ${avgGrowth}%`, right - 220, top + 20);
        }
    };

    const ctx = document.getElementById('growthChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'No. of Exhibitors',
                    data: exhibitors,
                    backgroundColor: '#aa2324',
                    yAxisID: 'y'
                },
                {
                    label: 'Trade Visitors',
                    data: visitors,
                    backgroundColor: '#fbbf24',
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: {
                    callbacks: {
                        label: (context) =>
                            `${context.dataset.label}: ${context.parsed.y.toLocaleString()}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Exhibitors'
                    }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
                    },
                    title: {
                        display: true,
                        text: 'Visitors'
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