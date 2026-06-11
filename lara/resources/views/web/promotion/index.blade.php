@include('web.templates.header.4')
@php

    $segments = request()->segments();

    $lastSegment = end($segments);
    $secondlastSegment = count($segments) > 1
        ? $segments[count($segments) - 2]
        : null;


    // echo $lastSegment;
    // echo $secondlastSegment;
@endphp

<div style="margin-top:50px">


    @if($lastSegment === 'buyer')
        @include('web.templates.bookyourstall')

        @include('web.templates.forms.buyers.index')

    @elseif($lastSegment === 'seller')
        @include('web.templates.bookyourstall')

    @elseif($lastSegment === 'list')
        @include('web.promotion.list')
    @else
    @endif



    <div>


    </div>





    @include('web.templates.faq')




</div>

@include('web.footer')