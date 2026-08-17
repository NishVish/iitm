@php
    $segments = request()->segments();

    $lastSegment = end($segments);
    $secondlastSegment = count($segments) > 1
        ? $segments[count($segments) - 2]
        : null;
@endphp


@include('web.registrationold.header')

@if($lastSegment == "register")
    @include('web.registrationold.choose')


@elseif($lastSegment == "eventlist" || $lastSegment == "retry")
    @include('web.registrationold.eventlist')
@elseif($lastSegment == "exhibitor")
    @include('web.registrationold.form')
@elseif($secondlastSegment == "trade")

    @include('web.registrationold.form')

@else
    @include('web.registrationold.choose')
@endif