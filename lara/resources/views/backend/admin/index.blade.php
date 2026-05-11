@include('backend.header')

<!DOCTYPE html>
<html>

<head>
    <title>Assign Sales Person</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 13px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f4f4f4;
        }

        select {
            width: 150px;
        }

        .btn {
            padding: 5px 10px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

    <h2>Assign Sales Person</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Lead ID</th>
                <th>Company ID</th>
                <th>Contact ID</th>
                <th>Year</th>
                <th>Company Name</th>
                <th>Contact Name</th>
                <th>Designation</th>
                <th>Mobile</th>
                <th>Email</th>

                <th>Exhibition Year</th>
                <th>Fascia</th>

                <th>Locations</th>
                <th>Quotation Total</th>
                <th>Paid</th>
                <th>Balance</th>

                <th>Sales Person</th>
                <th>Exhibitor</th>
                <th>Created At</th>
                <th>Updated At</th>

                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($leads as $lead)

                <tr>

                    <td>{{ $lead->lead_id }}</td>
                    <td>{{ $lead->company_id }}</td>
                    <td>{{ $lead->contact_id }}</td>
                    <td>{{ $lead->exhibition_year }}</td>
                    <td>{{ $lead->company_name ?? 'N/A' }}</td>
                    <td>{{ $lead->contact_name ?? 'N/A' }}</td>
                    <td>{{ $lead->designation ?? 'N/A' }}</td>
                    <td>{{ $lead->mobile ?? 'N/A' }}</td>
                    <td>{{ $lead->email ?? 'N/A' }}</td>

                    <td>{{ $lead->exhibition_year ?? 'N/A' }}</td>
                    <td>{{ $lead->fascia ?? 'N/A' }}</td>

                    <td>{{ $lead->total_locations ?? 0 }}</td>
                    <td>{{ $lead->grand_total ?? 0 }}</td>
                    <td>{{ $lead->payment_status ?? 0 }}</td>

                    <td>
                        {{ ($lead->grand_total ?? 0) - ($lead->total_paid ?? 0) }}
                    </td>

                    <td>
                        <form method="POST" action="{{ route('assign.lead') }}">
                            @csrf

                            <input type="hidden" name="lead_id" value="{{ $lead->lead_id }}">

                            <!-- THIS TELLS CONTROLLER WHICH COLUMN TO UPDATE -->
                            <input type="hidden" name="field_name" value="sales_person">

                            <select name="field_value">
                                <option value="">Select</option>

                                @foreach($users as $user)
                                    <option value="{{ $user->name }}" {{ $lead->sales_person == $user->name ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                    </td>

                    <td>{{ $lead->exhibitor ?? 'N/A' }}</td>
                    <td>{{ $lead->created_at }}</td>
                    <td>{{ $lead->updated_at }}</td>

                    <td>
                        <button type="submit" class="btn">Save</button>
                        </form>
                    </td>
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="19">No leads found</td>
                </tr>
            @endforelse
        </tbody>

    </table>
    @include('backend.data.otherregistration')

    <iframe src="{{route('example.bookingprocess')}}" frameborder="0" style="width:100%; height:400px;"></iframe>


</body>

</html>