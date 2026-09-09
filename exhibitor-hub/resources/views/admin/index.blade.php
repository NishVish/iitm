<!DOCTYPE html>
<html>

<head>
    <title>Admin Bookings</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>

</head>

<body>

    <h1> Hello </h1>

    @php


        $lastsegment = basename(url()->current());
        echo $lastsegment;
    @endphp

    @if ($lastsegment == 'tables')
        @include('admin.tables')
    @endif

    @if ($lastsegment == 'login' || $lastsegment == 'logout')
        @include('admin.login')
    @endif



</body>

</html>