

<form action="{{ route('booking_store') }}" method="POST">
    @csrf

    <div class="row">

        {{-- Event --}}
        <div class="col-md-6 mb-3">
            <label for="event_id" class="form-label">
                Event <span class="text-danger">*</span>
            </label>

            <select name="event_id" id="event_id" class="form-control" required>
                <option value="">Select Event</option>

                @foreach($eventsdata as $event)
                    @if(!empty($event->name))
                        <option value="{{ $event->event_id }}"
                            {{ old('event_id') == $event->event_id ? 'selected' : '' }}>
                            {{ $event->name }}
                        </option>
                    @endif
                @endforeach
            </select>

            @error('event_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


      {{-- Company --}}

<div class="col-md-6 mb-3">
    <!-- <label class="form-label">
        Company <span class="text-danger">*</span>
    </label> -->

    @php
        $company = $companydata->first();
    @endphp

    @if($company)

        {{-- Company ID --}}
        <input
            type="hidden"
            name="company_id"
            value="{{ $company->company_id }}"
        >

        {{-- Company Name --}}
        <input
            type="text"
            class="form-control mb-2"
            value="{{ $company->company_name }}"
            readonly
        >
<br>
        {{-- Address --}}
        <textarea
            class="form-control mb-2"
            rows="3"
            readonly
        >{{ $company->address }}</textarea>

        {{-- City / State / Pincode --}}
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">City</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ $company->city }}"
                    readonly
                >
            </div>

            <div class="col-md-4">
                <label class="form-label">State</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ $company->state }}"
                    readonly
                >
            </div>

            <div class="col-md-4">
                <label class="form-label">Pincode</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ $company->pincode }}"
                    readonly
                >
            </div>
        </div>

    @else
        <div class="alert alert-warning">
            Company details not found.
        </div>
    @endif

    @error('company_id')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>



        {{-- Sales Person --}}
        <div class="col-md-6 mb-3">
            <label for="sales_id" class="form-label">
                Sales Person
            </label>

            <select name="sales_id" id="sales_id" class="form-control">
                <option value="">Select Sales Person</option>

                @foreach($usersdata as $user)
                    <option value="{{ $user->id }}"
                        {{ old('sales_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>

            @error('sales_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


        {{-- Stall Size --}}
        <div class="col-md-6 mb-3">
            <label for="stall_size" class="form-label">
                Stall Size
            </label>

            <input
                type="text"
                name="stall_size"
                id="stall_size"
                class="form-control"
                maxlength="50"
                value="{{ old('stall_size') }}"
                placeholder="e.g. 3m x 3m"
            >

            @error('stall_size')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


        {{-- Stall Location --}}
        <div class="col-md-6 mb-3">
            <label for="stall_location" class="form-label">
                Stall Location
            </label>

            <input
                type="text"
                name="stall_location"
                id="stall_location"
                class="form-control"
                maxlength="100"
                value="{{ old('stall_location') }}"
                placeholder="e.g. Hall A - Stall 25"
            >

            @error('stall_location')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


        {{-- Stall Type --}}
        <div class="col-md-6 mb-3">
            <label for="stall_type" class="form-label">
                Stall Type
            </label>

            <select name="stall_type" id="stall_type" class="form-control">
                <option value="">Select Stall Type</option>

                <option value="Shell Scheme"
                    {{ old('stall_type') == 'Shell Scheme' ? 'selected' : '' }}>
                    Shell Scheme
                </option>

                <option value="Bare Space"
                    {{ old('stall_type') == 'Bare Space' ? 'selected' : '' }}>
                    Bare Space
                </option>

                <option value="Custom Built"
                    {{ old('stall_type') == 'Custom Built' ? 'selected' : '' }}>
                    Custom Built
                </option>
            </select>

            @error('stall_type')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


        {{-- Fascia --}}
        <div class="col-md-6 mb-3">
            <label for="fascia" class="form-label">
                Fascia
            </label>

            <input
                type="text"
                name="fascia"
                id="fascia"
                class="form-control"
                maxlength="255"
                value="{{ old('fascia') }}"
                placeholder="Enter fascia details"
            >

            @error('fascia')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


        {{-- Certificate --}}
        <div class="col-md-6 mb-3">
            <label for="certificate" class="form-label">
                Certificate
            </label>

            <input
                type="text"
                name="certificate"
                id="certificate"
                class="form-control"
                maxlength="255"
                value="{{ old('certificate') }}"
                placeholder="Enter certificate details"
            >

            @error('certificate')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


        {{-- Branding --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">
                Branding
            </label>

            <div class="form-check">
                <input
                    type="hidden"
                    name="branding"
                    value="0"
                >

                <input
                    type="checkbox"
                    name="branding"
                    id="branding"
                    value="1"
                    class="form-check-input"
                    {{ old('branding') == 1 ? 'checked' : '' }}
                >

                <label for="branding" class="form-check-label">
                    Branding Required
                </label>
            </div>

            @error('branding')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

    </div>

    <button type="submit" class="btn btn-primary">
        Save Stall Details
    </button>

</form>