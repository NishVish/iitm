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

    {{-- Header --}}
    @include('web.header2')

    <div class="container mt-4">


        @php
            $lastSegment = request()->segment(count(request()->segments()));
        @endphp
        @if($lastSegment === 'contactus')


            @include('web.templates.contactus')

            <!-- {{-- includes register.blade.php --}} -->
        @elseif($lastSegment === 'aboutus')
            <div style="height:40px;"></div>
            @include('web.templates.aboutus')
            @include('web.templates.faq')


        @elseif($lastSegment === 'resourcepage')
            @include('web.templates.resources')

        @elseif($lastSegment === 'gallery')
            @include('web.templates.gallery')

        @endif
    </div>

    {{-- Footer --}}
    @include('web.footer')

</body>

</html>