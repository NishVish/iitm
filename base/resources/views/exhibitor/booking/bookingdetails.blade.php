@include('exhibitor.booking.booking.bookingcss')

<div class="sb-wrapper">
    <div class="sb-card">

        <div class="sb-card-header">
            <h4 class="sb-card-title">Stall Space Selection</h4>
        </div>

        @php
            $currentBookingId = $bookingdata->booking_id
                ?? $booking_id
                ?? request()->segment(count(request()->segments()));
        @endphp

        <form action="{{ route('updateStallBooking') }}" method="POST" id="bookingForm">
            @csrf

            <input
                type="hidden"
                name="booking_id"
                value="{{ $currentBookingId }}">

            <div class="sb-table-responsive">
                <table class="sb-table" id="stallTable">

                    <thead>
                        <tr>
                            <th style="min-width: 200px;">Location / Event</th>
                            <th style="width: 110px;">Space</th>
                            <th style="width: 120px;">Price</th>
                            <th style="width: 130px;">Total</th>
                            <th style="width: 80px; text-align: center;">Action</th>
                        </tr>
                    </thead>

                    <tbody id="stallRows">

                        @if(isset($stall) && is_iterable($stall) && count($stall))

                            @foreach($stall as $index => $bookingStall)

                                @php
                                    $currentBookingId = $bookingStall->booking_id ?? $bookingdata->booking_id ?? $booking_id ?? '';
                                    $currentStallId = $bookingStall->id ?? '';

                                    $currentEventId = $bookingStall->event_id ?? '';
                                    $currentEventName = $bookingStall->event_name ?? '';
                                    $currentPrice = (float) ($bookingStall->stall_price ?? 0);
                                    $currentSpace = $bookingStall->stall_size ?? '';
                                    $currentLocation = $bookingStall->stall_location ?? '';
                                    $currentType = $bookingStall->stall_type ?? '';
                                @endphp

                                <tr class="stall-row">

                                    {{-- Hidden booking ID for this existing stall --}}
                                    <input
                                        type="hidden"
                                        name="stalls[{{ $index }}][booking_id]"
                                        value="{{ $currentBookingId }}">

                                    {{-- Existing stall record ID --}}
                                    @if($currentStallId)
                                        <input
                                            type="hidden"
                                            name="stalls[{{ $index }}][stall_id]"
                                            value="{{ $currentStallId }}">
                                    @endif

                                    <td>
                                        <select
                                            name="stalls[{{ $index }}][event_id]"
                                            class="sb-select event-select"
                                            onchange="calculateRow(this)"
                                            required>

                                            <option value="">Select Event</option>

                                            @if(isset($eventsdata) && is_iterable($eventsdata))

                                                @foreach($eventsdata as $event)

                                                    <option
                                                        value="{{ $event->event_id }}"
                                                        data-price="{{ $event->stall_price ?? 0 }}"
                                                        {{ (string) $currentEventId === (string) ($event->event_id ?? '') ? 'selected' : '' }}>

                                                        {{ $event->name ?? $event->event_name ?? ('Event #' . ($event->event_id ?? '')) }}

                                                    </option>

                                                @endforeach

                                            @endif

                                            @if(
                                                $currentEventId &&
                                                !collect($eventsdata ?? [])->contains(function ($event) use ($currentEventId) {
                                                    return (string) ($event->event_id ?? '') === (string) $currentEventId;
                                                })
                                            )

                                                <option
                                                    value="{{ $currentEventId }}"
                                                    data-price="{{ $currentPrice }}"
                                                    selected>

                                                    {{ $currentEventName ?: 'Event #' . $currentEventId }}

                                                </option>

                                            @endif

                                        </select>
                                    </td>

                                    <td>
                                        <input
                                            type="text"
                                            name="stalls[{{ $index }}][stall_size]"
                                            class="sb-input space-input"
                                            value="{{ $currentSpace }}"
                                            inputmode="decimal"
                                            placeholder="Sq. Mtr"
                                            oninput="calculateRow(this)"
                                            required>
                                    </td>

                                   
                                   

                                    <td>
                                        <input
                                            type="text"
                                            class="sb-input price-input"
                                            value="{{ $currentPrice > 0 ? '₹' . number_format($currentPrice, 2) : '' }}"
                                            readonly>

                                        <input
                                            type="hidden"
                                            name="stalls[{{ $index }}][stall_price]"
                                            class="price-hidden"
                                            value="{{ $currentPrice }}">
                                    </td>

                                    <td>
                                        <input
                                            type="text"
                                          
                                          name="stalls[{{ $index }}][original_amount]"  class="sb-input total-input sb-total-input"
                                            readonly>
                                    </td>



                                    <td style="text-align: center;">
                                        <button
                                            type="button"
                                            class="sb-btn sb-btn-danger remove-row"
                                            onclick="removeRow(this)">
                                            Remove
                                        </button>
                                    </td>

                                </tr>

                            @endforeach

                        @else

                            <tr class="stall-row">

                                {{-- Hidden booking ID for the initial new stall --}}
                                <input
                                    type="hidden"
                                    name="stalls[0][booking_id]"
                                    value="{{ $currentBookingId }}">

                                <td>
                                    <select
                                        name="stalls[0][event_id]"
                                        class="sb-select event-select"
                                        onchange="calculateRow(this)"
                                        required>

                                        <option value="">Select Event</option>

                                        @if(isset($eventsdata) && is_iterable($eventsdata))

                                            @foreach($eventsdata as $event)

                                                <option
                                                    value="{{ $event->event_id }}"
                                                    data-price="{{ $event->stall_price ?? 0 }}">

                                                    {{ $event->name ?? $event->event_name ?? ('Event #' . ($event->event_id ?? '')) }}

                                                </option>

                                            @endforeach

                                        @endif

                                    </select>
                                </td>

                                <td>
                                    <input
                                        type="text"
                                        name="stalls[0][stall_size]"
                                        class="sb-input space-input"
                                        inputmode="decimal"
                                        placeholder="Sq. Mtr"
                                        oninput="calculateRow(this)"
                                        required>
                                </td>

                                

                                

                                <td>
                                    <input
                                        type="text"
                                        class="sb-input price-input"
                                        readonly>

                                    <input
                                        type="hidden"
                                        name="stalls[0][stall_price]"
                                        class="price-hidden"
                                        value="0">
                                </td>

                                <td>
                                    <input
                                        type="text"
                                        class="sb-input total-input sb-total-input"
                                        readonly>
                                </td>

                                <td style="text-align: center;">
                                    <button
                                        type="button"
                                        class="sb-btn sb-btn-danger remove-row"
                                        onclick="removeRow(this)">
                                        Remove
                                    </button>
                                </td>

                            </tr>

                        @endif

                    </tbody>

                    <tfoot>
                        
                        <td>
                            <label for="discount_code">Discount Code :</label>
                                        <input
                                            type="text"
                                          
                                          name="discount_code"  class=""
                                          >
                                    </td>
                        <tr style="background-color: #f9fafb;">

                            <td
                                colspan="5"
                                style="text-align: right; font-weight: 700; color: #111827;">
                                Grand Total
                            </td>

                            <td>
                                <input
                                    type="text"
                                    id="grandTotal"
                                    class="sb-input sb-total-input"
                                    style="font-size: 1rem; border-color: #4f46e5;"
                                    value="₹0.00"
                                    readonly>
                            </td>

                            <td></td>

                        </tr>
                    </tfoot>

                </table>
            </div>

            <div class="sb-footer-actions">

                <button
                    type="button"
                    class="sb-btn sb-btn-primary"
                    onclick="addRow()">
                    + Add Stall
                </button>

                <button
                    type="submit"
                    class="sb-btn sb-btn-success">
                    Save Booking
                </button>

            </div>

        </form>

    </div>
</div>

@include('exhibitor.booking.booking.bookingscript')