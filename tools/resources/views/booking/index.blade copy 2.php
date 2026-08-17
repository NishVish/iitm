@include('booking.header')

@php
$lastsegment = request()->segment(count(request()->segments()));


$secondlastSegment = request()->segment(count(request()->segments()) - 1);

echo $lastsegment;


echo $secondlastSegment;

@endphp

@if($lastsegment == 'bookingportal')
@include('booking.enterbookingid')


@elseif($secondlastSegment == 'leadsdetails' || $lastsegment == 'payment-success')
@include('booking.status')
@include('booking.form')

@else

@include('booking.payment')






@endif