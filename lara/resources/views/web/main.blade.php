<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
</head>

<body>

    {{-- Include Header --}}
    @include('web.header')

    <div class="container mt-4">

        <div id="content">
            {{-- Check the last segment of the URL --}}
            @php
                $lastSegment = request()->segment(count(request()->segments()));
                $secondlastSegment = request()->segment(count(request()->segments()) - 1);
            @endphp

            @if($lastSegment === 'events' || $lastSegment === 'register')
                @include('web.events') {{-- includes events.blade.php --}}
            @elseif($secondlastSegment === 'register')
                @include('web.register') {{-- includes register.blade.php --}}
            @else
                @include('web.home') {{-- includes home.blade.php --}}
            @endif
        </div>
    </div>
    @include('web.footer')

</body>

</html>