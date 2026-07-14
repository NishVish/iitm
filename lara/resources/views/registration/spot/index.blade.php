@php
    $segments = request()->segments();

    $lastSegment = end($segments);
    $secondLastSegment = $segments[count($segments) - 2] ?? null;
    $thirdLastSegment = $segments[count($segments) - 3] ?? null;

    $for = (
        $lastSegment === 'exhibitor' ||
        $secondLastSegment === 'exhibitor' ||
        $thirdLastSegment === 'exhibitor'
    ) ? 'exhibitor' : 'trade';
@endphp

@include('registration.header')

<h2>{{ ucfirst($for) }} Registration</h2>

@include('registration.spot.parameter')