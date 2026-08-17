<?php

$industry1 = "Leisure & Tour Operators";
$industry2 = "Hoteleliers";
$industry3 = "MICE & Wedding Planners";
$industry4 = "Event Management & Corporate";

$industry1Percent = 71.8;
$industry2Percent = 10.2;
$industry3Percent = 12;
$industry4Percent = 6;

$industry1Color = "#0f766e";
$industry2Color = "#0284c7";
$industry3Color = "#f59e0b";
$industry4Color = "#6366f1";

$topSegment = max(
    $industry1Percent,
    $industry2Percent,
    $industry3Percent,
    $industry4Percent
);

$gradient = "
    {$industry1Color} 0% {$industry1Percent}%,
    {$industry2Color} {$industry1Percent}% " . ($industry1Percent + $industry2Percent) . "%,
    {$industry3Color} " . ($industry1Percent + $industry2Percent) . "% " . ($industry1Percent + $industry2Percent + $industry3Percent) . "%,
    {$industry4Color} " . ($industry1Percent + $industry2Percent + $industry3Percent) . "% 100%
";

$industries = [
    [
        'name' => $industry1,
        'percent' => $industry1Percent,
        'color' => $industry1Color
    ],
    [
        'name' => $industry2,
        'percent' => $industry2Percent,
        'color' => $industry2Color
    ],
    [
        'name' => $industry3,
        'percent' => $industry3Percent,
        'color' => $industry3Color
    ],
    [
        'name' => $industry4,
        'percent' => $industry4Percent,
        'color' => $industry4Color
    ]
];

?>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px;">

    <div
        style="background: #ffffff; border: 2px solid #cbd5e1; border-radius: 12px; padding: 20px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.03), 0 4px 6px rgba(0,0,0,0.05); display: flex; flex-direction: column; align-items: center;">

        <h3
            style="color: #0f766e; font-size: 16px; margin-bottom: 15px; text-align: center; border-bottom: 2px solid #99f6e4; padding-bottom: 6px; width: 100%;">
            📊 Visitor Industry Distribution
        </h3>

        <div style="display: flex; flex-direction: column; align-items: center; gap: 15px; width: 100%;">

            <div style="
                width:170px;
                height:170px;
                border-radius:50%;
                position:relative;
                background:conic-gradient(<?= $gradient; ?>);
                border:4px solid #ffffff;
                box-shadow:
                    0 0 0 2px #cbd5e1,
                    inset 0 0 18px rgba(0,0,0,0.25),
                    0 8px 18px rgba(0,0,0,0.18);
                overflow:hidden;">

                <div style="
                    position:absolute;
                    inset:0;
                    border-radius:50%;
                    background:radial-gradient(circle at 35% 30%, rgba(255,255,255,0.45), transparent 45%);
                "></div>

                <div style="
                    position:absolute;
                    width:75px;
                    height:75px;
                    background:#ffffff;
                    border-radius:50%;
                    top:50%;
                    left:50%;
                    transform:translate(-50%,-50%);
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    flex-direction:column;
                    box-shadow:
                        inset 0 2px 8px rgba(0,0,0,0.12),
                        0 2px 8px rgba(0,0,0,0.15);">

                    <span style="font-size:18px;font-weight:800;color:#0f766e;">
                        <?= $topSegment; ?>%
                    </span>

                    <span style="font-size:10px;color:#64748b;">
                        Top Segment
                    </span>

                </div>

            </div>

            <div style="width:100%; display:flex; flex-direction:column; gap:6px; font-size:12px;">

                <?php foreach ($industries as $industry) { ?>

                    <div
                        style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px dotted #e2e8f0; padding-bottom:4px;">

                        <span style="display:flex; align-items:center; gap:8px; font-weight:bold; color:#334155;">

                            <span
                                style="width:12px; height:12px; border-radius:50%; border:1px solid rgba(0,0,0,0.15); display:inline-block; background:<?= $industry['color']; ?>;"></span>

                            <?= $industry['name']; ?>

                        </span>

                        <span style="font-weight:700; color:#0f766e;">
                            <?= $industry['percent']; ?>%
                        </span>

                    </div>

                <?php } ?>

            </div>

        </div>

    </div>

    <?php include("bydesignation.php"); ?>

</div>