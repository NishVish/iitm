@include("exhibitor.header")

@include('exhibitor.dashboard.leftpannel.left')

<main class="booking-main">


    @include('exhibitor.dashboard.layout2.index')

    <section class="dashboard-section">
        <div class="section-head">
            <h2>Payment</h2>
        </div>

        <div class="payment-card">
            <p>Proceed to the payment page to complete your stall booking payment.</p>

            <a href="{{ url('exhibitor/payment/' . $bookingdata->booking_id) }}" class="btn-dashboard">
                Move to Payment Page
            </a>
        </div>
    </section>


    <div id="summary">

        <a href="{{ url('exhibitor/openbooking/' . ($final_bookingdetails->booking->booking_id ?? '')) }}"
            class="open-booking-btn">
            Open Booking
        </a>
        <!-- @include('exhibitor.booking.summary.index') -->
    </div>

</main>

</div>

</div>

<script>
    var countDownDate = new Date("Aug 30, 2026 23:59:59").getTime();

    var x = setInterval(function () {

        var now = new Date().getTime();
        var distance = countDownDate - now;

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
            return;
        }

        var days = Math.floor(
            distance / (1000 * 60 * 60 * 24)
        );

        var hours = Math.floor(
            (distance % (1000 * 60 * 60 * 24)) /
            (1000 * 60 * 60)
        );

        var minutes = Math.floor(
            (distance % (1000 * 60 * 60)) /
            (1000 * 60)
        );

        var seconds = Math.floor(
            (distance % (1000 * 60)) /
            1000
        );

        document.getElementById("demo").innerHTML =
            days + "d " +
            hours + "h " +
            minutes + "m " +
            seconds + "s";

    }, 1000);
</script>