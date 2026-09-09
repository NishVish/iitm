{{-- =====================================================
====
    RAZORPAY PAYMENT FORM

    Flow:
    1. Select Stall
    2. Full Payment / Partial Payment
    3. Enter amount for Partial Payment
    4. Pay with Razorpay
========================================================= --}}

@php

    $bookingId = $payment['booking']['booking_id']
        ?? ($bookingdata->booking_id ?? '');

    $stalls = $payment['stalls'] ?? [];

    /*
     * IMPORTANT:
     *
     * Only the PUBLIC Razorpay Key ID goes to JavaScript.
     *
     * The Secret is NEVER sent to the browser.
     */
    $razorpayKey = config('services.razorpay.key_id');

@endphp


@php

    $hasRemainingAmount = collect($stalls)->contains(function ($stall) {

        return (float) ($stall['remaining_amount'] ?? 0) > 0;

    });

@endphp


@if($hasRemainingAmount)

    <div class="card">

        <div class="card-header bg-success text-white">

            <h5 class="mb-0">
                Make Payment
            </h5>

        </div>


        <div class="card-body">

            <form id="razorpay-payment-form">

                @csrf

                <input type="hidden"
                    id="booking_id"
                    value="{{ $bookingId }}">


                {{-- =================================================
                    1. SELECT STALL
                ================================================== --}}

                <div class="mb-4">

                    <label for="stall_select"
                        class="form-label fw-bold">

                        Select Stall

                    </label>


                    <select id="stall_select"
                        class="form-select"
                        required>

                        <option value="">
                            -- Select Stall --
                        </option>


                        @foreach($stalls as $stall)

                            @php

                                $stallId =
                                    $stall['stall_id'] ?? null;

                                $stallRemaining =
                                    (float) (
                                        $stall['remaining_amount']
                                        ?? 0
                                    );

                            @endphp


                            @if($stallId && $stallRemaining > 0)

                                <option
                                    value="{{ $stallId }}"
                                    data-due="{{ number_format($stallRemaining, 2, '.', '') }}">

                                    Stall #{{ $stallId }}

                                    @if(!empty($stall['stall_size']))
                                        - Size {{ $stall['stall_size'] }}
                                    @endif

                                    - Due ₹{{ number_format($stallRemaining, 2) }}

                                </option>

                            @endif

                        @endforeach

                    </select>

                </div>


                {{-- =================================================
                    2. PAYMENT TYPE
                ================================================== --}}

                <div id="payment-type-section"
                    class="mb-4"
                    style="display:none;">

                    <label class="form-label fw-bold">

                        Payment Type

                    </label>


                    <div>

                        <label class="me-4">

                            <input type="radio"
                                name="payment_type"
                                value="full"
                                checked>

                            Full Payment

                        </label>


                        <label>

                            <input type="radio"
                                name="payment_type"
                                value="partial">

                            Partial Payment

                        </label>

                    </div>

                </div>


                {{-- =================================================
                    3. PAYMENT AMOUNT
                ================================================== --}}

                <div id="amount-section"
                    class="mb-4"
                    style="display:none;">

                    <label for="payment_amount"
                        class="form-label fw-bold">

                        Payment Amount

                    </label>


                    <div class="input-group">

                        <span class="input-group-text">
                            ₹
                        </span>


                        <input type="number"
                            id="payment_amount"
                            class="form-control"
                            min="1"
                            step="0.01"
                            readonly
                            required>

                    </div>


                    <small class="text-muted"
                        id="amount-help">
                    </small>

                </div>


                {{-- =================================================
                    4. PAYMENT SUMMARY
                ================================================== --}}

                <div id="payment-summary"
                    class="alert alert-info"
                    style="display:none;">

                    <div class="d-flex justify-content-between">

                        <span>
                            Stall Due
                        </span>

                        <strong id="stall-due">
                            ₹0.00
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mt-2">

                        <span>
                            Payment Now
                        </span>

                        <strong id="payment-now">
                            ₹0.00
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

                <div id="razorpay-section"
                    style="display:none;">

                    <button type="submit"
                        id="pay-button"
                        class="btn btn-success">

                        <i class="fas fa-credit-card me-1"></i>

                        Pay with Razorpay

                    </button>

                </div>

            </form>

        </div>

    </div>


@else

    <div class="card border-success">

        <div class="card-body">

            <h5 class="text-success mb-1">
                Payment Completed
            </h5>

            <p class="text-muted mb-0">
                There is no remaining amount for this booking.
            </p>

        </div>

    </div>

@endif


@if($hasRemainingAmount)

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const bookingId =
                @json($bookingId);


            /*
             * PUBLIC KEY ID ONLY.
             *
             * This is safe to expose in Checkout.
             */
            const razorpayKey =
                @json($razorpayKey);


            const createOrderUrl =
                @json(route('exhibitor.payment.razorpay.order'));


            const verifyPaymentUrl =
                @json(route('exhibitor.payment.razorpay.verify'));


            const form =
                document.getElementById(
                    'razorpay-payment-form'
                );


            const stallSelect =
                document.getElementById(
                    'stall_select'
                );


            const paymentTypeSection =
                document.getElementById(
                    'payment-type-section'
                );


            const amountSection =
                document.getElementById(
                    'amount-section'
                );


            const amountInput =
                document.getElementById(
                    'payment_amount'
                );


            const paymentSummary =
                document.getElementById(
                    'payment-summary'
                );


            const razorpaySection =
                document.getElementById(
                    'razorpay-section'
                );


            const payButton =
                document.getElementById(
                    'pay-button'
                );


            const stallDueText =
                document.getElementById(
                    'stall-due'
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


            function money(value)
            {
                return '₹' +
                    Number(value).toLocaleString(
                        'en-IN',
                        {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }
                    );
            }


            function getStallDue()
            {
                const option =
                    stallSelect.options[
                        stallSelect.selectedIndex
                    ];

                return Number(
                    option?.dataset?.due || 0
                );
            }


            function getPaymentType()
            {
                const selected =
                    document.querySelector(
                        'input[name="payment_type"]:checked'
                    );

                return selected
                    ? selected.value
                    : 'full';
            }


            function updatePayment()
            {
                const stallId =
                    stallSelect.value;


                const stallDue =
                    getStallDue();


                const paymentType =
                    getPaymentType();


                if (!stallId || stallDue <= 0) {

                    paymentTypeSection.style.display =
                        'none';

                    amountSection.style.display =
                        'none';

                    paymentSummary.style.display =
                        'none';

                    razorpaySection.style.display =
                        'none';

                    return;
                }


                paymentTypeSection.style.display =
                    'block';

                amountSection.style.display =
                    'block';

                paymentSummary.style.display =
                    'block';

                razorpaySection.style.display =
                    'block';


                let amount;


                /*
                 * FULL PAYMENT
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
                 * PARTIAL PAYMENT
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

                        amountInput.value =
                            '';

                        amount = 0;

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


                stallDueText.textContent =
                    money(stallDue);


                paymentNowText.textContent =
                    money(amount);


                remainingText.textContent =
                    money(remaining);


                payButton.disabled =
                    amount <= 0 ||
                    amount > stallDue;
            }


            /*
             * Stall changed.
             */
            stallSelect.addEventListener(
                'change',
                function () {

                    updatePayment();

                }
            );


            /*
             * Full / Partial changed.
             */
            document
                .querySelectorAll(
                    'input[name="payment_type"]'
                )
                .forEach(function (radio) {

                    radio.addEventListener(
                        'change',
                        function () {

                            updatePayment();

                        }
                    );

                });


            /*
             * Partial amount changed.
             */
            amountInput.addEventListener(
                'input',
                function () {

                    const stallDue =
                        getStallDue();


                    let amount =
                        Number(
                            amountInput.value || 0
                        );


                    if (amount < 0) {

                        amount = 0;

                        amountInput.value = '';

                    }


                    if (amount > stallDue) {

                        amount =
                            stallDue;

                        amountInput.value =
                            stallDue.toFixed(2);

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
             * Submit -> Create Razorpay Order.
             */
            form.addEventListener(
                'submit',
                function (event) {

                    event.preventDefault();


                    const stallId =
                        stallSelect.value;


                    const stallDue =
                        getStallDue();


                    const paymentType =
                        getPaymentType();


                    const amount =
                        Number(
                            amountInput.value || 0
                        );


                    if (!stallId) {

                        alert(
                            'Please select a stall.'
                        );

                        return;

                    }


                    if (
                        amount <= 0 ||
                        amount > stallDue
                    ) {

                        alert(
                            'Please enter a valid payment amount.'
                        );

                        return;

                    }


                    if (!razorpayKey) {

                        alert(
                            'Razorpay Key ID is not configured.'
                        );

                        return;

                    }


                    payButton.disabled =
                        true;


                    payButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span>' +
                        'Please wait...';


                    /*
                     * Ask Laravel to create the order.
                     *
                     * The Laravel controller reads the secret
                     * directly from config/services.php.
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
                         * Open Razorpay Checkout.
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


                            handler:
                                function (response) {

                                    /*
                                     * Razorpay has returned
                                     * successful payment details.
                                     *
                                     * Send them to Laravel for
                                     * signature verification.
                                     */
                                    payButton.innerHTML =
                                        '<span class="spinner-border spinner-border-sm me-1"></span>' +
                                        'Verifying...';


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
             * Initial state.
             */
            updatePayment();

        });

    </script>

@endif
