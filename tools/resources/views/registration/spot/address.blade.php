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
    <style>
        /* Apply ONLY to this textarea */
        textarea[name="address"] {
            width: 100%;
            min-height: 120px;
            padding: 10px 12px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            line-height: 1.5;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            resize: vertical;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        textarea[name="address"]:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, .15);
        }

        textarea[name="address"]::placeholder {
            color: #999;
        }
    </style>

    <textarea name="address" placeholder="Address"
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
</script>