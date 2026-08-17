<div style="max-width:1100px;margin:10px auto;background:#fff;border-radius:20px;padding:10px;">

    <h3 style="
        text-align:center;
        margin-bottom:25px;
        font-family:'Segoe UI',sans-serif;
        font-size:24px;
        font-weight:700;
        color:#222;">
    </h3>

    <!-- MAIN ROW -->
    <div style="
        display:flex;
        align-items:center;
        gap:40px;
        flex-wrap:wrap;
        justify-content:center;
    ">

        <!-- PIE CHART -->
        <div style="
    flex:0 0 35px;
            display:flex;
            justify-content:center;
            align-items:center;
        ">
            <canvas id="visitorPieChart" width="380" height="380"></canvas>
        </div>

        <!-- TEXT BLOCK -->
        <div style="
            flex:1;
            min-width:300px;
            background:#f8f9fa;
            padding:20px 22px;
            border-left:5px solid #aa2324;
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
            font-family:'Segoe UI',sans-serif;
        ">
            <h4 style="margin-top:0;color:#aa2324;font-size:18px;">
                Visitor Insights
            </h4>

            <p style="line-height:1.7;color:#333;">
                The visitor profile represents a strong mix of tourism professionals,
                ensuring industry-wide participation and networking opportunities.
            </p>
            <ul style="line-height:1.9;padding-left:18px;margin:10px 0;">
                <li><b>35%</b> Others</li>
                <li><b>20%</b> Hotels & Resorts</li>
                <li><b>40%</b> Travel & Tourism Professionals</li>
                <li><b>5%</b> Airlines & Aviation</li>
            </ul>

            <p style="line-height:1.7;color:#555;">
                This balanced distribution highlights strong engagement across all major
                sectors of the travel industry.
            </p>
        </div>

    </div>

    <!-- LEGEND -->
    <div id="customLegend" style="
        display:grid;
        grid-template-columns:repeat(2,1fr);
        gap:8px 12px;
        margin-top:25px;
        font-family:'Segoe UI',sans-serif;
        font-size:14px;
        padding:0 10px;
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

                const { x, y, startAngle, endAngle, outerRadius } = element;

                for (let i = 15; i > 0; i--) {

                    ctx.beginPath();
                    ctx.arc(x, y + i, outerRadius, startAngle, endAngle);
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

    // Darker color helper
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
                'Airlines & Aviation',
                'Hotels & Resorts',
                'Others'
            ],
            datasets: [{
                data: [40, 5, 20, 35], // Total = 100
                backgroundColor: [
                    '#aa2324',
                    '#fbbf24',
                    '#3b82f6',
                    '#10b981'
                ],
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 12
            }]
        },

        options: {
            responsive: true, maintainAspectRatio: false,   // 👈 important
            layout: {
                padding: {
                    bottom: 30   // 👈 gives space for 3D depth
                }
            },
            plugins: {
                legend: { display: false },
                datalabels: {
                    color: '#222',
                    font: { weight: 'bold', size: 11 },
                    formatter: (value) => value + '%'
                }
            }
        },

        plugins: [ChartDataLabels, pie3dPlugin]
    });

    // Legend
    const legendContainer = document.getElementById('customLegend');

    chart.data.labels.forEach((label, i) => {
        const color = chart.data.datasets[0].backgroundColor[i];

        legendContainer.innerHTML += `
        <div style="display:flex;align-items:center;gap:10px;">
            <span style="
                width:14px;
                height:14px;
                border-radius:50%;
                background:${color};
                display:inline-block;
            "></span>
            <span>${label}</span>
        </div>
    `;
    });
</script>