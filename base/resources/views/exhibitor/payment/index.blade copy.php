<div class="container py-4">

    @php
        $totalOriginal = 0;
        $totalDiscount = 0;
        $totalGst = 0;
        $totalFinal = 0;
        $totalDue = 0;

        /*
        |--------------------------------------------------------------------------
        | PAYMENT STATUS
        |--------------------------------------------------------------------------
        */

        $hasFullBookingPayment = collect($payment ?? [])
            ->contains(function ($record) {
                return $record->payment_for === 'full_booking_payment'
                    && (float) $record->amount > 0
                    && in_array($record->status, ['pending', 'approved']);
            });

        /*
        |--------------------------------------------------------------------------
        | If full booking payment already exists,
        | there is no payment due on this page.
        |--------------------------------------------------------------------------
        */

        if ($hasFullBookingPayment) {
            $totalDue = 0;
        }
    @endphp


    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                Booking Payment
            </h4>

            <a href="{{ url('exhibitor/closebooking/' . $bookingdata->booking_id) }}" class="btn btn-light btn-sm">

                Move to Dashboard

            </a>

        </div>


        <div class="card-body">

            {{-- =====================================================
            PART 1: BOOKING / PAYMENT SUMMARY
            ====================================================== --}}

            @include('exhibitor.payment.summary')


            {{-- =====================================================
            PART 2: PAYMENT FORM
            ====================================================== --}}

            @if($hasFullBookingPayment)

                <div class="alert alert-success mt-3">

                    <strong>Full payment has already been submitted.</strong>

                    <div class="mt-1">
                        No payment is currently due for this booking.
                    </div>

                </div>

            @else

                @include('exhibitor.payment.form')

            @endif
            <!-- @include('exhibitor.payment.form') -->


            {{-- =====================================================
            PAYMENT LOGS
            ====================================================== --}}

            @include('exhibitor.payment.logs')

        </div>

    </div>

</div>