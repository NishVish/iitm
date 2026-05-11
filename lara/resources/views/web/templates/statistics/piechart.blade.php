<div style="
    max-width: 600px;
    height: auto !important;
    margin: 0px auto;
    background: #fff;
    border-radius: 12px;
">
    <h3 style="text-align:center; margin-bottom:0px; font-family: 'Segoe UI', Arial, sans-serif;">
        VISITORS PROFILE </h3>

    <canvas id="visitorPieChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<script>
    // We must manually register the plugin
    Chart.register(ChartDataLabels);

    const pieCtx = document.getElementById('visitorPieChart').getContext('2d');

    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: [
                'Travel & Tourism Professionals',
                'Tour Operators',
                'Travel Agents',
                'Online Travel Agencies (OTA)',
                'Airlines & Aviation',
                'Hotels & Resorts',
                'Others'
            ],
            datasets: [{
                data: [15, 10, 8, 12, 10, 20, 25],
                backgroundColor: [
                    '#aa2324', // Your primary maroon
                    '#fbbf24', // Amber
                    '#3b82f6', // Blue
                    '#10b981', // Emerald
                    '#8b5cf6', // Violet
                    '#f97316', // Orange
                    '#9ca3af'  // Gray
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            layout: {
                // Generous padding to prevent labels from cutting off
                padding: {
                    left: 100,
                    right: 100
                }
            },
            plugins: {
                legend: {
                    display: false // Hide bottom legend, labels are already outside
                },
                tooltip: {
                    enabled: true // Tooltips are still helpful
                },
                datalabels: {
                    color: '#444',
                    font: {
                        size: 11,
                        weight: '100',
                        family: "'Segoe UI', Arial, sans-serif"
                    },
                    // The core of the solution (outlabels)
                    anchor: 'end',
                    align: 'end',
                    offset: 15, // Distance from the slice
                    clamp: true, // Keep labels inside the canvas area

                    // Formatter to show: "Label (15%)"
                    formatter: (value, ctx) => {
                        let label = ctx.chart.data.labels[ctx.dataIndex];
                        return label + ' (' + value + '%)';
                    },

                    // Custom drawing logic to create the connection lines
                    listeners: {
                        // We use the 'afterDraw' hook via the listeners object to ensure lines are drawn last
                        afterDraw: (ctx) => {
                            const chart = ctx.chart;
                            const ctx2d = chart.ctx;

                            chart.data.datasets.forEach((dataset, i) => {
                                const meta = chart.getDatasetMeta(i);
                                meta.data.forEach((element, index) => {
                                    // 1. Find center of the slice
                                    const { x, y, startAngle, endAngle, outerRadius } = element;
                                    const midAngle = startAngle + (endAngle - startAngle) / 2;
                                    const cosMidAngle = Math.cos(midAngle);
                                    const sinMidAngle = Math.sin(midAngle);

                                    // Line start point (edge of slice)
                                    const startX = x + (outerRadius * cosMidAngle);
                                    const startY = y + (outerRadius * sinMidAngle);

                                    // 2. Find label position
                                    const model = ctx.chart.getDatasetMeta(0).data[index];
                                    if (!model || !model.$datalabels) return;

                                    // Use datalabels coordinates if they are calculated
                                    const labelX = model.$datalabels[0]._model.x;
                                    const labelY = model.$datalabels[0]._model.y;

                                    if (isNaN(labelX) || isNaN(labelY)) return;

                                    // 3. Draw the line
                                    ctx2d.save();
                                    ctx2d.beginPath();
                                    ctx2d.moveTo(startX, startY);
                                    ctx2d.lineTo(labelX, labelY);

                                    // Match the line color to the slice color (Optional, looking better)
                                    // ctx2d.strokeStyle = dataset.backgroundColor[index];
                                    ctx2d.strokeStyle = '#888'; // Use a generic gray for all lines

                                    ctx2d.lineWidth = 1;
                                    ctx2d.stroke();
                                    ctx2d.restore();
                                });
                            });
                        }
                    }
                }
            }
        },
        // We need to provide the datalabels plugin instance
        plugins: [ChartDataLabels]
    });
</script>