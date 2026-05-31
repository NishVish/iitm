@include('mail.header')


@php
    $lastSegment = request()->segment(count(request()->segments()));
    $secondlastSegment = request()->segment(count(request()->segments()) - 1);
@endphp
@if($lastSegment === 'buy')

    @include('mail.templates.buy')

@elseif($lastSegment === 'mail')




@elseif($lastSegment === 'home')


@endif


@include('mail.footer')