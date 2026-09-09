<div class="sales-page">

    <div class="page-header">

        <div class="current-event-info">

            <h2>
                {{ $currentevent->name ?? 'Stalls' }}
                @if(!empty($currentevent->year))
                    <span class="event-year">{{ $currentevent->year }}</span>
                @endif
            </h2>

            @if(!empty($currentevent->venue_details))
                <p>
                    <strong>Venue:</strong>
                    {{ $currentevent->venue_details }}
                </p>
            @endif

            @if(!empty($currentevent->start_date) || !empty($currentevent->end_date))
                <p>
                    <strong>Date:</strong>

                    @if(!empty($currentevent->start_date))
                        {{ \Carbon\Carbon::parse($currentevent->start_date)->format('d M Y') }}
                    @endif

                    @if(!empty($currentevent->start_date) && !empty($currentevent->end_date))
                        -
                    @endif

                    @if(!empty($currentevent->end_date))
                        {{ \Carbon\Carbon::parse($currentevent->end_date)->format('d M Y') }}
                    @endif
                </p>
            @endif

            <p>
                Event stall booking details
            </p>

        </div>




        <span class="total-stalls">
            {{ count($data) }} Stalls
        </span>

    </div>


    <div class="event-buttons">

        @foreach($events as $event)

            <a href="{{ url('sales/stallsbyevent/' . $event->event_id) }}"
                class="event-button {{ isset($currentevent->event_id) && $currentevent->event_id == $event->event_id ? 'active' : '' }}">

                <span class="event-name">
                    {{ $event->name ?: 'Event #' . $event->event_id }}
                </span>

                <span class="stall-count">
                    {{ $event->stall_count }} Stalls
                </span>

            </a>

        @endforeach

    </div>
    <style>
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .current-event-info {
            min-width: 280px;
            flex: 1;
        }

        .current-event-info h2 {
            margin: 0 0 8px;
            font-size: 22px;
            font-weight: 700;
            color: #222;
        }

        .current-event-info p {
            margin: 3px 0;
            font-size: 12px;
            color: #666;
            line-height: 1.5;
        }

        .current-event-info strong {
            color: #444;
        }

        .event-year {
            display: inline-block;
            margin-left: 6px;
            padding: 3px 7px;
            background: #f1f1f1;
            color: #666;
            border-radius: 4px;
            font-size: 11px;
            vertical-align: middle;
        }

        .event-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
            flex: 2;
        }

        .event-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: #f5f5f5;
            color: #333;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
            transition: all .2s ease;
        }

        .event-button:hover {
            background: #222;
            border-color: #222;
            color: #fff;
        }

        .event-button.active {
            background: #222;
            border-color: #222;
            color: #fff;
        }

        .event-name {
            white-space: nowrap;
        }

        .stall-count {
            padding: 2px 6px;
            background: #e9e9e9;
            color: #555;
            border-radius: 10px;
            font-size: 9px;
            white-space: nowrap;
        }

        .event-button:hover .stall-count,
        .event-button.active .stall-count {
            background: rgba(255, 255, 255, .18);
            color: #fff;
        }

        .total-stalls {
            white-space: nowrap;
            padding: 7px 12px;
            background: #222;
            color: #fff;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        @media(max-width: 900px) {

            .page-header {
                align-items: flex-start;
            }

            .current-event-info {
                flex: 100%;
            }

            .event-buttons {
                flex: 100%;
                justify-content: flex-start;
            }

        }

        @media(max-width: 600px) {

            .event-buttons {
                display: grid;
                grid-template-columns: 1fr 1fr;
            }

            .event-button {
                justify-content: space-between;
            }

            .total-stalls {
                width: 100%;
                text-align: center;
            }

        }
    </style>



    <div class="table-wrapper">

        <table class="stall-table">

            <thead>
                <tr>
                    <th>Company</th>
                    <th>Sales ID</th>
                    <th>Stall Size</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Billing Contact</th>
                    <th>Designation</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Fascia</th>
                    <th>Certificate</th>
                    <th>Delegates</th>
                </tr>
            </thead>

            <tbody>

                @forelse($data as $item)

                    @php
                        $stall = $item['stall'];
                        $company = $item['company'];
                        $billing = $item['billing_contact'];
                        $payment = $item['payment'];

                        /*
                         * Payment collection can be empty.
                         * stalldatastallid() already provides paid_amount.
                         */
                        $paidAmount = $stall->paid_amount ?? 0;

                        $finalPrice = $stall->final_price ?? 0;

                        if ($paidAmount >= $finalPrice && $finalPrice > 0) {
                            $paymentStatus = 'Paid';
                        } elseif ($paidAmount > 0) {
                            $paymentStatus = 'Partial';
                        } else {
                            $paymentStatus = 'Pending';
                        }

                        /*
                         * Contacts/delegates
                         */
                        $delegatesCount = isset($stall->contacts)
                            ? $stall->contacts->count()
                            : 0;
                    @endphp


                    <tr>

                        {{-- Company --}}
                        <td>
                            <a href="{{ url('sales/booking/') . '/' . $stall->booking_id }}">
                                <strong>
                                    {{ $company->company_name ?? '—' }}
                                </strong>
                            </a>
                        </td>


                        {{-- Sales ID --}}
                        <td>
                            {{ $company->sales_person ?? '—' }}
                        </td>


                        {{-- Stall Size --}}
                        <td>
                            {{ $stall->stall_size ?? '—' }}
                        </td>


                        {{-- Payment --}}
                        <td>

                            <div>
                                ₹{{ number_format($paidAmount, 2) }}
                            </div>

                            <small class="payment-status {{ strtolower($paymentStatus) }}">
                                {{ $paymentStatus }}
                            </small>

                        </td>


                        {{-- Status --}}
                        <td>

                            @if($stall->due_amount > 0)

                                <span class="status pending">
                                    Pending
                                </span>

                            @else

                                <span class="status paid">
                                    Paid
                                </span>

                            @endif

                        </td>


                        {{-- Billing Contact --}}
                        <td>
                            {{ $billing->name ?? '—' }}
                        </td>


                        {{-- Designation --}}
                        <td>
                            {{ $billing->designation ?? '—' }}
                        </td>


                        {{-- Mobile --}}
                        <td>
                            {{ $billing->contact_mobile ?? '—' }}
                        </td>


                        {{-- Email --}}
                        <td>
                            {{ $billing->contact_email ?? '—' }}
                        </td>


                        {{-- Fascia --}}
                        <td>
                            {{ $stall->fascia ?? '—' }}
                        </td>


                        {{-- Certificate --}}
                        <td>
                            {{ $stall->certificate ?? '—' }}
                        </td>


                        {{-- Delegates --}}
                        <td>
                            {{ $delegatesCount }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="12" class="no-data">
                            No stalls found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<style>
    body {
        margin: 0;
        background: #f7f7f7;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #222;
    }

    .sales-page {
        padding: 30px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-header h2 {
        margin: 0 0 4px;
        font-size: 22px;
        font-weight: 600;
    }

    .page-header p {
        margin: 0;
        color: #777;
        font-size: 13px;
    }

    .page-header>span {
        color: #666;
        font-size: 13px;
    }


    .table-wrapper {
        background: #fff;
        border: 1px solid #ddd;
        overflow-x: auto;
    }

    .stall-table {
        width: 100%;
        min-width: 1300px;
        border-collapse: collapse;
    }

    .stall-table th {
        background: #fafafa;
        color: #555;
        font-size: 11px;
        font-weight: 600;
        text-align: left;
        padding: 12px 14px;
        border-bottom: 1px solid #ddd;
        white-space: nowrap;
    }

    .stall-table td {
        padding: 12px 14px;
        font-size: 12px;
        color: #444;
        border-bottom: 1px solid #eee;
        white-space: nowrap;
        vertical-align: middle;
    }

    .stall-table tbody tr:hover {
        background: #fafafa;
    }

    .stall-table strong {
        color: #222;
        font-weight: 600;
    }


    /* Status */

    .status,
    .payment-status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 600;
    }

    .status.paid,
    .payment-status.paid {
        background: #eaf7ee;
        color: #218838;
    }

    .status.pending,
    .payment-status.pending {
        background: #fff4e5;
        color: #b76e00;
    }

    .payment-status.partial {
        background: #eef4ff;
        color: #356ac3;
    }


    /* Empty */

    .no-data {
        text-align: center;
        padding: 40px !important;
        color: #888 !important;
    }
</style>