@foreach($final_bookingdetails->stalls as $stall)

    <div style="display: flex; gap: 20px; width: 100%;">
        <div style="flex: 1;">
            @include('exhibitor.booking.summary.stallleft')
        </div>

        <div style="flex: 1;">
            @include('exhibitor.booking.summary.stallright')
        </div>
    </div>

@endforeach