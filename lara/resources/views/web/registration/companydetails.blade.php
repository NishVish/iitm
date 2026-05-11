<h3>Company & Business Interests</h3>

<div class="section-title">General Information</div>
<div class="row g-3">
    <div class="col-12 form-group">
        <input type="hidden" name="company_id" value="{{ $company['company_id'] }}" class="form-control">
        <label>Company Name</label>
        <input type="text" name="company_name" value="{{ $company['company_name'] ?? '' }}" class="form-control"
            required>
    </div>


    <div class="col-md-4 form-group">
        <label>Pincode</label>
        <input type="text" name="pincode" id="pincode" value="{{ $company['pincode'] ?? '' }}" class="form-control">
    </div>
    <div class="col-md-4 form-group position-relative">
        <label>City</label>

        <input type="text" name="city" id="city" class="form-control" autocomplete="off" required>

        <div id="citySuggestions" class="list-group position-absolute w-100"
            style="z-index:999; max-height:250px; overflow-y:auto;"></div>
    </div>

    <div class="col-md-4 form-group">
        <label>State</label>
        <input type="text" name="state" id="state" class="form-control" readonly required>
    </div>

    <div class="col-md-4 form-group">
        <label>Country</label>
        <input type="text" name="country" id="country" class="form-control" readonly>
    </div>
    <div class="col-md-8 form-group">
        <label>Address</label>
        <textarea name="address" class="form-control" required>{{ $company['address'] ?? '' }}</textarea>

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
        pincodeInput?.addEventListener("input", function () {

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
           3. CITY BLUR FALLBACK (optional safety)
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
           5. PREFILL (Laravel)
        ========================= */
        document.addEventListener("DOMContentLoaded", function () {
            cityInput.value = "{{ $company['city'] ?? '' }}";
            stateInput.value = "{{ $company['state'] ?? '' }}";
            countryInput.value = "{{ $company['country'] ?? '' }}";
        });
    </script>


</div>



<div>
    <!-- <input type="hidden" name="last_confirmed_at" value="{{ $company['last_confirmed_at'] ?? '' }}"> -->
    <!-- <input type="hidden" name="session" value="{{ $company['session'] ?? 0 }}"> -->
    <!-- <input type="hidden" name="cross_validation" value="{{ $company['cross_validation'] ?? 0 }}"> -->
    <!-- <input type="hidden" name="last_comments" value="{{ $company['last_comments'] ?? '' }}"> -->
    <!-- <input type="hidden" name="second_last_comments" value="{{ $company['second_last_comments'] ?? '' }}"> -->
    <!-- <input type="hidden" name="updated_by" value="{{ $company['updated_by'] ?? '' }}"> -->
    <!-- <input type="number" name="pin" value="{{ $company['pin'] ?? '' }}"> -->
    <!-- <input type="hidden" name="travel_segments" value="{{ $company['travel_segments'] ?? '' }}"> -->
    <!-- <input type="hidden" name="meet_profiles" value="{{ $company['meet_profiles'] ?? '' }}"> -->
    <!-- <input type="hidden" name="meet_regions" value="{{ $company['meet_regions'] ?? '' }}"> -->
    <!-- <input type="hidden" name="interested_states" value="{{ $company['interested_states'] ?? '' }}"> -->
    <!-- <input type="hidden" name="branch_offices" value="{{ $company['branch_offices'] ?? '' }}"> -->
    <!-- <input type="hidden" name="total_staff" value="{{ $company['total_staff'] ?? '' }}"> -->
</div>
<div class="section-title">Business Details</div>



<div class="row g-3">
    <div class="col-md-4 form-group">
        <label>Category</label>

        <select id="categoryDropdown" name="category" class="form-control" required>

            @if(!empty($company['category']))
                <option value="{{ $company['category'] }}" selected>
                    {{ $company['category'] }}
                </option>
            @else
                <option value="" selected>Loading...</option>
            @endif

        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ $company['phone'] ?? '' }}" class="form-control" required>
    </div>

    <div class="col-md-4 form-group">
        <label>Website</label>
        <input type="text" name="website" value="{{ $company['website'] ?? '' }}" class="form-control">
    </div>

    <div class="col-md-4 form-group">
        <label>Association Membership</label>
        <input type="text" name="association_membership" value="{{ $company['association_membership'] ?? '' }}"
            class="form-control" placeholder="Assocaition name">
    </div>
    <div class="col-md-4 form-group">
        <label>Postion at Association Membership</label>
        <input type="text" name="position_at_association" value="{{ $company['position_at_association'] ?? '' }}"
            class="form-control" placeholder="Postion at Association Membership">
    </div>
    <!-- <div class="col-md-4 form-group">
        <label>Sub Category</label>
        <select id="subcategoryDropdown" name="subcategory" class="form-control" required>
            <option value="">Loading...</option>
        </select>
    </div> -->

    <!-- 
    <div class="col-md-4 form-group" id="otherCategoryBox" style="display:none;">
        <label>Other (Travel / Hospitality)</label>
        <input type="text" id="otherCategoryInput" class="form-control" placeholder="Enter your category">
    </div> -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const categoryDropdown = document.getElementById("categoryDropdown");
            const subcategoryDropdown = document.getElementById("subcategoryDropdown");
            const otherBox = document.getElementById("otherCategoryBox");
            const otherInput = document.getElementById("otherCategoryInput");
            const form = categoryDropdown.closest("form");

            let categoryMap = {}; // store category → subcategories

            const selectedCategory = "{{ $company['category'] ?? '' }}";

            fetch("{{ url('public/assets/dictionary.json') }}")
                .then(res => res.json())
                .then(data => {

                    categoryDropdown.innerHTML =
                        '<option value="">Select Category</option>';

                    // Build mapping
                    data.forEach(item => {
                        if (!categoryMap[item.category]) {
                            categoryMap[item.category] = [];
                        }

                        categoryMap[item.category].push(item.keyword);
                    });

                    // Populate category dropdown
                    Object.keys(categoryMap).forEach(category => {

                        const option = document.createElement("option");

                        option.value = category;
                        option.textContent = category;

                        // Set selected value
                        if (category === selectedCategory) {
                            option.selected = true;
                        }

                        categoryDropdown.appendChild(option);
                    });

                    // Add Other option
                    const otherOption = document.createElement("option");

                    otherOption.value = "other";
                    otherOption.textContent =
                        "Other (Travel / Hospitality related)";

                    // Select if saved value is other
                    if (selectedCategory === "other") {
                        otherOption.selected = true;
                    }

                    categoryDropdown.appendChild(otherOption);
                });
            categoryDropdown.addEventListener("change", function () {
                const selectedCategory = this.value;

                // Reset subcategory
                subcategoryDropdown.innerHTML = '<option value="">Select Sub Category</option>';

                if (selectedCategory === "other") {
                    otherBox.style.display = "block";
                    otherInput.setAttribute("required", "required");

                    // 👉 Set subcategory to "other" automatically
                    const option = document.createElement("option");
                    option.value = "other";
                    option.textContent = "Other";
                    option.selected = true;

                    subcategoryDropdown.appendChild(option);

                    return;
                } else {
                    otherBox.style.display = "none";
                    otherInput.removeAttribute("required");
                }

                // Populate normal subcategories
                if (categoryMap[selectedCategory]) {
                    categoryMap[selectedCategory].forEach(sub => {
                        const option = document.createElement("option");
                        option.value = sub;
                        option.textContent = sub.charAt(0).toUpperCase() + sub.slice(1);
                        subcategoryDropdown.appendChild(option);
                    });
                }
            });
            // Handle form submit
            form.addEventListener("submit", function () {
                if (categoryDropdown.value === "__other__") {
                    const val = otherInput.value.trim();

                    if (val !== "") {
                        let hidden = document.createElement("input");
                        hidden.type = "hidden";
                        hidden.name = "category";
                        hidden.value = val;

                        form.appendChild(hidden);
                        categoryDropdown.removeAttribute("name");
                    }
                }
            });
        });
    </script>
</div>

<!-- <div class="col-md-4 form-group">
        <label>GST Number</label>
        <input type="text" name="gst_number" value="{{ $company['gst_number'] ?? '' }}" class="form-control">
    </div> -->
<!-- 
    <div class="col-md-4 form-group">
        <label>Sales Person</label>
        <input type="text" name="sales_person" value="{{ $company['sales_person'] ?? '' }}" class="form-control">
    </div> -->

<!-- <div class="col-md-4 form-group">
        <label>Branch Offices</label>
        <input type="text" name="branch_offices" value="{{ $company['branch_offices'] ?? '' }}" class="form-control">
    </div> -->

<!-- <div class="col-md-4 form-group">
        <label>Total Staff</label>
        <input type="text" name="total_staff" value="{{ $company['total_staff'] ?? '' }}" class="form-control">
    </div>

    <div class="col-md-4 form-group">
        <label>Association Membership</label>
        <input type="text" name="association_membership" value="{{ $company['association_membership'] ?? '' }}"
            class="form-control">
    </div>-->
<!-- </div> -->
<!--
<div class="section-title">Business Profile</div> 
    <div class="row g-3"> -->
<!-- <div class="col-md-6 form-group">
        <label>Buyer Responsibility</label>
        <select name="buyer_responsibility" class="form-control">
            <option value="Owner" {{ ($contact->buyer_responsibility ?? '') == 'Owner' ? 'selected' : '' }}>Owner</option>
            <option value="MD/CEO" {{ ($contact->buyer_responsibility ?? '') == 'MD/CEO' ? 'selected' : '' }}>MD/CEO
            </option>
            <option value="Middle Management" {{ ($contact->buyer_responsibility ?? '') == 'Middle Management' ? 'selected' : '' }}>Middle Management</option>
        </select>
    </div> -->

<!-- <div class="col-md-6 form-group">
        <label>Reason for Attending</label>
        <div class="d-flex gap-4 pt-2">
            <label>
                <input type="radio" name="attending_reason" value="Buy" {{ ($contact->attending_reason ?? '') == 'Buy' ? 'checked' : '' }}>
                Buy
            </label>

            <label>
                <input type="radio" name="attending_reason" value="Sell" {{ ($contact->attending_reason ?? '') == 'Sell' ? 'checked' : '' }}>
                Sell
            </label>
        </div>
    </div>
</div> -->
<!-- 
<div class="section-title">Travel Segments</div>
<div class="row g-3">
    <div class="col-md-12">
        @php $segments = explode(',', $company['travel_segments'] ?? ''); @endphp

        @foreach(['FIT', 'MICE', 'GIT', 'Ticketing', 'Airlines', 'Cruises', 'Adventure', 'Wellness', 'Religious'] as $seg)
            <label style="margin-right:10px;">
                <input type="checkbox" name="travel_segments[]" value="{{ $seg }}" {{ in_array($seg, $segments) ? 'checked' : '' }}>
                {{ $seg }}
            </label>
        @endforeach
    </div>
</div> -->
<!-- 
<div class="section-title">Meeting Preferences</div>
<div class="row g-3">
    <div class="col-md-6 form-group">
        <label>Meet Profiles</label>
        <input type="text" name="meet_profiles" value="{{ $company['meet_profiles'] ?? '' }}" class="form-control">
    </div>

    <div class="col-md-6 form-group">
        <label>Meet Regions</label>
        <input type="text" name="meet_regions" value="{{ $company['meet_regions'] ?? '' }}" class="form-control">
    </div>

    <div class="col-md-12 form-group">
        <label>Interested States</label>
        <input type="text" name="interested_states" value="{{ $company['interested_states'] ?? '' }}"
            class="form-control">
    </div>
</div>

<div class="section-title">Event Preferences</div>
<div class="row">
    <div class="col-md-6">
        <label>Attended Past Events?</label><br>
        <label>
            <input type="radio" name="attended_past" value="Yes" {{ ($contact->attended_past ?? '') == 'Yes' ? 'checked' : '' }}>
            Yes
        </label>
        <label>
            <input type="radio" name="attended_past" value="No" {{ ($contact->attended_past ?? '') == 'No' ? 'checked' : '' }}>
            No
        </label>
    </div>

    <div class="col-md-6">
        <label>Interested in Forum?</label><br>
        <label>
            <input type="radio" name="interest_forum" value="Yes" {{ ($contact->interest_forum ?? '') == 'Yes' ? 'checked' : '' }}>
            Yes
        </label>
        <label>
            <input type="radio" name="interest_forum" value="No" {{ ($contact->interest_forum ?? '') == 'No' ? 'checked' : '' }}>
            No
        </label>
    </div>
</div> -->