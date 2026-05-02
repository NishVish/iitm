<canvas id="growthChart" height="100"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('growthChart').getContext('2d');

    const growthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['2022', '2023', '2024', '2025', '2026 (Pred)'],
            datasets: [{
                label: 'Visitors',
                data: [30000, 34000, 40000, 40000, 55000],
                borderColor: '#aa2324',
                backgroundColor: 'rgba(170,35,36,0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 6,
                // The "segment" object allows conditional styling of the line
                segment: {
                    borderDash: ctx => ctx.p0DataIndex >= 3 ? [5, 5] : undefined,
                    borderColor: ctx => ctx.p0DataIndex >= 3 ? '#fbbf24' : undefined
                },
                // Style individual points to match the prediction color
                pointBackgroundColor: (context) => {
                    return context.dataIndex === 4 ? '#fbbf24' : '#aa2324';
                },
                pointBorderColor: (context) => {
                    return context.dataIndex === 4 ? '#fbbf24' : '#aa2324';
                }
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let label = context.dataset.label || '';
                            if (context.dataIndex === 4) label += ' (Projected)';
                            return `${label}: ${context.parsed.y.toLocaleString()}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => value.toLocaleString()
                    }
                }
            }
        }
    });
</script>