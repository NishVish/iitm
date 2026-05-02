@include('backend.home')



@php
    $lastsegmetn = request()->segment(2);
    // echo $lastsegmetn;
@endphp
@if($lastsegmetn == 'leads')
    @include('backend.leads')
@endif

@if($lastsegmetn == 'search')
    @include('backend.header')

    @include('backend.search')
@endif

<style>
    .logout-btn {
        background-color: #f44336;
        border: none;
        color: white;
        padding: 12px 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
    }
</style>