@include('booking.header')

@php
$lastsegment = request()->segment(count(request()->segments()));

// echo $lastsegment;

$secondlastSegment = request()->segment(count(request()->segments()) - 1);
// echo $secondlastSegment;

@endphp

@if($lastsegment == 'bookingportal')
@include('booking.enterbookingid')
@else




@include('booking.form')


@endif

@include('booking.payment')