<form action="{{route('createbooking')}}" method="POST" id="bookingForm">
    @csrf

    <style>
        .booking-form {
            max-width: 600px;
            padding: 25px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fff;
        }

        .booking-form .form-group {
            margin-bottom: 20px;
        }

        .booking-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .booking-form input,
        .booking-form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .discount-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .discount-btn {
            padding: 8px 14px;
            border: 1px solid #007bff;
            background: #fff;
            color: #007bff;
            border-radius: 5px;
            cursor: pointer;
        }

        .discount-btn:hover,
        .discount-btn.active {
            background: #007bff;
            color: #fff;
        }

        .custom-discount {
            margin-top: 10px;
            display: none;
        }

        .price-summary {
            margin-top: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 8px;
        }

        .price-summary p {
            margin: 8px 0;
        }

        .final-price {
            font-size: 22px;
            font-weight: bold;
            color: #28a745;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-btn:hover {
            background: #218838;
        }

        .stall-price-display {
            margin-top: 8px;
            color: #555;
            font-size: 14px;
        }
    </style>


    <div class="booking-form">

        {{-- Event --}}
        <div class="form-group">
            <label for="event_id">Select Event</label>

            <select name="event_id" id="event_id" required>
                <option value="">-- Select Event --</option>

                @foreach($eventsdata as $event)
                    @if(!empty($event->name) && !empty($event->stall_price))

                        <option value="{{ $event->event_id }}" data-stall-price="{{ $event->stall_price }}">
                            {{ $event->name }}
                            - ₹{{ number_format($event->stall_price, 2) }}
                        </option>

                    @endif
                @endforeach

            </select>

            <div class="stall-price-display">
                Stall Price: ₹<span id="displayStallPrice">0.00</span>
            </div>
        </div>


        {{-- Area Required --}}
        <div class="form-group">
            <label for="area_required">Area Required</label>

            <input type="number" name="area_required" id="area_required" placeholder="Enter area required" min="1"
                step="0.01" required>
        </div>


        {{-- Amount --}}
        <div class="form-group">
            <label>Amount</label>

            <input type="text" id="amount_display" value="₹0.00" readonly>

            {{-- Actual amount submitted --}}
            <input type="hidden" name="amount" id="amount" value="0">
        </div>


        {{-- Discount --}}
        <div class="form-group">

            <label>Select Discount</label>

            <div class="discount-buttons">

                <button type="button" class="discount-btn" data-discount="10">
                    10%
                </button>

                <button type="button" class="discount-btn" data-discount="20">
                    20%
                </button>

                <button type="button" class="discount-btn" data-discount="30">
                    30%
                </button>

                <button type="button" class="discount-btn" data-discount="40">
                    40%
                </button>

                <button type="button" class="discount-btn" data-discount="50">
                    50%
                </button>

                <button type="button" class="discount-btn" data-discount="55">
                    55%
                </button>

                <button type="button" class="discount-btn" id="customBtn">
                    Custom
                </button>

            </div>


            <div class="custom-discount" id="customDiscountBox">

                <input type="number" id="customDiscount" name="custom_discount" placeholder="Enter custom discount %"
                    min="0" max="55" step="0.01">

            </div>


            <input type="hidden" name="discount" id="discount" value="0">

        </div>


        {{-- Price Summary --}}
        <div class="price-summary">

            <p>
                Area Required:
                <span id="displayArea">0</span>
            </p>

            <p>
                Stall Price:
                ₹<span id="displayStallPrice2">0.00</span>
            </p>

            <p>
                Amount:
                ₹<span id="displayAmount">0.00</span>
            </p>

            <p>
                Discount:
                ₹<span id="displayDiscount">0.00</span>
            </p>

            <p>
                Amount After Discount:
                ₹<span id="displayAfterDiscount">0.00</span>
            </p>

            <p>
                GST (18%):
                ₹<span id="displayGst">0.00</span>
            </p>

            <p class="final-price">
                Final Price:
                ₹<span id="finalPrice">0.00</span>
            </p>

        </div>


        <button type="submit" class="submit-btn">
            Create Booking
        </button>

    </div>


    <script>

        const eventInput = document.getElementById('event_id');
        const areaInput = document.getElementById('area_required');

        const amountInput = document.getElementById('amount');
        const amountDisplay = document.getElementById('amount_display');

        const discountInput = document.getElementById('discount');

        const customDiscount = document.getElementById('customDiscount');
        const customDiscountBox = document.getElementById('customDiscountBox');
        const customBtn = document.getElementById('customBtn');

        const displayArea = document.getElementById('displayArea');

        const displayStallPrice = document.getElementById('displayStallPrice');
        const displayStallPrice2 = document.getElementById('displayStallPrice2');

        const displayAmount = document.getElementById('displayAmount');
        const displayDiscount = document.getElementById('displayDiscount');
        const displayAfterDiscount = document.getElementById('displayAfterDiscount');
        const displayGst = document.getElementById('displayGst');
        const finalPrice = document.getElementById('finalPrice');

        const discountButtons =
            document.querySelectorAll('.discount-btn[data-discount]');


        function calculatePrice() {

            // Get selected event
            const selectedOption =
                eventInput.options[eventInput.selectedIndex];

            // Get stall price
            const stallPrice =
                parseFloat(selectedOption.dataset.stallPrice) || 0;

            // Get area
            const area =
                parseFloat(areaInput.value) || 0;


            // Amount = Area × Stall Price
            const amount = area * stallPrice;


            // Discount percentage
            const discountPercent =
                parseFloat(discountInput.value) || 0;


            // Discount amount
            const discountAmount =
                amount * discountPercent / 100;


            // Amount after discount
            const amountAfterDiscount =
                amount - discountAmount;


            // GST 18%
            const gst =
                amountAfterDiscount * 18 / 100;


            // Final price
            const total =
                amountAfterDiscount + gst;


            // Update hidden amount
            amountInput.value = amount.toFixed(2);


            // Update display
            displayArea.textContent =
                area.toFixed(2);

            displayStallPrice.textContent =
                stallPrice.toFixed(2);

            displayStallPrice2.textContent =
                stallPrice.toFixed(2);

            amountDisplay.value =
                '₹' + amount.toFixed(2);

            displayAmount.textContent =
                amount.toFixed(2);

            displayDiscount.textContent =
                discountAmount.toFixed(2);

            displayAfterDiscount.textContent =
                amountAfterDiscount.toFixed(2);

            displayGst.textContent =
                gst.toFixed(2);

            finalPrice.textContent =
                total.toFixed(2);
        }


        // Event change
        eventInput.addEventListener('change', calculatePrice);


        // Area change
        areaInput.addEventListener('input', calculatePrice);


        // Discount buttons
        discountButtons.forEach(function (button) {

            button.addEventListener('click', function () {

                discountButtons.forEach(function (btn) {
                    btn.classList.remove('active');
                });

                customBtn.classList.remove('active');

                this.classList.add('active');

                discountInput.value =
                    this.dataset.discount;

                customDiscountBox.style.display =
                    'none';

                calculatePrice();
            });

        });


        // Custom discount
        customBtn.addEventListener('click', function () {

            discountButtons.forEach(function (btn) {
                btn.classList.remove('active');
            });

            this.classList.add('active');

            customDiscountBox.style.display =
                'block';

            discountInput.value =
                customDiscount.value || 0;

            calculatePrice();
        });


        // Custom discount input
        customDiscount.addEventListener('input', function () {

            let value =
                parseFloat(this.value) || 0;

            // Maximum 55%
            if (value > 55) {
                value = 55;
                this.value = 55;
            }

            if (value < 0) {
                value = 0;
                this.value = 0;
            }

            discountInput.value =
                value;

            calculatePrice();
        });


        // Initial calculation
        calculatePrice();

    </script>

</form>