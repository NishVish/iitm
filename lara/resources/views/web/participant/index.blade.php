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

                @include('web.header2')

                @include('web.participant.exhibiting.exhibiting')

                <script>

                    document.addEventListener("DOMContentLoaded", function () {
                        const wrapper = document.getElementById('iitmHeader');
                        wrapper.style.display = 'none';
                        if (wrapper) {
                            setTimeout(() => {
                                // Force display block with zero spacing
                                wrapper.style.display = 'block';

                                setTimeout(() => {
                                    wrapper.style.opacity = '1';

                                }, 50);

                            }, 5000);
                        }
                    });
                </script>
            @elseif($lastSegment === 'attending')
                {{-- Your Attending Content Here --}}

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

                @include('web.header2') {{-- includes register.blade.php --}}
                @include('web.participant.form.visitor')
            @else
                @include('web.loading2') {{-- includes register.blade.php --}}
                @include('web.participant.attending')
                @include('web.home.index') {{-- includes home.blade.php --}}
            @endif
        </div>
    </div>
    @php
        // echo "<pre>";
        // print_r($contact);
        // print_r($company);
        // print_r($eventinfo);
        // echo "</pre>";
    @endphp
    @include('web.footer')

</body>

</html>