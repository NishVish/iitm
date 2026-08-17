<?php

$role1 = "Business Owners / Decision Makers";
$role2 = "Senior Management";
$role3 = "Sales & Business Development";
$role4 = "Operations / Executives";

$role1Percent = 75.5;
$role2Percent = 9.2;
$role3Percent = 10.4;
$role4Percent = 4.9;

$role1Color = "#0369a1";
$role2Color = "#14b8a6";
$role3Color = "#f59e0b";
$role4Color = "#ef4444";

$topRole = max(
    $role1Percent,
    $role2Percent,
    $role3Percent,
    $role4Percent
);

$topRoleLabel = $role1;

$roleGradient = "
    {$role1Color} 0% {$role1Percent}%,
    {$role2Color} {$role1Percent}% " . ($role1Percent + $role2Percent) . "%,
    {$role3Color} " . ($role1Percent + $role2Percent) . "% " . ($role1Percent + $role2Percent + $role3Percent) . "%,
    {$role4Color} " . ($role1Percent + $role2Percent + $role3Percent) . "% 100%
";

$roles = [
    [
        'name' => $role1,
        'percent' => $role1Percent,
        'color' => $role1Color
    ],
    [
        'name' => $role2,
        'percent' => $role2Percent,
        'color' => $role2Color
    ],
    [
        'name' => $role3,
        'percent' => $role3Percent,
        'color' => $role3Color
    ],
    [
        'name' => $role4,
        'percent' => $role4Percent,
        'color' => $role4Color
    ]
];

?>

<div
    style="background:#ffffff; border:2px solid #cbd5e1; border-radius:12px; padding:20px; box-shadow:inset 0 2px 4px rgba(0,0,0,0.03),0 4px 6px rgba(0,0,0,0.05); display:flex; flex-direction:column; align-items:center;">

    <h3
        style="color:#0f766e; font-size:16px; margin-bottom:15px; text-align:center; border-bottom:2px solid #99f6e4; padding-bottom:6px; width:100%;">
        👔 Visitor Professional Role Profile
    </h3>

    <div style="display:flex; flex-direction:column; align-items:center; gap:15px; width:100%;">

        <div style="
            width:170px;
            height:170px;
            border-radius:50%;
            position:relative;
            background:conic-gradient(<?= $roleGradient; ?>);
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
                pointer-events:none;
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

                <span style="font-size:18px; font-weight:800; color:#0f766e;">
                    <?= $topRole; ?>%
                </span>

                <span style="font-size:10px; color:#64748b; text-align:center;">
                    <?= $topRoleLabel; ?>
                </span>

            </div>

        </div>

        <div style="width:100%; display:flex; flex-direction:column; gap:8px; font-size:12px;">

            <?php foreach ($roles as $index => $role) { ?>

                <div
                    style="display:flex; justify-content:space-between; align-items:center; <?= $index < count($roles) - 1 ? 'border-bottom:1px dotted #e2e8f0; padding-bottom:4px;' : ''; ?>">

                    <span style="display:flex; align-items:center; gap:8px; font-weight:bold; color:#334155;">

                        <span style="width:12px; height:12px; border-radius:50%; background:<?= $role['color']; ?>;"></span>

                        <?= $role['name']; ?>

                    </span>

                    <span style="font-weight:700; color:#0f766e;">
                        <?= $role['percent']; ?>%
                    </span>

                </div>

            <?php } ?>

        </div>

    </div>

</div>