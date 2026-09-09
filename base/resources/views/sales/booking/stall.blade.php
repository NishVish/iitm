{{-- =====================================================
STALLS
====================================================== --}}
@foreach($bookingdata->stalls as $index => $stall)
    <form action="" method="POST">
        @csrf

        <div class="card mb-4">

            {{-- Stall Header --}}
            <div class="card-header d-flex justify-content-between align-items-center">

                <div>
                    <strong>
                        Stall #{{ $index + 1 }}
                    </strong>

                    <span class="text-muted ms-2">
                        {{ $stall['stall_id'] }}
                    </span>
                </div>

                <span class="badge bg-primary">
                    {{ $stall['name'] }}
                </span>

            </div>


            <div class="card-body">

                {{-- =================================================
                Hidden IDs
                ================================================== --}}

                <input type="hidden" name="stalls[{{ $index }}][stall_id]" value="{{ $stall['stall_id'] }}">

                <input type="hidden" name="stalls[{{ $index }}][booking_id]" value="{{ $stall['booking_id'] }}">


                {{-- =================================================
                EVENT INFORMATION
                ================================================== --}}

                <div class="bg-light border rounded p-3 mb-4">

                    <h6 class="mb-3">
                        Event Information
                    </h6>

                    <div class="row">

                        {{-- Event ID --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Event ID
                            </label>

                            <input type="number" class="form-control" name="stalls[{{ $index }}][event_id]"
                                value="{{ $stall['event_id'] }}">

                        </div>


                        {{-- Event Name --}}
                        <div class="col-md-5 mb-3">

                            <label class="form-label">
                                Event Name
                            </label>

                            <input type="text" class="form-control" value="{{ $stall['name'] }}" readonly>

                        </div>


                        {{-- Year --}}
                        <div class="col-md-2 mb-3">

                            <label class="form-label">
                                Year
                            </label>

                            <input type="number" class="form-control" value="{{ $stall['year'] }}" readonly>

                        </div>


                        {{-- B2B --}}
                        <div class="col-md-2 mb-3">

                            <label class="form-label">
                                B2B Constraint
                            </label>

                            <input type="text" class="form-control" value="{{ $stall['b2b_constrain'] }}" readonly>

                        </div>


                        {{-- Venue --}}
                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Venue
                            </label>

                            <textarea class="form-control" rows="2" readonly>{{ $stall['venue_details'] }}</textarea>

                        </div>


                        {{-- Start Date --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Start Date
                            </label>

                            <input type="date" class="form-control" value="{{ $stall['start_date'] }}" readonly>

                        </div>


                        {{-- End Date --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                End Date
                            </label>

                            <input type="date" class="form-control" value="{{ $stall['end_date'] }}" readonly>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                STALL INFORMATION
                ================================================== --}}

                <h6 class="mb-3">
                    Stall Information
                </h6>

                <div class="row">

                    {{-- Stall Size --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Stall Size
                        </label>

                        <input type="text" class="form-control" name="stalls[{{ $index }}][stall_size]"
                            value="{{ $stall['stall_size'] }}">

                    </div>


                    {{-- Stall Location --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Stall Location
                        </label>

                        <input type="text" class="form-control" name="stalls[{{ $index }}][stall_location]"
                            value="{{ $stall['stall_location'] }}">

                    </div>


                    {{-- Stall Type --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Stall Type
                        </label>

                        <input type="text" class="form-control" name="stalls[{{ $index }}][stall_type]"
                            value="{{ $stall['stall_type'] }}">

                    </div>


                    {{-- Fascia --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Fascia
                        </label>

                        <input type="text" class="form-control" name="stalls[{{ $index }}][fascia]"
                            value="{{ $stall['fascia'] }}">

                    </div>


                    {{-- Certificate --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Certificate
                        </label>

                        <input type="text" class="form-control" name="stalls[{{ $index }}][certificate]"
                            value="{{ $stall['certificate'] }}">

                    </div>


                    {{-- Branding --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Branding
                        </label>

                        <select class="form-select" name="stalls[{{ $index }}][branding]">

                            <option value="1" {{ $stall['branding'] == 1 ? 'selected' : '' }}>
                                Yes
                            </option>

                            <option value="0" {{ $stall['branding'] == 0 ? 'selected' : '' }}>
                                No
                            </option>

                        </select>

                    </div>

                </div>


                {{-- =================================================
                PAYMENT INFORMATION
                ================================================== --}}

                <hr>

                <h6 class="mb-3">
                    Payment Details
                </h6>

                <div class="row">

                    {{-- Original Amount --}}
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Original Amount
                        </label>

                        <input type="number" step="0.01" class="form-control" name="stalls[{{ $index }}][original_amount]"
                            value="{{ $stall['original_amount'] }}">

                    </div>


                    {{-- Discount Code --}}
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Discount Code
                        </label>

                        <input type="text" class="form-control" name="stalls[{{ $index }}][discount_code]"
                            value="{{ $stall['discount_code'] }}">

                    </div>


                    {{-- Discount --}}
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Discount Amount
                        </label>

                        <input type="number" step="0.01" class="form-control" name="stalls[{{ $index }}][discount_amount]"
                            value="{{ $stall['discount_amount'] }}">

                    </div>


                    {{-- GST --}}
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            GST Amount
                        </label>

                        <input type="number" step="0.01" class="form-control" name="stalls[{{ $index }}][gst_amount]"
                            value="{{ $stall['gst_amount'] }}">

                    </div>


                    {{-- Final Price --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Final Price
                        </label>

                        <input type="number" step="0.01" class="form-control" name="stalls[{{ $index }}][final_price]"
                            value="{{ $stall['final_price'] }}">

                    </div>


                    {{-- Due Amount --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Due Amount
                        </label>

                        <input type="number" step="0.01" class="form-control" name="stalls[{{ $index }}][due_amount]"
                            value="{{ $stall['due_amount'] }}">

                    </div>

                </div>

            </div>

        </div> <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            Save Booking
        </button>

    </form>

@endforeach


{{-- =====================================================
SAVE
====================================================== --}}