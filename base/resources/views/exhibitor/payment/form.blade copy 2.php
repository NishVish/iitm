{{-- =====================================================
PART 2: PAYMENT FORM
====================================================== --}}

@if($totalDue > 0)

    <div class="card border">

        <div class="card-header bg-success text-white">
            <h5 class="mb-0">2. Make Payment</h5>
        </div>

        <div class="card-body">

            <form action="{{ url('updatePayment') }}" method="POST">
                @csrf

                {{-- Booking ID is still required to identify the booking --}}
                <input type="hidden" name="booking_id"
                    value="{{ $final_bookingdetails->booking->booking_id ?? $bookingdata->booking_id }}">

                {{-- =====================================================
                PAYMENT TYPE
                ====================================================== --}}

                <div class="mb-4">

                    <label class="form-label fw-bold">
                        Payment Type
                    </label>

                    <div class="row g-3">

                        {{-- FULL PAYMENT --}}
                        <div class="col-md-4">

                            <label class="payment-option border rounded p-3 d-block h-100">

                                <input type="radio" name="payment_type" value="full" class="form-check-input payment-type"
                                    checked>

                                <span class="fw-bold ms-2">
                                    Full Payment
                                </span>

                                <div class="small text-muted mt-2">
                                    Pay the complete remaining amount of all stalls.
                                </div>

                            </label>

                        </div>


                        {{-- PARTIAL PAYMENT --}}
                        <div class="col-md-4">

                            <label class="payment-option border rounded p-3 d-block h-100">

                                <input type="radio" name="payment_type" value="partial"
                                    class="form-check-input payment-type">

                                <span class="fw-bold ms-2">
                                    Partial Payment
                                </span>

                                <div class="small text-muted mt-2">
                                    Pay any amount now and keep the remaining balance due.
                                </div>

                            </label>

                        </div>


                        {{-- SPECIFIC STALL --}}
                        <div class="col-md-4">

                            <label class="payment-option border rounded p-3 d-block h-100">

                                <input type="radio" name="payment_type" value="stall" class="form-check-input payment-type">

                                <span class="fw-bold ms-2">
                                    Pay Specific Stall
                                </span>

                                <div class="small text-muted mt-2">
                                    Select a stall and pay its complete remaining amount.
                                </div>

                            </label>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                STALL SELECTION
                ====================================================== --}}

                <div id="stall-payment-section" class="mb-4" style="display:none;">

                    <label for="payment-stall-id" class="form-label fw-bold">

                        Select Stall
                    </label>

                    <select name="stall_id" id="payment-stall-id" class="form-select form-select-lg">

                        <option value="">
                            -- Select Stall --
                        </option>

                        @foreach($final_bookingdetails->stalls as $stall)

                            @php
                                /*
                                 * IMPORTANT:
                                 * stall_id is the actual stall record ID.
                                 * Payment will be posted using this ID.
                                 *
                                 * Do NOT use booking_id here.
                                 */
                                $stallId = $stall->stall_id ?? $stall->id ?? null;

                                $stallFinal = (float) ($stall->final_price ?? 0);
                                $stallPaid = (float) ($stall->paid_amount ?? 0);

                                $stallDue = max(0, $stallFinal - $stallPaid);
                            @endphp

                            @if($stallId && $stallDue > 0)

                                <option value="{{ $stallId }}" data-due="{{ number_format($stallDue, 2, '.', '') }}">

                                    Stall #{{ $stallId }}
                                    -
                                    {{ $stall->event_name ?? 'Event' }}
                                    -
                                    {{ $stall->stall_size ?? '-' }}
                                    -
                                    Due ₹{{ number_format($stallDue, 2) }}

                                </option>

                            @endif

                        @endforeach

                    </select>

                    <div class="form-text">
                        The payment record will be linked to the selected
                        <strong>stall ID</strong>.
                    </div>

                </div>


                {{-- =====================================================
                PAYMENT AMOUNT + METHOD
                ====================================================== --}}

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label for="payment_amount" class="form-label fw-bold">

                            Payment Amount
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                ₹
                            </span>

                            <input type="number" name="amount" id="payment_amount" class="form-control form-control-lg"
                                min="0.01" max="{{ number_format($totalDue, 2, '.', '') }}" step="0.01"
                                value="{{ number_format($totalDue, 2, '.', '') }}" required>

                        </div>

                        <div class="form-text" id="amount-help">

                            Full payment:
                            ₹{{ number_format($totalDue, 2) }}

                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label for="payment_method" class="form-label fw-bold">

                            Payment Method
                        </label>

                        <select name="payment_method" id="payment_method" class="form-select form-select-lg" required>

                            <option value="">
                                -- Select Payment Method --
                            </option>

                            <option value="bank_transfer">
                                Bank Transfer
                            </option>

                            <option value="upi">
                                UPI
                            </option>

                            <option value="cheque">
                                Cheque
                            </option>

                            <option value="cash">
                                Cash
                            </option>

                            <option value="card">
                                Card
                            </option>

                        </select>

                    </div>

                </div>


                {{-- =====================================================
                TRANSACTION DETAILS
                ====================================================== --}}

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label for="utr_id" class="form-label fw-bold">

                            UTR / Transaction ID
                        </label>

                        <input type="text" name="utr_id" id="utr_id" class="form-control"
                            placeholder="Enter UTR / transaction reference">

                    </div>


                    <div class="col-md-6 mb-3">

                        <label for="payment_date" class="form-label fw-bold">

                            Payment Date
                        </label>

                        <input type="date" name="payment_date" id="payment_date" class="form-control"
                            value="{{ date('Y-m-d') }}" required>

                    </div>

                </div>


                {{-- =====================================================
                REMARKS
                ====================================================== --}}

                <div class="mb-4">

                    <label for="remarks" class="form-label fw-bold">

                        Remarks
                    </label>

                    <textarea name="remarks" id="remarks" class="form-control" rows="3"
                        placeholder="Optional payment remarks"></textarea>

                </div>


                {{-- =====================================================
                PAYMENT PREVIEW
                ====================================================== --}}

                <div class="alert alert-info">

                    <div class="d-flex justify-content-between">

                        <span>
                            Payment Now
                        </span>

                        <strong id="payment-preview">
                            ₹{{ number_format($totalDue, 2) }}
                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mt-2">

                        <span>
                            Remaining Booking Balance
                        </span>

                        <strong id="remaining-preview">
                            ₹0.00
                        </strong>

                    </div>

                </div>


                {{-- =====================================================
                SUBMIT
                ====================================================== --}}

                <div class="text-end">

                    <button type="submit" class="btn btn-success btn-lg px-5" id="submit-payment">

                        <i class="fas fa-credit-card me-1"></i>
                        Confirm Payment

                    </button>

                </div>

            </form>

        </div>

    </div>

@else

    <div class="card border-success">

        <div class="card-body text-center py-5">

            <div class="text-success mb-3">
                <i class="fas fa-check-circle fa-3x"></i>
            </div>

            <h4 class="text-success">
                Payment Completed
            </h4>

            <p class="text-muted mb-0">
                There is no remaining amount for this booking.
            </p>

        </div>

    </div>

@endif


<style>
    .payment-option {
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
    }

    .payment-option:hover {
        border-color: #198754 !important;
        background: #f8fff9;
    }

    .payment-option:has(input:checked) {
        border-color: #198754 !important;
        background: #f0fff4;
        box-shadow: 0 0 0 1px #198754;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const paymentTypes =
            document.querySelectorAll('.payment-type');

        const stallSection =
            document.getElementById('stall-payment-section');

        const stallSelect =
            document.getElementById('payment-stall-id');

        const amountInput =
            document.getElementById('payment_amount');

        const amountHelp =
            document.getElementById('amount-help');

        const paymentPreview =
            document.getElementById('payment-preview');

        const remainingPreview =
            document.getElementById('remaining-preview');

        const submitButton =
            document.getElementById('submit-payment');


        /*
         * FULL BOOKING REMAINING BALANCE
         *
         * Full Payment means:
         * all remaining amounts of ALL stalls.
         */
        const totalDue =
            Number({{ number_format($totalDue, 2, '.', '') }});


        function money(value) {

            return '₹' + Number(value).toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

        }


        function getPaymentType() {

            const selected =
                document.querySelector(
                    '.payment-type:checked'
                );

            return selected
                ? selected.value
                : 'full';

        }


        /*
         * UPDATE FORM BASED ON PAYMENT TYPE
         */
        function updatePaymentForm() {

            const type = getPaymentType();


            /*
             * =========================================================
             * FULL PAYMENT
             * =========================================================
             *
             * Amount = complete remaining balance of ALL stalls.
             */
            if (type === 'full') {

                stallSection.style.display = 'none';

                stallSelect.value = '';

                amountInput.readOnly = true;

                amountInput.value =
                    totalDue.toFixed(2);

                amountInput.max =
                    totalDue.toFixed(2);

                amountHelp.textContent =
                    'Full payment for all stalls: ' +
                    money(totalDue);

                updatePreview();

                return;
            }


            /*
             * =========================================================
             * PARTIAL PAYMENT
             * =========================================================
             *
             * User chooses any amount up to booking balance.
             */
            if (type === 'partial') {

                stallSection.style.display = 'none';

                stallSelect.value = '';

                amountInput.readOnly = false;

                amountInput.value = '';

                amountInput.max =
                    totalDue.toFixed(2);

                amountHelp.textContent =
                    'Enter any amount up to ' +
                    money(totalDue);

                updatePreview();

                return;
            }


            /*
             * =========================================================
             * SPECIFIC STALL PAYMENT
             * =========================================================
             *
             * The selected stall ID is submitted.
             *
             * The amount is automatically the remaining amount
             * for that specific stall.
             */
            if (type === 'stall') {

                stallSection.style.display = 'block';

                amountInput.readOnly = true;

                const option =
                    stallSelect.options[
                    stallSelect.selectedIndex
                    ];

                const stallDue =
                    Number(
                        option?.dataset?.due || 0
                    );


                if (stallDue > 0) {

                    amountInput.value =
                        stallDue.toFixed(2);

                    /*
                     * Important:
                     * For a specific stall, max must be that
                     * stall's remaining balance, NOT total booking due.
                     */
                    amountInput.max =
                        stallDue.toFixed(2);

                    amountHelp.textContent =
                        'Selected stall remaining amount: ' +
                        money(stallDue);

                } else {

                    amountInput.value =
                        '0.00';

                    amountInput.max =
                        '0.00';

                    amountHelp.textContent =
                        'Select a stall to continue.';

                }

                updatePreview();

            }

        }


        /*
         * =========================================================
         * PREVIEW
         * =========================================================
         */
        function updatePreview() {

            const type =
                getPaymentType();

            let amount = 0;


            if (type === 'full') {

                /*
                 * Full payment = ALL stalls.
                 */
                amount = totalDue;

            }


            else if (type === 'partial') {

                amount =
                    Number(
                        amountInput.value || 0
                    );

            }


            else if (type === 'stall') {

                const option =
                    stallSelect.options[
                    stallSelect.selectedIndex
                    ];

                amount =
                    Number(
                        option?.dataset?.due || 0
                    );

            }


            amount =
                Math.max(0, amount);


            /*
             * For preview purposes, the booking balance is reduced
             * by the payment being made.
             */
            const remaining =
                Math.max(
                    0,
                    totalDue - amount
                );


            paymentPreview.textContent =
                money(amount);

            remainingPreview.textContent =
                money(remaining);


            /*
             * Enable/disable submit intelligently.
             */
            if (submitButton) {

                if (type === 'stall') {

                    submitButton.disabled =
                        amount <= 0 ||
                        !stallSelect.value;

                } else {

                    submitButton.disabled =
                        amount <= 0 ||
                        amount > totalDue;

                }

            }

        }


        /*
         * =========================================================
         * PAYMENT TYPE CHANGE
         * =========================================================
         */
        paymentTypes.forEach(function (radio) {

            radio.addEventListener(
                'change',
                function () {

                    updatePaymentForm();

                }
            );

        });


        /*
         * =========================================================
         * STALL CHANGE
         * =========================================================
         */
        if (stallSelect) {

            stallSelect.addEventListener(
                'change',
                function () {

                    updatePaymentForm();

                }
            );

        }


        /*
         * =========================================================
         * AMOUNT CHANGE
         * =========================================================
         */
        if (amountInput) {

            amountInput.addEventListener(
                'input',
                function () {

                    const type =
                        getPaymentType();

                    let amount =
                        Number(
                            amountInput.value || 0
                        );


                    if (amount < 0) {

                        amount = 0;

                        amountInput.value =
                            '0.00';

                    }


                    /*
                     * Partial payment cannot exceed
                     * the complete remaining booking balance.
                     */
                    if (
                        type === 'partial' &&
                        amount > totalDue
                    ) {

                        amount =
                            totalDue;

                        amountInput.value =
                            totalDue.toFixed(2);

                    }


                    updatePreview();

                }
            );

        }


        /*
         * =========================================================
         * INITIAL STATE
         * =========================================================
         */
        updatePaymentForm();

    });
</script>