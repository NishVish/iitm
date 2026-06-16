{{-- resources/views/mail/apis.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mail API List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Mail API Endpoints</h4>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    @foreach ($data as $key => $url)
                        <div class="col-md-3">

                            @php
                                $colors = [
                                    'primary',
                                    'success',
                                    'warning',
                                    'danger',
                                    'info',
                                    'secondary',
                                    'dark'
                                ];
                            @endphp

                            <a href="{{ $url }}" class="btn btn-{{ $colors[$loop->index % count($colors)] }} w-100">

                                {{ ucfirst($key) }}

                            </a>

                        </div>
                    @endforeach

                </div>

                <hr>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="200">Type</th>
                            <th>URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $url)
                            <tr>
                                <td>{{ ucfirst($key) }}</td>
                                <td>
                                    <a href="{{ $url }}">
                                        {{ $url }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>

    <form method="POST" action="{{ url('api/mail/registration') }}">
        @csrf
        <h1>
            {{ csrf_token() }}
        </h1>
        <h3>Event Registration Email Form</h3>
        <label>Company ID</label>
        <input type="text" name="company_id" value="CMP_6a2d28f2da56b">

        <label>Contact ID</label>
        <input type="text" name="contact_id" value="353320">

        <label>Database Name</label>
        <input type="text" name="databasename" value="iitm-chennai-2026">

        <label>Event Name</label>
        <input type="text" name="eventname" value="iitm-chennai-2026">

        <label>Status</label>
        <input type="text" name="status" value="success">

        <label>Message</label>
        <input type="text" name="message" value="Your registration has been successfully completed">

        <hr>

        <h4>Contact Details</h4>

        <label>Contact Name</label>
        <input type="text" name="contactName" value="Nishant">

        <label>Email</label>
        <input type="email" name="email" value="noreply@iitmindia.com">

        <label>Mobile</label>
        <input type="text" name="mobile" value="7909075199">

        <label>Company Name</label>
        <input type="text" name="companyName" value="ABC Technologies">

        <label>Venue</label>
        <input type="text" name="venue" value="Abcd Parkway">

        <hr>

        <h4>Flags</h4>

        <label>
            <input type="checkbox" name="print" checked>
            Print
        </label>

        <label>
            <input type="checkbox" name="preview">
            Preview
        </label>

        <label>
            <input type="checkbox" name="emailpage" checked>
            Email Page
        </label>
        <hr>

        <button type="submit">Send Registration Mail</button>

    </form>



</body>

</html>