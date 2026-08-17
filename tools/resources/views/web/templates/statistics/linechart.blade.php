<canvas id="growthChart" height="100"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('growthChart').getContext('2d');

    const growthChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['2022', '2023', '2024', '2025', '2026 (Pred)'],
            datasets: [
                {
                    label: 'Domestic Visitors',
                    data: [20000, 24000, 28000, 27000, 35000],
                    backgroundColor: '#aa2324'
                },
                {
                    label: 'International Visitors',
                    data: [10000, 10000, 12000, 13000, 20000],
                    backgroundColor: '#fbbf24'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false,
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
                x: {
                    stacked: true
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    ticks: {
                        callback: value => value.toLocaleString()
                    }
                }
            }
        }
    });
</script>