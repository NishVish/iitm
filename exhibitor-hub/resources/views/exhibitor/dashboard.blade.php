@php
    $data = $booking[0] ?? null;

    $steps = [
        [
            'key' => 'booking',
            'title' => 'Booking Details',
            'is_completed' => !empty($data->stall) && !empty($data->event_year),
            'content' => [
                'Stall Number' => $data->stall ?? 'N/A',
                'Event Year' => $data->event_year ?? 'N/A',
                'Location' => $data->event_location ?? 'N/A',
                'Company' => $data->company_name ?? 'N/A',
                'Contact Person' => ($data->contact_name ?? 'N/A') . ' (' . ($data->mobile ?? 'N/A') . ')',
                'Email' => $data->email ?? 'N/A',
            ]
        ],
        [
            'key' => 'payment',
            'title' => 'Payment Details',
            'is_completed' => !empty($data->amount) || (!empty($data->payment_status) && $data->payment_status === 'Paid'),
            'content' => [
                'Status' => $data->payment_status ?? (!empty($data->amount) ? 'Paid' : 'Pending'),
                'Amount' => isset($data->amount) ? '₹' . number_format($data->amount) : 'Pending',
                'Transaction ID' => $data->transaction_id ?? 'N/A',
            ]
        ],
        [
            'key' => 'branding',
            'title' => 'Branding Details',
            'is_completed' => !empty($data->branding),
            'raw_text' => $data->branding ?? 'Upload logo and branding requirements.'
        ],
        [
            'key' => 'delegates',
            'title' => 'Delegate Details',
            'is_completed' => !empty($data->delegate_details),
            'raw_text' => $data->delegate_details ?? 'Add attendee name, designation, mobile and email.'
        ],
        [
            'key' => 'fascia',
            'title' => 'Fascia Details',
            'is_completed' => !empty($data->fascia_name) || !empty($data->fascia),
            'content' => [
                'Fascia Name' => $data->fascia_name ?? $data->fascia ?? 'Not Provided'
            ]
        ],
        [
            'key' => 'certificate',
            'title' => 'Certificate Details',
            'is_completed' => !empty($data->certificate_name) || !empty($data->certificate),
            'content' => [
                'Certificate Name' => $data->certificate_name ?? $data->certificate ?? 'Confirmation pending'
            ]
        ],
    ];

    $totalSteps = count($steps);
    $completedCount = count(array_filter($steps, fn($s) => $s['is_completed']));
    $progressPercentage = $totalSteps > 0 ? round(($completedCount / $totalSteps) * 100) : 0;
@endphp

@if($data)
    <div class="exhibitor-dashboard">

        <!-- Modern Header -->
        <div class="dashboard-header">
            <div>
                <span class="header-subtitle">Exhibitor Portal</span>
                <h2 class="header-title">Booking Overview</h2>
            </div>
            
            <div class="progress-pill">
                <div class="progress-ring-text">
                    <span class="progress-val">{{ $progressPercentage }}%</span>
                    <span class="progress-lbl">Complete</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: {{ $progressPercentage }}%;"></div>
                </div>
            </div>
        </div>

        <!-- Connected Timeline Grid -->
        <div class="timeline-container">
            @foreach($steps as $step)
                <div class="timeline-row {{ $step['is_completed'] ? 'is-done' : 'is-pending' }}">
                    
                    <!-- Left Column: Status Node -->
                    <div class="timeline-node">
                        <div class="node-icon">
                            @if($step['is_completed'])
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            @else
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            @endif
                        </div>
                        <div class="node-meta">
                            <span class="node-title">{{ ucfirst($step['key']) }}</span>
                            <span class="node-badge">{{ $step['is_completed'] ? 'Completed' : 'Action Required' }}</span>
                        </div>
                    </div>

                    <!-- Right Column: Content Card -->
                    <div class="timeline-card">
                        <h3 class="card-heading">{{ $step['title'] }}</h3>
                        
                        @if(isset($step['content']))
                            <div class="data-grid">
                                @foreach($step['content'] as $label => $value)
                                    <div class="data-item">
                                        <span class="data-label">{{ $label }}</span>
                                        <span class="data-value">{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @elseif(isset($step['raw_text']))
                            <p class="card-text">{{ $step['raw_text'] }}</p>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

    </div>
@else
    <div class="exhibitor-dashboard empty-state">
        <p>No booking details available at this time.</p>
    </div>
@endif

<style>
    :root {
        --primary: #4f46e5;
        --primary-light: #eef2ff;
        --success: #10b981;
        --success-light: #ecfdf5;
        --warning: #f59e0b;
        --warning-light: #fffbeb;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --border-color: #f1f5f9;
        --card-bg: #ffffff;
        --bg-subtle: #f8fafc;
    }

    .exhibitor-dashboard {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        background: var(--card-bg);
        padding: 32px;
        border-radius: 20px;
        box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.05), 0 0 1px rgba(15, 23, 42, 0.1);
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        box-sizing: border-box;
    }

    /* Header Styling */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
    }

    .header-subtitle {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
        color: var(--primary);
    }

    .header-title {
        margin: 4px 0 0 0;
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-main);
        letter-spacing: -0.02em;
    }

    /* Progress Widget */
    .progress-pill {
        background: var(--bg-subtle);
        padding: 10px 16px;
        border-radius: 12px;
        min-width: 160px;
        border: 1px solid var(--border-color);
    }

    .progress-ring-text {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 6px;
    }

    .progress-val {
        font-weight: 800;
        font-size: 0.95rem;
        color: var(--text-main);
    }

    .progress-lbl {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .progress-bar-bg {
        height: 6px;
        width: 100%;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), #6366f1);
        border-radius: 10px;
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Timeline Section */
    .timeline-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
        position: relative;
    }

    .timeline-row {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 20px;
        align-items: stretch;
        position: relative;
    }

    /* Connector Line */
    .timeline-node {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 12px;
        position: relative;
        background: var(--bg-subtle);
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }

    .timeline-row.is-done .timeline-node {
        background: var(--success-light);
        border-color: #a7f3d0;
    }

    .timeline-row.is-pending .timeline-node {
        background: var(--warning-light);
        border-color: #fde68a;
    }

    .node-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .is-done .node-icon {
        background: var(--success);
        color: white;
    }

    .is-pending .node-icon {
        background: var(--warning);
        color: white;
    }

    .node-meta {
        display: flex;
        flex-direction: column;
    }

    .node-title {
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--text-main);
    }

    .node-badge {
        font-size: 0.72rem;
        font-weight: 500;
        opacity: 0.85;
    }

    .is-done .node-badge { color: #065f46; }
    .is-pending .node-badge { color: #92400e; }

    /* Right Card Styling */
    .timeline-card {
        background: var(--bg-subtle);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-heading {
        margin: 0 0 12px 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-main);
    }

    /* Key-Value Data Grid */
    .data-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 12px;
    }

    .data-item {
        display: flex;
        flex-direction: column;
    }

    .data-label {
        font-size: 0.72rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.03em;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .data-value {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-main);
        word-break: break-word;
    }

    .card-text {
        margin: 0;
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    .empty-state {
        text-align: center;
        color: var(--text-muted);
    }

    /* Mobile Responsive Layout */
    @media (max-width: 640px) {
        .exhibitor-dashboard {
            padding: 20px;
        }

        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .progress-pill {
            width: 100%;
            box-sizing: border-box;
        }

        .timeline-row {
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .data-grid {
            grid-template-columns: 1fr;
        }
    }
</style>