<section>
    <div class="section-head">
        <h2>Stall Documents</h2>
        <p>Certificate Name & Fascia Name</p>
    </div>

    @php
        $stalls = $final_bookingdetails ?? collect();

        if (is_object($stalls) && isset($stalls->stalls)) {
            $stalls = $stalls->stalls;
        }

        if (!is_iterable($stalls)) {
            $stalls = collect();
        }
    @endphp

    @forelse($stalls as $stall)

        @php
            $stallId = $stall->id ?? null;
            $certificateName = $stall->certificate ?? null;
            $fasciaName = $stall->fascia ?? null;
        @endphp

        <div class="card mb-4 shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <strong>Stall #{{ $stallId }}</strong>
                </div>

                @if($stallId)
                    <span class="badge bg-success">
                        Stall ID Available
                    </span>
                @else
                    <span class="badge bg-danger">
                        Stall ID Missing
                    </span>
                @endif
            </div>

            <div class="card-body">

                <form method="POST" action="{{ url('updateStallDetailsId') }}">

                    @csrf

                    <input type="hidden" name="stall_id" value="{{ $stallId }}">

                    <input type="hidden" name="booking_id" value="{{ $stall->booking_id ?? '' }}">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                Certificate Name
                            </label>

                            <div class="input-group">

                                <input type="text" name="certificate" class="form-control"
                                    value="{{ $certificateName ?? '' }}" placeholder="Enter certificate name">

                                @if(!empty($certificateName))
                                    <span class="input-group-text bg-success text-white">
                                        ✓
                                    </span>
                                @else
                                    <span class="input-group-text bg-danger text-white">
                                        ✕
                                    </span>
                                @endif

                            </div>

                            @if(!empty($certificateName))
                                <small class="text-success">
                                    Certificate name is available.
                                </small>
                            @else
                                <small class="text-danger">
                                    Certificate name is not available.
                                </small>
                            @endif

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                Fascia Name
                            </label>

                            <div class="input-group">

                                <input type="text" name="fascia" class="form-control" value="{{ $fasciaName ?? '' }}"
                                    placeholder="Enter fascia name">

                                @if(!empty($fasciaName))
                                    <span class="input-group-text bg-success text-white">
                                        ✓
                                    </span>
                                @else
                                    <span class="input-group-text bg-danger text-white">
                                        ✕
                                    </span>
                                @endif

                            </div>

                            @if(!empty($fasciaName))
                                <small class="text-success">
                                    Fascia name is available.
                                </small>
                            @else
                                <small class="text-danger">
                                    Fascia name is not available.
                                </small>
                            @endif

                        </div>

                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-2">

                        <div>
                            <small class="text-muted">
                                Booking ID:
                                <strong>{{ $stall->booking_id ?? '-' }}</strong>
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save Stall Details
                        </button>

                    </div>

                </form>

            </div>

        </div>

    @empty

        <div class="alert alert-warning">
            No stall details found.
        </div>

    @endforelse

    @include('exhibitor.booking.stalldetails.stalldetailscss')

    @include('exhibitor.booking.stalldetails.index')

</section>