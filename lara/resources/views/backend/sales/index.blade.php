@include('backend/header')
@php
    echo "<pre>";
    print_r(session()->all());
    echo "</pre>";
@endphp
@include('backend/search')

@include('backend/sales/lead')

@include('backend/sales/mail')