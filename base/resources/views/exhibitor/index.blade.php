@include('header')

@if($page === 'dashboard')

    @include('exhibitor.dashboard.index')

@elseif($page === 'invoice')
    @include('exhibitor.invoice.index')
@elseif($page === 'stall')

    @include('exhibitor.stallinfo.index')


@elseif($page === 'payment')

    @include('exhibitor.payment.index')
@endif