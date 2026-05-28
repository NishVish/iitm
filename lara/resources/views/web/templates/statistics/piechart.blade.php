<div style="
    margin:auto;
    background:#fff;
    border-radius:20px;
">
    <h3 style="
        text-align:center;
        margin-bottom:5px;
        font-family:'Segoe UI', sans-serif;
        font-size:24px;
        font-weight:700;
        color:#222;
    ">
        VISITORS PROFILE
    </h3>

    <div style="width:300px; height:300px; margin:auto;">
        <canvas id="visitorPieChart"></canvas>
    </div>
    <!-- Custom 2 Column Legend -->
    <div id="customLegend" style="
        display:grid;
        grid-template-columns:repeat(2,1fr);
        gap:6px 10px;
        font-family:'Segoe UI',sans-serif;
        font-size:14px;
    "></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    Chart.register(ChartDataLabels);

    // 3D Plugin
    const pie3dPlugin = {
        id: 'pie3d',

        beforeDatasetDraw(chart, args) {

            const { ctx } = chart;
            const meta = chart.getDatasetMeta(args.index);

            meta.data.forEach((element, index) => {

                const {
                    x,
                    y,
                    startAngle,
                    endAngle,
                    outerRadius
                } = element;

                for (let i = 15; i > 0; i--) {

                    ctx.beginPath();

                    ctx.arc(
                        x,
                        y + i,
                        outerRadius,
                        startAngle,
                        endAngle
                    );

                    ctx.lineTo(x, y + i);

                    ctx.fillStyle = darkenColor(
                        chart.data.datasets[0].backgroundColor[index],
                        35
                    );

                    ctx.fill();
                }
            });
        }
    };

    // Darker Shade
    function darkenColor(color, percent) {

        let num = parseInt(color.replace("#", ""), 16),
            amt = Math.round(2.55 * percent),
            R = (num >> 16) - amt,
            G = (num >> 8 & 0x00FF) - amt,
            B = (num & 0x0000FF) - amt;

        return "#" + (
            0x1000000 +
            (R < 255 ? (R < 1 ? 0 : R) : 255) * 0x10000 +
            (G < 255 ? (G < 1 ? 0 : G) : 255) * 0x100 +
            (B < 255 ? (B < 1 ? 0 : B) : 255)
        ).toString(16).slice(1);
    }

    // Chart
    const chart = new Chart(document.getElementById('visitorPieChart'), {

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
                    '#aa2324',
                    '#fbbf24',
                    '#3b82f6',
                    '#10b981',
                    '#8b5cf6',
                    '#f97316',
                    '#9ca3af'
                ],

                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 13
            }]
        },

        options: {

            responsive: true,

            layout: {
                padding: 20
            },

            plugins: {

                // Hide default legend
                legend: {
                    display: false
                },

                tooltip: {
                    enabled: true
                },

                datalabels: {

                    color: '#222',

                    font: {
                        weight: 'bold',
                        size: 11
                    },

                    formatter: (value) => value + '%'
                }
            }
        },

        plugins: [ChartDataLabels, pie3dPlugin]
    });

    // Custom 2 Column Legend
    const legendContainer = document.getElementById('customLegend');

    chart.data.labels.forEach((label, i) => {

        const color = chart.data.datasets[0].backgroundColor[i];

        legendContainer.innerHTML += `
        <div style="
            display:flex;
            align-items:center;
            gap:10px;
        ">
            <span style="
                width:14px;
                height:14px;
                border-radius:50%;
                background:${color};
                display:inline-block;
            "></span>

            <span style="color:#333;">
                ${label}
            </span>
        </div>
    `;
    });
</script>