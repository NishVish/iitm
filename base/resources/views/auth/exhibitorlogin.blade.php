<form action="{{ route('auth.exhibitor.verify') }}" method="POST">
    @csrf

    <div class="card">
        <div class="card-body">

            <h5 class="card-title mb-4">Enter Booking Details</h5>

            <div class="mb-3">
                <label for="booking_id" class="form-label">
                    Booking ID
                </label>

                <input type="text" class="form-control" id="booking_id" name="booking_id"
                    placeholder="Enter your booking ID" required>
            </div>

            <div class="mb-3">
                <label for="pin" class="form-label">
                    PIN
                </label>

                <input type="password" class="form-control" id="pin" name="pin" placeholder="Enter your PIN"
                    maxlength="6" required>
            </div>

            <button type="submit" class="btn btn-primary">
                Verify Booking
            </button>

        </div>
    </div>
</form>