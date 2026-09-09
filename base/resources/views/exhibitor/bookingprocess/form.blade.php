@php
    $isDelegate = false;
@endphp

@include('company.form.index')


<br>
@include('exhibitor.bookingprocess.stalllocation')






<div class="footer">


    <div style="display: inline-flex; align-items: center; gap: 20px; text-align: left;">

        <img src="https://spheretravelmedia.com/wp-content/uploads/2025/03/cropped-cropped-38x38inch-Sphere-Logo-Copy-min_prev_ui-300x100.png"
            style="width: 200px; height: auto;">

        <div style="line-height: 1.5;">
            <strong>Sphere Travelmedia & Exhibitions Pvt Ltd</strong><br>
            #245, “Shivashakthi”, 7th Main, Amarjyothi Layout, Domlur, Bangalore - 560071, India<br>
            Ph: +91-80-4083 4100 | Fax: +91-80-4083 4101<br>
            Email: <a href="mailto:info@iitmindia.com">info@iitmindia.com</a>
        </div>

    </div>
</div>



<a href="{{ url('exhibitor/dashboard/' . $bookingdata->booking_id) }}" class="btn-dashboard">
    Move to Dashboard
</a>

<a href="{{ url('exhibitor/closebooking/' . $bookingdata->booking_id) }}" class="btn-dashboard">
    Close Booking
</a>

</div>