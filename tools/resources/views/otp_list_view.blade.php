{{-- resources/views/otp_list_view.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OTP List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">OTP List</h1>

        @if($otps->isEmpty())
            <p>No OTPs available.</p>
        @else
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Contact ID</th>
                        <th>Contact Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>OTP</th>
                        <th>Expiry</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($otps as $index => $otp)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $otp->contact_id }}</td>
                            <td>{{ $otp->name ?? 'N/A' }}</td>
                            <td>{{ $otp->mobile ?? 'N/A' }}</td>
                            <td>{{ $otp->email ?? 'N/A' }}</td>
                            <td>{{ $otp->otp }}</td>
                            <td>{{ $otp->otp_expiry }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>

</html>