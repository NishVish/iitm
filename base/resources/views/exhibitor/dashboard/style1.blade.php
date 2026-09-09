<style>
    .booking-overview {
        max-width: 1100px;
        margin: 0 auto;
    }

    .card-box {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .card-header-custom {
        padding: 18px 22px;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }

    .card-body-custom {
        padding: 22px;
    }

    .label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .value {
        font-weight: 500;
        margin-bottom: 15px;
    }

    .status {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .completed {
        background: #dcfce7;
        color: #15803d;
    }

    .pending {
        background: #fee2e2;
        color: #b91c1c;
    }

    .action {
        background: #fef3c7;
        color: #b45309;
    }

    .stall {
        border: 1px solid #dfe3e8;
        border-radius: 12px;
        margin-bottom: 25px;
        overflow: hidden;
    }

    .stall-header {
        background: #f1f5f9;
        padding: 15px 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stall-header h5 {
        margin: 0;
    }

    .stall-body {
        padding: 20px;
    }

    .status-section {
        padding: 18px 0;
        border-top: 1px solid #e5e7eb;
    }

    .status-section:first-child {
        border-top: 0;
    }

    .status-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .status-heading strong {
        font-size: 16px;
    }

    .description {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 12px;
    }
</style>


@php
    $booking = $data['booking'];
    $contact = $data['contact']->first();
    $company = $data['company']->first();
    $stalls = $data['bookings'];
@endphp


<div class="booking-overview">


    {{-- =====================================================
    BOOKING DETAILS
    ====================================================== --}}

    <div class="card-box">

        <div class="card-header-custom d-flex justify-content-between align-items-center">

            <div>
                <h4 class="mb-1">Booking Overview</h4>

                <div class="text-muted">
                    Booking ID: {{ $booking->booking_id }}
                </div>
            </div>

            <span class="status completed">
                Booking Active
            </span>

        </div>

        <div class="card-body-custom">

            <div class="row">

                <div class="col-md-6">
                    <div class="label">Event</div>
                    <div class="value">
                        {{ $booking->event_name }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="label">Event Year</div>
                    <div class="value">
                        {{ $booking->event_year }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="label">Event ID</div>
                    <div class="value">
                        {{ $booking->event_id }}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="label">Venue</div>
                    <div class="value">
                        {{ $booking->venue_details }}
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
    BILLING CONTACT
    ====================================================== --}}

    <div class="card-box">

        <div class="card-header-custom d-flex justify-content-between">

            <h5 class="mb-0">Billing Contact</h5>

            <span class="status completed">
                Completed
            </span>

        </div>

        <div class="card-body-custom">

            <div class="row">

                <div class="col-md-6">
                    <div class="label">Name</div>
                    <div class="value">
                        {{ $contact->name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="label">Designation</div>
                    <div class="value">
                        {{ $contact->designation ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="label">Email</div>
                    <div class="value">
                        {{ $contact->email ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="label">Mobile</div>
                    <div class="value">
                        {{ $contact->mobile ?? '-' }}
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
    COMPANY DETAILS
    ====================================================== --}}

    <div class="card-box">

        <div class="card-header-custom d-flex justify-content-between">

            <h5 class="mb-0">Company Details</h5>

            <span class="status completed">
                Completed
            </span>

        </div>

        <div class="card-body-custom">

            <div class="row">

                <div class="col-md-6">
                    <div class="label">Company Name</div>
                    <div class="value">
                        {{ $company->company_name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="label">Company ID</div>
                    <div class="value">
                        {{ $company->company_id ?? $booking->company_id }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="label">Category</div>
                    <div class="value">
                        {{ $company->category ?? '-' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="label">City</div>
                    <div class="value">
                        {{ $company->city ?? '-' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="label">State</div>
                    <div class="value">
                        {{ $company->state ?? '-' }}
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="label">Address</div>
                    <div class="value">
                        {{ $company->address ?? '-' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="label">Pincode</div>
                    <div class="value">
                        {{ $company->pincode ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="label">GST Number</div>
                    <div class="value">
                        {{ $company->gst_number ?: '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="label">Website</div>
                    <div class="value">
                        {{ $company->website ?: '-' }}
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
    EACH STALL
    ====================================================== --}}

    <div class="card-box">

        <div class="card-header-custom">

            <h5 class="mb-0">Stall Details</h5>

        </div>

        <div class="card-body-custom">

            @foreach($stalls as $index => $stall)

                <div class="stall">

                    <div class="stall-header">

                        <h5>
                            Stall {{ $index + 1 }}
                        </h5>

                        <span class="status completed">
                            {{ $stall->stall_type }}
                        </span>

                    </div>


                    <div class="stall-body">


                        {{-- STALL INFORMATION --}}

                        <div class="row">

                            <div class="col-md-4">
                                <div class="label">Stall Size</div>
                                <div class="value">
                                    {{ $stall->stall_size ?: '-' }}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="label">Stall Location</div>
                                <div class="value">
                                    {{ $stall->stall_location ?: '-' }}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="label">Stall Type</div>
                                <div class="value">
                                    {{ $stall->stall_type ?: '-' }}
                                </div>
                            </div>

                        </div>


                        {{-- PAYMENT --}}

                        <div class="status-section">

                            <div class="status-heading">

                                <strong>Payment</strong>

                                <span class="status pending">
                                    Pending
                                </span>

                            </div>

                            <div class="description">
                                Payment has not been received.
                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="label">
                                        Payment Status
                                    </div>

                                    <div class="value">
                                        <span class="status pending">
                                            Pending
                                        </span>
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="label">
                                        Amount
                                    </div>

                                    <div class="value">
                                        Pending
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="label">
                                        Transaction ID
                                    </div>

                                    <div class="value">
                                        N/A
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- FASCIA --}}

                        <div class="status-section">

                            <div class="status-heading">

                                <strong>Fascia</strong>

                                @if($stall->fascia)

                                    <span class="status completed">
                                        Completed
                                    </span>

                                @else

                                    <span class="status action">
                                        Action Required
                                    </span>

                                @endif

                            </div>

                            @if($stall->fascia)

                                <div class="label">
                                    Fascia Name
                                </div>

                                <div class="value">
                                    {{ $stall->fascia }}
                                </div>

                            @else

                                <div class="description">
                                    Fascia details have not been submitted.
                                </div>

                            @endif

                        </div>


                        {{-- DELEGATES --}}

                        <div class="status-section">

                            <div class="status-heading">

                                <strong>Delegates</strong>

                                <span class="status action">
                                    Action Required
                                </span>

                            </div>

                            <div class="description">
                                Delegate details have not been submitted.
                            </div>

                            <a href="#" class="btn btn-primary btn-sm">
                                Add Delegates
                            </a>

                        </div>


                        {{-- CERTIFICATE --}}

                        <div class="status-section">

                            <div class="status-heading">

                                <strong>Certificate</strong>

                                @if($stall->certificate)

                                    <span class="status completed">
                                        Completed
                                    </span>

                                @else

                                    <span class="status action">
                                        Action Required
                                    </span>

                                @endif

                            </div>

                            @if($stall->certificate)

                                <div class="label">
                                    Certificate Name
                                </div>

                                <div class="value">
                                    {{ $stall->certificate }}
                                </div>

                            @else

                                <div class="description">
                                    Certificate details have not been submitted.
                                </div>

                            @endif

                        </div>


                        {{-- BRANDING --}}

                        <div class="status-section">

                            <div class="status-heading">

                                <strong>Branding</strong>

                                @if($stall->branding)

                                    <span class="status completed">
                                        Completed
                                    </span>

                                @else

                                    <span class="status action">
                                        Action Required
                                    </span>

                                @endif

                            </div>

                            @if($stall->branding)

                                <div class="description">
                                    Branding requirements have been submitted.
                                </div>

                            @else

                                <div class="description">
                                    Upload logo and branding requirements.
                                </div>

                                <a href="" class="btn btn-primary btn-sm">
                                    Add Branding
                                </a>

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>