<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: top;
        }

        th {
            background: #343a40;
            color: #fff;
        }

        pre {
            margin: 0;
            white-space: pre-wrap;
            word-break: break-word;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <h2>Exhibitor Bookings</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Event Details</th>
                <th>Company Details</th>
                <th>Billing Contact</th>
                <th>Delegate Details</th>
                <th>Booking Details</th>
                <th>Branding</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>

                    <td>
                        <pre>{{ json_encode(json_decode($booking->event_details), JSON_PRETTY_PRINT) }}</pre>
                    </td>

                    <td>
                        <pre>{{ json_encode(json_decode($booking->company_details), JSON_PRETTY_PRINT) }}</pre>
                    </td>

                    <td>
                        <pre>{{ json_encode(json_decode($booking->billing_contact), JSON_PRETTY_PRINT) }}</pre>
                    </td>

                    <td>
                        <pre>{{ json_encode(json_decode($booking->delegate_details), JSON_PRETTY_PRINT) }}</pre>
                    </td>

                    <td>
                        <pre>{{ json_encode(json_decode($booking->booking_details), JSON_PRETTY_PRINT) }}</pre>
                    </td>

                    <td>
                        <pre>{{ json_encode(json_decode($booking->branding_extra_requirements), JSON_PRETTY_PRINT) }}</pre>
                    </td>

                    <td>{{ $booking->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">No bookings found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>