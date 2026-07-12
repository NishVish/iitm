@php
    $lastsegment = basename($_SERVER['REQUEST_URI']);
    $secondlastSegment = basename(dirname($_SERVER['REQUEST_URI']));



    if ($lastsegment == "trade") {

        $for = 'Trade';
    } else {

        $for = 'Exhibitor';
    }

@endphp


@include('registration.header')

<h2>{{$for}} Registration</h2>
@include('registration.spot.parameter')