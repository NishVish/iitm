<?php

include('header.php');

$area1 = 63329;
$area2 = 65557;
$area3 = 76205;

$trade1 = 7900;
$trade2 = 8710;
$trade3 = 9160;

$exhibitor1 = 490;
$exhibitor2 = 570;
$exhibitor3 = 674;

$tradeYoy2 = (($trade2 - $trade1) / $trade1) * 100;
$tradeYoy3 = (($trade3 - $trade2) / $trade2) * 100;

$exhibitorYoy2 = (($exhibitor2 - $exhibitor1) / $exhibitor1) * 100;
$exhibitorYoy3 = (($exhibitor3 - $exhibitor2) / $exhibitor2) * 100;

$maxArea = max($area1, $area2, $area3);
$maxTrade = max($trade1, $trade2, $trade3);
$maxExhibitor = max($exhibitor1, $exhibitor2, $exhibitor3);

$years = [
    [
        'label' => '2024 - 2025',
        'area' => $area1,
        'areaHeight' => round(($area1 / $maxArea) * 200),
        'trade' => $trade1,
        'tradeHeight' => round(($trade1 / $maxTrade) * 200),
        'tradeYoY' => '',
        'exhibitor' => $exhibitor1,
        'exhibitorHeight' => round(($exhibitor1 / $maxExhibitor) * 60),
        'exhibitorYoY' => ''
    ],
    [
        'label' => '2025 - 2026',
        'area' => $area2,
        'areaHeight' => round(($area2 / $maxArea) * 200),
        'trade' => $trade2,
        'tradeHeight' => round(($trade2 / $maxTrade) * 200),
        'tradeYoY' => '+' . number_format($tradeYoy2, 1) . '% YoY',
        'exhibitor' => $exhibitor2,
        'exhibitorHeight' => round(($exhibitor2 / $maxExhibitor) * 60),
        'exhibitorYoY' => '+' . number_format($exhibitorYoy2, 1) . '% YoY'
    ],
    [
        'label' => '2026 - 2027',
        'area' => $area3,
        'areaHeight' => round(($area3 / $maxArea) * 200),
        'trade' => $trade3,
        'tradeHeight' => round(($trade3 / $maxTrade) * 200),
        'tradeYoY' => '+' . number_format($tradeYoy3, 1) . '% YoY',
        'exhibitor' => $exhibitor3,
        'exhibitorHeight' => round(($exhibitor3 / $maxExhibitor) * 60),
        'exhibitorYoY' => '+' . number_format($exhibitorYoy3, 1) . '% YoY'
    ]
];

?>

<div class="container">

    <div class="header">
        <h1>Trade Visitor Analytics</h1>
        <p>Year-over-Year (YoY) Growth of Trade Visitors & Exhibitors</p>
    </div>

    <div class="card">

        <div class="chart">

            <style>
                .bar.area {
                    background-color: #ffda75ff !important;
                }
            </style>

            <?php foreach ($years as $year) { ?>

                <div class="year">

                    <div class="bars">

                        <div class="bar-box">
                            <div class="bar area" style="height:<?= $year['areaHeight']; ?>px;">
                                <div class="bar-header">
                                    <div class="value">
                                        <?= number_format($year['area']); ?><br>
                                        Sq ft.
                                    </div>
                                </div>
                            </div>
                            <div class="label">Area</div>
                        </div>

                        <div class="bar-box">
                            <div class="bar trade" style="height:<?= $year['tradeHeight']; ?>px;">
                                <div class="bar-header">
                                    <?php if ($year['tradeYoY'] != '') { ?>
                                        <span class="yoy-badge"><?= $year['tradeYoY']; ?></span>
                                    <?php } ?>
                                    <div class="value"><?= number_format($year['trade']); ?></div>
                                </div>
                            </div>
                            <div class="label">Visitors</div>
                        </div>

                        <div class="bar-box">
                            <div class="bar exhibitor" style="height:<?= $year['exhibitorHeight']; ?>px;">
                                <div class="bar-header">
                                    <?php if ($year['exhibitorYoY'] != '') { ?>
                                        <span class="yoy-badge"><?= $year['exhibitorYoY']; ?></span>
                                    <?php } ?>
                                    <div class="value"><?= number_format($year['exhibitor']); ?></div>
                                </div>
                            </div>
                            <div class="label">Exhibitors</div>
                        </div>

                    </div>

                    <div class="year-name"><?= $year['label']; ?></div>

                </div>

            <?php } ?>

        </div>

        <div class="legend">
            <div><span class="dot trade-dot"></span> Trade Visitors</div>
            <div><span class="dot expo-dot"></span> Exhibitors</div>
        </div>

        <div class="stats">

            <div class="stat-card">
                <h3>📈 Trade Visitors YoY Growth</h3>

                <div class="row">
                    <span>2025 vs 2024</span>
                    <span class="growth">▲ <?= $years[1]['tradeYoY']; ?></span>
                </div>

                <div class="row">
                    <span>2026 vs 2025</span>
                    <span class="growth">▲ <?= $years[2]['tradeYoY']; ?></span>
                </div>

            </div>

            <div class="stat-card">
                <h3>🏢 Exhibitor YoY Growth</h3>

                <div class="row">
                    <span>2025 vs 2024</span>
                    <span class="growth">▲ <?= $years[1]['exhibitorYoY']; ?></span>
                </div>

                <div class="row">
                    <span>2026 vs 2025</span>
                    <span class="growth">▲ <?= $years[2]['exhibitorYoY']; ?></span>
                </div>

            </div>

        </div>

    </div>