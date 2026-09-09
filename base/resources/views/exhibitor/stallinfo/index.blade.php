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

        $bookingId = $stall->booking_id ?? '';
        $bookingId = $stall->booking_id ?? '';
        echo '<a href="' . url('exhibitor/booking/' . $bookingId) . '">View Booking</a>';
        $stallId = $stall->id;
        echo '<a href="' . url('exhibitor/invoice/' . $stallId) . '">View invoice</a>';
        $razorpayKey = config('services.razorpay.key_id'); // public key only — never the secret

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
                Stall <span class="mono">#{{ $stallId }}</span>
                &nbsp;·&nbsp;
                Booking <span class="mono">{{ $bookingId ?: '—' }}</span>
            </p>
        </div>
        <span class="tag tag-{{ $paymentState['class'] }}">{{ $paymentState['label'] }}</span>
    </header>

    {{-- Payment --}}
    @if($remainingAmount > 0)
        <section class="block pay-card">
            <h2>Make payment</h2>

            <form id="razorpay-payment-form">
                @csrf
                <input type="hidden" id="booking_id" value="{{ $bookingId }}">
                <input type="hidden" id="stall_id" value="{{ $stallId }}">

                <div class="pay-row">
                    <span>Amount due</span>
                    <strong class="bad">{{ $money($remainingAmount) }}</strong>
                </div>

                <div class="field">
                    <span class="field-label">Payment type</span>
                    <div class="radio-group">
                        <label><input type="radio" name="payment_type" value="full" checked> Full payment</label>
                        <label><input type="radio" name="payment_type" value="partial"> Partial payment</label>
                    </div>
                </div>

                <div class="field">
                    <label class="field-label" for="payment_amount">Amount to pay</label>
                    <div class="amount-input">
                        <span>₹</span>
                        <input type="number" id="payment_amount" min="0.01"
                            max="{{ number_format($remainingAmount, 2, '.', '') }}" step="0.01"
                            value="{{ number_format($remainingAmount, 2, '.', '') }}" readonly required>
                    </div>
                    <small id="amount-help" class="hint">Full payment for this stall: {{ $money($remainingAmount) }}</small>
                </div>

                <div class="pay-summary">
                    <div><span>Payment now</span><strong id="payment-now">{{ $money($remainingAmount) }}</strong></div>
                    <div><span>Remaining after</span><strong id="payment-remaining">₹0.00</strong></div>
                </div>

                <button type="submit" id="pay-button" class="btn-primary">Pay with Razorpay</button>
            </form>
        </section>
    @else
        <div class="notice notice-ok">Payment completed — there is no remaining amount for this stall.</div>
    @endif

    {{-- Payment summary figures --}}
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
                        <strong>{{ $money($remainingAmount) }}</strong>
                    </td>
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

    /* Payment card */
    .pay-card {
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.25rem 1.4rem 1.5rem;
    }

    .pay-card h2 {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 1.1rem;
    }

    .pay-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding-bottom: 1rem;
        margin-bottom: 1.1rem;
        border-bottom: 1px solid var(--border);
        font-size: .95rem;
    }

    .pay-row strong {
        font-size: 1.2rem;
    }

    .field {
        margin-bottom: 1.1rem;
    }

    .field-label {
        display: block;
        font-size: .85rem;
        font-weight: 600;
        margin-bottom: .5rem;
    }

    .radio-group {
        display: flex;
        gap: 1.5rem;
        font-size: .9rem;
    }

    .radio-group label {
        display: flex;
        align-items: center;
        gap: .4rem;
        cursor: pointer;
    }

    .amount-input {
        display: flex;
        align-items: center;
        border: 1px solid var(--border);
        border-radius: 6px;
        overflow: hidden;
        max-width: 220px;
    }

    .amount-input span {
        padding: .55rem .7rem;
        background: #f4f2ef;
        color: var(--muted);
        font-size: .9rem;
    }

    .amount-input input {
        border: none;
        outline: none;
        padding: .55rem .7rem;
        width: 100%;
        font-size: .95rem;
        font-family: inherit;
    }

    .amount-input input:read-only {
        background: #fafaf9;
        color: var(--muted);
    }

    .hint {
        display: block;
        margin-top: .4rem;
        color: var(--muted);
        font-size: .8rem;
    }

    .pay-summary {
        background: #f4f2ef;
        border-radius: 6px;
        padding: .9rem 1rem;
        margin-bottom: 1.25rem;
        font-size: .9rem;
    }

    .pay-summary>div {
        display: flex;
        justify-content: space-between;
    }

    .pay-summary>div+div {
        margin-top: .5rem;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: .7rem 1.4rem;
        font-size: .92rem;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
    }

    .btn-primary:disabled {
        opacity: .55;
        cursor: not-allowed;
    }

    .btn-primary:hover:not(:disabled) {
        filter: brightness(0.94);
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

@if($remainingAmount > 0)
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bookingId = @json($bookingId);
            const stallId = @json($stallId);
            const stallDue = Number(@json($remainingAmount));
            const razorpayKey = @json($razorpayKey); // public key only

            const createOrderUrl = @json(route('exhibitor.payment.razorpay.order'));
            const verifyPaymentUrl = @json(route('exhibitor.payment.razorpay.verify'));

            const form = document.getElementById('razorpay-payment-form');
            const amountInput = document.getElementById('payment_amount');
            const paymentNowText = document.getElementById('payment-now');
            const remainingText = document.getElementById('payment-remaining');
            const amountHelp = document.getElementById('amount-help');
            const payButton = document.getElementById('pay-button');

            function money(value) {
                return '₹' + Number(value).toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                });
            }

            function getPaymentType() {
                const selected = document.querySelector('input[name="payment_type"]:checked');
                return selected ? selected.value : 'full';
            }

            function updatePayment() {
                const paymentType = getPaymentType();
                let amount = 0;

                if (paymentType === 'full') {
                    amount = stallDue;
                    amountInput.readOnly = true;
                    amountInput.value = stallDue.toFixed(2);
                    amountInput.max = stallDue.toFixed(2);
                    amountHelp.textContent = 'Full payment for this stall: ' + money(stallDue);
                } else {
                    amountInput.readOnly = false;
                    amountInput.max = stallDue.toFixed(2);
                    amount = Number(amountInput.value || 0);
                    if (amount <= 0 || amount > stallDue) amount = 0;
                    amountHelp.textContent = 'Enter any amount up to ' + money(stallDue);
                }

                const remaining = Math.max(0, stallDue - amount);
                paymentNowText.textContent = money(amount);
                remainingText.textContent = money(remaining);
                payButton.disabled = amount <= 0 || amount > stallDue;
            }

            document.querySelectorAll('input[name="payment_type"]').forEach(function (radio) {
                radio.addEventListener('change', function () {
                    if (this.value === 'partial') amountInput.value = '';
                    updatePayment();
                });
            });

            amountInput.addEventListener('input', function () {
                let amount = Number(amountInput.value || 0);

                if (amount > stallDue) {
                    amount = stallDue;
                    amountInput.value = stallDue.toFixed(2);
                }
                if (amount < 0) {
                    amount = 0;
                    amountInput.value = '';
                }

                const remaining = Math.max(0, stallDue - amount);
                paymentNowText.textContent = money(amount);
                remainingText.textContent = money(remaining);
                payButton.disabled = amount <= 0 || amount > stallDue;
            });

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const paymentType = getPaymentType();
                const amount = Number(amountInput.value || 0);

                if (amount <= 0 || amount > stallDue) {
                    alert('Please enter a valid payment amount.');
                    return;
                }
                if (!razorpayKey) {
                    alert('Razorpay Key ID is not configured.');
                    return;
                }

                payButton.disabled = true;
                payButton.textContent = 'Please wait...';

                fetch(createOrderUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify({
                        booking_id: bookingId,
                        stall_id: stallId,
                        payment_type: paymentType,
                        amount: amount,
                    }),
                })
                    .then(function (response) {
                        return response.json().then(function (data) {
                            if (!response.ok) throw new Error(data.message || 'Unable to create payment order.');
                            return data;
                        });
                    })
                    .then(function (data) {
                        if (!data.success) throw new Error(data.message || 'Unable to create Razorpay order.');

                        const options = {
                            key: razorpayKey,
                            amount: data.amount,
                            currency: data.currency || 'INR',
                            name: @json(config('app.name')),
                            description: 'Booking ' + bookingId + ' - Stall ' + stallId,
                            order_id: data.order_id,
                            theme: { color: '#2d5f5d' },

                            handler: function (response) {
                                payButton.textContent = 'Verifying...';

                                fetch(verifyPaymentUrl, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                    },
                                    body: JSON.stringify({
                                        booking_id: bookingId,
                                        stall_id: stallId,
                                        payment_type: paymentType,
                                        amount: amount,
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_order_id: response.razorpay_order_id,
                                        razorpay_signature: response.razorpay_signature,
                                    }),
                                })
                                    .then(function (response) {
                                        return response.json().then(function (data) {
                                            if (!response.ok) throw new Error(data.message || 'Payment verification failed.');
                                            return data;
                                        });
                                    })
                                    .then(function (result) {
                                        if (!result.success) throw new Error(result.message || 'Payment verification failed.');
                                        alert(result.message || 'Payment completed successfully.');
                                        window.location.reload();
                                    })
                                    .catch(function (error) {
                                        alert(error.message || 'Payment verification failed.');
                                        payButton.disabled = false;
                                        payButton.textContent = 'Pay with Razorpay';
                                    });
                            },

                            modal: {
                                ondismiss: function () {
                                    payButton.disabled = false;
                                    payButton.textContent = 'Pay with Razorpay';
                                },
                            },
                        };

                        const razorpay = new Razorpay(options);

                        razorpay.on('payment.failed', function (response) {
                            console.error(response);
                            alert(response.error?.description || 'Razorpay payment failed.');
                            payButton.disabled = false;
                            payButton.textContent = 'Pay with Razorpay';
                        });

                        razorpay.open();
                    })
                    .catch(function (error) {
                        alert(error.message || 'Unable to start Razorpay payment.');
                        payButton.disabled = false;
                        payButton.textContent = 'Pay with Razorpay';
                    });
            });

            updatePayment();
        });
    </script>
@endif