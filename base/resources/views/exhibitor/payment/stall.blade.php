@php
    $booking = $payment['booking'] ?? [];
    $summary = $payment['summary'] ?? [];
    $stalls = $payment['stalls'] ?? [];

    $segments = request()->segments();
    $lastSegment = $segments[count($segments) - 1] ?? null;
    $secondLastSegment = $segments[count($segments) - 2] ?? null;

    $money = function ($value) {
        return '₹' . number_format((float) $value, 2);
    };

    $paymentStatus = strtolower($summary['payment_status'] ?? 'pending');

    $statusClass = match ($paymentStatus) {
        'paid', 'completed', 'success' => 'success',
        'partial', 'partially_paid' => 'warning',
        'failed', 'cancelled' => 'danger',
        default => 'secondary',
    };
@endphp


<style>
    .payment-page {
        padding: 5px;
    }

    .page-title {
        font-size: 22px;
        font-weight: 700;
        color: #212529;
        margin-bottom: 20px;
    }

    /* =====================================================
       CARDS
    ====================================================== */

    .payment-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .payment-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 18px;
        background: #f8f9fa;
        border-bottom: 1px solid #e5e7eb;
    }

    .payment-card-header h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #212529;
    }

    .payment-card-body {
        padding: 18px;
    }

    /* =====================================================
       BOOKING DETAILS
    ====================================================== */

    .booking-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px 25px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .detail-label {
        font-size: 12px;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .detail-value {
        font-size: 14px;
        font-weight: 600;
        color: #212529;
    }

    /* =====================================================
       SUMMARY
    ====================================================== */

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .summary-item {
        padding: 14px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
    }

    .summary-item.highlight {
        background: #eef6ff;
        border-color: #cfe2ff;
    }

    .summary-item.remaining {
        background: #fff8e6;
        border-color: #ffe69c;
    }

    .summary-label {
        display: block;
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .summary-value {
        display: block;
        font-size: 17px;
        font-weight: 700;
        color: #212529;
    }

    /* =====================================================
       STATUS
    ====================================================== */

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-success {
        background: #d1e7dd;
        color: #0f5132;
    }

    .status-warning {
        background: #fff3cd;
        color: #664d03;
    }

    .status-danger {
        background: #f8d7da;
        color: #842029;
    }

    .status-secondary {
        background: #e9ecef;
        color: #495057;
    }

    /* =====================================================
       STALL TABLE
    ====================================================== */

    .stall-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .stall-table {
        width: 100%;
        min-width: 1200px;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .stall-table th {
        background: #f8f9fa;
        color: #495057;
        font-size: 12px;
        font-weight: 700;
        padding: 12px 10px;
        border-bottom: 1px solid #dee2e6;
        white-space: nowrap;
    }

    .stall-table td {
        padding: 12px 10px;
        font-size: 13px;
        color: #343a40;
        border-bottom: 1px solid #edf0f2;
        vertical-align: middle;
        white-space: nowrap;
    }

    .stall-table tbody tr:hover {
        background: #f8fbff;
    }

    .stall-number {
        width: 45px;
        text-align: center;
        color: #6c757d !important;
        font-weight: 600;
    }

    .stall-link {
        color: #0d6efd;
        font-weight: 600;
        text-decoration: none;
    }

    .stall-link:hover {
        text-decoration: underline;
    }

    .price-main {
        font-weight: 700;
        color: #212529;
    }

    .price-muted {
        color: #6c757d;
    }

    .gst-rate {
        font-size: 11px;
        color: #6c757d;
    }

    .empty-state {
        padding: 40px !important;
        text-align: center;
        color: #6c757d !important;
    }

    /* =====================================================
       RESPONSIVE
    ====================================================== */

    @media (max-width: 992px) {

        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }

    }

    @media (max-width: 768px) {

        .payment-page {
            padding: 12px;
        }

        .booking-details {
            grid-template-columns: 1fr;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .payment-card-header {
            padding: 13px 14px;
        }

        .payment-card-body {
            padding: 14px;
        }

    }
</style>


<div class="payment-page">


    {{-- =====================================================
    PAYMENT DETAILS
    ====================================================== --}}

    @if($secondLastSegment === 'payment')


        {{-- =================================================
        BOOKING INFORMATION
        ================================================== --}}

        <div class="payment-card">

            <div class="payment-card-header">

                <h5>
                    Booking Information
                </h5>

                @if(!empty($booking['booking_id']))

                    <span class="status-badge status-secondary">
                        {{ $booking['booking_id'] }}
                    </span>

                @endif

            </div>


            <div class="payment-card-body">

                <div class="booking-details">

                    <div class="detail-item">

                        <span class="detail-label">
                            Booking ID
                        </span>

                        <span class="detail-value">
                            {{ $booking['booking_id'] ?? '-' }}
                        </span>

                    </div>


                    <div class="detail-item">

                        <span class="detail-label">
                            Company ID
                        </span>

                        <span class="detail-value">
                            {{ $booking['company_id'] ?? '-' }}
                        </span>

                    </div>


                    <div class="detail-item">

                        <span class="detail-label">
                            Billing Contact ID
                        </span>

                        <span class="detail-value">
                            {{ $booking['billing_contact_id'] ?? '-' }}
                        </span>

                    </div>


                    <div class="detail-item">

                        <span class="detail-label">
                            Sales ID
                        </span>

                        <span class="detail-value">
                            {{ $booking['sales_id'] ?? '-' }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
        PAYMENT SUMMARY
        ================================================== --}}

        <div class="payment-card">

            <div class="payment-card-header">

                <h5>
                    Payment Summary
                </h5>


                <span class="status-badge status-{{ $statusClass }}">

                    {{ ucfirst(str_replace('_', ' ', $paymentStatus)) }}

                </span>

            </div>


            <div class="payment-card-body">

                <div class="summary-grid">


                    {{-- Total Stalls --}}
                    <div class="summary-item">

                        <span class="summary-label">
                            Total Stalls
                        </span>

                        <span class="summary-value">
                            {{ $summary['total_stalls'] ?? 0 }}
                        </span>

                    </div>


                    {{-- Original Price --}}
                    <div class="summary-item">

                        <span class="summary-label">
                            Original Price
                        </span>

                        <span class="summary-value">
                            {{ $money($summary['total_original_price'] ?? 0) }}
                        </span>

                    </div>


                    {{-- Discount --}}
                    <div class="summary-item">

                        <span class="summary-label">
                            Discount
                        </span>

                        <span class="summary-value">
                            {{ $money($summary['total_discount_amount'] ?? 0) }}
                        </span>

                    </div>


                    {{-- Final Price --}}
                    <div class="summary-item">

                        <span class="summary-label">
                            Final Price
                        </span>

                        <span class="summary-value">
                            {{ $money($summary['total_final_price'] ?? 0) }}
                        </span>

                    </div>


                    {{-- GST --}}
                    <div class="summary-item">

                        <span class="summary-label">
                            GST ({{ $summary['gst_rate'] ?? 18 }}%)
                        </span>

                        <span class="summary-value">
                            {{ $money($summary['total_gst_amount'] ?? 0) }}
                        </span>

                    </div>


                    {{-- Conclusive --}}
                    <div class="summary-item highlight">

                        <span class="summary-label">
                            Conclusive Price
                        </span>

                        <span class="summary-value">
                            {{ $money($summary['total_conclusive_price'] ?? 0) }}
                        </span>

                    </div>


                    {{-- Paid --}}
                    <div class="summary-item">

                        <span class="summary-label">
                            Paid Amount
                        </span>

                        <span class="summary-value">
                            {{ $money($summary['total_paid_amount'] ?? 0) }}
                        </span>

                    </div>


                    {{-- Remaining --}}
                    <div class="summary-item remaining">

                        <span class="summary-label">
                            Remaining Amount
                        </span>

                        <span class="summary-value">
                            {{ $money($summary['total_remaining_amount'] ?? 0) }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- =====================================================
    STALL DETAILS
    ====================================================== --}}

    <div class="payment-card">

        <div class="payment-card-header">

            <h5>
                Stall Details
            </h5>

            <span class="status-badge status-secondary">

                {{ count($stalls) }}
                {{ count($stalls) === 1 ? 'Stall' : 'Stalls' }}

            </span>

        </div>


        <div class="stall-table-wrapper">

            <table class="stall-table">

                <thead>

                    <tr>

                        <th class="stall-number">
                            #
                        </th>

                        <th>
                            Stall ID
                        </th>

                        <th>
                            Event ID
                        </th>

                        <th>
                            Size
                        </th>

                        <th>
                            Original Price
                        </th>

                        <th>
                            Discount
                        </th>

                        <th>
                            Final Price
                        </th>

                        <th>
                            GST
                        </th>

                        <th>
                            Conclusive Price
                        </th>

                        <th>
                            Paid
                        </th>

                        <th>
                            Remaining
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($stalls as $index => $stall)

                        @php
                            $stallStatus = strtolower(
                                $stall['payment_status'] ?? 'pending'
                            );

                            $stallStatusClass = match ($stallStatus) {
                                'paid', 'completed', 'success' => 'success',
                                'partial', 'partially_paid' => 'warning',
                                'failed', 'cancelled' => 'danger',
                                default => 'secondary',
                            };
                        @endphp


                        <tr>


                            {{-- # --}}
                            <td class="stall-number">

                                {{ $index + 1 }}

                            </td>


                            {{-- STALL ID --}}
                            <td>

                                <a href="{{ url('exhibitor/stall/' . ($stall['stall_id'] ?? '')) }}" class="stall-link">
                                    {{ $stall['stall_id'] ?? '-' }}
                                </a>

                            </td>


                            {{-- EVENT --}}
                            <td>

                                {{ $stall['event_id'] ?? '-' }}

                            </td>


                            {{-- SIZE --}}
                            <td>

                                {{ $stall['stall_size'] ?? '-' }}

                            </td>


                            {{-- ORIGINAL PRICE --}}
                            <td>

                                <span class="price-main">
                                    {{ $money($stall['area_required_original_price'] ?? 0) }}
                                </span>

                            </td>


                            {{-- DISCOUNT --}}
                            <td>

                                <span class="price-muted">
                                    {{ $money($stall['discount_amount'] ?? 0) }}
                                </span>

                            </td>


                            {{-- FINAL PRICE --}}
                            <td>

                                <span class="price-main">
                                    {{ $money($stall['final_price'] ?? 0) }}
                                </span>

                            </td>


                            {{-- GST --}}
                            <td>

                                <span class="price-main">
                                    {{ $money($stall['gst_amount'] ?? 0) }}
                                </span>

                                <span class="gst-rate">
                                    ({{ $stall['gst_rate'] ?? 18 }}%)
                                </span>

                            </td>


                            {{-- CONCLUSIVE --}}
                            <td>

                                <span class="price-main">
                                    {{ $money($stall['conclusive_price'] ?? 0) }}
                                </span>

                            </td>


                            {{-- PAID --}}
                            <td>

                                {{ $money($stall['paid_amount'] ?? 0) }}

                            </td>


                            {{-- REMAINING --}}
                            <td>

                                <span class="price-main">
                                    {{ $money($stall['remaining_amount'] ?? 0) }}
                                </span>

                            </td>


                            {{-- STATUS --}}
                            <td>

                                <span class="status-badge status-{{ $stallStatusClass }}">

                                    {{ ucfirst(str_replace('_', ' ', $stallStatus)) }}

                                </span>

                            </td>

                        </tr>


                        {{-- =================================================
                        PAYMENT LOGS
                        ================================================== --}}

                        @if($secondLastSegment === 'payment')

                            @include(
                                'exhibitor.payment.logs',
                                ['stall' => $stall]
                            )

                        @endif


                    @empty

                        <tr>

                            <td colspan="12" class="empty-state">
                                No stall data found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>