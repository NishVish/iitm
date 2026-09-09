<div class="stall-page">

    @php
        $stallList = is_iterable($stall) && !($stall instanceof \stdClass) ? $stall : [$stall];
    @endphp

    @foreach($stallList as $index => $item)

        <form action="{{ url('updateStallDetailsId') }}" method="POST" class="stall-form">
            @csrf

            <input type="hidden" name="booking_id" value="{{ $bookingdata->booking_id ?? '' }}">
            <input type="hidden" name="id" value="{{ data_get($item, 'id') }}">
            <input type="hidden" name="event_id" value="{{ data_get($item, 'event_id') ?? '' }}">

            <div class="stall-card mb-4">

                <div class="card-badge-header d-flex justify-content-between align-items-center">

                    <div class="event-title d-flex align-items-center gap-3">
                        <span class="badge-soft">
                            STALL {{ $index + 1 }}
                        </span>

                        <h5 class="font-weight-bold text-dark">
                            {{ data_get($item, 'event_name') ?? 'Event Not Assigned' }}
                        </h5>
                          
                    </div>

                    <span class="event-id-badge badge bg-white text-secondary border px-3 py-2 rounded-pill shadow-sm">
                        ID: {{ data_get($item, 'event_id') ?? 'N/A' }}
                    </span>

                </div>

                <div class="stall-body">

                    <div class="event-info-panel">

                        <div class="event-info-grid">

                            <div class="info-item">

                                <div class="info-icon">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>

                                <div class="info-content">
                                    <div class="info-label">
                                        Year / Schedule
                                    </div>

                                    <div class="info-value">
                                        {{ data_get($item, 'year') ?? '-' }}

                                        <span class="info-value-small">
                                            {{ data_get($item, 'start_date') ?? '-' }}
                                            to
                                            {{ data_get($item, 'end_date') ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                            </div>

                            <div class="info-item">

                                <div class="info-icon">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                        </path>
                                    </svg>
                                </div>

                                <div class="info-content">
                                    <div class="info-label">
                                        Venue Details
                                    </div>

                                    <div class="info-value">
                                        {{ data_get($item, 'venue_details') ?? '-' }}
                                    </div>
                                </div>

                            </div>

                            <div class="info-item">

                                <div class="info-icon">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                                        </path>
                                    </svg>
                                </div>

                                <div class="info-content">
                                    <div class="info-label">
                                        Venue Area
                                    </div>

                                    <div class="info-value">
                                        {{ data_get($item, 'total_venue_area') ?? '-' }}
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="form-section">

                        <div class="form-grid">

                            <div class="form-field">

                                <label class="field-label">
                                    Stall Size
                                </label>

                                <div class="allocated-area">
                                    <span>
                                        Allocated Area
                                    </span>

                                    <strong>
                                        {{ data_get($item, 'stall_size') ?? 'N/A' }}
                                    </strong>
                                </div>

                            </div>

                            <div class="form-field">

                                <label class="field-label">
                                    Stall Location
                                </label>

                                <input
                                    type="text"
                                    name="stall_location"
                                    class="form-control-modern"
                                    value="{{ data_get($item, 'stall_location') ?? '' }}"
                                    placeholder="e.g. Hall A, Row 4"
                                >

                            </div>

                            <div class="form-field">

                                <label class="field-label">
                                    Fascia Name
                                </label>

                                <input
                                    type="text"
                                    name="fascia"
                                    class="form-control-modern"
                                    value="{{ data_get($item, 'fascia') ?? '' }}"
                                    placeholder="Text for Fascia Board"
                                >

                            </div>

                            <div class="form-field">

                                <label class="field-label">
                                    Certificate Details
                                </label>

                                <input
                                    type="text"
                                    name="certificate"
                                    class="form-control-modern"
                                    value="{{ data_get($item, 'certificate') ?? '' }}"
                                    placeholder="Name printed on Certificate"
                                >

                            </div>

                            <div class="form-field">

                                <label class="field-label">
                                    Branding Needed
                                </label>

                                <div class="segmented-control">

                                    <input
                                        type="radio"
                                        id="branding_yes_{{ $index }}"
                                        name="branding"
                                        value="1"
                                        {{ (data_get($item, 'branding') ?? 0) == 1 ? 'checked' : '' }}
                                    >

                                    <label for="branding_yes_{{ $index }}">
                                        Yes
                                    </label>

                                    <input
                                        type="radio"
                                        id="branding_no_{{ $index }}"
                                        name="branding"
                                        value="0"
                                        {{ (data_get($item, 'branding') ?? 0) == 0 ? 'checked' : '' }}
                                    >

                                    <label for="branding_no_{{ $index }}">
                                        No
                                    </label>

                                </div>

                            </div>

                        </div>
                        <h1>Hlleo</h1>

                    </div>

                </div>

                <div class="save-section">

                    <button type="submit" class="btn-gradient">

                        <span>
                            Save Stall {{ $index + 1 }} &amp; Continue
                        </span>

                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"
                            >
                            </path>
                        </svg>

                    </button>

                </div>

            </div>

        </form>
        @include('exhibitor.booking.delegate')

    @endforeach

</div>