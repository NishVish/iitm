@php
    $lastsegment = request()->segment(count(request()->segments()));
    $secondlastsegment = request()->segment(count(request()->segments()) - 1);
@endphp


@include('header')

@if($lastsegment == "space_booking")
    @include('sales.booking.add_booking.index')


@elseif($secondlastsegment == "company_details")
    @include('company.form.index')

    @include('company.index')

@elseif($lastsegment == "sales" && $secondlastsegment == "")
    @include('sales.dashboard.index')

@elseif($lastsegment == "company_search")

    @include('sales.selectcompany')

@elseif($lastsegment == "add_company")

    @include('company.form.index')

@elseif($secondlastsegment == "booking" && $lastsegment != "add")

    @include('sales.booking.index')

@elseif($secondlastsegment == "stallsbyevent")

    @include('sales.stalls.index')


@elseif($secondlastsegment == "step5")
    @php
        $isDelegate = true;
    @endphp
    @include('exhibitor.booking.stalldetails.stalldetailscss')

    @include('exhibitor.booking.stalldetails.index')

@elseif($secondlastsegment == "step6")

    @include('exhibitor.booking.summary.index')

@endif

@include('footer')