<div class="stall-page">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="notice notice-ok">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="notice notice-bad">{{ session('error') }}</div>
    @endif

    @php
        $paidAmount = (float) ($stall->paid_amount ?? 0);
        $finalPrice = (float) ($stall->final_price ?? 0);
        $gstAmount = (float) ($stall->gst_amount ?? 0);
        $originalAmount = (float) ($stall->original_amount ?? 0);
        $discountAmount = (float) ($stall->discount_amount ?? 0);

        $totalPayable = $finalPrice + $gstAmount;
        $remainingAmount = max(0, $totalPayable - $paidAmount);

        // Small local helpers so the markup below doesn't repeat formatting/branching logic.
        $money = fn($v) => '₹' . number_format((float) $v, 2);

        $paymentState = $remainingAmount <= 0
            ? ['label' => 'Fully paid', 'class' => 'ok']
            : ($paidAmount > 0
                ? ['label' => 'Partially paid', 'class' => 'warn']
                : ['label' => 'Payment pending', 'class' => 'bad']);

        $statusMap = [
            'approved' => ['Success', 'ok'],
            'success' => ['Success', 'ok'],
            'pending' => ['Pending', 'warn'],
            'rejected' => ['Rejected', 'bad'],
        ];
    @endphp

    {{-- Header --}}
    <header class="stall-header">
        <div>
            <h1>{{ $stall->event_name ?? 'Stall details' }}</h1>
            <p class="meta">
                Stall <span class="mono">#{{ $stall->id }}</span>
                &nbsp;·&nbsp;
                Booking <span class="mono">{{ $stall->booking_id ?? '—' }}</span>
            </p>
        </div>
        <span class="tag tag-{{ $paymentState['class'] }}">{{ $paymentState['label'] }}</span>
    </header>

    {{-- Payment summary --}}
    <section class="figures">
        <div>
            <span class="label">Total payable</span>
            <strong>{{ $money($totalPayable) }}</strong>
        </div>
        <div>
            <span class="label">Paid</span>
            <strong class="ok">{{ $money($paidAmount) }}</strong>
        </div>
        <div>
            <span class="label">Remaining</span>
            <strong class="{{ $remainingAmount > 0 ? 'bad' : 'ok' }}">{{ $money($remainingAmount) }}</strong>
        </div>
        <div>
            <span class="label">Discount</span>
            <strong>{{ $money($discountAmount) }}</strong>
        </div>
    </section>

    {{-- Stall overview --}}
    <section class="block">
        <h2>Stall overview</h2>
        <dl class="grid">
            <div>
                <dt>Event ID</dt>
                <dd>{{ $stall->event_id ?? '—' }}</dd>
            </div>
            <div>
                <dt>Year</dt>
                <dd>{{ $stall->year ?? '—' }}</dd>
            </div>
            <div>
                <dt>Size</dt>
                <dd>{{ $stall->stall_size ?? '—' }}</dd>
            </div>
            <div>
                <dt>Type</dt>
                <dd>{{ $stall->stall_type ?? '—' }}</dd>
            </div>
            <div>
                <dt>Location</dt>
                <dd>{{ $stall->stall_location ?? '—' }}</dd>
            </div>
            <div>
                <dt>Branding</dt>
                <dd>{{ $stall->branding ? 'Yes' : 'No' }}</dd>
            </div>
            <div>
                <dt>Fascia name</dt>
                <dd>{{ $stall->fascia ?: 'Not provided' }}</dd>
            </div>
            <div>
                <dt>Certificate name</dt>
                <dd>{{ $stall->certificate ?: 'Not provided' }}</dd>
            </div>
        </dl>
    </section>

    {{-- Venue --}}
    <section class="block">
        <h2>Venue</h2>
        <dl class="grid grid-2">
            <div>
                <dt>Location</dt>
                <dd>{{ $stall->venue_details ?? '—' }}</dd>
            </div>
            <div>
                <dt>Booking notes</dt>
                <dd>{{ $stall->venue_booking_details ?: 'No additional details.' }}</dd>
            </div>
        </dl>
    </section>

    {{-- Payment breakdown --}}
    <section class="block">
        <h2>Payment breakdown</h2>
        <table class="data">
            <thead>
                <tr>
                    <th>Original</th>
                    <th>Discount</th>
                    <th>Final price</th>
                    <th>GST</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Remaining</th>
                </tr>
            </thead>
            <tbody>
                <tr class="mono">
                    <td>{{ $money($originalAmount) }}</td>
                    <td class="bad">−{{ $money($discountAmount) }}</td>
                    <td>{{ $money($finalPrice) }}</td>
                    <td>+{{ $money($gstAmount) }}</td>
                    <td><strong>{{ $money($totalPayable) }}</strong></td>
                    <td class="ok">{{ $money($paidAmount) }}</td>
                    <td class="{{ $remainingAmount > 0 ? 'bad' : 'ok' }}">
                        <strong>{{ $money($remainingAmount) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </section>

    {{-- Delegates --}}
    <section class="block">
        <h2>Stall delegates</h2>
        @if($stall->contacts && $stall->contacts->count())
            <table class="data">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Email</th>
                        <th>Mobile</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stall->contacts as $contact)
                        <tr>
                            <td>{{ $contact->name ?? '—' }}</td>
                            <td>{{ $contact->designation ?? '—' }}</td>
                            <td>{{ $contact->contact_email ?? $contact->email ?? '—' }}</td>
                            <td class="mono">{{ $contact->contact_mobile ?? $contact->mobile ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">No delegates assigned to this stall.</p>
        @endif
    </section>

    {{-- Payment history --}}
    <section class="block">
        <h2>Payment history</h2>
        @if($payment && $payment->count())
            <table class="data">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>For</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Reference</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payment as $item)
                        @php [$statusLabel, $statusClass] = $statusMap[$item->status] ?? [ucfirst($item->status ?? '—'), 'muted']; @endphp
                        <tr>
                            <td class="mono">{{ $item->id }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $item->payment_for ?? '—')) }}</td>
                            <td class="mono"><strong>{{ $money($item->amount ?? 0) }}</strong></td>
                            <td>{{ strtoupper($item->payment_method ?? '—') }}</td>
                            <td class="mono">{{ $item->utr_id ?? $item->transaction_id ?? '—' }}</td>
                            <td><span class="tag tag-{{ $statusClass }}">{{ $statusLabel }}</span></td>
                            <td>{{ $item->payment_date ?? $item->created_at ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">No payment records found.</p>
        @endif
    </section>

</div>

<style>
    .stall-page {
        --ink: #1c1b1a;
        --muted: #6b6560;
        --border: #e5e2dd;
        --bg: #fafaf9;
        --accent: #2d5f5d;
        --ok: #2f6f4e;
        --warn: #9a6b12;
        --bad: #b23a34;

        max-width: 920px;
        margin: 0 auto;
        padding: 2.5rem 1.25rem 4rem;
        color: var(--ink);
        font: 15px/1.5 -apple-system, "Segoe UI", Roboto, sans-serif;
    }

    .mono {
        font-family: "SFMono-Regular", Consolas, "Liberation Mono", monospace;
        font-size: 0.92em;
    }

    .notice {
        padding: .75rem 1rem;
        border-radius: 4px;
        margin-bottom: 1.25rem;
        font-size: .9rem;
    }

    .notice-ok {
        background: #eef6f1;
        color: var(--ok);
        border: 1px solid #cfe6d8;
    }

    .notice-bad {
        background: #fbeeed;
        color: var(--bad);
        border: 1px solid #f0d3d0;
    }

    .stall-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
        margin-bottom: 1.75rem;
    }

    .stall-header h1 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0 0 .3rem;
    }

    .stall-header .meta {
        color: var(--muted);
        font-size: .9rem;
        margin: 0;
    }

    .tag {
        display: inline-block;
        padding: .3rem .7rem;
        border-radius: 100px;
        font-size: .78rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .tag-ok {
        background: #eef6f1;
        color: var(--ok);
    }

    .tag-warn {
        background: #fbf3e3;
        color: var(--warn);
    }

    .tag-bad {
        background: #fbeeed;
        color: var(--bad);
    }

    .tag-muted {
        background: #eeece9;
        color: var(--muted);
    }

    .figures {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1px;
        background: var(--border);
        border: 1px solid var(--border);
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .figures>div {
        background: #fff;
        padding: 1rem 1.1rem;
    }

    .figures .label {
        display: block;
        color: var(--muted);
        font-size: .78rem;
        margin-bottom: .3rem;
    }

    .figures strong {
        font-size: 1.15rem;
        font-weight: 600;
    }

    .figures .ok {
        color: var(--ok);
    }

    .figures .bad {
        color: var(--bad);
    }

    .block {
        margin-bottom: 2rem;
    }

    .block h2 {
        font-size: .78rem;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .04em;
        margin: 0 0 .9rem;
        padding-bottom: .6rem;
        border-bottom: 1px solid var(--border);
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.1rem 1.5rem;
        margin: 0;
    }

    .grid-2 {
        grid-template-columns: repeat(2, 1fr);
    }

    .grid dt {
        color: var(--muted);
        font-size: .8rem;
        margin-bottom: .2rem;
    }

    .grid dd {
        margin: 0;
        font-weight: 500;
    }

    table.data {
        width: 100%;
        border-collapse: collapse;
        font-size: .9rem;
    }

    table.data th {
        text-align: left;
        font-size: .75rem;
        color: var(--muted);
        font-weight: 600;
        padding: 0 .75rem .6rem 0;
        border-bottom: 1px solid var(--border);
    }

    table.data td {
        padding: .65rem .75rem .65rem 0;
        border-bottom: 1px solid var(--border);
    }

    table.data tbody tr:last-child td {
        border-bottom: none;
    }

    table.data .ok {
        color: var(--ok);
    }

    table.data .bad {
        color: var(--bad);
    }

    .empty {
        color: var(--muted);
        font-size: .9rem;
        padding: 1rem 0;
    }

    @media (max-width: 720px) {
        .figures {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid {
            grid-template-columns: repeat(2, 1fr);
        }

        table.data {
            display: block;
            overflow-x: auto;
        }
    }
</style>
<div class="container-fluid py-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @php
        /*
         * ============================================================
         * STALL PAYMENT DATA
         * ============================================================
         */

        $paidAmount = (float) ($stall->paid_amount ?? 0);

        $finalPrice = (float) ($stall->final_price ?? 0);

        $gstAmount = (float) ($stall->gst_amount ?? 0);

        $originalAmount = (float) ($stall->original_amount ?? 0);

        $discountAmount = (float) ($stall->discount_amount ?? 0);

        /*
         * Total amount payable for this stall.
         */
        $totalPayable = $finalPrice + $gstAmount;

        /*
         * Amount still pending.
         */
        $remainingAmount = max(
            0,
            $totalPayable - $paidAmount
        );

        /*
         * Razorpay PUBLIC key only.
         *
         * Never expose the Razorpay secret here.
         */
        $razorpayKey = config('services.razorpay.key_id');

        /*
         * Booking ID comes directly from this stall.
         */
        $bookingId = $stall->booking_id ?? '';

        /*
         * This page contains only ONE stall.
         */
        $stallId = $stall->id;
    @endphp


    {{-- ============================================================
    RAZORPAY PAYMENT
    ============================================================= --}}

    @if($remainingAmount > 0)

        <div class="card mb-4">

            <div class="card-header bg-success text-white">

                <h5 class="mb-0">
                    Make Payment
                </h5>

            </div>


            <div class="card-body">

                <form id="razorpay-payment-form">

                    @csrf


                    {{-- =================================================
                    HIDDEN PAYMENT DATA
                    ================================================== --}}

                    <input type="hidden" id="booking_id" value="{{ $bookingId }}">

                    <input type="hidden" id="stall_id" value="{{ $stallId }}">

                    <input type="hidden" id="stall_due" value="{{ number_format($remainingAmount, 2, '.', '') }}">


                    {{-- =================================================
                    STALL INFORMATION
                    ================================================== --}}

                    <div class="alert alert-light border mb-4">

                        <div class="d-flex justify-content-between">

                            <span>
                                Stall
                            </span>

                            <strong>
                                #{{ $stallId }}
                            </strong>

                        </div>


                        @if(!empty($stall->stall_size))

                            <div class="d-flex justify-content-between mt-2">

                                <span>
                                    Size
                                </span>

                                <strong>
                                    {{ $stall->stall_size }}
                                </strong>

                            </div>

                        @endif


                        <div class="d-flex justify-content-between mt-2">

                            <span>
                                Total Payable
                            </span>

                            <strong>
                                ₹{{ number_format($totalPayable, 2) }}
                            </strong>

                        </div>


                        <div class="d-flex justify-content-between mt-2">

                            <span>
                                Already Paid
                            </span>

                            <strong>
                                ₹{{ number_format($paidAmount, 2) }}
                            </strong>

                        </div>


                        <div class="d-flex justify-content-between mt-2 text-danger">

                            <span>
                                Amount Due
                            </span>

                            <strong>
                                ₹{{ number_format($remainingAmount, 2) }}
                            </strong>

                        </div>

                    </div>


                    {{-- =================================================
                    PAYMENT TYPE
                    ================================================== --}}

                    <div id="payment-type-section" class="mb-4">

                        <label class="form-label fw-bold">
                            Payment Type
                        </label>


                        <div>

                            <label class="me-4">

                                <input type="radio" name="payment_type" value="full" checked>

                                Full Payment

                            </label>


                            <label>

                                <input type="radio" name="payment_type" value="partial">

                                Partial Payment

                            </label>

                        </div>

                    </div>


                    {{-- =================================================
                    PAYMENT AMOUNT
                    ================================================== --}}

                    <div id="amount-section" class="mb-4">

                        <label for="payment_amount" class="form-label fw-bold">
                            Payment Amount
                        </label>


                        <div class="input-group">

                            <span class="input-group-text">
                                ₹
                            </span>


                            <input type="number" id="payment_amount" class="form-control" min="0.01"
                                max="{{ number_format($remainingAmount, 2, '.', '') }}" step="0.01"
                                value="{{ number_format($remainingAmount, 2, '.', '') }}" readonly required>

                        </div>


                        <small class="text-muted" id="amount-help">
                            Full payment for this stall:
                            ₹{{ number_format($remainingAmount, 2) }}
                        </small>

                    </div>


                    {{-- =================================================
                    PAYMENT SUMMARY
                    ================================================== --}}

                    <div id="payment-summary" class="alert alert-info">

                        <div class="d-flex justify-content-between">

                            <span>
                                Stall Due
                            </span>

                            <strong id="stall-due">
                                ₹{{ number_format($remainingAmount, 2) }}
                            </strong>

                        </div>


                        <div class="d-flex justify-content-between mt-2">

                            <span>
                                Payment Now
                            </span>

                            <strong id="payment-now">
                                ₹{{ number_format($remainingAmount, 2) }}
                            </strong>

                        </div>


                        <div class="d-flex justify-content-between mt-2">

                            <span>
                                Remaining
                            </span>

                            <strong id="payment-remaining">
                                ₹0.00
                            </strong>

                        </div>

                    </div>


                    {{-- =================================================
                    RAZORPAY BUTTON
                    ================================================== --}}

                    <div id="razorpay-section">

                        <button type="submit" id="pay-button" class="btn btn-success">

                            <i class="fas fa-credit-card me-1"></i>

                            Pay with Razorpay

                        </button>

                    </div>

                </form>

            </div>

        </div>


    @else

        <div class="card border-success mb-4">

            <div class="card-body">

                <h5 class="text-success mb-1">
                    Payment Completed
                </h5>

                <p class="text-muted mb-0">
                    There is no remaining amount for this stall.
                </p>

            </div>

        </div>

    @endif


    {{-- ============================================================
    STALL HEADER
    ============================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="mb-1">
                {{ $stall->event_name ?? 'Stall Details' }}
            </h3>

            <p class="text-muted mb-0">
                Stall ID: {{ $stall->id }}
            </p>

        </div>


        @if($remainingAmount <= 0)

            <span class="badge bg-success px-3 py-2">
                Fully Paid
            </span>

        @elseif($paidAmount > 0)

            <span class="badge bg-warning text-dark px-3 py-2">
                Partially Paid
            </span>

        @else

            <span class="badge bg-danger px-3 py-2">
                Payment Pending
            </span>

        @endif

    </div>


    {{-- ============================================================
    STALL INFORMATION
    ============================================================= --}}

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Stall Information
            </h5>

        </div>


        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Stall ID
                    </small>

                    <strong>
                        {{ $stall->id }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Booking ID
                    </small>

                    <strong>
                        {{ $stall->booking_id }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Event
                    </small>

                    <strong>
                        {{ $stall->event_name ?? '-' }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Event ID
                    </small>

                    <strong>
                        {{ $stall->event_id ?? '-' }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Year
                    </small>

                    <strong>
                        {{ $stall->year ?? '-' }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Stall Size
                    </small>

                    <strong>
                        {{ $stall->stall_size ?? '-' }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Stall Type
                    </small>

                    <strong>
                        {{ $stall->stall_type ?? '-' }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Stall Location
                    </small>

                    <strong>
                        {{ $stall->stall_location ?? '-' }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Branding
                    </small>

                    @if($stall->branding)

                        <span class="badge bg-success">
                            Yes
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            No
                        </span>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ================================================================
RAZORPAY CHECKOUT
================================================================ --}}

@if($remainingAmount > 0)

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
             * ========================================================
             * PAYMENT CONFIG
             * ========================================================
             */

            const bookingId = @json($bookingId);

            const stallId = @json($stallId);

            const stallDue = Number(@json($remainingAmount));
            /*
             * PUBLIC RAZORPAY KEY ONLY.
             *
             * Secret key must NEVER be sent to JavaScript.
             */

            const razorpayKey =
                @json($razorpayKey);


            const createOrderUrl =
                @json(route('exhibitor.payment.razorpay.order'));


            const verifyPaymentUrl =
                @json(route('exhibitor.payment.razorpay.verify'));


            /*
             * ========================================================
             * DOM ELEMENTS
             * ========================================================
             */

            const form =
                document.getElementById(
                    'razorpay-payment-form'
                );


            const amountInput =
                document.getElementById(
                    'payment_amount'
                );


            const paymentNowText =
                document.getElementById(
                    'payment-now'
                );


            const remainingText =
                document.getElementById(
                    'payment-remaining'
                );


            const amountHelp =
                document.getElementById(
                    'amount-help'
                );


            const payButton =
                document.getElementById(
                    'pay-button'
                );


            /*
             * ========================================================
             * HELPERS
             * ========================================================
             */

            function money(value) {
                return '₹' +
                    Number(value).toLocaleString(
                        'en-IN',
                        {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }
                    );
            }


            function getPaymentType() {
                const selected =
                    document.querySelector(
                        'input[name="payment_type"]:checked'
                    );

                return selected
                    ? selected.value
                    : 'full';
            }


            function updatePayment() {
                const paymentType =
                    getPaymentType();


                let amount = 0;


                /*
                 * ====================================================
                 * FULL PAYMENT
                 * ====================================================
                 */

                if (paymentType === 'full') {

                    amount =
                        stallDue;


                    amountInput.readOnly =
                        true;


                    amountInput.value =
                        stallDue.toFixed(2);


                    amountInput.max =
                        stallDue.toFixed(2);


                    amountHelp.textContent =
                        'Full payment for this stall: ' +
                        money(stallDue);

                }


                /*
                 * ====================================================
                 * PARTIAL PAYMENT
                 * ====================================================
                 */

                else {

                    amountInput.readOnly =
                        false;


                    amountInput.max =
                        stallDue.toFixed(2);


                    amount =
                        Number(
                            amountInput.value || 0
                        );


                    if (
                        amount <= 0 ||
                        amount > stallDue
                    ) {

                        amount =
                            0;

                    }


                    amountHelp.textContent =
                        'Enter any amount up to ' +
                        money(stallDue);

                }


                const remaining =
                    Math.max(
                        0,
                        stallDue - amount
                    );


                paymentNowText.textContent =
                    money(amount);


                remainingText.textContent =
                    money(remaining);


                payButton.disabled =
                    amount <= 0 ||
                    amount > stallDue;

            }


            /*
             * ========================================================
             * PAYMENT TYPE CHANGE
             * ========================================================
             */

            document
                .querySelectorAll(
                    'input[name="payment_type"]'
                )
                .forEach(function (radio) {

                    radio.addEventListener(
                        'change',
                        function () {

                            /*
                             * When switching to partial,
                             * clear the full amount so the user
                             * explicitly enters the amount.
                             */
                            if (
                                this.value === 'partial'
                            ) {

                                amountInput.value =
                                    '';

                            }


                            updatePayment();

                        }
                    );

                });


            /*
             * ========================================================
             * PARTIAL AMOUNT CHANGE
             * ========================================================
             */

            amountInput.addEventListener(
                'input',
                function () {

                    let amount =
                        Number(
                            amountInput.value || 0
                        );


                    /*
                     * Prevent amount above remaining balance.
                     */
                    if (amount > stallDue) {

                        amount =
                            stallDue;


                        amountInput.value =
                            stallDue.toFixed(2);

                    }


                    if (amount < 0) {

                        amount =
                            0;


                        amountInput.value =
                            '';

                    }


                    const remaining =
                        Math.max(
                            0,
                            stallDue - amount
                        );


                    paymentNowText.textContent =
                        money(amount);


                    remainingText.textContent =
                        money(remaining);


                    payButton.disabled =
                        amount <= 0 ||
                        amount > stallDue;

                }
            );


            /*
             * ========================================================
             * FORM SUBMIT
             * ========================================================
             */

            form.addEventListener(
                'submit',
                function (event) {

                    event.preventDefault();


                    const paymentType =
                        getPaymentType();


                    const amount =
                        Number(
                            amountInput.value || 0
                        );


                    /*
                     * Validate amount.
                     */
                    if (
                        amount <= 0 ||
                        amount > stallDue
                    ) {

                        alert(
                            'Please enter a valid payment amount.'
                        );

                        return;

                    }


                    /*
                     * Validate Razorpay key.
                     */
                    if (!razorpayKey) {

                        alert(
                            'Razorpay Key ID is not configured.'
                        );

                        return;

                    }


                    /*
                     * Disable button while creating
                     * the Razorpay order.
                     */
                    payButton.disabled =
                        true;


                    payButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span>' +
                        'Please wait...';


                    /*
                     * =================================================
                     * CREATE RAZORPAY ORDER
                     * =================================================
                     */

                    fetch(
                        createOrderUrl,
                        {
                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    document.querySelector(
                                        'input[name="_token"]'
                                    ).value

                            },

                            body: JSON.stringify({

                                booking_id:
                                    bookingId,

                                stall_id:
                                    stallId,

                                payment_type:
                                    paymentType,

                                amount:
                                    amount

                            })

                        }
                    )
                        .then(function (response) {

                            return response.json()
                                .then(function (data) {

                                    if (!response.ok) {

                                        throw new Error(
                                            data.message ||
                                            'Unable to create payment order.'
                                        );

                                    }


                                    return data;

                                });

                        })
                        .then(function (data) {

                            if (!data.success) {

                                throw new Error(
                                    data.message ||
                                    'Unable to create Razorpay order.'
                                );

                            }


                            /*
                             * =================================================
                             * OPEN RAZORPAY CHECKOUT
                             * =================================================
                             */

                            const options = {

                                key:
                                    razorpayKey,


                                amount:
                                    data.amount,


                                currency:
                                    data.currency ||
                                    'INR',


                                name:
                                    @json(config('app.name')),


                                description:
                                    'Booking ' +
                                    bookingId +
                                    ' - Stall ' +
                                    stallId,


                                order_id:
                                    data.order_id,


                                theme: {

                                    color:
                                        '#198754'

                                },


                                /*
                                 * =================================================
                                 * PAYMENT SUCCESS
                                 * =================================================
                                 */

                                handler:
                                    function (response) {

                                        payButton.innerHTML =
                                            '<span class="spinner-border spinner-border-sm me-1"></span>' +
                                            'Verifying...';


                                        /*
                                         * Send Razorpay response
                                         * to Laravel.
                                         *
                                         * Laravel must verify the
                                         * Razorpay signature.
                                         */
                                        fetch(
                                            verifyPaymentUrl,
                                            {
                                                method: 'POST',

                                                headers: {

                                                    'Content-Type':
                                                        'application/json',

                                                    'Accept':
                                                        'application/json',

                                                    'X-CSRF-TOKEN':
                                                        document.querySelector(
                                                            'input[name="_token"]'
                                                        ).value

                                                },

                                                body:
                                                    JSON.stringify({

                                                        booking_id:
                                                            bookingId,

                                                        stall_id:
                                                            stallId,

                                                        payment_type:
                                                            paymentType,

                                                        amount:
                                                            amount,

                                                        razorpay_payment_id:
                                                            response.razorpay_payment_id,

                                                        razorpay_order_id:
                                                            response.razorpay_order_id,

                                                        razorpay_signature:
                                                            response.razorpay_signature

                                                    })

                                            }
                                        )
                                            .then(function (response) {

                                                return response.json()
                                                    .then(function (data) {

                                                        if (!response.ok) {

                                                            throw new Error(
                                                                data.message ||
                                                                'Payment verification failed.'
                                                            );

                                                        }


                                                        return data;

                                                    });

                                            })
                                            .then(function (result) {

                                                if (!result.success) {

                                                    throw new Error(
                                                        result.message ||
                                                        'Payment verification failed.'
                                                    );

                                                }


                                                alert(
                                                    result.message ||
                                                    'Payment completed successfully.'
                                                );


                                                /*
                                                 * Reload the page so that
                                                 * paid_amount / remaining
                                                 * amount / status are updated.
                                                 */
                                                window.location.reload();

                                            })
                                            .catch(function (error) {

                                                alert(
                                                    error.message ||
                                                    'Payment verification failed.'
                                                );


                                                payButton.disabled =
                                                    false;


                                                payButton.innerHTML =
                                                    '<i class="fas fa-credit-card me-1"></i>' +
                                                    'Pay with Razorpay';

                                            });

                                    },


                                /*
                                 * =================================================
                                 * CHECKOUT CLOSED
                                 * =================================================
                                 */

                                modal: {

                                    ondismiss:
                                        function () {

                                            payButton.disabled =
                                                false;


                                            payButton.innerHTML =
                                                '<i class="fas fa-credit-card me-1"></i>' +
                                                'Pay with Razorpay';

                                        }

                                }

                            };


                            const razorpay =
                                new Razorpay(options);


                            /*
                             * =================================================
                             * PAYMENT FAILED
                             * =================================================
                             */

                            razorpay.on(
                                'payment.failed',
                                function (response) {

                                    console.error(
                                        response
                                    );


                                    alert(
                                        response.error?.description ||
                                        'Razorpay payment failed.'
                                    );


                                    payButton.disabled =
                                        false;


                                    payButton.innerHTML =
                                        '<i class="fas fa-credit-card me-1"></i>' +
                                        'Pay with Razorpay';

                                }
                            );


                            razorpay.open();

                        })
                        .catch(function (error) {

                            alert(
                                error.message ||
                                'Unable to start Razorpay payment.'
                            );


                            payButton.disabled =
                                false;


                            payButton.innerHTML =
                                '<i class="fas fa-credit-card me-1"></i>' +
                                'Pay with Razorpay';

                        });

                });


            /*
             * ========================================================
             * INITIAL STATE
             * ========================================================
             */

            updatePayment();

        });

    </script>

@endif


@include('exhibitor.stallinfo.oldinfo')