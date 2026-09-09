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

                {{-- Existing Stalls --}}
                @foreach($stall as $index => $item)

                <div class="stall-row border rounded p-3 mb-3">

                    <div class="d-flex justify-content-between mb-3">
                        <h6>Stall {{ $index + 1 }}</h6>

                        <button type="button" class="btn btn-danger btn-sm removeStall">
                            Remove
                        </button>
                    </div>

                    <input type="hidden" name="stalls[{{ $index }}][id]" value="{{ $item->id }}">

                    <input type="hidden" name="stalls[{{ $index }}][event_id]" value="{{ $item->event_id ?? '' }}">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stall Size</label>
                            <input type="text" name="stalls[{{ $index }}][stall_size]" class="form-control"
                                value="{{ $item->stall_size }}" placeholder="Enter stall size">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stall Location</label>
                            <input type="text" name="stalls[{{ $index }}][stall_location]" class="form-control"
                                value="{{ $item->stall_location }}" placeholder="Enter stall location">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stall Type</label>
                            <select name="stalls[{{ $index }}][stall_type]" class="form-select">
                                <option value="">Select Stall Type</option>

                                <option value="Shell Scheme" {{ $item->stall_type == 'Shell Scheme' ? 'selected' : ''
                                    }}>
                                    Shell Scheme
                                </option>

                                <option value="Bare Space" {{ $item->stall_type == 'Bare Space' ? 'selected' : '' }}>
                                    Bare Space
                                </option>

                                <option value="Open Space" {{ $item->stall_type == 'Open Space' ? 'selected' : '' }}>
                                    Open Space
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fascia</label>
                            <input type="text" name="stalls[{{ $index }}][fascia]" class="form-control"
                                value="{{ $item->fascia }}" placeholder="Enter fascia">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Certificate</label>
                            <input type="text" name="stalls[{{ $index }}][certificate]" class="form-control"
                                value="{{ $item->certificate }}" placeholder="Enter certificate">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">Branding</label>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="stalls[{{ $index }}][branding]"
                                    value="1" {{ $item->branding == 1 ? 'checked' : '' }}>

                                <label class="form-check-label">
                                    Yes
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="stalls[{{ $index }}][branding]"
                                    value="0" {{ $item->branding == 0 ? 'checked' : '' }}>

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

    document.getElementById('addStall').addEventListener('click', function () {

        const container = document.getElementById('stallContainer');

        const stall = `
                <div class="stall-row border rounded p-3 mb-3">

                    <div class="d-flex justify-content-between mb-3">
                        <h6>Stall ${stallIndex + 1}</h6>

                        <button type="button"
                                class="btn btn-danger btn-sm removeStall">
                            Remove
                        </button>
                    </div>

                    <input type="hidden"
                           name="stalls[${stallIndex}][event_id]"
                           value="{{ $bookingdata->event_id ?? '' }}">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stall Size</label>
                            <input type="text"
                                   name="stalls[${stallIndex}][stall_size]"
                                   class="form-control"
                                   placeholder="Enter stall size">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stall Location</label>
                            <input type="text"
                                   name="stalls[${stallIndex}][stall_location]"
                                   class="form-control"
                                   placeholder="Enter stall location">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stall Type</label>
                            <select name="stalls[${stallIndex}][stall_type]"
                                    class="form-select">
                                <option value="">Select Stall Type</option>
                                <option value="Shell Scheme">Shell Scheme</option>
                                <option value="Bare Space">Bare Space</option>
                                <option value="Open Space">Open Space</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fascia</label>
                            <input type="text"
                                   name="stalls[${stallIndex}][fascia]"
                                   class="form-control"
                                   placeholder="Enter fascia">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Certificate</label>
                            <input type="text"
                                   name="stalls[${stallIndex}][certificate]"
                                   class="form-control"
                                   placeholder="Enter certificate">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">Branding</label>

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

    document.getElementById('stallContainer').addEventListener('click', function (e) {

        if (e.target.classList.contains('removeStall')) {
            e.target.closest('.stall-row').remove();
        }

    });

    });
</script>