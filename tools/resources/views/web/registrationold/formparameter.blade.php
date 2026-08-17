<form action="{{ url('store') }}" method="POST">
    @csrf

    <div class="card border-0 shadow-lg rounded-4">

        <div class="card-body p-4">

            <div class="row g-4">

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <select name="title" class="form-select" required>
                        <option value="">Select Title</option>
                        <option>Mr.</option>
                        <option>Ms.</option>
                        <option>Mrs.</option>
                        <option>Dr.</option>
                        <option>Prof.</option>
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="firstname" class="form-control" placeholder="Enter your full name"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="lastname" class="form-control" placeholder="Enter your full name" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Designation</label>
                    <input type="text" name="designation" class="form-control" placeholder="Your designation">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Organisation</label>
                    <input type="text" name="organisation" class="form-control" placeholder="Company / Organisation">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="Landline Number">
                </div>


                @include('web.registrationold.number')







                <div class="col-md-4 form-group">
                    <label>Pincode</label>
                    <input type="text" name="pincode" id="pincode" value="{{ $company['pincode'] ?? '' }}"
                        class="form-control">
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

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Website</label>
                    <input type="text" name="website" class="form-control" placeholder="Website">
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
                                    9
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
                    <input type="text" name="phone" value="{{ $company['phone'] ?? '' }}" class="form-control">
                </div>

                <div class="col-md-4 form-group">
                    <label>Website</label>
                    <input type="text" name="website" value="{{ $company['website'] ?? '' }}" class="form-control">
                </div>

                <input type="hidden" name="eventinfo" value="{{ json_encode([
    'event_id' => $event1->id ?? '',
    'year' => $event1->year ?? 2026,
    'name' => $event1->name ?? 'IITM Chennai',
    'event_image' => $event1->event_image ?? 'https://iitmindia.com/wp-content/uploads/2023/05/2-1-1.jpg',
    'venue_details' => $event1->venue_details ?? 'Convention Center, Chennai Trade Center, CTC Complex, Nandambakkam, Chennai – 600089',
    'start_date' => $event1->start_date ?? '2026-07-16',
    'end_date' => $event1->end_date ?? '2026-07-18'
]) }}" class="form-control">

                <!-- <div class="col-md-4 form-group">
                    <label>Association Membership</label>
                    <input type="text" name="association_membership"
                        value="{{ $company['association_membership'] ?? '' }}" class="form-control"
                        placeholder="Assocaition name">
                </div>
                <div class="col-md-4 form-group">
                    <label>Postion at Association Membership</label>
                    <input type="text" name="position_at_association"
                        value="{{ $company['position_at_association'] ?? '' }}" class="form-control"
                        placeholder="Postion at Association Membership">
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
                                // Add Other (General) option
                                const otherGeneralOption = document.createElement("option");

                                otherGeneralOption.value = "other_general";
                                otherGeneralOption.textContent = "Other (Not related to Travel / Hospitality)";

                                if (selectedCategory === "other_general") {
                                    otherGeneralOption.selected = true;
                                }

                                categoryDropdown.appendChild(otherGeneralOption);
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
            @if ($lastSegment == "exhibitor")
                <div class="mt-4">
                    <label class="form-label fw-semibold">Select City</label>

                    <div class="row g-3">
                        @foreach($cities as $city)
                            <div class="col-md-4">
                                <div class="form-check p-3 border rounded-3 shadow-sm">
                                    <input class="form-check-input" type="checkbox" name="city_name[]" value="{{ $city }}"
                                        id="city_{{ $loop->index }}">

                                    <label class="form-check-label ms-2" for="city_{{ $loop->index }}">
                                        {{ $city }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else

                <input type="hidden" name="city_name" value="{{ $city }}">


            @endif

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">
                    <i class="bi bi-send-fill me-2"></i> Submit Registration
                </button>
            </div>

        </div>
    </div>
</form>