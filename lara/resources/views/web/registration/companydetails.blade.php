<h3>Company & Business Interests</h3>

<div class="section-title">General Information</div>
<div class="row g-3">
    <div class="col-12 form-group">
        <label>Company Name</label>
        <input type="text" name="company_name" value="{{ $company['company_name'] ?? '' }}" class="form-control"
            required>
    </div>

    <div class="col-md-4 form-group">
        <label>City</label>
        <input type="text" name="city" value="{{ $company['city'] ?? '' }}" class="form-control" required>
    </div>

    <div class="col-md-4 form-group">
        <label>State</label>
        <input type="text" name="state" value="{{ $company['state'] ?? '' }}" class="form-control" required>
    </div>

    <div class="col-md-4 form-group">
        <label>Country</label>
        <input type="text" name="country" value="{{ $company['country'] ?? '' }}" class="form-control" required>
    </div>

    <div class="col-md-12 form-group">
        <label>Address</label>
        <textarea name="address" class="form-control" required>{{ $company['address'] ?? '' }}</textarea>
    </div>

    <div class="col-md-4 form-group">
        <label>Pincode</label>
        <input type="text" name="pincode" value="{{ $company['pincode'] ?? '' }}" class="form-control" required>
    </div>

    <div class="col-md-4 form-group">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ $company['phone'] ?? '' }}" class="form-control" required>
    </div>

    <div class="col-md-4 form-group">
        <label>Website</label>
        <input type="text" name="website" value="{{ $company['website'] ?? '' }}" class="form-control" required>
    </div>
</div>

<div class="section-title">Business Details</div>
<div class="row g-3">
    <div class="col-md-4 form-group">
        <label>Category</label>
        <select id="categoryDropdown" name="category" class="form-control" required>
            <option value="">Loading...</option>
        </select>
    </div>

    <div class="col-md-4 form-group" id="otherCategoryBox" style="display:none;">
        <label>Other (Travel / Hospitality)</label>
        <input type="text" id="otherCategoryInput" class="form-control" placeholder="Enter your category">
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dropdown = document.getElementById("categoryDropdown");
            const otherBox = document.getElementById("otherCategoryBox");
            const otherInput = document.getElementById("otherCategoryInput");
            const form = dropdown.closest("form");

            fetch("{{ url('public/assets/dictionary.json') }}")
                .then(res => res.json())
                .then(data => {
                    dropdown.innerHTML = '<option value="">Select Keyword</option>';

                    const grouped = {};
                    data.forEach(item => {
                        if (!grouped[item.category]) {
                            grouped[item.category] = [];
                        }
                        grouped[item.category].push(item.keyword);
                    });

                    Object.keys(grouped).forEach(category => {
                        const optgroup = document.createElement("optgroup");
                        optgroup.label = category;

                        grouped[category].forEach(keyword => {
                            const option = document.createElement("option");
                            option.value = keyword;
                            option.textContent = keyword.charAt(0).toUpperCase() + keyword.slice(1);
                            optgroup.appendChild(option);
                        });

                        dropdown.appendChild(optgroup);
                    });

                    const otherOption = document.createElement("option");
                    otherOption.value = "__other__";
                    otherOption.textContent = "Other (Travel / Hospitality related)";
                    dropdown.appendChild(otherOption);

                    const selected = "{{ $company['category'] ?? '' }}";
                    if (selected) dropdown.value = selected;
                });

            // ONLY change → make "other" required when visible
            dropdown.addEventListener("change", function () {
                if (this.value === "__other__") {
                    otherBox.style.display = "block";
                    otherInput.setAttribute("required", "required");
                } else {
                    otherBox.style.display = "none";
                    otherInput.removeAttribute("required");
                }
            });

            form.addEventListener("submit", function () {
                if (dropdown.value === "__other__") {
                    const val = otherInput.value.trim();

                    if (val !== "") {
                        let hidden = document.createElement("input");
                        hidden.type = "hidden";
                        hidden.name = "category";
                        hidden.value = "other - " + val;

                        form.appendChild(hidden);
                        dropdown.removeAttribute("name");
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