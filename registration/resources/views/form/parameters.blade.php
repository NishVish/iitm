<form action="{{ url('register') }}/mumbai/2000" method="post" class="register-form">

    @csrf




    <div class="form-group">
        <select class="form-control" name="title" required>
            <option value="Mr.">Mr</option>
            <option value="Mrs.">Mrs</option>
            <option value="Ms.">Ms</option>
            <option value="Dr.">Dr</option>
        </select>
    </div>
    <!--<div class="form-group">
                        <input type="text" class="form-control" placeholder="First Name *" name="select2" required>
                    </div>-->

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
    </div>

    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.css">

    <div class="form-group">
        <!-- Keep this hidden input to store the dial code or country code for form submission -->
        <input type="hidden" id="countryCode" name="country_code">

        <div class="form-group">
            <!-- <label class="form-label fw-semibold">Mobile Number</label> -->
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

    <div class="form-group">
        <select id="categoryDropdown" name="category" class="form-control" required="">
            <option value="">Select Category</option>
            <option value="Hospitality">Hospitality</option>
            <option value="Travel Agency">Travel Agency</option>
            <option value="Aviation">Aviation</option>
            <option value="Transport">Transport</option>
            <option value="MICE">MICE</option>
            <option value="Adventure">Adventure</option>
            <option value="TA">TA</option>
            <option value="other_general">Other (Not related to Travel / Hospitality)</option>
            <option value="other_trave_hospitality">Other (Travel / Hospitality related)</option>
        </select>

    </div>

    <div class="form-group">
        <input type="text" name="pincode" id="pincode" placeholder="Pincode"
            value="<?php echo isset($company['pincode']) ? htmlspecialchars($company['pincode']) : ''; ?>"
            class="form-control">
    </div>

    <div class="form-group">

        <input type="text" name="city" id="city" placeholder="City" class="form-control" autocomplete="off" required>

        <div id="citySuggestions" class="list-group position-absolute w-100"
            style="z-index:999; max-height:250px; overflow-y:auto;"></div>
    </div>

    <div class="form-group">
        <input type="text" name="state" id="state" placeholder="State" class="form-control" readonly required>
    </div>

    <div class="form-group">
        <input type="text" name="country" id="country" placeholder="Country" class="form-control" readonly>
    </div>

    <div class="form-group">
        <textarea name="address" class="form-control" placeholder="Address"
            required><?php echo isset($company['address']) ? htmlspecialchars($company['address']) : ''; ?></textarea>
    </div>



    <script>
        const pincodeInput = document.getElementById("pincode");
        const cityInput = document.getElementById("city");
        const stateInput = document.getElementById("state");
        const countryInput = document.getElementById("country");
        const box = document.getElementById("citySuggestions");

        let timer = null;

        /* =========================
           1. PINCODE → ADDRESS
        ========================= */
        pincodeInput.addEventListener("input", function () {

            clearTimeout(timer);

            const pincode = this.value.trim();

            if (pincode.length !== 6) {
                cityInput.value = "";
                stateInput.value = "";
                countryInput.value = "";
                return;
            }

            timer = setTimeout(() => {

                fetch(`https://api.postalpincode.in/pincode/${pincode}`)
                    .then(res => res.json())
                    .then(data => {

                        if (!data || data[0].Status !== "Success") return;

                        const po = data[0].PostOffice[0];

                        cityInput.value = po.District || "";
                        stateInput.value = po.State || "";
                        countryInput.value = "India";

                    })
                    .catch(err => console.error(err));

            }, 400);
        });


        /* =========================
           2. CITY → SUGGESTIONS
        ========================= */
        cityInput.addEventListener("input", function () {

            clearTimeout(timer);

            const query = this.value.trim();

            if (query.length < 2) {
                box.innerHTML = "";
                return;
            }

            timer = setTimeout(() => {

                fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&addressdetails=1&limit=6`)
                    .then(res => res.json())
                    .then(data => {

                        box.innerHTML = "";

                        if (!Array.isArray(data)) return;

                        data.forEach(item => {

                            const addr = item.address || {};

                            const city =
                                addr.city ||
                                addr.town ||
                                addr.village ||
                                addr.county ||
                                item.display_name;

                            const state = addr.state || addr.region || "";
                            const country = addr.country || "";

                            const div = document.createElement("div");
                            div.className = "list-group-item list-group-item-action";
                            div.style.cursor = "pointer";
                            div.textContent = city + (state ? `, ${state}` : "");

                            div.onclick = () => {

                                cityInput.value = city;
                                stateInput.value = state;
                                countryInput.value = country;

                                box.innerHTML = "";
                            };

                            box.appendChild(div);
                        });

                    })
                    .catch(err => console.error(err));

            }, 300);
        });


        /* =========================
           3. CITY BLUR FALLBACK
        ========================= */
        cityInput.addEventListener("blur", function () {

            const city = this.value.trim();

            if (!city || stateInput.value) return;

            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(city)}&format=json&addressdetails=1&limit=1`)
                .then(res => res.json())
                .then(data => {

                    if (!Array.isArray(data) || !data.length) return;

                    const addr = data[0].address || {};

                    stateInput.value =
                        addr.state ||
                        addr.region ||
                        addr.state_district ||
                        "";

                    countryInput.value =
                        addr.country || countryInput.value;

                });

        });


        /* =========================
           4. CLOSE DROPDOWN
        ========================= */
        document.addEventListener("click", function (e) {
            if (!cityInput.contains(e.target) && !box.contains(e.target)) {
                box.innerHTML = "";
            }
        });


        /* =========================
           5. PREFILL (Plain PHP)
        ========================= */
        document.addEventListener("DOMContentLoaded", function () {
            cityInput.value = "<?php echo isset($company['city']) ? addslashes($company['city']) : ''; ?>";
            stateInput.value = "<?php echo isset($company['state']) ? addslashes($company['state']) : ''; ?>";
            countryInput.value = "<?php echo isset($company['country']) ? addslashes($company['country']) : ''; ?>";
        });
    </script><!-- 
<div class="form-group">
    <textarea class="form-control" placeholder="Address" name="address"></textarea>
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="City" name="city">
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="State" name="state">
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="Pincode" name="pincode">
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="Country" name="country">
</div> -->
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Phone *" name="phone" minlength="10" maxlength="10">
    </div>

    <div class="form-group">
        <input type="text" class="form-control" placeholder="Website" name="website">
    </div>
    <div class="form-group">
        <textarea class="form-control" placeholder="Your Message" name="Message"></textarea>
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" placeholder="city_name *" value="hello" name="city_name"
            minlength="10" maxlength="10">
    </div>


    <button type="submit" class="btnRegister">Submit</button>
</form>
</div>
</div>
</div>
</body>

</html>