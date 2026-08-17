<!-- intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.css">

<div class="row">
    <!-- Keep this hidden input to store the dial code or country code for form submission -->
    <input type="hidden" id="countryCode" name="country_code">

    <div class="col-md-6">
        <label class="form-label fw-semibold">Mobile Number</label>
        <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="Enter Mobile Number" required>
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