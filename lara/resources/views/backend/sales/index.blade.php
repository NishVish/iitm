@include('backend/header')
@php
    // echo "<pre>";
    // print_r(session()->all());
    // echo "</pre>";
@endphp
@include('backend/search')

@include('backend/sales/leadstable')

@include('backend/sales/mail')