<div class="form-container">

    <!-- HEADER -->
    <div class="form-header">
        <h2>Exhibitor Enquiry</h2>
        <p>Partner with India's leading Travel Media platform</p>
    </div>

    <!-- CALLBACK SECTION -->
    <div class="callback-box">
        <div>
            <h3>Need Help?</h3>
            <p>Helpline from our exhibition team</p>
        </div>

        <a href="tel:+917909075195" class="callback-btn">
            +91 7909075195 </a>
    </div>

    <!-- FORM -->
    <form action="" method="POST">
        @csrf

        <div class="form-grid">

            <div class="form-group full-width">
                <label>Company Name</label>
                <input type="text" name="company_name" required>
            </div>

            <div class="form-group">
                <label>Contact Person</label>
                <input type="text" name="contact_name" required>
            </div>
            <div class="form-group">
                <label>Designation</label>
                <input type="text" name="designation" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" required>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="phone" required>
            </div>
            <div class="form-group">
                <label>Category</label>

                <select name="category" id="categorySelect" class="form-control">
                    <option value="">Loading...</option>
                </select>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", async function () {

                    const select = document.getElementById("categorySelect");

                    try {
                        const response = await fetch("{{ url('/dictionary/json') }}");
                        const result = await response.json();

                        select.innerHTML = `<option value="">Select Category</option>`;

                        if (!result.data) {
                            select.innerHTML = `<option value="">No data found</option>`;
                            return;
                        }

                        // store unique categories
                        const categories = new Set();

                        result.data.forEach(item => {
                            if (item.category) {
                                categories.add(item.category);
                            }
                        });

                        // build options
                        categories.forEach(category => {
                            const option = document.createElement("option");
                            option.value = category;
                            option.textContent = category;
                            select.appendChild(option);
                        });

                    } catch (error) {
                        console.error("Error loading categories:", error);
                        select.innerHTML = `<option value="">Failed to load</option>`;
                    }
                });
            </script>

            <div class="form-group full-width">
                <label>Cities of Interest</label>

                <div class="city-selection">
                    @php
                        $cities = ['Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Chennai', 'Kolkata', 'Ahmedabad', 'Pune', 'Kochi'];
                    @endphp

                    @foreach($cities as $city)
                        <label class="city-option">
                            <input type="checkbox" name="cities[]" value="{{ $city }}">
                            {{ $city }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group full-width">
                <label>Requirements</label>
                <textarea name="message" rows="4"></textarea>
            </div>

        </div>

        <button type="submit" class="submit-btn">
            Request Prospectus & Pricing
        </button>

    </form>

</div>
</div>