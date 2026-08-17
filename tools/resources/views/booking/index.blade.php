@include('booking.header')

@php
    $lastsegment = request()->segment(count(request()->segments()));
    $secondlastSegment = request()->segment(count(request()->segments()) - 1);
    $step = request('step', 1);
@endphp

@if($lastsegment == 'bookingportal')

    @include('booking.enterbookingid')

@elseif($secondlastSegment == 'leadsdetails' || $lastsegment == 'payment-success')

    <div id="div1" style="{{ $step == 2 ? 'display:none;' : '' }}">

        @include('booking.status2')

        <button onclick="goNext()"
            style="padding:10px 15px; background:#007bff; color:#fff; border:none; border-radius:5px;">
            Process
        </button>
    </div>

    <div id="div2" style="{{ $step == 2 ? '' : 'display:none;' }}">
        <h3>Step 2</h3>

        @include('booking.form')
    </div>

    <script>
        function goNext() {
            const url = new URL(window.location.href);
            url.searchParams.set('step', '2');
            window.location.href = url.toString();
        }
    </script>

@else

@endif