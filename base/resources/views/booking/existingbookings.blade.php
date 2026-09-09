<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Booking ID</th>
                <th>Event</th>
                <th>Company ID</th>
                <th>Sales ID</th>
                <th>Stall Size</th>
                <th>Location</th>
                <th>Stall Type</th>
                <th>Fascia</th>
                <th>Certificate</th>
                <th>Branding</th>
            </tr>
        </thead>

        <tbody>
            @forelse($bookingdata as $key => $booking)
                <tr>
                    <td>{{ $key + 1 }}</td>

                    <td>
                        <strong>{{ $booking->booking_id }}</strong>
                    </td>

                    <td>
                        <strong>{{ $booking->event_name ?? '-' }}</strong>
                        <br>
                        <small class="text-muted">
                            {{ $booking->event_year ?? '-' }}
                        </small>
                    </td>

                    <td>
                        <span class="badge bg-primary">
                            {{ $booking->company_id }}
                        </span>
                    </td>

                    <td>{{ $booking->sales_id ?? '-' }}</td>

                    <td>{{ $booking->stall_size ?? '-' }}</td>

                    <td>{{ $booking->stall_location ?? '-' }}</td>

                    <td>
                        <span class="badge bg-info text-dark">
                            {{ $booking->stall_type ?? '-' }}
                        </span>
                    </td>

                    <td>{{ $booking->fascia ?? '-' }}</td>

                    <td>{{ $booking->certificate ?? '-' }}</td>

                    <td>
                        @if($booking->branding == 1)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center text-muted py-4">
                        No booking data found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>