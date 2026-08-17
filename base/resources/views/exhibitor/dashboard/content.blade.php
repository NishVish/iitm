@php
    $data = $booking[0] ?? null;

    // Define field presence rules for each step
    $steps = [
        'booking' => !empty($data->stall) && !empty($data->event_year),
        'payment' => !empty($data->amount) || (!empty($data->payment_status) && $data->payment_status === 'Paid'),
        'branding' => !empty($data->branding),
        'delegates' => !empty($data->delegate_details),
        'fascia' => !empty($data->fascia_name) || !empty($data->fascia),
        'certificate' => !empty($data->certificate_name) || !empty($data->certificate),
    ];

    // Calculate dynamic progress percentage
    $totalSteps = count($steps);
    $completedCount = count(array_filter($steps));
    $progressPercentage = $totalSteps > 0 ? round(($completedCount / $totalSteps) * 100) : 0;
@endphp

@if($data)
    <div class="dashboard-card">

        <div class="card-header">
            <h2>Exhibitor Booking Status</h2>
            <span class="progress-badge">{{ $progressPercentage }}% Completed</span>
        </div>

        <!-- Status Navigation Buttons -->
        <div class="status-buttons">

            <!-- Booking Step -->
            <button class="status-btn {{ $steps['booking'] ? 'completed' : '' }} active"
                onclick="openPanel('booking', this)">
                <span>{{ $steps['booking'] ? '✓' : '!' }}</span>
                Booking
                <small>{{ $steps['booking'] ? 'Completed' : 'Pending' }}</small>
            </button>

            <!-- Payment Step -->
            <button class="status-btn {{ $steps['payment'] ? 'completed' : '' }}" onclick="openPanel('payment', this)">
                <span>{{ $steps['payment'] ? '✓' : '!' }}</span>
                Payment
                <small>{{ $steps['payment'] ? 'Completed' : 'Pending' }}</small>
            </button>

            <!-- Branding Step -->
            <button class="status-btn {{ $steps['branding'] ? 'completed' : '' }}" onclick="openPanel('branding', this)">
                <span>{{ $steps['branding'] ? '✓' : '!' }}</span>
                Branding
                <small>{{ $steps['branding'] ? 'Completed' : 'Pending' }}</small>
            </button>

            <!-- Delegates Step -->
            <button class="status-btn {{ $steps['delegates'] ? 'completed' : '' }}" onclick="openPanel('delegates', this)">
                <span>{{ $steps['delegates'] ? '✓' : '!' }}</span>
                Delegates
                <small>{{ $steps['delegates'] ? 'Completed' : 'Pending' }}</small>
            </button>

            <!-- Fascia Step -->
            <button class="status-btn {{ $steps['fascia'] ? 'completed' : '' }}" onclick="openPanel('fascia', this)">
                <span>{{ $steps['fascia'] ? '✓' : '!' }}</span>
                Fascia
                <small>{{ $steps['fascia'] ? 'Completed' : 'Pending' }}</small>
            </button>

            <!-- Certificate Step -->
            <button class="status-btn {{ $steps['certificate'] ? 'completed' : '' }}"
                onclick="openPanel('certificate', this)">
                <span>{{ $steps['certificate'] ? '✓' : '!' }}</span>
                Certificate
                <small>{{ $steps['certificate'] ? 'Completed' : 'Pending' }}</small>
            </button>

        </div>

        <!-- Detail Panels -->
        <div id="booking" class="info-panel active">
            <h3>Booking Details</h3>
            <p><strong>Stall Number:</strong> {{ $data->stall ?? 'N/A' }}</p>
            <p><strong>Event Year:</strong> {{ $data->event_year ?? 'N/A' }}</p>
            <p><strong>Location:</strong> {{ $data->event_location ?? 'N/A' }}</p>
            <p><strong>Company:</strong> {{ $data->company_name ?? 'N/A' }}</p>
            <p><strong>Contact Person:</strong> {{ $data->contact_name ?? 'N/A' }} ({{ $data->mobile ?? 'N/A' }})</p>
            <p><strong>Email:</strong> {{ $data->email ?? 'N/A' }}</p>
        </div>

        <div id="payment" class="info-panel">
            <h3>Payment Details</h3>
            <p><strong>Status:</strong> {{ $data->payment_status ?? ($steps['payment'] ? 'Paid' : 'Pending') }}</p>
            <p><strong>Amount:</strong> {{ isset($data->amount) ? '₹' . number_format($data->amount) : 'Pending' }}</p>
            <p><strong>Transaction ID:</strong> {{ $data->transaction_id ?? 'N/A' }}</p>
        </div>

        <div id="branding" class="info-panel">
            <h3>Branding Details</h3>
            <p><strong>Branding Info:</strong> {{ $data->branding ?? 'Upload logo and branding requirements.' }}</p>
        </div>

        <div id="delegates" class="info-panel">
            <h3>Delegate Details</h3>
            <p>{{ $data->delegate_details ?? 'Add attendee name, designation, mobile and email.' }}</p>
        </div>

        <div id="fascia" class="info-panel">
            <h3>Fascia Details</h3>
            <p><strong>Fascia Name:</strong> {{ $data->fascia_name ?? $data->fascia ?? 'Not Provided' }}</p>
        </div>

        <div id="certificate" class="info-panel">
            <h3>Certificate Details</h3>
            <p><strong>Certificate Name:</strong>
                {{ $data->certificate_name ?? $data->certificate ?? 'Confirmation pending' }}
            </p>
        </div>

    </div>
@else
    <div class="dashboard-card">
        <p>No booking information available.</p>
    </div>
@endif

<style>
    .dashboard-card {
        width: 100%;
        max-width: 750px;
        background: #ffffff;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        font-family: Arial, sans-serif;
        box-sizing: border-box;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .card-header h2 {
        margin: 0;
        font-size: 1.4rem;
        color: #333;
    }

    .progress-badge {
        background: #e8f1ff;
        color: #0066cc;
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.85rem;
    }

    /* Status buttons */
    .status-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .status-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        border: 2px solid transparent;
        padding: 10px 16px;
        border-radius: 30px;
        background: #fff3cd;
        color: #856404;
        cursor: pointer;
        font-weight: bold;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .status-btn:hover {
        transform: translateY(-2px);
    }

    .status-btn.active {
        border-color: #0066cc;
    }

    .status-btn span {
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffc107;
        color: white;
        border-radius: 50%;
        font-size: 12px;
    }

    .status-btn.completed {
        background: #d4edda;
        color: #218838;
    }

    .status-btn.completed span {
        background: #28a745;
    }

    .status-btn small {
        font-size: 11px;
        opacity: 0.85;
    }

    /* Info Panel */
    .info-panel {
        display: none;
        margin-top: 25px;
        padding: 20px;
        background: #f8f9fa;
        border-left: 5px solid #0066cc;
        border-radius: 8px;
        animation: slide 0.3s ease forwards;
    }

    .info-panel.active {
        display: block;
    }

    .info-panel h3 {
        margin-top: 0;
        margin-bottom: 12px;
        color: #0066cc;
    }

    .info-panel p {
        margin: 6px 0;
        color: #444;
        line-height: 1.4;
    }

    @keyframes slide {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    function openPanel(id, btnElement) {
        document.querySelectorAll('.info-panel').forEach(panel => {
            panel.classList.remove('active');
        });

        document.querySelectorAll('.status-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        const targetPanel = document.getElementById(id);
        if (targetPanel) {
            targetPanel.classList.add('active');
        }

        if (btnElement) {
            btnElement.classList.add('active');
        }
    }
</script>