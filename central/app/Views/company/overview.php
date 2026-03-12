<?php include(APPPATH . 'Views/company/side.php'); ?>

    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <style>
        :root {
            --bg: #0a0a0f;
            --surface: #13131a;
            --surface2: #1c1c27;
            --border: #2a2a3d;
            --accent: #6c63ff;
            --accent2: #ff6584;
            --accent3: #43e97b;
            --accent4: #f7971e;
            --text: #e8e8f0;
            --muted: #6b6b85;
            --font-display: 'Syne', sans-serif;
            --font-mono: 'DM Mono', monospace;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

       

        /* Noise texture overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.4;
        }

        .wrapper {
            position: relative;
            z-index: 1;
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 32px 64px;
        }

        /* ── Header ── */
        .header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding: 48px 0 32px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 40px;
        }

        .header-left .label {
            font-size: 11px;
            letter-spacing: 0.2em;
            color: var(--accent);
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .header-left h1 {
            font-family: var(--font-display);
            font-size: clamp(28px, 4vw, 48px);
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.03em;
        }

        .header-left h1 span {
            color: var(--accent);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .live-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: rgba(67,233,123,0.08);
            border: 1px solid rgba(67,233,123,0.25);
            border-radius: 100px;
            font-size: 11px;
            color: var(--accent3);
            letter-spacing: 0.1em;
        }

        .live-dot {
            width: 6px; height: 6px;
            background: var(--accent3);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.8); }
        }

        /* ── Filter Bar ── */
        .filter-bar {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 40px;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .filter-bar-title {
            font-size: 10px;
            letter-spacing: 0.2em;
            color: var(--muted);
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 12px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-group label {
            font-size: 10px;
            color: var(--muted);
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .filter-group select,
        .filter-group input {
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 8px 12px;
            border-radius: 8px;
            font-family: var(--font-mono);
            font-size: 12px;
            outline: none;
            transition: border-color 0.2s;
            appearance: none;
            -webkit-appearance: none;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            border-color: var(--accent);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .btn {
            padding: 8px 20px;
            border-radius: 8px;
            border: none;
            font-family: var(--font-mono);
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.05em;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
        }

        .btn-primary:hover { background: #5a52e0; transform: translateY(-1px); }

        .btn-ghost {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
        }

        .btn-ghost:hover { border-color: var(--muted); color: var(--text); }

        /* ── KPI Cards ── */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 40px;
        }

        .kpi-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px 20px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, border-color 0.2s;
            animation: fadeUp 0.5s ease both;
        }

        .kpi-card:nth-child(1) { animation-delay: 0.05s; }
        .kpi-card:nth-child(2) { animation-delay: 0.1s; }
        .kpi-card:nth-child(3) { animation-delay: 0.15s; }
        .kpi-card:nth-child(4) { animation-delay: 0.2s; }
        .kpi-card:nth-child(5) { animation-delay: 0.25s; }
        .kpi-card:nth-child(6) { animation-delay: 0.3s; }
        .kpi-card:nth-child(7) { animation-delay: 0.35s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .kpi-card:hover {
            transform: translateY(-3px);
            border-color: var(--accent);
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: var(--accent-color, var(--accent));
            opacity: 0.8;
        }

        .kpi-card[data-color="green"]  { --accent-color: var(--accent3); }
        .kpi-card[data-color="red"]    { --accent-color: var(--accent2); }
        .kpi-card[data-color="orange"] { --accent-color: var(--accent4); }
        .kpi-card[data-color="purple"] { --accent-color: var(--accent); }

        .kpi-label {
            font-size: 10px;
            letter-spacing: 0.15em;
            color: var(--muted);
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .kpi-value {
            font-family: var(--font-display);
            font-size: 38px;
            font-weight: 800;
            line-height: 1;
            color: var(--accent-color, var(--accent));
            letter-spacing: -0.03em;
        }

        .kpi-sub {
            margin-top: 8px;
            font-size: 11px;
            color: var(--muted);
        }

        .kpi-sub b { color: var(--text); }

        /* ── Section layout ── */
        .section-title {
            font-family: var(--font-display);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 40px;
        }

        .three-col {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 24px;
            margin-bottom: 40px;
        }

        @media (max-width: 1100px) {
            .three-col { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .two-col, .three-col { grid-template-columns: 1fr; }
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
        }

        /* ── Chart panels ── */
        .chart-wrap {
            position: relative;
            height: 220px;
        }

        /* ── Table ── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .data-table thead th {
            font-size: 10px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            text-align: left;
            padding: 8px 12px;
            border-bottom: 1px solid var(--border);
        }

        .data-table tbody tr {
            border-bottom: 1px solid rgba(42,42,61,0.5);
            transition: background 0.15s;
        }

        .data-table tbody tr:last-child { border-bottom: none; }
        .data-table tbody tr:hover { background: var(--surface2); }

        .data-table td {
            padding: 10px 12px;
            color: var(--text);
        }

        .data-table td:first-child { color: var(--muted); font-size: 11px; }

        /* progress bar inline */
        .bar-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .bar-track {
            flex: 1;
            height: 4px;
            background: var(--surface2);
            border-radius: 2px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            border-radius: 2px;
            background: var(--accent);
            transition: width 0.8s ease;
        }

        /* status pills */
        .pill {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 100px;
            font-size: 10px;
            letter-spacing: 0.08em;
            font-weight: 500;
        }

        .pill-green  { background: rgba(67,233,123,0.12); color: var(--accent3); }
        .pill-red    { background: rgba(255,101,132,0.12); color: var(--accent2); }
        .pill-orange { background: rgba(247,151,30,0.12); color: var(--accent4); }

        /* ── Stale table ── */
        .stale-badge {
            font-size: 10px;
            color: var(--accent2);
            background: rgba(255,101,132,0.1);
            padding: 2px 8px;
            border-radius: 4px;
        }

        /* ── Geo breakdown bar chart ── */
        .geo-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 0;
            border-bottom: 1px solid rgba(42,42,61,0.4);
        }

        .geo-row:last-child { border-bottom: none; }

        .geo-name {
            font-size: 12px;
            color: var(--text);
            width: 120px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .geo-bar-track {
            flex: 1;
            height: 6px;
            background: var(--surface2);
            border-radius: 3px;
            overflow: hidden;
        }

        .geo-bar-fill {
            height: 100%;
            border-radius: 3px;
            background: linear-gradient(90deg, var(--accent), #a78bfa);
        }

        .geo-count {
            font-size: 11px;
            color: var(--muted);
            width: 36px;
            text-align: right;
        }

        /* scrollable panel body */
        .scroll-body {
            max-height: 280px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--border) transparent;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <div class="label">CRM · Analytics</div>
            <h1>Company <span>Overview</span></h1>
        </div>
        <div class="header-right">
            <span class="live-badge">
                <span class="live-dot"></span>
                LIVE DATA
            </span>
        </div>
    </header>

    <!-- Filters -->
    <div class="filter-bar">
        <div class="filter-bar-title">Filter Data</div>
        <form method="GET" action="">
            <div class="filter-grid">
                <div class="filter-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="">All</option>
                        <option value="active"   <?= ($filters['status'] ?? '') === 'active'   ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Sales Person</label>
                    <select name="sales_person">
                        <option value="">All</option>
                        <?php foreach ($salesPersonList as $sp): ?>
                            <option value="<?= esc($sp['sales_person']) ?>"
                                <?= ($filters['sales_person'] ?? '') === $sp['sales_person'] ? 'selected' : '' ?>>
                                <?= esc($sp['sales_person']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Country</label>
                    <select name="country">
                        <option value="">All</option>
                        <?php foreach ($countryList as $c): ?>
                            <option value="<?= esc($c['country']) ?>"
                                <?= ($filters['country'] ?? '') === $c['country'] ? 'selected' : '' ?>>
                                <?= esc($c['country']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label>State</label>
                    <select name="state">
                        <option value="">All</option>
                        <?php foreach ($stateList as $s): ?>
                            <option value="<?= esc($s['state']) ?>"
                                <?= ($filters['state'] ?? '') === $s['state'] ? 'selected' : '' ?>>
                                <?= esc($s['state']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Entry Type</label>
                    <select name="entry_type">
                        <option value="">All</option>
                        <?php foreach ($entryTypeList as $et): ?>
                            <option value="<?= esc($et['entry_type']) ?>"
                                <?= ($filters['entry_type'] ?? '') === $et['entry_type'] ? 'selected' : '' ?>>
                                <?= esc($et['entry_type']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Outbound</label>
                    <select name="outbound">
                        <option value="">All</option>
                        <option value="1" <?= ($filters['outbound'] ?? '') === '1' ? 'selected' : '' ?>>Outbound</option>
                        <option value="0" <?= ($filters['outbound'] ?? '') === '0' ? 'selected' : '' ?>>Inbound</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Date From</label>
                    <input type="date" name="date_from" value="<?= esc($filters['date_from'] ?? '') ?>">
                </div>

                <div class="filter-group">
                    <label>Date To</label>
                    <input type="date" name="date_to" value="<?= esc($filters['date_to'] ?? '') ?>">
                </div>

                <div class="filter-group filter-actions">
                    <button type="submit" class="btn btn-primary">Apply</button>
                    <a href="<?= current_url() ?>" class="btn btn-ghost">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- KPI Cards -->
    <div class="kpi-grid">
        <div class="kpi-card" data-color="purple">
            <div class="kpi-label">Total Companies</div>
            <div class="kpi-value"><?= number_format($total) ?></div>
        </div>
        <div class="kpi-card" data-color="green">
            <div class="kpi-label">Active</div>
            <div class="kpi-value"><?= number_format($activeCount) ?></div>
            <div class="kpi-sub">
                <b><?= $total > 0 ? round(($activeCount / $total) * 100) : 0 ?>%</b> of total
            </div>
        </div>
        <div class="kpi-card" data-color="red">
            <div class="kpi-label">Inactive</div>
            <div class="kpi-value"><?= number_format($inactiveCount) ?></div>
            <div class="kpi-sub">
                <b><?= $total > 0 ? round(($inactiveCount / $total) * 100) : 0 ?>%</b> of total
            </div>
        </div>
        <div class="kpi-card" data-color="orange">
            <div class="kpi-label">Outbound</div>
            <div class="kpi-value"><?= number_format($outboundCount) ?></div>
        </div>
        <div class="kpi-card" data-color="purple">
            <div class="kpi-label">Inbound</div>
            <div class="kpi-value"><?= number_format($inboundCount) ?></div>
        </div>
        <div class="kpi-card" data-color="green">
            <div class="kpi-label">Cross Validated</div>
            <div class="kpi-value"><?= number_format($crossValidated) ?></div>
        </div>
        <div class="kpi-card" data-color="red">
            <div class="kpi-label">No Sessions</div>
            <div class="kpi-value"><?= number_format($noSession) ?></div>
            <div class="kpi-sub">Zero engagement</div>
        </div>
    </div>

    <!-- Monthly Trend + Active vs Inactive Donut -->
    <div class="section-title">Trends &amp; Distribution</div>
    <div class="two-col" style="margin-bottom:40px">
        <div class="panel">
            <div class="section-title" style="font-size:11px; margin-bottom:16px">Monthly Registrations · Last 12 Months</div>
            <div class="chart-wrap">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
        <div class="panel">
            <div class="section-title" style="font-size:11px; margin-bottom:16px">Active vs Inactive</div>
            <div class="chart-wrap" style="height:200px">
                <canvas id="statusChart"></canvas>
            </div>
            <div style="display:flex; gap:24px; justify-content:center; margin-top:16px; font-size:11px; color:var(--muted)">
                <span><span style="color:var(--accent3)">●</span> Active — <?= number_format($activeCount) ?></span>
                <span><span style="color:var(--accent2)">●</span> Inactive — <?= number_format($inactiveCount) ?></span>
            </div>
        </div>
    </div>

    <!-- Sales Person + Entry Type + Geo -->
    <div class="section-title">Breakdowns</div>
    <div class="three-col">
        <!-- Sales Person Table -->
        <div class="panel">
            <div class="section-title" style="font-size:11px; margin-bottom:12px">By Sales Person</div>
            <div class="scroll-body">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Total</th>
                            <th>Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $maxSP = max(array_column($bySalesPerson, 'total') ?: [1]); ?>
                        <?php foreach ($bySalesPerson as $i => $sp): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($sp['sales_person'] ?: '—') ?></td>
                            <td>
                                <div class="bar-wrap">
                                    <div class="bar-track">
                                        <div class="bar-fill" style="width:<?= round(($sp['total'] / $maxSP) * 100) ?>%"></div>
                                    </div>
                                    <?= number_format($sp['total']) ?>
                                </div>
                            </td>
                            <td><span class="pill pill-green"><?= number_format($sp['active_count']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($bySalesPerson)): ?>
                            <tr><td colspan="4" style="color:var(--muted); padding:20px; text-align:center">No data</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- By State -->
        <div class="panel">
            <div class="section-title" style="font-size:11px; margin-bottom:12px">By State</div>
            <div class="scroll-body">
                <?php $maxState = max(array_column($byState, 'total') ?: [1]); ?>
                <?php foreach (array_slice($byState, 0, 15) as $row): ?>
                <div class="geo-row">
                    <div class="geo-name"><?= esc($row['state'] ?: 'Unknown') ?></div>
                    <div class="geo-bar-track">
                        <div class="geo-bar-fill" style="width:<?= round(($row['total'] / $maxState) * 100) ?>%"></div>
                    </div>
                    <div class="geo-count"><?= $row['total'] ?></div>
                </div>
                <?php endforeach; ?>
                <?php if (empty($byState)): ?>
                    <div style="color:var(--muted); padding:20px; text-align:center; font-size:12px">No data</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Entry Type Donut -->
        <div class="panel">
            <div class="section-title" style="font-size:11px; margin-bottom:12px">By Entry Type</div>
            <div class="chart-wrap" style="height:180px">
                <canvas id="entryChart"></canvas>
            </div>
            <div style="margin-top:14px; display:flex; flex-direction:column; gap:6px">
                <?php
                $entryColors = ['#6c63ff','#ff6584','#43e97b','#f7971e','#38bdf8','#a78bfa'];
                foreach ($byEntryType as $ei => $et): ?>
                <div style="display:flex; align-items:center; gap:8px; font-size:11px; color:var(--muted)">
                    <span style="width:8px;height:8px;border-radius:2px;background:<?= $entryColors[$ei % count($entryColors)] ?>;flex-shrink:0"></span>
                    <?= esc($et['entry_type'] ?: 'Unknown') ?> — <b style="color:var(--text)"><?= $et['total'] ?></b>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Stale Companies -->
    <div class="section-title">⚠ At-Risk · Not Confirmed in 90+ Days</div>
    <div class="panel" style="margin-bottom:40px">
        <div class="scroll-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Company</th>
                        <th>Sales Person</th>
                        <th>Last Confirmed</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($staleCompanies as $i => $sc): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($sc['company_name'] ?: '—') ?></td>
                        <td><?= esc($sc['sales_person'] ?: '—') ?></td>
                        <td>
                            <?php if ($sc['last_confirmed_at']): ?>
                                <span class="stale-badge"><?= esc($sc['last_confirmed_at']) ?></span>
                            <?php else: ?>
                                <span class="stale-badge">Never confirmed</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="pill <?= $sc['active_inactive'] === 'active' ? 'pill-green' : 'pill-red' ?>">
                                <?= esc($sc['active_inactive']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($staleCompanies)): ?>
                        <tr><td colspan="5" style="color:var(--accent3); padding:20px; text-align:center">✓ All companies confirmed recently</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div><!-- /wrapper -->

<script>
// ── Chart defaults ──
Chart.defaults.color = '#6b6b85';
Chart.defaults.borderColor = '#2a2a3d';
Chart.defaults.font.family = "'DM Mono', monospace";
Chart.defaults.font.size = 11;

// ── Monthly Trend ──
const trendData = <?= json_encode($monthlyTrend) ?>;
new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: trendData.map(r => r.month),
        datasets: [
            {
                label: 'Total',
                data: trendData.map(r => r.total),
                borderColor: '#6c63ff',
                backgroundColor: 'rgba(108,99,255,0.08)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                pointBackgroundColor: '#6c63ff',
            },
            {
                label: 'Active',
                data: trendData.map(r => r.active_count),
                borderColor: '#43e97b',
                backgroundColor: 'rgba(67,233,123,0.05)',
                borderWidth: 1.5,
                fill: true,
                tension: 0.4,
                pointRadius: 2,
                pointBackgroundColor: '#43e97b',
                borderDash: [4, 3],
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: true, position: 'top' } },
        scales: {
            x: { grid: { color: '#2a2a3d' } },
            y: { grid: { color: '#2a2a3d' }, beginAtZero: true }
        }
    }
});

// ── Status Donut ──
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Active', 'Inactive'],
        datasets: [{
            data: [<?= (int)$activeCount ?>, <?= (int)$inactiveCount ?>],
            backgroundColor: ['rgba(67,233,123,0.8)', 'rgba(255,101,132,0.8)'],
            borderColor: ['#43e97b', '#ff6584'],
            borderWidth: 1,
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '72%',
        plugins: { legend: { display: false } }
    }
});

// ── Entry Type Donut ──
const entryData = <?= json_encode($byEntryType) ?>;
const entryColors = ['#6c63ff','#ff6584','#43e97b','#f7971e','#38bdf8','#a78bfa'];
new Chart(document.getElementById('entryChart'), {
    type: 'doughnut',
    data: {
        labels: entryData.map(r => r.entry_type || 'Unknown'),
        datasets: [{
            data: entryData.map(r => r.total),
            backgroundColor: entryColors.map(c => c + 'cc'),
            borderColor: entryColors,
            borderWidth: 1,
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: { legend: { display: false } }
    }
});
</script>
</body>
</html>







