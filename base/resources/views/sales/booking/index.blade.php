<div class="container-fluid">

    @include('exhibitor.bookingprocess.form') {{-- =====================================================
    SHARE BOOKING LINK WITH EXHIBITOR
    ====================================================== --}}
    <div class="card mt-4 mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-share-alt"></i>
                    Share Booking With Exhibitor
                </h5>
            </div>

            <div class="input-group">

                <input type="text" id="exhibitor-booking-link" class="form-control"
                    value="{{ url('exhibitor/booking/' . ($bookingdata->booking_id ?? '')) }}" readonly>

                <button type="button" class="btn btn-primary" onclick="copyExhibitorBookingLink()">
                    <i class="fas fa-copy"></i>
                    Copy Link
                </button>

            </div>

            <small class="text-muted d-block mt-2">
                Share this link with the exhibitor to access their booking.
            </small>

            <input type="hidden" name="booking_id" value="{{ $bookingdata->booking_id ?? '' }}">

        </div>
    </div>

</div>


<script>
    function copyExhibitorBookingLink() {

        const input = document.getElementById('exhibitor-booking-link');

        if (!input) {
            return;
        }

        navigator.clipboard.writeText(input.value)
            .then(function () {

                const button = document.querySelector(
                    '[onclick="copyExhibitorBookingLink()"]'
                );

                if (!button) {
                    return;
                }

                const originalHtml = button.innerHTML;

                button.innerHTML = `
                    <i class="fas fa-check"></i>
                    Copied
                `;

                button.classList.remove('btn-primary');
                button.classList.add('btn-success');

                setTimeout(function () {

                    button.innerHTML = originalHtml;

                    button.classList.remove('btn-success');
                    button.classList.add('btn-primary');

                }, 2000);

            })
            .catch(function () {

                input.select();
                input.setSelectionRange(0, 99999);

                document.execCommand('copy');

                alert('Booking link copied.');

            });
    }
</script>