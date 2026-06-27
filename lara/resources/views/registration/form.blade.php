@include('registration.header')
<h2>Exhibitor Registration</h2>

@php
    $lastsegment = basename($_SERVER['REQUEST_URI']);
    $secondlastSegment = basename(dirname($_SERVER['REQUEST_URI']));
@endphp
<form method="post" action="{{ url('store/' . $secondlastSegment . '/' . $lastsegment) }}">
    @csrf

    <label>Delegates</label>
    <button type="button" class="btn btn-add" onclick="addDelegate()">+ Add Delegate</button>

    <div id="delegateContainer"></div>

    <label>Company Name</label>
    <input type="text" name="company_name" placeholder="Enter company name">

    <label>Mobile</label>
    <input type="text" name="mobile" placeholder="Enter mobile number">
    <label>Stall No.</label>
    <input type="text" name="stallno" placeholder="Enter stall no.">

    <button type="submit" class="btn btn-submit">Submit Registration</button>

    <div class="note">Please ensure all details are correct before submitting.</div>
</form>
</div>

<script>
    function addDelegate() {
        let container = document.getElementById("delegateContainer");

        let input = document.createElement("input");
        input.type = "text";
        input.name = "delegates[]";
        input.placeholder = "Enter delegate name";

        container.appendChild(input);
    }
</script>

</body>

</html>