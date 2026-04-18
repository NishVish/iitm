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
            @if($lastSegment === 'exhibiting')

                <!-- @include('web.loading2') {{-- includes register.blade.php --}} -->
                @include('web.header2') {{-- includes register.blade.php --}}

                @include('web.participant.exhibiting.exhibiting') {{-- includes register.blade.php --}}
            @elseif($lastSegment === 'attending')

                <!-- @include('web.loading2') {{-- includes register.blade.php --}} -->
                @include('web.header2')
                @include('web.participant.attending.hook2')
                @include('web.templates.whyvisit')

                @include('web.participant.attending.hook')

                @include('web.participant.attending.attending')

                @include('web.templates.otp')
            @elseif($lastSegment === 'enquiry')
                @include('web.participant.form.enquiry-form')


                <!-- @include('web.loading2') {{-- includes register.blade.php --}} -->

                @include('web.header2') {{-- includes register.blade.php --}}

                <!-- Header 2 -->
            @elseif($lastSegment === 'visitor-form')

                @include('web.header2') {{-- includes register.blade.php --}}
                @include('web.participant.visitor-form');
            @else
                @include('web.loading2') {{-- includes register.blade.php --}}
                @include('web.participant.attending')
                @include('web.home.index') {{-- includes home.blade.php --}}
            @endif
        </div>
    </div>
    @include('web.footer')

</body>

</html>