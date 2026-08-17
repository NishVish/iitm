<!-- @include('booking.header')

@php
    $lastsegment = request()->segment(count(request()->segments()));

    // echo $lastsegment;

    $secondlastSegment = request()->segment(count(request()->segments()) - 1);
    // echo $secondlastSegment;

@endphp

@if($lastsegment == 'bookingportal')
    @include('booking.enterbookingid')
@elseif($secondlastSegment == 'leadsdetails')
    @include('booking.leadsdetails')


@elseif($secondlastSegment == 'payment')
    @include('booking.payment')
@endif


@include('booking.footer') -->