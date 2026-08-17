<div style="max-width: 760px; margin: 14px auto; font-family: 'Segoe UI', Tahoma, sans-serif; color: #1e293b;">

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px;">

        <div
            style="background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; box-shadow: 0 2px 5px rgba(0,0,0,0.06);">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span
                    style="background: #aa2324; color: white; padding: 3px 8px; border-radius: 5px; font-size: 0.68rem; font-weight: 700;">
                    EXHIBITORS
                </span>

                <span id="exh-growth" style="color: #16a34a; font-weight: 700; font-size: 0.72rem;"></span>
            </div>

            <div style="font-size: 0.75rem; color: #64748b;">Cumulative Total</div>

            <div id="exh-total" style="font-size: 1.6rem; font-weight: 800; color: #aa2324; margin: 4px 0 8px;">
                0
            </div>

            <div style="font-size: 0.72rem; border-top: 1px solid #f1f5f9; padding-top: 8px; color: #475569;">
                Base: <b>900</b>
                <span style="margin: 0 8px; color: #cbd5e1;">|</span>
                Projected: <b>2,550</b>
            </div>
        </div>

        <div
            style="background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; box-shadow: 0 2px 5px rgba(0,0,0,0.06);">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span
                    style="background: #fbbf24; color: #92400e; padding: 3px 8px; border-radius: 5px; font-size: 0.68rem; font-weight: 700;">
                    VISITORS
                </span>

                <span id="vis-growth" style="color: #16a34a; font-weight: 700; font-size: 0.72rem;"></span>
            </div>

            <div style="font-size: 0.75rem; color: #64748b;">Cumulative Total</div>

            <div id="vis-total" style="font-size: 1.6rem; font-weight: 800; color: #b45309; margin: 4px 0 8px;">
                0
            </div>

            <div style="font-size: 0.72rem; border-top: 1px solid #f1f5f9; padding-top: 8px; color: #475569;">
                Base: <b>11,000</b>
                <span style="margin: 0 8px; color: #cbd5e1;">|</span>
                Projected: <b>27,000</b>
            </div>
        </div>

    </div>
</div>

<script>
    (function () {
        const exhibitors = [900, 950, 1100, 1400, 1200, 1100, 1250, 1450, 2100, 2350, 2550];
        const visitors = [11000, 14000, 12000, 20000, 15000, 15000, 20000, 17000, 20000, 24000, 27000];

        const calculateStats = (data) => {
            const total = data.reduce((a, b) => a + b, 0);

            let growthRates = [];

            for (let i = 1; i < data.length; i++) {
                growthRates.push(((data[i] - data[i - 1]) / data[i - 1]) * 100);
            }

            const avgGrowth =
                (growthRates.reduce((a, b) => a + b, 0) / growthRates.length).toFixed(1);

            return {
                total: total.toLocaleString(),
                growth: avgGrowth
            };
        };

        const eStats = calculateStats(exhibitors);
        const vStats = calculateStats(visitors);

        document.getElementById('exh-total').innerText = eStats.total;
        document.getElementById('exh-growth').innerText = `↑ ${eStats.growth}%`;

        document.getElementById('vis-total').innerText = vStats.total;
        document.getElementById('vis-growth').innerText = `↑ ${vStats.growth}%`;
    })();
</script>