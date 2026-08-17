<!-- =========================================================
     HOSPITALITY
========================================================== -->

<div id="hospitality_question" class="conditional-question" data-category="Hospitality">

    <label class="sub-question-title">
        What type of business does the company operate?
    </label>

    <span class="sub-question-description">
        Select the company's primary business type.
    </span>

    <select name="business_type" class="form-control conditional-input">

        <option value="">Select a business type</option>

        <option value="Hotel">Hotel</option>
        <option value="Resort">Resort</option>
        <option value="Hostel">Hostel</option>
        <option value="Guest house">Guest house</option>
        <option value="Restaurant">Restaurant</option>
        <option value="Event or venue">Event or venue</option>
        <option value="Property management">Property management</option>
        <option value="Other">Other</option>

    </select>


    <!-- Business Services -->
    <div class="sub-question">

        <label class="sub-question-title">
            What services or offerings does the company provide?
        </label>

        <span class="sub-question-description">
            Select all services that apply.
        </span>

        <div class="option-grid">

            <div class="option">
                <input type="checkbox" id="hospitality_room_booking" name="business_services[]" value="Room bookings"
                    class="conditional-input">
                <label for="hospitality_room_booking">
                    Room bookings
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="hospitality_food_beverage" name="business_services[]"
                    value="Food and beverage" class="conditional-input">
                <label for="hospitality_food_beverage">
                    Food & Beverage
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="hospitality_events" name="business_services[]" value="Events"
                    class="conditional-input">
                <label for="hospitality_events">
                    Events
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="hospitality_conference" name="business_services[]"
                    value="Conference facilities" class="conditional-input">
                <label for="hospitality_conference">
                    Conference Facilities
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="hospitality_wedding" name="business_services[]" value="Wedding services"
                    class="conditional-input">
                <label for="hospitality_wedding">
                    Wedding Services
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="hospitality_restaurant" name="business_services[]" value="Restaurant"
                    class="conditional-input">
                <label for="hospitality_restaurant">
                    Restaurant
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="hospitality_other_service" name="business_services[]" value="Other"
                    class="conditional-input">
                <label for="hospitality_other_service">
                    Other
                </label>
            </div>

        </div>

    </div>


    <!-- Business Capacity -->
    <div class="sub-question">

        <label class="sub-question-title" for="business_capacity">
            What is the approximate capacity of your business?
        </label>

        <span class="sub-question-description">
            For example, number of rooms, seats, units, or guests that
            your business can accommodate.
        </span>

        <input type="number" id="business_capacity" name="business_capacity" class="form-control conditional-input"
            min="0" placeholder="Example: 120">

    </div>


    <!-- Business Volume -->
    <div class="sub-question">

        <label class="sub-question-title" for="business_volume">
            Approximately how many customers or guests do you serve per month?
        </label>

        <span class="sub-question-description">
            Enter the approximate number of customers, guests, or bookings
            handled each month.
        </span>

        <input type="number" id="business_volume" name="business_volume" class="form-control conditional-input" min="0"
            placeholder="Example: 800">

    </div>


    <!-- Business Description -->
    <div class="sub-question">

        <label class="sub-question-title" for="business_description">
            Describe your main business offering.
        </label>

        <span class="sub-question-description">
            Briefly describe the services or offerings that generate the
            most business for your company.
        </span>

        <textarea id="business_description" name="business_description" class="form-control conditional-input" rows="4"
            placeholder="Example: We operate a 60-room hotel offering accommodation, restaurant and conference facilities."></textarea>

    </div>

</div>