<div class="kpi-widget-wrapper">
    <style>
        /* Scoped box-sizing to protect the rest of your website */
        .kpi-widget-wrapper,
        .kpi-widget-wrapper * {
            box-sizing: border-box;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin: 0 auto;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 10px 14px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03), 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1),
                box-shadow 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 1px solid blac !important;

        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06), 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        /* Hero / Featured Card Styling */
        .span-2 {
            grid-column: span 2;
            background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);
            padding: 14px 16px;
            border-color: #e5e5e5;
        }

        .stat-num {
            font-size: 3.5vh;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 4px;
            line-height: 1;
            letter-spacing: -0.5px;
        }

        /* Make the feature number pop a bit more */
        .span-2 .stat-num {
            font-size: 8vh !important;
            color: #000000;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 500;
            color: #718096;
            letter-spacing: 0.1px;
            line-height: 1.3;
        }

        /* Small Screen Optimization */
        @media (max-width: 380px) {
            .stats-container {
                grid-template-columns: 1fr;
                padding: 0 16px;
            }

            .span-2 {
                grid-column: auto;
            }

            .stat-num {
                font-size: 26px;
            }

            .span-2 .stat-num {
                font-size: 30px;
            }
        }
    </style>

    <div class="stats-container">
        <!-- Row 1: Featured Full Width -->
        <div class="stat-card span-2">
            <div class="stat-num">24,000+</div>
            <div class="stat-label">Annual Visitors</div>
        </div>

        <!-- Row 2: Even Split -->
        <div class="stat-card">
            <div class="stat-num">2,000+</div>
            <div class="stat-label">Exhibitors</div>
        </div>

        <div class="stat-card">
            <div class="stat-num">24+</div>
            <div class="stat-label">States Represented</div>
        </div>

        <!-- Row 3: Even Split -->
        <div class="stat-card">
            <div class="stat-num">15+</div>
            <div class="stat-label">Countries Represented</div>
        </div>

        <div class="stat-card">
            <div class="stat-num">8+</div>
            <div class="stat-label">Annual Trade Shows</div>
        </div>
    </div>

</div>