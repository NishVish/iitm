<!-- =========================================================
     TRAVEL
========================================================== -->

<div id="travel_question" class="conditional-question" data-category="Travel">

    <label class="sub-question-title">
        What type of business does the company operate?
    </label>

    <span class="sub-question-description">
        Select the company's primary business type.
    </span>

    <select name="business_type" class="form-control conditional-input">

        <option value="">Select a business type</option>

        <option value="Travel agency">Travel Agency</option>
        <option value="Tour operator">Tour Operator</option>
        <option value="Travel booking">Travel Booking</option>
        <option value="Corporate travel">Corporate Travel</option>
        <option value="Airline">Airline</option>
        <option value="Cruise">Cruise</option>
        <option value="Transportation">Transportation</option>
        <option value="Other">Other</option>

    </select>


    <!-- Business Services -->
    <div class="sub-question">

        <label class="sub-question-title">
            What travel services does the company provide?
        </label>

        <span class="sub-question-description">
            Select all services that apply.
        </span>

        <div class="option-grid">

            <div class="option">
                <input type="checkbox" id="travel_domestic" name="business_services[]" value="Domestic travel"
                    class="conditional-input">
                <label for="travel_domestic">
                    Domestic Travel
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="travel_international" name="business_services[]" value="International travel"
                    class="conditional-input">
                <label for="travel_international">
                    International Travel
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="travel_flight_booking" name="business_services[]" value="Flight booking"
                    class="conditional-input">
                <label for="travel_flight_booking">
                    Flight Booking
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="travel_hotel_booking" name="business_services[]" value="Hotel booking"
                    class="conditional-input">
                <label for="travel_hotel_booking">
                    Hotel Booking
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="travel_tour_packages" name="business_services[]" value="Tour packages"
                    class="conditional-input">
                <label for="travel_tour_packages">
                    Tour Packages
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="travel_corporate" name="business_services[]" value="Corporate travel"
                    class="conditional-input">
                <label for="travel_corporate">
                    Corporate Travel
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="travel_transportation" name="business_services[]" value="Transportation"
                    class="conditional-input">
                <label for="travel_transportation">
                    Transportation
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="travel_cruise" name="business_services[]" value="Cruise"
                    class="conditional-input">
                <label for="travel_cruise">
                    Cruise
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="travel_other_service" name="business_services[]" value="Other"
                    class="conditional-input">
                <label for="travel_other_service">
                    Other
                </label>
            </div>

        </div>

    </div>


    <!-- Business Volume -->
    <div class="sub-question">

        <label class="sub-question-title" for="business_volume">
            Approximately how many trips or bookings do you handle per month?
        </label>

        <span class="sub-question-description">
            Include the approximate number of trips or bookings handled
            each month.
        </span>

        <input type="number" id="business_volume" name="business_volume" class="form-control conditional-input" min="0"
            placeholder="Example: 25">

    </div>


    <!-- Business Description -->
    <div class="sub-question">

        <label class="sub-question-title" for="business_description">
            Describe your main business offering.
        </label>

        <span class="sub-question-description">
            Briefly describe the travel services or packages that generate
            the most business for your company.
        </span>

        <textarea id="business_description" name="business_description" class="form-control conditional-input" rows="4"
            placeholder="Example: We provide domestic and international tour packages, flight bookings and hotel reservations."></textarea>

    </div>

</div>