<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Booking Summary</h5>
    </div>
    @include('exhibitor.booking.summary.index')
    <div class="card-body">

        {{-- Booking Details --}}
        <h6 class="mb-3">Booking Details</h6>

        <div class="table-responsive mb-4">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="25%">Booking ID</th>
                        <td>{{ $bookingdata->booking_id ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Event</th>
                        <td>{{ $bookingdata->event_name ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Stall Type</th>
                        <td>{{ $bookingdata->stall_type ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Stall Size</th>
                        <td>{{ $bookingdata->stall_size ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Stall Location</th>
                        <td>{{ $bookingdata->stall_location ?? '-' }}</td>
                    </tr>

                </tbody>
            </table>
        </div>





        {{-- Stall Details --}}
        <h6 class="mb-3">Stall Details</h6>

        @if($stall && $stall->count())
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Stall Size</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Fascia</th>
                            <th>Certificate</th>
                            <th>Branding</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($stall as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->stall_size ?? '-' }}</td>
                                <td>{{ $item->stall_location ?? '-' }}</td>
                                <td>{{ $item->stall_type ?? '-' }}</td>
                                <td>{{ $item->fascia ?? '-' }}</td>
                                <td>{{ $item->certificate ?? '-' }}</td>
                                <td>
                                    {{ $item->branding == 1 ? 'Yes' : 'No' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">No stall details available.</p>
        @endif

    </div>
</div>
Move to Dashboard
<a href="{{ url('exhibitor/closebooking/' . $bookingdata->booking_id) }}">Dashboard</a>