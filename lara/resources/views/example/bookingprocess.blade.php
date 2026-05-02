<!DOCTYPE html>
<html>

<head>
    <title>Booking Process</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            padding: 20px;
        }

        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        h2 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background: #f0f0f0;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .small {
            font-size: 13px;
            color: #666;
        }
    </style>
</head>

<body>

    <h2>Booking Process</h2>

    @foreach($leads as $lead)

        <div class="card">

            <h3>Thank You for Your Query 🙏</h3>

            <p>
                Dear {{ $lead->name ?? 'Customer' }},
                <br><br>
                Thank you for showing interest in our exhibition.
            </p>

            <p><strong>We offer 3m², 6m², and 9m² SMM stall booking options.</strong></p>

            <h4>Stall Pricing</h4>

            <table>
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Year</th>
                        <th>Rate</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Chennai</td>
                        <td>2026</td>
                        <td>-</td>
                        <td>m² @ ₹34,000/m²</td>
                    </tr>
                    <tr>
                        <td>Bengaluru</td>
                        <td>2026</td>
                        <td>-</td>
                        <td>m² @ ₹37,000/m²</td>
                    </tr>
                    <tr>
                        <td>Delhi</td>
                        <td>2026</td>
                        <td>-</td>
                        <td>m² @ ₹37,000/m²</td>
                    </tr>
                    <tr>
                        <td>Mumbai</td>
                        <td>2026</td>
                        <td>-</td>
                        <td>m² @ ₹37,000/m²</td>
                    </tr>
                    <tr>
                        <td>Pune</td>
                        <td>2026</td>
                        <td>-</td>
                        <td>m² @ ₹34,000/m²</td>
                    </tr>
                    <tr>
                        <td>Hyderabad</td>
                        <td>2026</td>
                        <td>-</td>
                        <td>m² @ ₹34,000/m²</td>
                    </tr>
                    <tr>
                        <td>Kochi</td>
                        <td>2027</td>
                        <td>-</td>
                        <td>m² @ ₹34,000/m²</td>
                    </tr>
                    <tr>
                        <td>Kolkata</td>
                        <td>2027</td>
                        <td>-</td>
                        <td>m² @ ₹34,000/m²</td>
                    </tr>
                    <tr>
                        <td>Ahmedabad</td>
                        <td>2027</td>
                        <td>-</td>
                        <td>m² @ ₹37,000/m²</td>
                    </tr>
                </tbody>
            </table>

            @php
                $url = url('leadsdetails/' . $lead->lead_id) . '?mobile=' . urlencode($lead->mobile ?? '');
            @endphp

            <p style="margin-top:15px;">
                You can complete your booking using the link below:
            </p>

            <a href="{{ $url }}" target="_blank" class="btn">Complete Booking</a>

            <p class="small">
                Or use:<br>
                <strong>Booking ID:</strong> {{ $lead->lead_id }}<br>
                <strong>Mobile:</strong> {{ $lead->mobile ?? '-' }}
            </p>

        </div>

    @endforeach

</body>

</html>