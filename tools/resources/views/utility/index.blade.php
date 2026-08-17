<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <style>
        body {
            margin: 0;
        }
    </style>
</head>

<body>

    {{-- Include Header --}}
    <div class="container mt-4">

        <div id="content">
            {{-- Check the last segment of the URL --}}
            @php
                $lastSegment = request()->segment(count(request()->segments()));
                $secondlastSegment = request()->segment(count(request()->segments()) - 1);
            @endphp

            @if($lastSegment === 'pdftotext')

                @include('utility.pdftotext')

            @endif

</body>

</html>