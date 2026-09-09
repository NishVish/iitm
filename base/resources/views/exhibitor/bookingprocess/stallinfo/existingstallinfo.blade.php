<style>
    .stall-table-wrapper {
        width: 100%;
        overflow-x: auto;
        margin-bottom: 20px;
    }

    .stall-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
        background: #fff;
    }

    .stall-table th,
    .stall-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
        vertical-align: middle;
        white-space: nowrap;
    }

    .stall-table th {
        background: #f5f5f5;
        font-weight: 600;
        color: #333;
    }

    .stall-table tbody tr:nth-child(even) {
        background: #fafafa;
    }

    .stall-table input,
    .stall-table select {
        width: 100%;
        min-width: 100px;
        min-height: 36px;
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
        font-weight: 600;
    }

    .stall-table .stall-total-display {
        font-weight: 700;
        color: #198754;
    }

    .stall-table .remove-stall-btn {
        border: 0;
        background: #dc3545;
        color: #fff;
        padding: 7px 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    .stall-table .remove-stall-btn:hover {
        background: #bb2d3b;
    }

    #no-stalls {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: #f8f9fa;
        color: #666;
    }
</style>

<div class="stall-table-wrapper">

    <table class="stall-table">

        <thead>
            <tr>
                <th>Stall No.</th>
                <th>Event</th>
                <th>Stall Price / Sq.Ft</th>
                <th>Stall Size</th>
                <th>Original Price</th>
                <th>Discount Amount</th>
                <th>GST Amount (18%)</th>
                <th>Final Price</th>
                <th>Stall Total</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($bookingdata->stalls as $index => $stall)

                <tr class="stall-card">

                    {{-- HIDDEN VALUES --}}
                    <input type="hidden"
                        name="stalls[{{ $index }}][stall_id]"
                        value="{{ $stall['stall_id'] ?? '' }}">

                    <input type="hidden"
                        name="stalls[{{ $index }}][booking_id]"
                        value="{{ $stall['booking_id'] ?? $bookingdata->booking_id }}">

                    <input type="hidden"
                        name="stalls[{{ $index }}][original_amount]"
                        class="original-amount"
                        value="{{ $stall['original_amount'] ?? 0 }}">

                    <input type="hidden"
                        name="stalls[{{ $index }}][discount_code]"
                        value="{{ $stall['discount_code'] ?? '' }}">

                    <input type="hidden"
                        name="stalls[{{ $index }}][branding]"
                        value="{{ $stall['branding'] ?? 0 }}">


                    {{-- STALL NUMBER --}}
                    <td>
                        <span class="stall-number">
                            {{ $index + 1 }}
                        </span>
                    </td>


                    {{-- EVENT --}}
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


                    {{-- STALL PRICE --}}
                    <td>
                        <input
                            type="number"
                            step="0.01"
                            class="stall-price"
                            name="stalls[{{ $index }}][stall_price]"
                            value="{{ $stall['stall_price'] ?? 0 }}"
                            readonly>
                    </td>


                    {{-- STALL SIZE --}}
                    <td>
                        <input
                            type="text"
                            class="stall-size"
                            name="stalls[{{ $index }}][stall_size]"
                            value="{{ $stall['stall_size'] ?? '' }}"
                            placeholder="e.g. 10x20">
                    </td>


                    {{-- ORIGINAL PRICE --}}
                    <td>
                        <input
                            type="number"
                            step="0.01"
                            class="original-price"
                            name="stalls[{{ $index }}][original_price]"
                            value="{{ $stall['original_amount'] ?? 0 }}"
                            readonly>
                    </td>


                    {{-- DISCOUNT --}}
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
                                type="number"
                                step="0.01"
                                min="0"
                                class="discount-price"
                                name="stalls[{{ $index }}][discount_amount]"
                                value="{{ $stall['discount_amount'] ?? 0 }}"
                                readonly>

                        @endif

                    </td>


                    {{-- GST --}}
                    <td>
                        <input
                            type="number"
                            step="0.01"
                            class="gst-price"
                            name="stalls[{{ $index }}][gst_amount]"
                            value="{{ $stall['gst_amount'] ?? 0 }}"
                            readonly>
                    </td>


                    {{-- FINAL PRICE --}}
                    <td>
                        <input
                            type="number"
                            step="0.01"
                            class="final-price"
                            name="stalls[{{ $index }}][final_price]"
                            value="{{ $stall['final_price'] ?? 0 }}"
                            readonly>
                    </td>


                    {{-- STALL TOTAL --}}
                    <td>
                        <span class="stall-total-display">
                            {{ number_format($stall['final_price'] ?? 0, 2) }}
                        </span>
                    </td>


                    {{-- ACTION --}}
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

                <tr id="no-stalls">
                    <td colspan="10">
                        No existing stalls found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>
