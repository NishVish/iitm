@php
    $lastsegment = request()->segment(count(request()->segments()));
    $secondlastsegment = request()->segment(count(request()->segments()) - 1);

    $bookingId = $lastsegment;

    $steps = [
        'step1' => ['name' => 'Instructions', 'url' => url('exhibitor/booking/step1/' . $bookingId)],
        'step2' => ['name' => 'Contact Details', 'url' => url('exhibitor/booking/step2/' . $bookingId)],
        'step3' => ['name' => 'Company Details', 'url' => url('exhibitor/booking/step3/' . $bookingId)],
        'step4' => ['name' => 'Stall Space Selection', 'url' => url('exhibitor/booking/step4/' . $bookingId)],
        'step5' => ['name' => 'Stall Details', 'url' => url('exhibitor/booking/step5/' . $bookingId)],
        'step6' => ['name' => 'Summary', 'url' => url('exhibitor/booking/step6/' . $bookingId)],
    ];

    $currentStep = $secondlastsegment;
    $stepKeys = array_keys($steps);
    $currentIndex = array_search($currentStep, $stepKeys);
    $nextStep = $stepKeys[$currentIndex + 1] ?? null;
@endphp

@include("exhibitor.header2")

<style>
    .booking-navigation {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 20px;
        margin-bottom: 25px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .booking-steps {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .booking-step {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: #777;
    }

    .booking-step .step-number {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .booking-step.active {
        color: #0d6efd;
        font-weight: bold;
    }

    .booking-step.active .step-number {
        background: #0d6efd;
        color: #fff;
    }

    .step-arrow {
        color: #aaa;
    }

    .next-button {
        padding: 9px 20px;
        background: #0d6efd;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .next-button:hover {
        background: #0b5ed7;
        color: #fff;
    }
</style>

<div class="booking-navigation">

    <div class="booking-steps">
        @foreach($steps as $key => $step)
            <a href="{{ $step['url'] }}" class="booking-step {{ $currentStep == $key ? 'active' : '' }}">

                <span class="step-number">
                    {{ substr($key, -1) }}
                </span>

                <span>{{ $step['name'] }}</span>
            </a>

            @if(!$loop->last)
                <span class="step-arrow">→</span>
            @endif
        @endforeach
    </div>

    @if($nextStep)
        <a href="{{ $steps[$nextStep]['url'] }}" class="next-button">
            Next →
        </a>
    @endif

</div>

<div class="maincontainer">
    <style>
        .maincontainer {
            width: 60%;
            margin: auto;
            min-height: 500px;
            border-radius: 10px;
            background-color: #ffffff;
        }
    </style>

    @if($secondlastsegment == "step1")

        @include('exhibitor.booking.instructions')

    @elseif($secondlastsegment == "step2")
        @php
            $isDelegate = false;
        @endphp
        @include('exhibitor.booking.contactdetails')

    @elseif($secondlastsegment == "step3")

        @include('exhibitor.booking.companydetails')

    @elseif($secondlastsegment == "step4")

        @include('exhibitor.booking.bookingdetails')

    @elseif($secondlastsegment == "step5")
        @php
            $isDelegate = true;
        @endphp
        @include('exhibitor.booking.stalldetails.stalldetailscss')

        @include('exhibitor.booking.stalldetails.index')

    @elseif($secondlastsegment == "step6")

        @include('exhibitor.booking.summary.index')

    @endif
</div>

@include("exhibitor.booking.footer")