{{-- resources/views/exhibitor/invoice/index.blade.php --}}

@php

    /*
    |--------------------------------------------------------------------------
    | AMOUNT CALCULATION
    |--------------------------------------------------------------------------
    */

    $originalAmount = (float) ($stallData->original_amount ?? 0);
    $discountAmount = (float) ($stallData->discount_amount ?? 0);
    $gstAmount = (float) ($stallData->gst_amount ?? 0);
    $paidAmount = (float) ($stallData->paid_amount ?? 0);

    // Amount after discount and before GST
    $taxableAmount = max(0, $originalAmount - $discountAmount);

    // Final amount including GST
    $totalAmount = $taxableAmount + $gstAmount;

    // Always calculate balance from total - actual payment.
    // Do not rely on due_amount because it may be incorrect in the database.
    $dueAmount = max(0, $totalAmount - $paidAmount);

    /*
    |--------------------------------------------------------------------------
    | DOCUMENT STATUS
    |--------------------------------------------------------------------------
    */

    // If no amount has been received, it must be a PROFORMA INVOICE.
    $hasPayment = $paidAmount > 0;

    // Fully paid only when payment exists and balance is zero.
    $isPaid = $hasPayment && $dueAmount <= 0;

    if (!$hasPayment) {
        $documentTitle = 'PROFORMA INVOICE';
        $invoiceStatus = 'PAYMENT PENDING';
        $statusClass = 'pending';
    } elseif ($isPaid) {
        $documentTitle = 'INVOICE';
        $invoiceStatus = 'PAID';
        $statusClass = 'paid';
    } else {
        $documentTitle = 'INVOICE';
        $invoiceStatus = 'PARTIALLY PAID';
        $statusClass = 'partial';
    }

    $invoiceDate = now()->format('d M Y');

@endphp


<div class="invoice-wrapper">

    {{-- =====================================================
    HEADER
    ====================================================== --}}

    <div class="invoice-header">

        <div class="company-header">

            <img src="{{ asset('public/resources/spherelogo.png') }}" class="company-logo"
                alt="Sphere Travelmedia & Exhibitions">

            <div class="company-details">

                <h2>Sphere Travelmedia & Exhibitions</h2>

                <p>
                    245, Amar Jyothi Layout,<br>
                    Domlur, Bangalore – 560 071. India
                </p>

                <p>
                    <strong>Email:</strong>
                    info@spheretravelmedia.com
                </p>

                <p>
                    <strong>Phone:</strong>
                    +91-80-40834100
                </p>

            </div>

        </div>


        <div class="invoice-title">

            <h1>
                {{ $documentTitle }}
            </h1>

            <div class="invoice-number">
                Booking ID:
                <strong>{{ $stallData->booking_id ?? '—' }}</strong>
            </div>

            <div class="invoice-date">
                Date:
                <strong>{{ $invoiceDate }}</strong>
            </div>

            <span class="invoice-status {{ $statusClass }}">
                {{ $invoiceStatus }}
            </span>

        </div>

    </div>


    {{-- =====================================================
    BILL TO
    ====================================================== --}}

    <div class="bill-section">

        <div class="bill-box">

            <div class="section-label">
                BILL TO
            </div>

            <h3>
                {{ $company->company_name ?? '—' }}
            </h3>

            @if(!empty($company->address))
                <p>
                    {{ $company->address }}
                </p>
            @endif

            @if(
                    !empty($company->city) ||
                    !empty($company->state) ||
                    !empty($company->pincode)
                )

                <p>
                    {{ $company->city ?? '' }}

                    @if(!empty($company->city) && !empty($company->state))
                        ,
                    @endif

                    {{ $company->state ?? '' }}

                    @if(!empty($company->pincode))
                        - {{ $company->pincode }}
                    @endif
                </p>

            @endif

            @if(!empty($company->country))
                <p>
                    {{ $company->country }}
                </p>
            @endif

            @if(!empty($company->gst_number))
                <p>
                    <strong>GSTIN:</strong>
                    {{ $company->gst_number }}
                </p>
            @endif

        </div>


        <div class="bill-box">

            <div class="section-label">
                BILLING CONTACT
            </div>

            <h3>
                {{ $billingContact->name ?? '—' }}
            </h3>

            @if(!empty($billingContact->designation))
                <p>
                    {{ $billingContact->designation }}
                </p>
            @endif

            @if(!empty($billingContact->contact_mobile))
                <p>
                    {{ $billingContact->contact_mobile }}
                </p>
            @endif

            @if(!empty($billingContact->contact_email))
                <p>
                    {{ $billingContact->contact_email }}
                </p>
            @endif

        </div>

    </div>


    {{-- =====================================================
    EVENT SUMMARY
    ====================================================== --}}

    <div class="event-summary">

        <div>
            <span>EVENT</span>

            <strong>
                {{ $stallData->event_name ?? '—' }}
            </strong>
        </div>

        <div>
            <span>STALL SIZE</span>

            <strong>
                {{ $stallData->stall_size ?? '—' }}
            </strong>
        </div>

        <div>
            <span>STALL LOCATION</span>

            <strong>
                {{ $stallData->stall_location ?: '—' }}
            </strong>
        </div>

        <div>
            <span>FASCIA</span>

            <strong>
                {{ $stallData->fascia ?: '—' }}
            </strong>
        </div>

    </div>


    {{-- =====================================================
    PRICE BREAKDOWN
    ====================================================== --}}

    <div class="section">

        <h3 class="section-title">
            Price Breakdown
        </h3>

        <table class="invoice-table">

            <thead>

                <tr>
                    <th width="55%">Product / Description</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Amount</th>
                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>

                        <strong>
                            Exhibition Stall
                        </strong>

                        <small>
                            {{ $stallData->event_name ?? 'Exhibition Event' }}

                            @if(!empty($stallData->stall_size))
                                · {{ $stallData->stall_size }} sq. ft.
                            @endif
                        </small>

                    </td>

                    <td>
                        1
                    </td>

                    <td>
                        ₹{{ number_format($originalAmount, 2) }}
                    </td>

                    <td>
                        ₹{{ number_format($originalAmount, 2) }}
                    </td>

                </tr>


                @if($discountAmount > 0)

                    <tr>

                        <td>
                            Discount
                        </td>

                        <td>
                            1
                        </td>

                        <td>
                            —
                        </td>

                        <td class="discount">
                            - ₹{{ number_format($discountAmount, 2) }}
                        </td>

                    </tr>

                @endif


                <tr>

                    <td>
                        Taxable Amount
                    </td>

                    <td>
                        —
                    </td>

                    <td>
                        —
                    </td>

                    <td>
                        ₹{{ number_format($taxableAmount, 2) }}
                    </td>

                </tr>


                @if($gstAmount > 0)

                    <tr>

                        <td>
                            GST
                        </td>

                        <td>
                            —
                        </td>

                        <td>
                            —
                        </td>

                        <td>
                            ₹{{ number_format($gstAmount, 2) }}
                        </td>

                    </tr>

                @endif

            </tbody>

        </table>

    </div>


    {{-- =====================================================
    TOTAL SUMMARY
    ====================================================== --}}

    <div class="amount-section">

        <div class="amount-box">

            <div>

                <span>
                    Subtotal
                </span>

                <strong>
                    ₹{{ number_format($originalAmount, 2) }}
                </strong>

            </div>


            @if($discountAmount > 0)

                <div>

                    <span>
                        Discount
                    </span>

                    <strong class="discount">
                        - ₹{{ number_format($discountAmount, 2) }}
                    </strong>

                </div>

            @endif


            <div>

                <span>
                    Taxable Amount
                </span>

                <strong>
                    ₹{{ number_format($taxableAmount, 2) }}
                </strong>

            </div>


            @if($gstAmount > 0)

                <div>

                    <span>
                        GST
                    </span>

                    <strong>
                        ₹{{ number_format($gstAmount, 2) }}
                    </strong>

                </div>

            @endif


            <div class="grand-total">

                <span>
                    Total
                </span>

                <strong>
                    ₹{{ number_format($totalAmount, 2) }}
                </strong>

            </div>


            <div class="paid-row">

                <span>
                    Amount Paid
                </span>

                <strong>
                    ₹{{ number_format($paidAmount, 2) }}
                </strong>

            </div>


            <div class="due-row">

                <span>
                    Balance Due
                </span>

                <strong>
                    ₹{{ number_format($dueAmount, 2) }}
                </strong>

            </div>

        </div>

    </div>


    {{-- =====================================================
    PAYMENT DETAILS
    ====================================================== --}}

    @if($payment && $payment->count())

        <div class="section">

            <h3 class="section-title">
                Payment Details
            </h3>

            <table class="invoice-table payment-table">

                <thead>

                    <tr>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th>Amount</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($payment as $transaction)

                            <tr>

                                <td>
                                    {{ !empty($transaction->payment_date)
                        ? \Carbon\Carbon::parse($transaction->payment_date)->format('d M Y')
                        : '—'
                                            }}
                                </td>

                                <td>
                                    {{ ucfirst($transaction->payment_method ?? '—') }}
                                </td>

                                <td>
                                    {{ $transaction->transaction_id
                        ?? $transaction->utr_id
                        ?? '—'
                                            }}
                                </td>

                                <td>

                                    <span class="success">
                                        {{ ucfirst($transaction->status ?? '—') }}
                                    </span>

                                </td>

                                <td>
                                    ₹{{ number_format((float) ($transaction->amount ?? 0), 2) }}
                                </td>

                            </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif


    {{-- =====================================================
    TERMS & CONDITIONS
    ====================================================== --}}

    <div class="terms">

        <h3>
            Terms & Conditions
        </h3>

        <ol>

            <li>
                This {{ strtolower($documentTitle) }} is issued against
                the exhibition stall booking mentioned above.
            </li>

            <li>
                The stall booking is subject to the terms and conditions
                applicable to the respective exhibition/event.
            </li>

            <li>
                For an invoice, the amount received is considered against
                the corresponding booking ID.
            </li>

            <li>
                For a proforma invoice, payment is pending and the document
                is issued for payment/reference purposes only.
            </li>

            <li>
                Any additional services, branding, electricity, furniture,
                additional facilities or other requirements will be charged
                separately where applicable.
            </li>

            <li>
                Cancellation, refund and transfer of booking are subject to
                the applicable event terms and conditions.
            </li>

            <li>
                Any applicable taxes are included as shown in the price
                breakdown above.
            </li>

            <li>
                Please retain this document for your records and quote the
                booking ID for any future correspondence.
            </li>

        </ol>

    </div>


    {{-- =====================================================
    FOOTER
    ====================================================== --}}

    <div class="invoice-footer">

        <div>

            <strong>
                Thank you for your business.
            </strong>

            <p>
                For any queries, please contact
                info@spheretravelmedia.com
            </p>

        </div>

        <div class="footer-company">
            Sphere Travelmedia & Exhibitions
        </div>

    </div>


    {{-- =====================================================
    PRINT BUTTON
    ====================================================== --}}

    <div class="print-area">

        <button type="button" id="printInvoice">
            Print / Save PDF
        </button>

    </div>

</div>


<script>
    (function () {

        document.addEventListener('click', function (event) {

            const button = event.target.closest('#printInvoice');

            if (!button) {
                return;
            }

            event.preventDefault();

            requestAnimationFrame(function () {

                setTimeout(function () {

                    window.focus();
                    window.print();

                }, 100);

            });

        });

    })();
</script>


<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        background: #f2f3f5;
        color: #222;
        font-family: Arial, Helvetica, sans-serif;
    }


    .invoice-wrapper {
        width: 900px;
        max-width: calc(100% - 30px);
        margin: 30px auto;
        background: #fff;
        padding: 45px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, .08);
    }


    /* =====================================================
       HEADER
    ====================================================== */

    .invoice-header {
        display: flex;
        justify-content: space-between;
        gap: 30px;
        padding-bottom: 25px;
        border-bottom: 2px solid #222;
    }


    .company-header {
        display: flex;
        gap: 18px;
        align-items: flex-start;
    }


    .company-logo {
        width: 150px;
        height: auto;
        object-fit: contain;
    }


    .company-details h2 {
        margin: 0 0 8px;
        font-size: 17px;
        font-weight: 700;
    }


    .company-details p {
        margin: 3px 0;
        font-size: 11px;
        color: #666;
        line-height: 1.5;
    }


    /* =====================================================
       DOCUMENT TITLE
    ====================================================== */

    .invoice-title {
        text-align: right;
        min-width: 230px;
    }


    .invoice-title h1 {
        margin: 0 0 10px;
        font-size: 25px;
        letter-spacing: 1px;
    }


    .invoice-number,
    .invoice-date {
        font-size: 11px;
        color: #666;
        margin-bottom: 5px;
    }


    .invoice-number strong,
    .invoice-date strong {
        color: #222;
    }


    .invoice-status {
        display: inline-block;
        margin-top: 8px;
        padding: 5px 10px;
        border-radius: 3px;
        font-size: 10px;
        font-weight: 700;
    }


    .invoice-status.paid {
        color: #18763a;
        background: #eaf7ef;
    }


    .invoice-status.pending {
        color: #986b00;
        background: #fff4d6;
    }


    .invoice-status.partial {
        color: #2563a6;
        background: #eaf3ff;
    }


    /* =====================================================
       BILL TO
    ====================================================== */

    .bill-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 25px;
    }


    .bill-box {
        border: 1px solid #e2e2e2;
        padding: 16px;
        min-height: 130px;
    }


    .section-label {
        color: #888;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }


    .bill-box h3 {
        margin: 0 0 8px;
        font-size: 14px;
    }


    .bill-box p {
        margin: 3px 0;
        color: #666;
        font-size: 11px;
        line-height: 1.5;
    }


    /* =====================================================
       EVENT SUMMARY
    ====================================================== */

    .event-summary {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        margin-top: 20px;
        border: 1px solid #ddd;
    }


    .event-summary>div {
        padding: 12px;
        border-right: 1px solid #ddd;
    }


    .event-summary>div:last-child {
        border-right: none;
    }


    .event-summary span {
        display: block;
        font-size: 9px;
        color: #888;
        margin-bottom: 5px;
        font-weight: 600;
    }


    .event-summary strong {
        display: block;
        font-size: 11px;
    }


    /* =====================================================
       SECTION
    ====================================================== */

    .section {
        margin-top: 28px;
    }


    .section-title {
        margin: 0 0 10px;
        font-size: 14px;
        font-weight: 700;
    }


    /* =====================================================
       TABLE
    ====================================================== */

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
    }


    .invoice-table th {
        padding: 10px;
        background: #f7f7f7;
        border: 1px solid #ddd;
        text-align: left;
        font-size: 10px;
        color: #555;
    }


    .invoice-table td {
        padding: 11px 10px;
        border: 1px solid #ddd;
        font-size: 11px;
    }


    .invoice-table th:not(:first-child),
    .invoice-table td:not(:first-child) {
        text-align: right;
    }


    .invoice-table td:first-child {
        text-align: left;
    }


    .invoice-table small {
        display: block;
        margin-top: 4px;
        color: #888;
        font-size: 9px;
    }


    .discount {
        color: #c0392b !important;
    }


    /* =====================================================
       TOTAL
    ====================================================== */

    .amount-section {
        display: flex;
        justify-content: flex-end;
        margin-top: 15px;
    }


    .amount-box {
        width: 330px;
    }


    .amount-box>div {
        display: flex;
        justify-content: space-between;
        padding: 7px 0;
        font-size: 11px;
        border-bottom: 1px solid #eee;
    }


    .amount-box span {
        color: #666;
    }


    .amount-box strong {
        color: #222;
    }


    .grand-total {
        padding: 12px 0 !important;
        font-size: 14px !important;
        border-bottom: 2px solid #222 !important;
    }


    .grand-total strong {
        font-size: 15px;
    }


    .paid-row strong {
        color: #18763a;
    }


    .due-row strong {
        color: #c0392b;
    }


    /* =====================================================
       PAYMENT
    ====================================================== */

    .payment-table .success {
        color: #18763a;
        font-weight: 600;
    }


    /* =====================================================
       TERMS
    ====================================================== */

    .terms {
        margin-top: 35px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
    }


    .terms h3 {
        margin: 0 0 10px;
        font-size: 13px;
    }


    .terms ol {
        margin: 0;
        padding-left: 18px;
    }


    .terms li {
        margin-bottom: 5px;
        color: #666;
        font-size: 10px;
        line-height: 1.5;
    }


    /* =====================================================
       FOOTER
    ====================================================== */

    .invoice-footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 30px;
        padding-top: 18px;
        border-top: 1px solid #ddd;
    }


    .invoice-footer strong {
        font-size: 11px;
    }


    .invoice-footer p {
        margin: 5px 0 0;
        font-size: 9px;
        color: #888;
    }


    .footer-company {
        font-size: 10px;
        color: #555;
    }


    /* =====================================================
       PRINT
    ====================================================== */

    .print-area {
        text-align: center;
        margin-top: 30px;
    }


    .print-area button {
        border: none;
        background: #222;
        color: white;
        padding: 10px 18px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 11px;
    }


    @media print {

        @page {
            size: A4;
            margin: 12mm;
        }


        body {
            background: white;
        }


        .invoice-wrapper {
            width: 100%;
            max-width: none;
            margin: 0;
            padding: 0;
            box-shadow: none;
        }


        .print-area {
            display: none;
        }

    }


    /* =====================================================
       MOBILE
    ====================================================== */

    @media(max-width: 700px) {

        .invoice-wrapper {
            padding: 20px;
        }


        .invoice-header {
            flex-direction: column;
        }


        .invoice-title {
            text-align: left;
        }


        .bill-section,
        .event-summary {
            grid-template-columns: 1fr;
        }


        .event-summary>div {
            border-right: none;
            border-bottom: 1px solid #ddd;
        }


        .event-summary>div:last-child {
            border-bottom: none;
        }

    }
</style>