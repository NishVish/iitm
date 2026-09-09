@php
    $booking = $final_bookingdetails->booking;
    $company = $final_bookingdetails->company;
    $stalls = $final_bookingdetails->stalls;
    $billing = $final_bookingdetails->billingcontact;

    /*
    |--------------------------------------------------------------------------
    | PAYMENT SUMMARY
    |--------------------------------------------------------------------------
    */

    $paymentSummary = $payment['summary'] ?? [];

    $eventsBooked = (int) ($paymentSummary['total_stalls'] ?? $stalls->count());

    $totalOriginalPrice = (float) ($paymentSummary['total_original_price'] ?? 0);

    $totalDiscountAmount = (float) ($paymentSummary['total_discount_amount'] ?? 0);

    $totalFinalPrice = (float) ($paymentSummary['total_final_price'] ?? 0);

    $gstRate = (float) ($paymentSummary['gst_rate'] ?? 18);

    $totalGstAmount = (float) ($paymentSummary['total_gst_amount'] ?? 0);

    $totalConclusivePrice = (float) ($paymentSummary['total_conclusive_price'] ?? 0);

    $paidAmount = (float) ($paymentSummary['total_paid_amount'] ?? 0);

    $totalDue = (float) ($paymentSummary['total_remaining_amount'] ?? 0);

    $paymentStatus = $paymentSummary['payment_status'] ?? 'pending';

    /*
    |--------------------------------------------------------------------------
    | PAYMENT RECORDS
    |--------------------------------------------------------------------------
    */

    $payments = $final_bookingdetails->payment ?? collect();

    $pendingAmount = $payments
        ->where('status', 'pending')
        ->sum(function ($payment) {
            return (float) ($payment->amount ?? 0);
        });

    /*
    |--------------------------------------------------------------------------
    | MONEY FORMAT
    |--------------------------------------------------------------------------
    */

    $money = fn($n) => '₹' . number_format((float) $n, 0);

    /*
    |--------------------------------------------------------------------------
    | DATE FORMAT
    |--------------------------------------------------------------------------
    */

    $formatDate = function ($date) {
        if (!$date) {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($date)->format('d M');
        } catch (\Throwable $e) {
            return null;
        }
    };

    $formatDateYear = function ($date) {
        if (!$date) {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($date)->format('d M Y');
        } catch (\Throwable $e) {
            return null;
        }
    };

    /*
    |--------------------------------------------------------------------------
    | UPDATED DATE
    |--------------------------------------------------------------------------
    */

    $updatedAt = null;

    if (!empty($booking->updated_at)) {
        try {
            $updatedAt = \Carbon\Carbon::parse($booking->updated_at)
                ->format('d M Y');
        } catch (\Throwable $e) {
            $updatedAt = null;
        }
    }
@endphp

@include('exhibitor.dashboard.header')

<section class="summary-grid">
    <style>
        /* ==========================================================================
   Shared tokens — keep these identical to the stall-page tokens so the
   dashboard and the stall-detail view feel like one product.
   ========================================================================== */
        :root {
            --ink: #1c1b1a;
            --muted: #6b6560;
            --border: #e5e2dd;
            --bg: #fafaf9;
            --accent: #2d5f5d;
            --ok: #2f6f4e;
            --warn: #9a6b12;
            --bad: #b23a34;
        }

        body {
            color: var(--ink);
            font: 15px/1.5 -apple-system, "Segoe UI", Roboto, sans-serif;
            background: var(--bg);
        }

        /* ==========================================================================
   Summary grid — Company / Billing contact / Overview panels
   ========================================================================== */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin: 1.5rem 0 2rem;
        }

        .panel {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1.1rem 1.25rem 1.3rem;
            background: #fff;
        }

        .panel-label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: .9rem;
            padding-bottom: .6rem;
            border-bottom: 1px solid var(--border);
        }

        /* key/value list — Company + Billing contact panels */
        .kv {
            display: flex;
            flex-direction: column;
            gap: .15rem;
        }

        .kv+.kv {
            margin-top: .8rem;
        }

        .kv dt {
            font-size: .78rem;
            color: var(--muted);
            margin: 0;
        }

        .kv dd {
            margin: 0;
            font-weight: 500;
            font-size: .92rem;
            word-break: break-word;
        }

        .muted-val {
            color: var(--muted);
            font-style: italic;
            font-weight: 400 !important;
        }

        /* stat rows — Overview panel */
        .stat-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: .55rem 0;
            border-bottom: 1px solid var(--border);
            font-size: .9rem;
        }

        .stat-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .stat-label {
            color: var(--muted);
        }

        .stat-value {
            font-weight: 600;
            text-align: right;
        }

        .stat-value.ok {
            color: var(--ok);
        }

        .stat-value.due {
            color: var(--bad);
        }

        .text-success {
            color: var(--ok);
        }

        .text-warning {
            color: var(--warn);
        }

        .text-danger {
            color: var(--bad);
        }

        /* ==========================================================================
   Stalls section header
   ========================================================================== */
        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .section-head .count {
            font-size: .8rem;
            font-weight: 600;
            color: var(--muted);
            background: #f0eeeb;
            border-radius: 100px;
            padding: .3rem .8rem;
        }

        /* ==========================================================================
   Footer note
   ========================================================================== */
        .footer-note {
            margin-top: 2.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: .82rem;
            display: flex;
            flex-wrap: wrap;
            gap: .4rem 1rem;
        }

        /* ==========================================================================
   Responsive
   ========================================================================== */
        @media (max-width: 900px) {
            .summary-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    {{-- COMPANY --}}
    <div class="panel">
        <span class="panel-label">Company</span>

        <dl>
            <div class="kv">
                <dt>Company ID</dt>
                <dd>{{ $company->company_id }}</dd>
            </div>

            <div class="kv">
                <dt>Address</dt>

                @php
                    $addressParts = array_filter([
                        $company->address,
                        $company->city,
                        $company->state
                    ]);
                @endphp

                @if(count($addressParts))
                    <dd>{{ implode(', ', $addressParts) }}</dd>
                @else
                    <dd class="muted-val">Not provided</dd>
                @endif
            </div>

            <div class="kv">
                <dt>GST number</dt>

                <dd @class(['muted-val' => !$company->gst_number])>
                    {{ $company->gst_number ?: 'Not provided' }}
                </dd>
            </div>

            <div class="kv">
                <dt>Website</dt>

                <dd @class(['muted-val' => !$company->website])>
                    {{ $company->website ?: 'Not provided' }}
                </dd>
            </div>

            <div class="kv">
                <dt>Phone</dt>

                <dd @class(['muted-val' => !$company->phone])>
                    {{ $company->phone ?: 'Not provided' }}
                </dd>
            </div>
        </dl>
    </div>


    {{-- BILLING CONTACT --}}
    <div class="panel">
        <span class="panel-label">Billing contact</span>

        @if($billing)

            <dl>

                <div class="kv">
                    <dt>Name</dt>
                    <dd>{{ $billing->name }}</dd>
                </div>

                <div class="kv">
                    <dt>Designation</dt>

                    <dd @class(['muted-val' => !$billing->designation])>
                        {{ $billing->designation ?: 'Not provided' }}
                    </dd>
                </div>

                <div class="kv">
                    <dt>Email</dt>
                    <dd>{{ $billing->email }}</dd>
                </div>

                <div class="kv">
                    <dt>Mobile</dt>
                    <dd>{{ $billing->mobile }}</dd>
                </div>

            </dl>

        @else

            <p class="muted-val" style="font-size:13.5px;">
                No billing contact on file yet.
            </p>

        @endif
    </div>


    {{-- OVERVIEW --}}
    <div class="panel">

        <span class="panel-label">Overview</span>

        <div class="stat-row">
            <span class="stat-label">
                Stalls booked
            </span>

            <span class="stat-value">
                {{ $eventsBooked }}
            </span>
        </div>


        <div class="stat-row">
            <span class="stat-label">
                Stall value
            </span>

            <span class="stat-value">
                {{ $money($totalFinalPrice) }}
            </span>
        </div>


        @if($totalDiscountAmount > 0)

            <div class="stat-row">
                <span class="stat-label">
                    Discount
                </span>

                <span class="stat-value">
                    -{{ $money($totalDiscountAmount) }}
                </span>
            </div>

        @endif


        <div class="stat-row">
            <span class="stat-label">
                GST ({{ rtrim(rtrim(number_format($gstRate, 2), '0'), '.') }}%)
            </span>

            <span class="stat-value">
                {{ $money($totalGstAmount) }}
            </span>
        </div>


        <div class="stat-row">
            <span class="stat-label">
                Total payable
            </span>

            <span class="stat-value">
                {{ $money($totalConclusivePrice) }}
            </span>
        </div>


        {{-- PAID --}}
        <div class="stat-row">
            <span class="stat-label">
                Total paid
            </span>

            <span class="stat-value ok">
                {{ $money($paidAmount) }}
            </span>
        </div>


        {{-- PENDING APPROVAL --}}
        @if($pendingAmount > 0)

            <div class="stat-row">
                <span class="stat-label">
                    Pending approval
                </span>

                <span class="stat-value">
                    {{ $money($pendingAmount) }}
                </span>
            </div>

        @endif


        {{-- BALANCE --}}
        <div class="stat-row">

            <span class="stat-label">
                Balance due
            </span>

            <span class="stat-value {{ $totalDue > 0 ? 'due' : 'ok' }}">

                {{ $money($totalDue) }}

                @if($totalDue <= 0)
                    · Settled
                @endif

            </span>

        </div>


        {{-- PAYMENT STATUS --}}
        <div class="stat-row">

            <span class="stat-label">
                Payment status
            </span>

            <span class="stat-value">

                @if($paymentStatus === 'paid')
                    <span class="text-success">
                        Paid
                    </span>

                @elseif($paymentStatus === 'partial')
                    <span class="text-warning">
                        Partially Paid
                    </span>

                @else
                    <span class="text-danger">
                        Pending
                    </span>
                @endif

            </span>

        </div>

    </div>

</section>

{{-- STALLS --}}
<section>

    <div class="section-head">


        <span class="count">
            {{ $eventsBooked }} booked
        </span>

    </div>

    @include('exhibitor.dashboard.layout2.stalldetails')

</section>



{{-- FOOTER --}}
<p class="footer-note">

    @if(!$booking->allow_edit)

        <span>
            Contact your event coordinator to make changes to this booking.
        </span>

    @else

        <span>
            You can edit this booking. Contact your coordinator with any questions.
        </span>

    @endif


    @if($booking->sales_id)

        <span>
            Booking handled by sales rep #{{ $booking->sales_id }}
        </span>

    @endif

</p>

</div>

</body>

</html>