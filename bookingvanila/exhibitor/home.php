<?php

$data = $booking[0] ?? null;

/*
|--------------------------------------------------------------------------
| Dummy fallback data
|--------------------------------------------------------------------------
| If $booking[0] is empty, the dashboard will use this data.
| Remove this fallback later when your database data is working.
|--------------------------------------------------------------------------
*/

if (!$data) {
    $data = (object) [
        'stall' => 'A-101',
        'event_year' => '2026',
        'event_location' => 'Bangalore International Exhibition Centre',
        'company_name' => 'TechNova Solutions Pvt Ltd',
        'contact_name' => 'Rahul Sharma',
        'mobile' => '9876543210',
        'email' => 'rahul@technova.com',

        'payment_status' => 'Partial',
        'amount' => 40000,
        'transaction_id' => 'TXN20260810001',

        'branding' => 'Logo uploaded and branding artwork submitted.',
        'delegate_details' => 'Rahul Sharma - Director, Priya Kumar - Marketing Manager',

        'fascia_name' => 'TECHNOVA SOLUTIONS',
        'certificate_name' => 'TechNova Solutions Pvt Ltd'
    ];
}


/*
|--------------------------------------------------------------------------
| Helper
|--------------------------------------------------------------------------
*/

function e($value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}


/*
|--------------------------------------------------------------------------
| Status helpers
|--------------------------------------------------------------------------
*/

$paymentStatus = strtolower(trim($data->payment_status ?? ''));

$paymentCompleted =
    $paymentStatus === 'paid' ||
    $paymentStatus === 'completed';

$brandingCompleted = !empty($data->branding);

$delegateCompleted = !empty($data->delegate_details);

$fasciaCompleted =
    !empty($data->fascia_name) ||
    !empty($data->fascia);

$certificateCompleted =
    !empty($data->certificate_name) ||
    !empty($data->certificate);


/*
|--------------------------------------------------------------------------
| Steps
|--------------------------------------------------------------------------
*/

$steps = [

    [
        'key' => 'booking',
        'title' => 'Booking Details',

        'is_completed' =>
            !empty($data->stall) &&
            !empty($data->event_year),

        'content' => [

            'Stall Number' =>
                $data->stall ?? 'N/A',

            'Event Year' =>
                $data->event_year ?? 'N/A',

            'Location' =>
                $data->event_location ?? 'N/A',

            'Company' =>
                $data->company_name ?? 'N/A',

            'Contact Person' =>
                ($data->contact_name ?? 'N/A') .
                ' (' .
                ($data->mobile ?? 'N/A') .
                ')',

            'Email' =>
                $data->email ?? 'N/A'
        ]
    ],


    [
        'key' => 'payment',
        'title' => 'Payment Details',

        'is_completed' =>
            $paymentCompleted,

        'content' => [

            'Status' =>
                $data->payment_status ?? 'Pending',

            'Amount' =>
                isset($data->amount)
                ? '₹' . number_format((float) $data->amount)
                : 'Pending',

            'Transaction ID' =>
                $data->transaction_id ?? 'N/A'
        ]
    ],


    [
        'key' => 'branding',
        'title' => 'Branding Details',

        'is_completed' =>
            $brandingCompleted,

        'content' => [

            'Status' =>
                $brandingCompleted
                ? 'Submitted'
                : 'Pending',

            'Branding Details' =>
                $data->branding ??
                'Upload logo and branding requirements.'
        ]
    ],


    [
        'key' => 'delegates',
        'title' => 'Delegate Details',

        'is_completed' =>
            $delegateCompleted,

        'content' => [

            'Status' =>
                $delegateCompleted
                ? 'Submitted'
                : 'Pending',

            'Delegates' =>
                $data->delegate_details ??
                'Add attendee name, designation, mobile and email.'
        ]
    ],


    [
        'key' => 'fascia',
        'title' => 'Fascia Details',

        'is_completed' =>
            $fasciaCompleted,

        'content' => [

            'Status' =>
                $fasciaCompleted
                ? 'Submitted'
                : 'Pending',

            'Fascia Name' =>
                $data->fascia_name ??
                $data->fascia ??
                'Not Provided'
        ]
    ],


    [
        'key' => 'certificate',
        'title' => 'Certificate Details',

        'is_completed' =>
            $certificateCompleted,

        'content' => [

            'Status' =>
                $certificateCompleted
                ? 'Submitted'
                : 'Pending',

            'Certificate Name' =>
                $data->certificate_name ??
                $data->certificate ??
                'Confirmation pending'
        ]
    ]

];


/*
|--------------------------------------------------------------------------
| Progress
|--------------------------------------------------------------------------
*/

$totalSteps = count($steps);

$completedCount = 0;

foreach ($steps as $step) {

    if ($step['is_completed']) {
        $completedCount++;
    }

}

$progressPercentage =
    $totalSteps > 0
    ? round(
        ($completedCount / $totalSteps) * 100
    )
    : 0;

?>

<div class="exhibitor-dashboard">

    <!-- HEADER -->

    <div class="dashboard-header">

        <div>

            <span class="header-subtitle">
                Exhibitor Portal
            </span>

            <h2 class="header-title">
                Booking Overview
            </h2>

        </div>


        <div class="progress-pill">

            <div class="progress-ring-text">

                <span class="progress-val">
                    <?php echo e($progressPercentage); ?>%
                </span>

                <span class="progress-lbl">
                    Complete
                </span>

            </div>


            <div class="progress-bar-bg">

                <div
                    class="progress-bar-fill"
                    style="width: <?php echo e($progressPercentage); ?>%;"
                ></div>

            </div>

        </div>

    </div>


    <!-- SUMMARY -->

    <div class="summary-grid">

        <div class="summary-card">

            <span class="summary-label">
                Company
            </span>

            <strong>
                <?php echo e($data->company_name ?? 'N/A'); ?>
            </strong>

        </div>


        <div class="summary-card">

            <span class="summary-label">
                Stall
            </span>

            <strong>
                <?php echo e($data->stall ?? 'N/A'); ?>
            </strong>

        </div>


        <div class="summary-card">

            <span class="summary-label">
                Event Year
            </span>

            <strong>
                <?php echo e($data->event_year ?? 'N/A'); ?>
            </strong>

        </div>


        <div class="summary-card">

            <span class="summary-label">
                Completion
            </span>

            <strong>
                <?php echo e($completedCount); ?>
                /
                <?php echo e($totalSteps); ?>
            </strong>

        </div>

    </div>


    <!-- TIMELINE -->

    <div class="timeline-container">

        <?php foreach ($steps as $step): ?>

                <div
                    class="timeline-row <?php echo $step['is_completed'] ? 'is-done' : 'is-pending'; ?>"
                >

                    <!-- STATUS -->

                    <div class="timeline-node">

                        <div class="node-icon">

                            <?php if ($step['is_completed']): ?>

                                    <svg
                                        width="14"
                                        height="14"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="3"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>

                            <?php else: ?>

                                    <svg
                                        width="14"
                                        height="14"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="3"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="10"
                                        ></circle>

                                        <line
                                            x1="12"
                                            y1="8"
                                            x2="12"
                                            y2="12"
                                        ></line>

                                        <line
                                            x1="12"
                                            y1="16"
                                            x2="12.01"
                                            y2="16"
                                        ></line>

                                    </svg>

                            <?php endif; ?>

                        </div>


                        <div class="node-meta">

                            <span class="node-title">

                                <?php
                                echo e(
                                    ucfirst($step['key'])
                                );
                                ?>

                            </span>


                            <span class="node-badge">

                                <?php
                                echo $step['is_completed']
                                    ? 'Completed'
                                    : 'Action Required';
                                ?>

                            </span>

                        </div>

                    </div>


                    <!-- CONTENT -->

                    <div class="timeline-card">

                        <div class="card-top">

                            <h3 class="card-heading">

                                <?php
                                echo e($step['title']);
                                ?>

                            </h3>


                            <span
                                class="status-badge <?php echo $step['is_completed'] ? 'status-completed' : 'status-pending'; ?>"
                            >

                                <?php
                                echo $step['is_completed']
                                    ? 'Completed'
                                    : 'Pending';
                                ?>

                            </span>

                        </div>


                        <?php if (isset($step['content'])): ?>

                                <div class="data-grid">

                                    <?php foreach ($step['content'] as $label => $value): ?>

                                            <div class="data-item">

                                                <span class="data-label">

                                                    <?php
                                                    echo e($label);
                                                    ?>

                                                </span>


                                                <span class="data-value">

                                                    <?php
                                                    echo e($value);
                                                    ?>

                                                </span>

                                            </div>

                                    <?php endforeach; ?>

                                </div>

                        <?php endif; ?>

                    </div>

                </div>

        <?php endforeach; ?>

    </div>

</div>


<style>

:root {
    --primary: #4f46e5;
    --primary-dark: #4338ca;

    --success: #10b981;
    --success-light: #ecfdf5;

    --warning: #f59e0b;
    --warning-light: #fffbeb;

    --text-main: #0f172a;
    --text-muted: #64748b;

    --border-color: #e5e7eb;

    --bg-subtle: #f8fafc;

    --white: #ffffff;
}


.exhibitor-dashboard {
    width: 100%;
    max-width: 1000px;

    margin: 0 auto;

    padding: 30px;

    background: var(--white);

    border-radius: 20px;

    box-shadow:
        0 10px 30px rgba(15, 23, 42, 0.06),
        0 1px 2px rgba(15, 23, 42, 0.05);

    font-family:
        system-ui,
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        Roboto,
        sans-serif;

    box-sizing: border-box;
}


/* HEADER */

.dashboard-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    margin-bottom: 24px;

    padding-bottom: 22px;

    border-bottom: 1px solid var(--border-color);

}


.header-subtitle {

    display: block;

    margin-bottom: 5px;

    color: var(--primary);

    font-size: 11px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: 0.1em;

}


.header-title {

    margin: 0;

    color: var(--text-main);

    font-size: 25px;

    font-weight: 800;

    letter-spacing: -0.03em;

}


/* PROGRESS */

.progress-pill {

    width: 180px;

    padding: 11px 14px;

    border: 1px solid var(--border-color);

    border-radius: 12px;

    background: var(--bg-subtle);

}


.progress-ring-text {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 7px;

}


.progress-val {

    color: var(--text-main);

    font-size: 15px;

    font-weight: 800;

}


.progress-lbl {

    color: var(--text-muted);

    font-size: 11px;

}


.progress-bar-bg {

    width: 100%;

    height: 6px;

    overflow: hidden;

    border-radius: 20px;

    background: #e2e8f0;

}


.progress-bar-fill {

    height: 100%;

    border-radius: 20px;

    background:
        linear-gradient(
            90deg,
            var(--primary),
            #6366f1
        );

}


/* SUMMARY */

.summary-grid {

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 12px;

    margin-bottom: 25px;

}


.summary-card {

    padding: 16px;

    border: 1px solid var(--border-color);

    border-radius: 12px;

    background: var(--bg-subtle);

}


.summary-label {

    display: block;

    margin-bottom: 6px;

    color: var(--text-muted);

    font-size: 10px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 0.05em;

}


.summary-card strong {

    display: block;

    color: var(--text-main);

    font-size: 14px;

    font-weight: 700;

    word-break: break-word;

}


/* TIMELINE */

.timeline-container {

    display: flex;

    flex-direction: column;

    gap: 14px;

}


.timeline-row {

    display: grid;

    grid-template-columns:
        190px 1fr;

    gap: 16px;

    align-items: stretch;

}


/* NODE */

.timeline-node {

    display: flex;

    align-items: center;

    gap: 10px;

    min-height: 75px;

    padding: 12px;

    border: 1px solid var(--border-color);

    border-radius: 12px;

    background: var(--bg-subtle);

}


.is-done .timeline-node {

    border-color: #a7f3d0;

    background: var(--success-light);

}


.is-pending .timeline-node {

    border-color: #fde68a;

    background: var(--warning-light);

}


.node-icon {

    width: 30px;

    height: 30px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 8px;

}


.is-done .node-icon {

    color: #ffffff;

    background: var(--success);

}


.is-pending .node-icon {

    color: #ffffff;

    background: var(--warning);

}


.node-meta {

    display: flex;

    flex-direction: column;

    gap: 2px;

}


.node-title {

    color: var(--text-main);

    font-size: 13px;

    font-weight: 750;

}


.node-badge {

    color: var(--text-muted);

    font-size: 10px;

}


/* CARD */

.timeline-card {

    min-width: 0;

    padding: 16px 18px;

    border: 1px solid var(--border-color);

    border-radius: 12px;

    background: var(--bg-subtle);

}


.card-top {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 12px;

    margin-bottom: 13px;

}


.card-heading {

    margin: 0;

    color: var(--text-main);

    font-size: 14px;

    font-weight: 750;

}


/* STATUS BADGE */

.status-badge {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    padding: 5px 9px;

    border-radius: 20px;

    font-size: 9px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: 0.03em;

}


.status-completed {

    color: #047857;

    background: #d1fae5;

}


.status-pending {

    color: #b45309;

    background: #fef3c7;

}


/* DATA */

.data-grid {

    display: grid;

    grid-template-columns:
        repeat(
            auto-fit,
            minmax(160px, 1fr)
        );

    gap: 12px;

}


.data-item {

    min-width: 0;

    display: flex;

    flex-direction: column;

    gap: 3px;

}


.data-label {

    color: var(--text-muted);

    font-size: 9px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 0.04em;

}


.data-value {

    color: var(--text-main);

    font-size: 12px;

    font-weight: 600;

    line-height: 1.45;

    word-break: break-word;

}


/* MOBILE */

@media (max-width: 700px) {

    .exhibitor-dashboard {

        padding: 20px;

        border-radius: 14px;

    }


    .dashboard-header {

        flex-direction: column;

        align-items: flex-start;

    }


    .progress-pill {

        width: 100%;

        box-sizing: border-box;

    }


    .summary-grid {

        grid-template-columns:
            repeat(2, 1fr);

    }


    .timeline-row {

        grid-template-columns: 1fr;

        gap: 8px;

    }


    .timeline-node {

        min-height: auto;

    }


    .data-grid {

        grid-template-columns: 1fr;

    }

}


@media (max-width: 450px) {

    .summary-grid {

        grid-template-columns: 1fr;

    }

}

</style>