
{{-- =====================================================
BOOKING RECORD
====================================================== --}}
<div>

    <style>
        .stall-table-wrapper {
            width: 100%;
            overflow-x: auto;
            margin-top: 15px;
            margin-bottom: 25px;
        }

        .stall-table {
            width: 100%;
            min-width: 1000px;
            border-collapse: collapse;
            background: #fff;
        }

        .stall-table th,
        .stall-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            vertical-align: middle;
        }

        .stall-table th {
            background: #f5f5f5;
            color: #333;
            font-weight: 600;
            white-space: nowrap;
        }

        .stall-table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .stall-table tbody tr:hover {
            background: #f8fbff;
        }

        .stall-table input,
        .stall-table select {
            width: 100%;
            min-width: 100px;
            height: 38px;
            padding: 7px 9px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background: #fff;
        }

        .stall-table input[readonly] {
            background: #f3f3f3;
            color: #555;
        }

        .stall-table .stall-number {
            display: inline-block;
            min-width: 25px;
            font-weight: 600;
            text-align: center;
        }

        .stall-table .stall-total-display {
            font-weight: 700;
            color: #198754;
            white-space: nowrap;
        }

        .stall-table .remove-stall-btn {
            border: 0;
            background: #dc3545;
            color: #fff;
            padding: 7px 12px;
            border-radius: 4px;
            cursor: pointer;
            white-space: nowrap;
        }

        .stall-table .remove-stall-btn:hover {
            background: #bb2d3b;
        }

        .stall-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .stall-header h4 {
            margin: 0;
        }

        .add-stall-btn {
            border: 0;
            background: #198754;
            color: #fff;
            padding: 8px 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-stall-btn:hover {
            background: #157347;
        }

        .booking-summary {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
        }

        .booking-summary h4 {
            margin-top: 0;
            margin-bottom: 15px;
        }

        .summary-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .summary-row label {
            width: 180px;
            font-weight: 600;
        }

        .summary-row input {
            width: 250px;
            height: 38px;
            padding: 7px 9px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .save-booking-wrapper {
            margin-top: 20px;
        }

        .save-booking-btn {
            border: 0;
            background: #0d6efd;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .save-booking-btn:hover {
            background: #0b5ed7;
        }

        .show-summary-wrapper {
            margin-top: 15px;
        }

        .show-summary-wrapper a {
            color: #0d6efd;
            text-decoration: none;
        }

        .show-summary-wrapper a:hover {
            text-decoration: underline;
        }

        .no-stalls-row td {
            text-align: center;
            padding: 20px;
            color: #666;
            background: #f8f9fa;
        }

        @media (max-width: 768px) {

            .summary-row {
                display: block;
            }

            .summary-row label {
                display: block;
                width: 100%;
                margin-bottom: 5px;
            }

            .summary-row input {
                width: 100%;
            }
        }
    </style>


    <form action="{{ url('updateStallBooking') }}" method="POST">

        @csrf


        {{-- =====================================================
        BOOKING HIDDEN DATA
        ====================================================== --}}

        <input
            type="hidden"
            name="booking_id"
            value="{{ $bookingdata->booking_id ?? '' }}">

        <input
            type="hidden"
            name="company_id"
            value="{{ $bookingdata->company_id ?? '' }}">

        <input
            type="hidden"
            name="billing_contact_id"
            value="{{ $bookingdata->billing_contact_id ?? '' }}">

        <input
            type="hidden"
            name="sales_id"
            value="{{ $bookingdata->sales_id ?? '' }}">

        <input
            type="hidden"
            name="allow_edit"
            value="{{ $bookingdata->allow_edit ?? 0 }}">


        @php
            $segments = request()->segments();
            $third_last_segment = $segments[count($segments) - 3] ?? null;
            $is_sales = $third_last_segment === 'sales';
        @endphp


        {{-- =====================================================
        STALL HEADER
        ====================================================== --}}

        <div class="stall-header">

            <h4>
                Stalls
            </h4>

            <button
                type="button"
                class="add-stall-btn"
                onclick="addStall()">

                + Add Stall

            </button>

        </div>


        {{-- =====================================================
        STALL TABLE
        ====================================================== --}}

        <div class="stall-table-wrapper">

            <table class="stall-table">

                <thead>

                    <tr>

                        <th>
                            Stall No.
                        </th>

                        <th>
                            Event
                        </th>

                        <th>
                            Stall Price / Sq.Ft
                        </th>

                        <th>
                            Stall Size
                        </th>

                        <th>
                            Original Price
                        </th>

                        <th>
                            Discount Amount
                        </th>

                        <th>
                            GST Amount (18%)
                        </th>

                        <th>
                            Final Price
                        </th>

                        <th>
                            Stall Total
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody id="stall-body">

                    @forelse($bookingdata->stalls as $index => $stall)

                        <tr class="stall-card">

                            {{-- =====================================================
                            HIDDEN VALUES
                            ====================================================== --}}

                            <td>

                                <span class="stall-number">
                                    {{ $index + 1 }}
                                </span>


                                <input
                                    type="hidden"
                                    name="stalls[{{ $index }}][stall_id]"
                                    value="{{ $stall['stall_id'] ?? '' }}">


                                <input
                                    type="hidden"
                                    name="stalls[{{ $index }}][booking_id]"
                                    value="{{ $stall['booking_id'] ?? $bookingdata->booking_id }}">


                                <input
                                    type="hidden"
                                    name="stalls[{{ $index }}][original_amount]"
                                    class="original-amount"
                                    value="{{ $stall['original_amount'] ?? 0 }}">


                                <input
                                    type="hidden"
                                    name="stalls[{{ $index }}][discount_code]"
                                    value="{{ $stall['discount_code'] ?? '' }}">


                                <input
                                    type="hidden"
                                    name="stalls[{{ $index }}][branding]"
                                    value="{{ $stall['branding'] ?? 0 }}">

                            </td>


                            {{-- =====================================================
                            EVENT
                            ====================================================== --}}

                            <td>

                                <select
                                    class="event-select"
                                    name="stalls[{{ $index }}][event_id]"
                                    required>

                                    <option value="">
                                        -- Select Event --
                                    </option>

                                    @foreach($eventsdata as $event)

                                        @if(!empty($event->name))

                                            <option
                                                value="{{ $event->event_id }}"
                                                data-price="{{ $event->stall_price ?? 0 }}"
                                                {{ ($stall['event_id'] ?? null) == $event->event_id ? 'selected' : '' }}>

                                                {{ $event->name }}

                                            </option>

                                        @endif

                                    @endforeach

                                </select>

                            </td>


                            {{-- =====================================================
                            STALL PRICE
                            ====================================================== --}}

                            <td>

                                <input
                                    type="number"
                                    step="0.01"
                                    class="stall-price"
                                    name="stalls[{{ $index }}][stall_price]"
                                    value="{{ $stall['stall_price'] ?? 0 }}"
                                    readonly>

                            </td>


                            {{-- =====================================================
                            STALL SIZE
                            ====================================================== --}}

                            <td>

                                <input
                                    type="text"
                                    class="stall-size"
                                    name="stalls[{{ $index }}][stall_size]"
                                    value="{{ $stall['stall_size'] ?? '' }}"
                                    placeholder="e.g. 10x20">

                            </td>


                            {{-- =====================================================
                            ORIGINAL PRICE
                            ====================================================== --}}

                            <td>

                                <input
                                    type="number"
                                    step="0.01"
                                    class="original-price"
                                    name="stalls[{{ $index }}][original_price]"
                                    value="{{ $stall['original_price'] ?? ($stall['original_amount'] ?? 0) }}"
                                    readonly>

                            </td>


                            {{-- =====================================================
                            DISCOUNT
                            ====================================================== --}}

                            <td>

                                @if($is_sales)

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        class="discount-price"
                                        name="stalls[{{ $index }}][discount_amount]"
                                        value="{{ $stall['discount_amount'] ?? 0 }}">

                                @else

                                    <input
                                        type="hidden"
                                        class="discount-price"
                                        name="stalls[{{ $index }}][discount_amount]"
                                        value="{{ $stall['discount_amount'] ?? 0 }}">

                                    <span>
                                        {{ number_format($stall['discount_amount'] ?? 0, 2) }}
                                    </span>

                                @endif

                            </td>


                            {{-- =====================================================
                            GST
                            ====================================================== --}}

                            <td>

                                <input
                                    type="number"
                                    step="0.01"
                                    class="gst-price"
                                    name="stalls[{{ $index }}][gst_amount]"
                                    value="{{ $stall['gst_amount'] ?? 0 }}"
                                    readonly>

                            </td>


                            {{-- =====================================================
                            FINAL PRICE
                            ====================================================== --}}

                            <td>

                                <input
                                    type="number"
                                    step="0.01"
                                    class="final-price"
                                    name="stalls[{{ $index }}][final_price]"
                                    value="{{ $stall['final_price'] ?? 0 }}"
                                    readonly>

                            </td>


                            {{-- =====================================================
                            STALL TOTAL
                            ====================================================== --}}

                            <td>

                                <span class="stall-total-display">
                                    {{ number_format($stall['final_price'] ?? 0, 2) }}
                                </span>

                            </td>


                            {{-- =====================================================
                            ACTION
                            ====================================================== --}}

                            <td>

                                <button
                                    type="button"
                                    class="remove-stall-btn"
                                    onclick="removeStall(this)">

                                    Remove

                                </button>

                            </td>

                        </tr>

                    @empty

                        <tr id="no-stalls" class="no-stalls-row">

                            <td colspan="10">
                                No existing stalls found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
        BOOKING SUMMARY
        ====================================================== --}}

        <div class="booking-summary">

            <h4>
                Booking Summary
            </h4>


            <div class="summary-row">

                <label>
                    Total Amount
                </label>

                <input
                    type="number"
                    step="0.01"
                    id="total-amount"
                    value="0"
                    readonly>

            </div>


            <div class="summary-row">

                <label>
                    SGST (9%)
                </label>

                <input
                    type="number"
                    step="0.01"
                    id="sgst"
                    value="0"
                    readonly>

            </div>


            <div class="summary-row">

                <label>
                    CGST (9%)
                </label>

                <input
                    type="number"
                    step="0.01"
                    id="cgst"
                    value="0"
                    readonly>

            </div>


            <div class="summary-row">

                <label>
                    GST (18%)
                </label>

                <input
                    type="number"
                    step="0.01"
                    id="gst"
                    value="0"
                    readonly>

            </div>


            <div class="summary-row">

                <label>
                    Discount
                </label>

                <input
                    type="number"
                    step="0.01"
                    id="discount"
                    name="discount"
                    value="0"
                    readonly>

            </div>


            <div class="summary-row">

                <label>
                    Grand Total
                </label>

                <input
                    type="number"
                    step="0.01"
                    name="grandtotal"
                    id="grand-total"
                    value="0"
                    readonly>

            </div>

        </div>


        {{-- =====================================================
        SAVE
        ====================================================== --}}

        <div class="save-booking-wrapper">

            <button
                type="submit"
                class="save-booking-btn">

                Save Booking

            </button>

        </div>

    </form>


    {{-- =====================================================
    SHOW SUMMARY
    ====================================================== --}}

    <div class="show-summary-wrapper">

        <a href="{{ url('sales/bookingsummary/' . $bookingdata->booking_id) }}">

            Show Summary

        </a>

    </div>


    <script>

        /*
        |--------------------------------------------------------------------------
        | EVENT DATA
        |--------------------------------------------------------------------------
        */

        const eventData = @json(
            $eventsdata
                ->filter(fn($event) => !empty($event->name))
                ->map(fn($event) => [
                    'event_id' => $event->event_id,
                    'name' => $event->name,
                    'stall_price' => $event->stall_price ?? 0
                ])
                ->values()
        );


        /*
        |--------------------------------------------------------------------------
        | USER TYPE
        |--------------------------------------------------------------------------
        */

        const isSales = @json($is_sales);


        /*
        |--------------------------------------------------------------------------
        | STALL INDEX
        |--------------------------------------------------------------------------
        */

        let stallIndex = {{ is_countable($bookingdata->stalls ?? []) ? count($bookingdata->stalls ?? []) : 0 }};


        /*
        |--------------------------------------------------------------------------
        | GST
        |--------------------------------------------------------------------------
        */

        const GST_RATE = 0.18;
        const SGST_RATE = 0.09;
        const CGST_RATE = 0.09;


        /*
        |--------------------------------------------------------------------------
        | EVENT OPTIONS
        |--------------------------------------------------------------------------
        */

        function eventOptions() {

            return `
                <option value="">
                    -- Select Event --
                </option>

                ${eventData.map(e => `

                    <option
                        value="${escapeHtml(e.event_id)}"
                        data-price="${escapeHtml(e.stall_price)}">

                        ${escapeHtml(e.name)}

                    </option>

                `).join('')}
            `;

        }


        /*
        |--------------------------------------------------------------------------
        | ADD STALL
        |--------------------------------------------------------------------------
        */

        function addStall() {

            const i = stallIndex++;


            const discountFieldHtml = isSales

                ? `
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        class="discount-price"
                        name="stalls[${i}][discount_amount]"
                        value="0">
                  `

                : `
                    <input
                        type="hidden"
                        class="discount-price"
                        name="stalls[${i}][discount_amount]"
                        value="0">

                    <span>
                        0.00
                    </span>
                  `;


            const stall = `

                <tr class="stall-card">

                    <td>

                        <span class="stall-number">
                            ${i + 1}
                        </span>


                        <input
                            type="hidden"
                            name="stalls[${i}][stall_id]"
                            value="">


                        <input
                            type="hidden"
                            name="stalls[${i}][booking_id]"
                            value="{{ $bookingdata->booking_id ?? '' }}">


                        <input
                            type="hidden"
                            name="stalls[${i}][original_amount]"
                            class="original-amount"
                            value="0">


                        <input
                            type="hidden"
                            name="stalls[${i}][discount_code]"
                            value="">


                        <input
                            type="hidden"
                            name="stalls[${i}][branding]"
                            value="0">

                    </td>


                    <td>

                        <select
                            class="event-select"
                            name="stalls[${i}][event_id]"
                            required>

                            ${eventOptions()}

                        </select>

                    </td>


                    <td>

                        <input
                            type="number"
                            step="0.01"
                            class="stall-price"
                            name="stalls[${i}][stall_price]"
                            value="0"
                            readonly>

                    </td>


                    <td>

                        <input
                            type="text"
                            class="stall-size"
                            name="stalls[${i}][stall_size]"
                            value=""
                            placeholder="e.g. 10x20">

                    </td>


                    <td>

                        <input
                            type="number"
                            step="0.01"
                            class="original-price"
                            name="stalls[${i}][original_price]"
                            value="0"
                            readonly>

                    </td>


                    <td>

                        ${discountFieldHtml}

                    </td>


                    <td>

                        <input
                            type="number"
                            step="0.01"
                            class="gst-price"
                            name="stalls[${i}][gst_amount]"
                            value="0"
                            readonly>

                    </td>


                    <td>

                        <input
                            type="number"
                            step="0.01"
                            class="final-price"
                            name="stalls[${i}][final_price]"
                            value="0"
                            readonly>

                    </td>


                    <td>

                        <span class="stall-total-display">
                            0.00
                        </span>

                    </td>


                    <td>

                        <button
                            type="button"
                            class="remove-stall-btn"
                            onclick="removeStall(this)">

                            Remove

                        </button>

                    </td>

                </tr>

            `;


            const noStalls =
                document.getElementById('no-stalls');


            if (noStalls) {
                noStalls.remove();
            }


            const stallBody =
                document.getElementById('stall-body');


            if (stallBody) {

                stallBody.insertAdjacentHTML(
                    'beforeend',
                    stall
                );

            }


            updateNumbers();

            updateTotals();

        }


        /*
        |--------------------------------------------------------------------------
        | EVENT CHANGE
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'change',
            function (e) {

                if (
                    !e.target.classList.contains(
                        'event-select'
                    )
                ) {
                    return;
                }


                const stall =
                    e.target.closest(
                        '.stall-card'
                    );


                if (!stall) {
                    return;
                }


                const option =
                    e.target.options[
                        e.target.selectedIndex
                    ];


                const price =
                    parseFloat(
                        option?.dataset.price || 0
                    );


                const priceInput =
                    stall.querySelector(
                        '.stall-price'
                    );


                if (priceInput) {

                    priceInput.value =
                        price.toFixed(2);

                }


                calculateRow(stall);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | SIZE / DISCOUNT CHANGE
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'input',
            function (e) {

                if (
                    e.target.classList.contains(
                        'stall-size'
                    ) ||
                    e.target.classList.contains(
                        'discount-price'
                    )
                ) {

                    const stall =
                        e.target.closest(
                            '.stall-card'
                        );


                    if (stall) {

                        calculateRow(
                            stall
                        );

                    }

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | CALCULATE ROW
        |--------------------------------------------------------------------------
        */

        function calculateRow(stall) {

            if (!stall) {
                return;
            }


            const priceInput =
                stall.querySelector(
                    '.stall-price'
                );


            const sizeInput =
                stall.querySelector(
                    '.stall-size'
                );


            const originalInput =
                stall.querySelector(
                    '.original-price'
                );


            const originalHidden =
                stall.querySelector(
                    '.original-amount'
                );


            const discountInput =
                stall.querySelector(
                    '.discount-price'
                );


            const gstInput =
                stall.querySelector(
                    '.gst-price'
                );


            const finalInput =
                stall.querySelector(
                    '.final-price'
                );


            const stallTotal =
                stall.querySelector(
                    '.stall-total-display'
                );


            const price =
                parseFloat(
                    priceInput?.value || 0
                ) || 0;


            const size =
                parseSize(
                    sizeInput?.value || ''
                );


            const originalPrice =
                price * size;


            const discount =
                Math.max(
                    0,
                    parseFloat(
                        discountInput?.value || 0
                    ) || 0
                );


            const taxableAmount =
                Math.max(
                    0,
                    originalPrice - discount
                );


            const gst =
                taxableAmount * GST_RATE;


            const finalPrice =
                taxableAmount;


            const totalWithGst =
                finalPrice + gst;


            if (originalInput) {

                originalInput.value =
                    originalPrice.toFixed(2);

            }


            if (originalHidden) {

                originalHidden.value =
                    originalPrice.toFixed(2);

            }


            if (gstInput) {

                gstInput.value =
                    gst.toFixed(2);

            }


            if (finalInput) {

                finalInput.value =
                    finalPrice.toFixed(2);

            }


            if (stallTotal) {

                stallTotal.textContent =
                    totalWithGst.toFixed(2);

            }


            updateTotals();

        }


        /*
        |--------------------------------------------------------------------------
        | PARSE SIZE
        |--------------------------------------------------------------------------
        */

        function parseSize(value) {

            value = String(value)
                .trim()
                .toLowerCase()
                .replace(/×/g, 'x')
                .replace(/\*/g, 'x')
                .replace(/\s+/g, '');


            if (!value) {
                return 0;
            }


            if (value.includes('x')) {

                const parts =
                    value.split('x');


                const width =
                    parseFloat(
                        parts[0]
                    ) || 0;


                const length =
                    parseFloat(
                        parts[1]
                    ) || 0;


                return width * length;

            }


            return parseFloat(value) || 0;

        }


        /*
        |--------------------------------------------------------------------------
        | REMOVE STALL
        |--------------------------------------------------------------------------
        */

        function removeStall(button) {

            const stall =
                button.closest(
                    '.stall-card'
                );


            if (stall) {
                stall.remove();
            }


            updateNumbers();


            const stalls =
                document.querySelectorAll(
                    '#stall-body .stall-card'
                );


            if (stalls.length === 0) {

                document
                    .getElementById(
                        'stall-body'
                    )
                    .innerHTML = `

                        <tr
                            id="no-stalls"
                            class="no-stalls-row">

                            <td colspan="10">
                                No existing stalls found.
                            </td>

                        </tr>

                    `;

            }


            updateTotals();

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE STALL NUMBERS
        |--------------------------------------------------------------------------
        */

        function updateNumbers() {

            document
                .querySelectorAll(
                    '#stall-body .stall-card'
                )
                .forEach(
                    (stall, index) => {

                        const number =
                            stall.querySelector(
                                '.stall-number'
                            );


                        if (number) {

                            number.textContent =
                                index + 1;

                        }

                    }
                );

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE TOTALS
        |--------------------------------------------------------------------------
        */

        function updateTotals() {

            let totalOriginal = 0;
            let totalDiscount = 0;
            let totalFinal = 0;
            let totalGst = 0;


            document
                .querySelectorAll(
                    '#stall-body .stall-card'
                )
                .forEach(
                    stall => {

                        const original =
                            parseFloat(
                                stall.querySelector(
                                    '.original-price'
                                )?.value || 0
                            ) || 0;


                        const discount =
                            Math.max(
                                0,
                                parseFloat(
                                    stall.querySelector(
                                        '.discount-price'
                                    )?.value || 0
                                ) || 0
                            );


                        const finalPrice =
                            Math.max(
                                0,
                                original - discount
                            );


                        const gst =
                            finalPrice * GST_RATE;


                        const totalWithGst =
                            finalPrice + gst;


                        totalOriginal +=
                            original;


                        totalDiscount +=
                            discount;


                        totalFinal +=
                            finalPrice;


                        totalGst +=
                            gst;


                        const gstInput =
                            stall.querySelector(
                                '.gst-price'
                            );


                        if (gstInput) {

                            gstInput.value =
                                gst.toFixed(2);

                        }


                        const finalInput =
                            stall.querySelector(
                                '.final-price'
                            );


                        if (finalInput) {

                            finalInput.value =
                                finalPrice.toFixed(2);

                        }


                        const stallTotal =
                            stall.querySelector(
                                '.stall-total-display'
                            );


                        if (stallTotal) {

                            stallTotal.textContent =
                                totalWithGst.toFixed(2);

                        }

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | GST SPLIT
            |--------------------------------------------------------------------------
            */

            const sgst =
                totalGst * SGST_RATE / GST_RATE;


            const cgst =
                totalGst * CGST_RATE / GST_RATE;


            /*
            |--------------------------------------------------------------------------
            | GRAND TOTAL
            |--------------------------------------------------------------------------
            */

            const grandTotal =
                totalFinal + totalGst;


            /*
            |--------------------------------------------------------------------------
            | TOTAL AMOUNT
            |--------------------------------------------------------------------------
            */

            const totalAmountElement =
                document.getElementById(
                    'total-amount'
                );


            if (totalAmountElement) {

                totalAmountElement.value =
                    totalFinal.toFixed(2);

            }


            /*
            |--------------------------------------------------------------------------
            | SGST
            |--------------------------------------------------------------------------
            */

            const sgstElement =
                document.getElementById(
                    'sgst'
                );


            if (sgstElement) {

                sgstElement.value =
                    sgst.toFixed(2);

            }


            /*
            |--------------------------------------------------------------------------
            | CGST
            |--------------------------------------------------------------------------
            */

            const cgstElement =
                document.getElementById(
                    'cgst'
                );


            if (cgstElement) {

                cgstElement.value =
                    cgst.toFixed(2);

            }


            /*
            |--------------------------------------------------------------------------
            | GST
            |--------------------------------------------------------------------------
            */

            const gstElement =
                document.getElementById(
                    'gst'
                );


            if (gstElement) {

                gstElement.value =
                    totalGst.toFixed(2);

            }


            /*
            |--------------------------------------------------------------------------
            | DISCOUNT
            |--------------------------------------------------------------------------
            */

            const discountElement =
                document.getElementById(
                    'discount'
                );


            if (discountElement) {

                discountElement.value =
                    totalDiscount.toFixed(2);

            }


            /*
            |--------------------------------------------------------------------------
            | GRAND TOTAL
            |--------------------------------------------------------------------------
            */

            const grandTotalElement =
                document.getElementById(
                    'grand-total'
                );


            if (grandTotalElement) {

                grandTotalElement.value =
                    grandTotal.toFixed(2);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | INITIAL LOAD
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                document
                    .querySelectorAll(
                        '#stall-body .stall-card'
                    )
                    .forEach(
                        stall => {

                            const selectedEvent =
                                stall.querySelector(
                                    '.event-select'
                                );


                            if (selectedEvent) {

                                const option =
                                    selectedEvent.options[
                                        selectedEvent.selectedIndex
                                    ];


                                const price =
                                    parseFloat(
                                        option?.dataset.price || 0
                                    ) || 0;


                                const priceInput =
                                    stall.querySelector(
                                        '.stall-price'
                                    );


                                if (
                                    priceInput &&
                                    price > 0
                                ) {

                                    priceInput.value =
                                        price.toFixed(2);

                                }

                            }


                            calculateRow(
                                stall
                            );

                        }
                    );


                updateNumbers();

                updateTotals();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | ESCAPE HTML
        |--------------------------------------------------------------------------
        */

        function escapeHtml(value) {

            return String(value)
                .replace(
                    /&/g,
                    '&amp;'
                )
                .replace(
                    /</g,
                    '&lt;'
                )
                .replace(
                    />/g,
                    '&gt;'
                )
                .replace(
                    /"/g,
                    '&quot;'
                )
                .replace(
                    /'/g,
                    '&#039;'
                );

        }

    </script>

</div>