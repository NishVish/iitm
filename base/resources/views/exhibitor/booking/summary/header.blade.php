<div class="booking-topbar">

    <div>
        <h2 class="booking-title">
            Booking Summary
        </h2>

        <div class="booking-id">
            Booking ID:
            <strong>
                {{ $final_bookingdetails->booking->booking_id ?? '-' }}
            </strong>
        </div>
    </div>

</div>

<div>upcoming event list
    register for early bird Offer
</div>

<div class="deadline">

    <div class="deadline-text">
        <strong>Deadline to Update the Details:</strong>
        30-08-2026
    </div>

    <div class="deadline-timer" id="demo">
        Loading...
    </div>

</div>