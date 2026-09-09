{{-- =====================================================
ADD NEW STALL
====================================================== --}}

<div class="card mb-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <strong>
            Add New Stall
        </strong>

        <span class="badge bg-success">
            New Stall
        </span>

    </div>

    <form action="" method="POST">

        @csrf

        {{-- Booking ID --}}
        <input type="hidden" name="booking_id" value="{{ $bookingdata->booking_id }}">

        <div class="card-body">

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
                            Event ID <span class="text-danger">*</span>
                        </label>

                        <input type="number" class="form-control" name="event_id" value="{{ old('event_id') }}"
                            required>

                    </div>


                    {{-- Event Name --}}
                    <div class="col-md-5 mb-3">

                        <label class="form-label">
                            Event Name
                        </label>

                        <input type="text" class="form-control" name="event_name" value="{{ old('event_name') }}">

                    </div>


                    {{-- Year --}}
                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            Year
                        </label>

                        <input type="number" class="form-control" name="year" value="{{ old('year') }}">

                    </div>


                    {{-- B2B Constraint --}}
                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            B2B Constraint
                        </label>

                        <input type="text" class="form-control" name="b2b_constrain" value="{{ old('b2b_constrain') }}">

                    </div>


                    {{-- Venue --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Venue
                        </label>

                        <textarea class="form-control" name="venue_details"
                            rows="2">{{ old('venue_details') }}</textarea>

                    </div>


                    {{-- Start Date --}}
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Start Date
                        </label>

                        <input type="date" class="form-control" name="start_date" value="{{ old('start_date') }}">

                    </div>


                    {{-- End Date --}}
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            End Date
                        </label>

                        <input type="date" class="form-control" name="end_date" value="{{ old('end_date') }}">

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
                        Stall Size <span class="text-danger">*</span>
                    </label>

                    <input type="text" class="form-control" name="stall_size" value="{{ old('stall_size') }}" required>

                </div>


                {{-- Stall Location --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Stall Location
                    </label>

                    <input type="text" class="form-control" name="stall_location" value="{{ old('stall_location') }}">

                </div>


                {{-- Stall Type --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Stall Type
                    </label>

                    <input type="text" class="form-control" name="stall_type" value="{{ old('stall_type') }}">

                </div>


                {{-- Fascia --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Fascia
                    </label>

                    <input type="text" class="form-control" name="fascia" value="{{ old('fascia') }}">

                </div>


                {{-- Certificate --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Certificate
                    </label>

                    <input type="text" class="form-control" name="certificate" value="{{ old('certificate') }}">

                </div>


                {{-- Branding --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Branding
                    </label>

                    <select class="form-select" name="branding">

                        <option value="0" {{ old('branding', 0) == 0 ? 'selected' : '' }}>
                            No
                        </option>

                        <option value="1" {{ old('branding') == 1 ? 'selected' : '' }}>
                            Yes
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

                    <input type="number" step="0.01" class="form-control" name="original_amount"
                        value="{{ old('original_amount', 0) }}">

                </div>


                {{-- Discount Code --}}
                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Discount Code
                    </label>

                    <input type="text" class="form-control" name="discount_code" value="{{ old('discount_code') }}">

                </div>


                {{-- Discount --}}
                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Discount Amount
                    </label>

                    <input type="number" step="0.01" class="form-control" name="discount_amount"
                        value="{{ old('discount_amount', 0) }}">

                </div>


                {{-- GST --}}
                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        GST Amount
                    </label>

                    <input type="number" step="0.01" class="form-control" name="gst_amount"
                        value="{{ old('gst_amount', 0) }}">

                </div>


                {{-- Final Price --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Final Price
                    </label>

                    <input type="number" step="0.01" class="form-control" name="final_price"
                        value="{{ old('final_price', 0) }}">

                </div>


                {{-- Due Amount --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Due Amount
                    </label>

                    <input type="number" step="0.01" class="form-control" name="due_amount"
                        value="{{ old('due_amount', 0) }}">

                </div>

            </div>

        </div>


        {{-- =================================================
        FOOTER
        ================================================== --}}

        <div class="card-footer d-flex justify-content-end">

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add Stall
            </button>

        </div>

    </form>

</div>