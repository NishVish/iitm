<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Stall Details</h5>

        <button type="button" class="btn btn-success btn-sm" id="addStall">
            + Add Stall
        </button>
    </div>

    <div class="card-body">

        <form action="{{ url('updateStall') }}" method="POST">
            @csrf

            <input type="hidden" name="booking_id" value="{{ $bookingdata->booking_id ?? '' }}">

            <div id="stallContainer">

                @foreach($stall as $index => $item)

                <div class="stall-row border rounded p-3 mb-3">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">
                            Stall {{ $index + 1 }}
                        </h6>

                        <button type="button" class="btn btn-danger btn-sm removeStall">
                            Remove
                        </button>
                    </div>

                    {{-- Stall Hidden Data --}}
                    <input type="hidden" name="stalls[{{ $index }}][id]" value="{{ $item->id }}">

                    <input type="hidden" name="stalls[{{ $index }}][event_id]" value="{{ $item->event_id ?? '' }}">

                    {{-- Event Details --}}
                    <div class="card bg-light border mb-4">
                        <div class="card-header">
                            <strong>Event Details</strong>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 mb-2">
                                    <strong>Event:</strong>
                                    {{ $item->event_name ?? 'Event not assigned' }}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Event ID:</strong>
                                    {{ $item->event_id ?? 'Not assigned' }}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Year:</strong>
                                    {{ $item->year ?? '-' }}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Venue:</strong>
                                    {{ $item->venue_details ?? '-' }}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Start Date:</strong>
                                    {{ $item->start_date ?? '-' }}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>End Date:</strong>
                                    {{ $item->end_date ?? '-' }}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Total Venue Area:</strong>
                                    {{ $item->total_venue_area ?? '-' }}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Stall Price:</strong>
                                    {{ $item->stallprice ?? '-' }}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Coordinator:</strong>
                                    {{ $item->coordinator ?? '-' }}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>B2B Constraint:</strong>
                                    {{ $item->b2b_constrain ?? '-' }}
                                </div>

                                <div class="col-md-12 mb-2">
                                    <strong>Venue Booking Details:</strong>
                                    {{ $item->venue_booking_details ?? '-' }}
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Stall Details --}}
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stall Size</label>

                            <input type="text" name="stalls[{{ $index }}][stall_size]" class="form-control"
                                value="{{ $item->stall_size ?? '' }}" placeholder="Enter stall size">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stall Location</label>

                            <input type="text" name="stalls[{{ $index }}][stall_location]" class="form-control"
                                value="{{ $item->stall_location ?? '' }}" placeholder="Enter stall location">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stall Type</label>

                            <select name="stalls[{{ $index }}][stall_type]" class="form-select">

                                <option value="">
                                    Select Stall Type
                                </option>

                                <option value="Shell Scheme" {{ ($item->stall_type ?? '') == 'Shell Scheme' ? 'selected'
                                    : '' }}>
                                    Shell Scheme
                                </option>

                                <option value="Bare Space" {{ ($item->stall_type ?? '') == 'Bare Space' ? 'selected' :
                                    '' }}>
                                    Bare Space
                                </option>

                                <option value="Open Space" {{ ($item->stall_type ?? '') == 'Open Space' ? 'selected' :
                                    '' }}>
                                    Open Space
                                </option>

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fascia</label>

                            <input type="text" name="stalls[{{ $index }}][fascia]" class="form-control"
                                value="{{ $item->fascia ?? '' }}" placeholder="Enter fascia">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Certificate</label>

                            <input type="text" name="stalls[{{ $index }}][certificate]" class="form-control"
                                value="{{ $item->certificate ?? '' }}" placeholder="Enter certificate">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">
                                Branding
                            </label>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="stalls[{{ $index }}][branding]"
                                    value="1" {{ ($item->branding ?? 0) == 1 ? 'checked' : '' }}>

                                <label class="form-check-label">
                                    Yes
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="stalls[{{ $index }}][branding]"
                                    value="0" {{ ($item->branding ?? 0) == 0 ? 'checked' : '' }}>

                                <label class="form-check-label">
                                    No
                                </label>
                            </div>
                        </div>

                    </div>

                </div>

                @endforeach

            </div>

            <button type="submit" class="btn btn-primary">
                Save & Continue
            </button>

        </form>

    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        let stallIndex = {{ $stall-> count()
    }};

    const container = document.getElementById('stallContainer');
    const addStallButton = document.getElementById('addStall');

    addStallButton.addEventListener('click', function () {

        const eventId = @json($bookingdata -> event_id ?? '');
        const eventName = @json($bookingdata -> event_name ?? '');
        const eventYear = @json($bookingdata -> year ?? '');
        const eventImage = @json($bookingdata -> event_image ?? '');
        const venueDetails = @json($bookingdata -> venue_details ?? '');
        const totalVenueArea = @json($bookingdata -> total_venue_area ?? '');
        const stallPrice = @json($bookingdata -> stallprice ?? '');
        const venueBookingDetails = @json($bookingdata -> venue_booking_details ?? '');
        const coordinator = @json($bookingdata -> coordinator ?? '');
        const b2bConstrain = @json($bookingdata -> b2b_constrain ?? '');
        const startDate = @json($bookingdata -> start_date ?? '');
        const endDate = @json($bookingdata -> end_date ?? '');

        const stall = `
                <div class="stall-row border rounded p-3 mb-3">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">
                            Stall ${stallIndex + 1}
                        </h6>

                        <button type="button"
                                class="btn btn-danger btn-sm removeStall">
                            Remove
                        </button>
                    </div>

                    <input type="hidden"
                           name="stalls[${stallIndex}][event_id]"
                           value="${eventId}">

                    <div class="card bg-light border mb-4">
                        <div class="card-header">
                            <strong>Event Details</strong>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 mb-2">
                                    <strong>Event:</strong>
                                    ${eventName || 'Event not assigned'}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Event ID:</strong>
                                    ${eventId || 'Not assigned'}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Year:</strong>
                                    ${eventYear || '-'}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Venue:</strong>
                                    ${venueDetails || '-'}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Start Date:</strong>
                                    ${startDate || '-'}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>End Date:</strong>
                                    ${endDate || '-'}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Total Venue Area:</strong>
                                    ${totalVenueArea || '-'}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Stall Price:</strong>
                                    ${stallPrice || '-'}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>Coordinator:</strong>
                                    ${coordinator || '-'}
                                </div>

                                <div class="col-md-6 mb-2">
                                    <strong>B2B Constraint:</strong>
                                    ${b2bConstrain || '-'}
                                </div>

                                <div class="col-md-12 mb-2">
                                    <strong>Venue Booking Details:</strong>
                                    ${venueBookingDetails || '-'}
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Stall Size
                            </label>

                            <input type="text"
                                   name="stalls[${stallIndex}][stall_size]"
                                   class="form-control"
                                   placeholder="Enter stall size">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Stall Location
                            </label>

                            <input type="text"
                                   name="stalls[${stallIndex}][stall_location]"
                                   class="form-control"
                                   placeholder="Enter stall location">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Stall Type
                            </label>

                            <select name="stalls[${stallIndex}][stall_type]"
                                    class="form-select">

                                <option value="">
                                    Select Stall Type
                                </option>

                                <option value="Shell Scheme">
                                    Shell Scheme
                                </option>

                                <option value="Bare Space">
                                    Bare Space
                                </option>

                                <option value="Open Space">
                                    Open Space
                                </option>

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Fascia
                            </label>

                            <input type="text"
                                   name="stalls[${stallIndex}][fascia]"
                                   class="form-control"
                                   placeholder="Enter fascia">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Certificate
                            </label>

                            <input type="text"
                                   name="stalls[${stallIndex}][certificate]"
                                   class="form-control"
                                   placeholder="Enter certificate">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">
                                Branding
                            </label>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="stalls[${stallIndex}][branding]"
                                       value="1">

                                <label class="form-check-label">
                                    Yes
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="stalls[${stallIndex}][branding]"
                                       value="0"
                                       checked>

                                <label class="form-check-label">
                                    No
                                </label>
                            </div>
                        </div>

                    </div>

                </div>
            `;

        container.insertAdjacentHTML('beforeend', stall);

        stallIndex++;
    });

    container.addEventListener('click', function (e) {

        if (e.target.classList.contains('removeStall')) {
            e.target.closest('.stall-row').remove();
        }

    });

    });
</script>

<h1>HEhoiasdifhaspouidfhiosd</h1>