<!-- <div class="form-group">
    <select class="form-control" name="title" required>
        <option value="Mr.">Mr</option>
        <option value="Mrs.">Mrs</option>
        <option value="Ms.">Ms</option>
        <option value="Dr.">Dr</option>
    </select>
</div> -->
<!--<div class="form-group">
                        <input type="text" class="form-control" placeholder="First Name *" name="select2" required>
                    </div>-->
<!-- 
<div class="form-group">
    <input type="text" class="form-control" placeholder="First Name *" name="select2" value="" required />
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="Last Name" name="lastname">
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="Designation *" name="designation" required>
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="Company Name *" name="organisation" required>
</div>
<div class="form-group">
    <input type="email" class="form-control" placeholder="Your Email *" name="email" required>
</div> -->
<div class="form-group">
    <select class="form-control" name="title" required>
        <option value="Mr." selected>Mr</option>
        <option value="Mrs.">Mrs</option>
        <option value="Ms.">Ms</option>
        <option value="Dr.">Dr</option>
    </select>
</div>

<div class="form-group">
    <input type="text" class="form-control" placeholder="First Name *" name="select2" value="Rahul" required />
</div>

<div class="form-group">
    <input type="text" class="form-control" placeholder="Last Name" name="lastname" value="Sharma">
</div>

<div class="form-group">
    <input type="text" class="form-control" placeholder="Designation *" name="designation" value="Travel Manager"
        required>
</div>

<div class="form-group">
    <input type="text" class="form-control" placeholder="Company Name *" name="organisation"
        value="Global Travel Solutions" required>
</div>

<div class="form-group">
    <input type="email" class="form-control" placeholder="Your Email *" name="email" value="rahul.sharma@example.com"
        required>
</div>
<!-- intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.css">


<div class="form-group">
    <input type="hidden" id="countryCode" name="country_code" value="+91">

    <div class="form-group">
        <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="Enter Mobile Number"
            value="9876543210" required>
    </div>
</div>



<div class="form-group">
    <!-- Keep this hidden input to store the dial code or country code for form submission -->
    <!-- <input type="hidden" id="countryCode" name="country_code"> -->

    <div class="form-group">
        <!-- <label class="form-label fw-semibold">Mobile Number</label> -->
        <!-- <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="Enter Mobile Number" required> -->
    </div>
</div>

<!-- intl-tel-input JS -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/intlTelInput.min.js"></script>

<script>
    const countryHiddenInput = document.querySelector("#countryCode");
    const mobileInput = document.querySelector("#mobile");

    // Initialize ONLY on the mobile input
    const mobileITI = window.intlTelInput(mobileInput, {
        initialCountry: "in",
        nationalMode: true,
        separateDialCode: true,
        autoPlaceholder: "aggressive",
        strictMode: true,
        loadUtils: () =>
            import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js")
    });

    // Function to update the hidden country input value
    function updateCountryCode() {
        const dialCode = mobileITI.getSelectedCountryData().dialCode;
        // Stores something like "+91" in the hidden field
        countryHiddenInput.value = "+" + dialCode;
    }

    // Update hidden field on initialization and whenever the country changes
    mobileInput.addEventListener("init", updateCountryCode);
    mobileInput.addEventListener("countrychange", updateCountryCode);

    // Validate on blur
    mobileInput.addEventListener("blur", function () {
        if (mobileInput.value.trim()) {
            if (mobileITI.isValidNumber()) {
                mobileInput.classList.remove("is-invalid");
                mobileInput.classList.add("is-valid");
            } else {
                mobileInput.classList.remove("is-valid");
                mobileInput.classList.add("is-invalid");
            }
        }
    });

    // Form submission tracking
    document.querySelector("form")?.addEventListener("submit", function (e) {
        if (!mobileITI.isValidNumber()) {
            e.preventDefault();
            alert("Please enter a valid mobile number.");
            return;
        }

        // Full E.164 formatted number (e.g., +919876543210)
        const fullNumber = mobileITI.getNumber();
        console.log("Full Number:", fullNumber);

        // Option A: Submit the full string inside the mobile input
        mobileInput.value = fullNumber;
    });
</script>