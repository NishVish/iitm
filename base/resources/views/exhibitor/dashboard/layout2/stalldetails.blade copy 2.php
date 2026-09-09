<style>
    .stalls-table-wrapper {
        width: 100%;
        overflow-x: auto;
        border: 1px solid var(--line);
        border-radius: var(--radius);
        background: var(--panel);
    }

    .stalls-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }

    .stalls-table th,
    .stalls-table td {
        padding: 14px 16px;
        text-align: left;
        border-bottom: 1px solid var(--line);
        vertical-align: middle;
    }

    .stalls-table th {
        background: var(--ink);
        color: var(--paper);
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: .05em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .stalls-table td {
        font-size: 13px;
        color: var(--ink);
    }

    .stalls-table tbody tr:last-child td {
        border-bottom: none;
    }

    .stalls-table tbody tr:hover {
        background: var(--navy-bg);
    }

    .stall-name {
        font-weight: 700;
        font-family: 'Archivo', sans-serif;
    }

    .event-name {
        font-weight: 600;
    }

    .event-year {
        display: inline-block;
        margin-left: 6px;
        padding: 3px 7px;
        border-radius: 4px;
        background: var(--navy-bg);
        color: var(--navy);
        font-family: 'IBM Plex Mono', monospace;
        font-size: 10px;
    }

    .venue {
        color: var(--muted);
        line-height: 1.4;
        max-width: 240px;
    }

    .date {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px;
        white-space: nowrap;
    }

    .price {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px;
        white-space: nowrap;
    }

    .discount {
        color: var(--green);
    }

    .due-amount {
        font-weight: 600;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 500;
        padding: 6px 9px;
        border-radius: 5px;
        white-space: nowrap;
    }

    .status-pill.due {
        background: var(--red-bg);
        color: var(--red);
    }

    .status-pill.paid {
        background: var(--green-bg);
        color: var(--green);
    }

    .status-pill .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .empty-state {
        padding: 30px 20px;
        border: 1px solid var(--line);
        border-radius: var(--radius);
        background: var(--panel);
        color: var(--muted);
        font-size: 13px;
    }

    @media (max-width: 760px) {
        .stalls-table-wrapper {
            border-radius: var(--radius);
        }

        .stalls-table {
            min-width: 850px;
        }
    }
</style>
@if($stalls->isEmpty())

    <div class="empty-state">
        No stalls booked yet. Once a booking is confirmed, it will show up here.
    </div>

@else

    <div class="stalls-table-wrapper">

        <table class="stalls-table">

            <thead>
                <tr>
                    <th>Stall</th>
                    <th>Event</th>
                    <th>Venue</th>
                    <th>Dates</th>
                    <th>Final Price</th>
                    <th>Discount</th>
                    <th>GST</th>
                    <th>Amount Paid</th>
                    <th>Amount Due</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @foreach($stalls as $stall)

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | STALL PRICE
                        |--------------------------------------------------------------------------
                        | Final Price = final_price + GST
                        |--------------------------------------------------------------------------
                        */

                        $finalPrice = (float) ($stall->final_price ?? 0);

                        $gstAmount = (float) ($stall->gst_amount ?? 0);

                        $totalStallAmount = $finalPrice;


                        /*
                        |--------------------------------------------------------------------------
                        | PAYMENT FOR THIS STALL
                        |--------------------------------------------------------------------------
                        | payment_records.stall_id matches stall_booking_data.id
                        |--------------------------------------------------------------------------
                        */

                        $stallPayments = ($final_bookingdetails->payments ?? collect())
                            ->filter(function ($payment) use ($stall) {

                                return (string) ($payment->stall_id ?? '') ===
                                    (string) ($stall->id ?? '');
                            });


                        /*
                        |--------------------------------------------------------------------------
                        | AMOUNT PAID
                        |--------------------------------------------------------------------------
                        | Only approved payments are counted as paid.
                        |--------------------------------------------------------------------------
                        */

                        $amountPaid = $stallPayments
                            ->where('status', 'approved')
                            ->sum(function ($payment) {

                                return (float) ($payment->amount ?? 0);

                            });


                        /*
                        |--------------------------------------------------------------------------
                        | PENDING PAYMENT
                        |--------------------------------------------------------------------------
                        */

                        $pendingAmount = $stallPayments
                            ->where('status', 'pending')
                            ->sum(function ($payment) {

                                return (float) ($payment->amount ?? 0);

                            });


                        /*
                        |--------------------------------------------------------------------------
                        | AMOUNT DUE
                        |--------------------------------------------------------------------------
                        */

                        $due = max(
                            0,
                            $totalStallAmount - $amountPaid
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | DATES
                        |--------------------------------------------------------------------------
                        */

                        $start = $formatDate($stall->start_date);

                        $endWithYear = $formatDateYear($stall->end_date);

                    @endphp


                    <tr>

                        {{-- STALL --}}
                        <td>

                            <div class="stall-name">

                                Stall

                                @if($stall->stall_size)

                                    · {{ $stall->stall_size }} m²

                                @endif

                            </div>

                        </td>


                        {{-- EVENT --}}
                        <td>

                            <div class="event-name">

                                {{ $stall->event_name }}

                                @if($stall->event_year)

                                    <span class="event-year">
                                        {{ $stall->event_year }}
                                    </span>

                                @endif

                            </div>

                        </td>


                        {{-- VENUE --}}
                        <td>

                            @if($stall->venue_details)

                                <div class="venue">
                                    {{ $stall->venue_details }}
                                </div>

                            @else

                                —

                            @endif

                        </td>


                        {{-- DATES --}}
                        <td>

                            @if($start && $endWithYear)

                                <div class="date">
                                    {{ $start }} → {{ $endWithYear }}
                                </div>

                            @else

                                <span style="color: var(--muted);">
                                    Dates to be announced
                                </span>

                            @endif

                        </td>


                        {{-- FINAL PRICE + GST --}}
                        <td>

                            <span class="price">
                                {{ $money($totalStallAmount) }}
                            </span>

                        </td>


                        {{-- DISCOUNT --}}
                        <td>

                            @if((float) $stall->discount_amount > 0)

                                <span class="price discount">
                                    −{{ $money($stall->discount_amount) }}
                                </span>

                            @else

                                —

                            @endif

                        </td>


                        {{-- GST --}}
                        <td>

                            @if($gstAmount > 0)

                                <span class="price">
                                    {{ $money($gstAmount) }}
                                </span>

                            @else

                                —

                            @endif

                        </td>


                        {{-- AMOUNT PAID --}}
                        <td>

                            <span class="price" style="color: #198754;">
                                {{ $money($amountPaid) }}
                            </span>

                            @if($pendingAmount > 0)

                                <div style="
                                                                                    font-size: 11px;
                                                                                    color: #b7791f;
                                                                                    margin-top: 3px;
                                                                                ">
                                    Pending: {{ $money($pendingAmount) }}
                                </div>

                            @endif

                        </td>


                        {{-- AMOUNT DUE --}}
                        <td>

                            <span class="price due-amount">
                                {{ $money($due) }}
                            </span>

                        </td>


                        {{-- STATUS --}}
                        <td>

                            @if($due <= 0)

                                <span class="status-pill paid">
                                    <span class="dot"></span>
                                    Paid in full
                                </span>

                            @else

                                <span class="status-pill due">
                                    <span class="dot"></span>
                                    Payment due
                                </span>

                            @endif

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

@endif