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

                @include('web.header2') {{-- includes register.blade.php --}}

                @include('web.participant.exhibiting.exhibiting')

                <!-- {{-- includes register.blade.php --}} -->
            @elseif($lastSegment === 'attending')
                @include('web.loading2') {{-- includes register.blade.php --}}

                @include('web.header2') {{-- includes register.blade.php --}}

                @include('web.participant.attending.attending')

                {{-- includes register.blade.php --}}

                <!-- @#include('web.templates.otpless') -->
                <!-- @include('web.templates.registercitis') -->
            @elseif($lastSegment === 'enquiry')
                @include('web.loading2') {{-- includes register.blade.php --}}

                @include('web.header2')

                @include('web.participant.form.enquiry-form')

            @elseif($lastSegment === 'visitor-form')
                @include('web.loading2') {{-- includes register.blade.php --}}

                @include('web.header2') {{-- includes register.blade.php --}}
                @include('web.participant.form.visitor')
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