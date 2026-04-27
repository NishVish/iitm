@include('backend.home')

@php
    $lastsegmetn = request()->segment(2);
    echo $lastsegmetn;
@endphp
@if($lastsegmetn == 'leads')
    @include('backend.leads')
@endif

@if($lastsegmetn == 'search')
    @include('backend.header')

    @include('backend.search')
@endif