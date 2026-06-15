{{-- resources/views/mail/apis.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mail API List</title>

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

</body>

</html>