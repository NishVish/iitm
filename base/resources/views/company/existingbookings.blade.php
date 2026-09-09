<!-- Existing Bookings -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Existing Bookings</h5>
        <small class="text-muted">Previous and current bookings</small>
    </div>

    <div class="card-body">
        @php
            /*
             * $bookingdata can be either:
             *
             * 1. A single booking stdClass
             * 2. A Collection/array of booking stdClass objects
             *
             * Normalize everything into a collection of bookings.
             */

            if (isset($bookingdata) && is_object($bookingdata) && isset($bookingdata->booking_id)) {
                $bookings = collect([$bookingdata]);
            } elseif (isset($bookingdata) && $bookingdata instanceof \Illuminate\Support\Collection) {
                $bookings = $bookingdata;
            } elseif (isset($bookingdata) && is_array($bookingdata)) {
                $bookings = collect($bookingdata);
            } else {
                $bookings = collect();
            }

            $rowNumber = 1;
        @endphp

        @if($bookings->isNotEmpty())

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Booking ID</th>
                            <th>Event</th>
                            <th>Stall Size</th>
                            <th>Stall Location</th>
                            <th>Stall Type</th>
                            <th>Fascia</th>
                            <th>Certificate</th>
                            <th>Branding</th>
                            <th>Original Amount</th>
                            <th>Final Price</th>
                            <th>GST</th>
                            <th>Due Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($bookings as $booking)

                            @php
                                /*
                                 * Normalize stalls to a Collection.
                                 */
                                if (
                                    is_object($booking) &&
                                    isset($booking->stalls)
                                ) {
                                    if ($booking->stalls instanceof \Illuminate\Support\Collection) {
                                        $stalls = $booking->stalls;
                                    } elseif (is_array($booking->stalls)) {
                                        $stalls = collect($booking->stalls);
                                    } elseif (is_object($booking->stalls)) {
                                        $stalls = collect([$booking->stalls]);
                                    } else {
                                        $stalls = collect();
                                    }
                                } else {
                                    $stalls = collect();
                                }
                            @endphp

                            @forelse($stalls as $stall)

                                <tr>
                                    <td>
                                        {{ $rowNumber++ }}
                                    </td>

                                    <td>
                                        <a href="{{ url('sales/booking/' . $booking->booking_id) }}">
                                            <strong>
                                                {{ $booking->booking_id }}
                                            </strong>
                                        </a>
                                    </td>

                                    <td>
                                        {{ $stall->name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $stall->stall_size ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $stall->stall_location ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $stall->stall_type ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $stall->fascia ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $stall->certificate ?? '-' }}
                                    </td>

                                    <td>
                                        @if(isset($stall->branding))
                                            {{ $stall->branding == 1 ? 'Yes' : 'No' }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if(isset($stall->original_amount))
                                            {{ number_format((float) $stall->original_amount, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if(isset($stall->final_price))
                                            {{ number_format((float) $stall->final_price, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if(isset($stall->gst_amount))
                                            {{ number_format((float) $stall->gst_amount, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if(isset($stall->due_amount))
                                            {{ number_format((float) $stall->due_amount, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="13" class="text-center text-muted">
                                        No stalls found for this booking.
                                    </td>
                                </tr>

                            @endforelse

                        @endforeach
                    </tbody>
                </table>
            </div>

        @else

            <div class="alert alert-info mb-0">
                No existing bookings found.
            </div>

        @endif
    </div>
</div>