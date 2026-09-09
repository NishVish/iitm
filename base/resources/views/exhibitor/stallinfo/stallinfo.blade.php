{{-- FASCIA / CERTIFICATE --}}
<div class="card shadow-sm mb-4">

    <div class="card-header">
        <h5 class="mb-0">
            Stall Details
        </h5>
    </div>

    <div class="card-body">

        <div class="row g-4">

            <div class="col-md-6">

                <label class="form-label text-muted">
                    Fascia Name
                </label>

                @if(!empty($stall->fascia))

                    <div class="alert alert-success mb-0">
                        <strong>
                            {{ $stall->fascia }}
                        </strong>
                    </div>

                @else

                    <div class="alert alert-danger mb-0">
                        Fascia name not provided
                    </div>

                @endif

            </div>


            <div class="col-md-6">

                <label class="form-label text-muted">
                    Certificate Name
                </label>

                @if(!empty($stall->certificate))

                    <div class="alert alert-success mb-0">
                        <strong>
                            {{ $stall->certificate }}
                        </strong>
                    </div>

                @else

                    <div class="alert alert-danger mb-0">
                        Certificate name not provided
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>


{{-- VENUE --}}
<div class="card shadow-sm mb-4">

    <div class="card-header">
        <h5 class="mb-0">
            Venue Information
        </h5>
    </div>

    <div class="card-body">

        <div class="mb-3">

            <small class="text-muted d-block">
                Venue
            </small>

            <strong>
                {{ $stall->venue_details ?? '-' }}
            </strong>

        </div>

        <div>

            <small class="text-muted d-block">
                Booking Details
            </small>

            <strong>
                {{ $stall->venue_booking_details ?? '-' }}
            </strong>

        </div>

    </div>

</div>


{{-- PRICE --}}
<div class="card shadow-sm mb-4">

    <div class="card-header">
        <h5 class="mb-0">
            Payment Summary
        </h5>
    </div>

    <div class="card-body">

        <div class="row g-3">

            <div class="col-md-3">

                <small class="text-muted d-block">
                    Original Amount
                </small>

                <h5>
                    ₹{{ number_format($originalAmount, 2) }}
                </h5>

            </div>

            <div class="col-md-3">

                <small class="text-muted d-block">
                    Discount
                </small>

                <h5 class="text-danger">
                    ₹{{ number_format($discountAmount, 2) }}
                </h5>

            </div>

            <div class="col-md-3">

                <small class="text-muted d-block">
                    Final Price
                </small>

                <h5>
                    ₹{{ number_format($finalPrice, 2) }}
                </h5>

            </div>

            <div class="col-md-3">

                <small class="text-muted d-block">
                    GST
                </small>

                <h5>
                    ₹{{ number_format($gstAmount, 2) }}
                </h5>

            </div>

        </div>

        <hr>

        <div class="row">

            <div class="col-md-4">

                <small class="text-muted d-block">
                    Total Payable
                </small>

                <h4>
                    ₹{{ number_format($totalPayable, 2) }}
                </h4>

            </div>

            <div class="col-md-4">

                <small class="text-muted d-block">
                    Paid
                </small>

                <h4 class="text-success">
                    ₹{{ number_format($paidAmount, 2) }}
                </h4>

            </div>

            <div class="col-md-4">

                <small class="text-muted d-block">
                    Remaining
                </small>

                <h4 class="{{ $remainingAmount > 0 ? 'text-danger' : 'text-success' }}">
                    ₹{{ number_format($remainingAmount, 2) }}
                </h4>

            </div>

        </div>

    </div>

</div>


{{-- CONTACTS --}}
<div class="card shadow-sm mb-4">

    <div class="card-header">
        <h5 class="mb-0">
            Stall Delegates
        </h5>
    </div>

    <div class="card-body">

        @if($stall->contacts && $stall->contacts->count())

            <div class="row g-3">

                @foreach($stall->contacts as $contact)

                    <div class="col-md-6 col-lg-4">

                        <div class="border rounded p-3">

                            <h6 class="mb-2">
                                {{ $contact->name ?? '-' }}
                            </h6>

                            <div class="small text-muted">
                                {{ $contact->designation ?? '-' }}
                            </div>

                            <div class="mt-2">
                                {{ $contact->contact_email ?? $contact->email ?? '-' }}
                            </div>

                            <div>
                                {{ $contact->contact_mobile ?? $contact->mobile ?? '-' }}
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <p class="text-muted mb-0">
                No delegates assigned to this stall.
            </p>

        @endif

    </div>

</div>