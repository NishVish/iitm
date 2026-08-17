<?php


include('header.php');


?>

<div class="container">

    <div class="header">
        <h1>Trade Visitor Analytics</h1>
        <p>Year-over-Year (YoY) Growth of Trade Visitors & Exhibitors</p>
    </div>

    <div class="card">

        <div class="chart">

            <!-- 2024 -->
            <div class="year">
                <div class="bars">

                    <style>
                        .bar.area {

                            background-color: #ffda75ff !important;
                        }
                    </style>

                    <div class="bar-box">
                        <div class="bar area" style="height:120px;">
                            <div class="bar-header">
                                <div class="value">27569 <br>
                                    Sq ft.</div>
                            </div>
                        </div>
                        <div class="label">Area</div>
                    </div>



                    <div class="bar-box">
                        <div class="bar trade" style="height:96px;">
                            <div class="bar-header">
                                <div class="value">2,200</div>
                            </div>
                        </div>
                        <div class="label">Visitors</div>
                    </div>
                    <div class="bar-box">
                        <div class="bar exhibitor" style="height:35px;">
                            <div class="bar-header">
                                <div class="value">250</div>
                            </div>
                        </div>
                        <div class="label">Exhibitors</div>
                    </div>
                </div>
                <div class="year-name">2024 - 2025</div>
            </div>

            <!-- 2025 -->
            <div class="year">
                <div class="bars">

                    <div class="bar-box">
                        <div class="bar area" style="height:149px;">
                            <div class="bar-header">
                                <div class="value">30483 <br>

                                    Sq ft.</div>
                            </div>
                        </div>
                        <div class="label">Area</div>
                    </div>
                    <div class="bar-box">


                        <div class="bar trade" style="height:186px;">
                            <div class="bar-header">
                                <span class="yoy-badge">+93.2% YoY</span>
                                <div class="value">4,250</div>
                            </div>
                        </div>
                        <div class="label">Visitors</div>
                    </div>
                    <div class="bar-box">
                        <div class="bar exhibitor" style="height:37px;">
                            <div class="bar-header">
                                <span class="yoy-badge">+4.8% YoY</span>
                                <div class="value">262</div>
                            </div>
                        </div>
                        <div class="label">Exhibitors</div>
                    </div>
                </div>
                <div class="year-name">2025 - 2026</div>
            </div>

            <!-- 2026 -->
            <div class="year">
                <div class="bars">
                    <div class="bar-box">
                        <div class="bar area" style="height:167px;">
                            <div class="bar-header">
                                <div class="value">34576<br>

                                    Sq ft.</div>
                            </div>
                        </div>
                        <div class="label">Area</div>
                    </div>
                    <div class="bar-box">
                        <div class="bar trade" style="height:200px;">
                            <div class="bar-header">
                                <span class="yoy-badge">+7.3% YoY</span>
                                <div class="value">4,560</div>
                            </div>
                        </div>
                        <div class="label">Visitors</div>
                    </div>
                    <div class="bar-box">
                        <div class="bar exhibitor" style="height:39px;">
                            <div class="bar-header">
                                <span class="yoy-badge">+5.3% YoY</span>
                                <div class="value">276</div>
                            </div>
                        </div>
                        <div class="label">Exhibitors</div>
                    </div>
                </div>
                <div class="year-name">2026 - 2027</div>
            </div>

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
                    <span class="growth">▲ +93.2% YoY</span>
                </div>
                <div class="row">
                    <span>2026 vs 2025</span>
                    <span class="growth">▲ +7.3% YoY</span>
                </div>
            </div>

            <div class="stat-card">
                <h3>🏢 Exhibitor YoY Growth</h3>
                <div class="row">
                    <span>2025 vs 2024</span>
                    <span class="growth">▲ +4.8% YoY</span>
                </div>
                <div class="row">
                    <span>2026 vs 2025</span>
                    <span class="growth">▲ +5.3% YoY</span>
                </div>
            </div>
        </div>