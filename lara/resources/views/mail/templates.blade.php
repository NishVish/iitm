@php
    $lastSegment = request()->segment(count(request()->segments()));
    $secondlastSegment = request()->segment(count(request()->segments()) - 1);

    // echo $lastSegment;
    // echo "<br>";
    // echo $secondlastSegment;
@endphp

@if($lastSegment != 'registration' && $secondlastSegment != 'registration')
    @include('mail.header')
@endif

@if($lastSegment === 'general')

    @include('mail.templates.general')

@elseif($lastSegment === 'registration' || $secondlastSegment == 'registration')

    @include('mail.templates.registration')

@elseif($lastSegment === 'enquiry')

    @include('mail.templates.enquiry')

@elseif($lastSegment === 'test')

    @include('mail.templates.test')

@elseif($lastSegment === 'home')


@endif


@if($lastSegment != 'registration' && $secondlastSegment != 'registration')
    @include('mail.footer')
@endif