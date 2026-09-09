<div class="company-search-section">

    <style>
        .company-search-section .search-box {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .company-search-section .search-box input {
            flex: 1;
        }

        .company-search-section .search-box button,
        .company-search-section .add-booking-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .company-search-section .search-box button {
            background: #007bff;
            color: #fff;
        }

        .company-search-section .add-booking-btn {
            background: #28a745;
            color: #fff;
        }

        .company-search-section .add-booking-btn:hover {
            background: #218838;
        }
    </style>

    <div class="search-container">

        <div class="search-heading">
            <h1>Search Company</h1>
            <p>Find company details quickly and easily</p>
        </div>

        <form id="companySearchForm" method="POST" action="{{ route('company.search') }}" class="company-search-form">

            @csrf

            <div class="search-box">

                <input type="text" name="keyword" id="keyword" placeholder="Enter company name..." autocomplete="off"
                    required>

                <button type="submit">
                    Search
                </button>

                <a href="{{ route('open_booking_page') }}" class="add-booking-btn">
                    Add Booking
                </a>

            </div>

        </form>

    </div>
</div>
<div class="sales-page">

    <div class="page-header">
        <div>
            <h2>Events</h2>
            <p>Manage your events</p>
        </div>

        <span class="event-count">
            {{ $events->count() }} Events
        </span>
    </div>


    <div class="table-wrapper">

        <table class="events-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event Name</th>
                    <th>Year</th>
                    <th>Venue</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Stall Price</th>
                    <th>Stalls</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($events as $event)

                    <tr>

                        <td>
                            {{ $event->event_id }}
                        </td>

                        <td>
                            <strong>
                                {{ $event->name ?: 'Unnamed Event' }}
                            </strong>
                        </td>

                        <td>
                            {{ $event->year ?? '—' }}
                        </td>

                        <td class="venue">
                            {{ $event->venue_details ?: '—' }}
                        </td>

                        <td>
                            @if($event->start_date)
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                            @else
                                —
                            @endif
                        </td>

                        <td>
                            @if($event->end_date)
                                {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                            @else
                                —
                            @endif
                        </td>

                        <td>
                            @if($event->stall_price)
                                ₹{{ number_format($event->stall_price, 2) }}
                            @else
                                —
                            @endif
                        </td>

                        <td>
                            {{ $event->stall_count }}
                        </td>

                        <td>
                            <a href="{{ url('sales/stallsbyevent/' . $event->event_id) }}" class="manage-btn">
                                Manage
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="9" class="no-data">
                            No events found.
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

    /* Header */

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
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

    .event-count {
        color: #666;
        font-size: 13px;
    }


    /* Table */

    .table-wrapper {
        background: #fff;
        border: 1px solid #ddd;
        overflow-x: auto;
    }

    .events-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
    }

    .events-table th {
        background: #fafafa;
        color: #555;
        font-size: 12px;
        font-weight: 600;
        text-align: left;
        padding: 12px 14px;
        border-bottom: 1px solid #ddd;
        white-space: nowrap;
    }

    .events-table td {
        padding: 13px 14px;
        font-size: 13px;
        border-bottom: 1px solid #eee;
        color: #444;
        vertical-align: middle;
    }

    .events-table tbody tr:last-child td {
        border-bottom: none;
    }

    .events-table tbody tr:hover {
        background: #fafafa;
    }

    .events-table strong {
        color: #222;
        font-weight: 600;
    }

    .venue {
        max-width: 250px;
    }


    /* Button */

    .manage-btn {
        display: inline-block;
        padding: 6px 11px;
        background: #222;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        font-size: 12px;
    }

    .manage-btn:hover {
        background: #444;
    }


    /* Empty */

    .no-data {
        text-align: center;
        padding: 40px !important;
        color: #888 !important;
    }


    /* Mobile */

    @media (max-width: 700px) {

        .sales-page {
            padding: 20px 15px;
        }

        .page-header {
            align-items: flex-start;
            gap: 10px;
            flex-direction: column;
        }

    }
</style>