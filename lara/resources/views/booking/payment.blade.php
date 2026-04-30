<div>

    <button type="button" onclick="openPayment()" style="
        padding: 12px 20px;
        background: linear-gradient(135deg,#667eea,#764ba2);
        color: white;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 15px;
    ">
        Pay
    </button>

    <!-- PAYMENT MODAL -->
    <div id="paymentModal" style="
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        justify-content: center;
        align-items: center;
    ">

        <div style="
            background: white;
            padding: 25px;
            border-radius: 12px;
            width: 320px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        ">

            <h3 style="margin-top:0;">Payment</h3>

            <p style="color:#666;">Complete your payment securely</p>

            <div style="margin:15px 0;">
                <strong>Total: ₹500</strong>
            </div>

            <!-- RAZORPAY BUTTON -->
            <button onclick="payNow()" style="
                width: 100%;
                padding: 10px;
                margin-top: 10px;
                background: #28a745;
                color: white;
                border: none;
                border-radius: 8px;
                cursor: pointer;
            ">
                Pay Now
            </button>

            <button type="button" onclick="closePayment()" style="
                margin-top: 10px;
                background: transparent;
                border: none;
                color: #666;
                cursor: pointer;
            ">
                Cancel
            </button>

        </div>

    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        function openPayment() {
            document.getElementById('paymentModal').style.display = 'flex';
        }

        function closePayment() {
            document.getElementById('paymentModal').style.display = 'none';
        }

        function payNow() {

            var options = {
                key: "rzp_test_SjJuZPt7y1odXP",
                amount: 5, // ₹500 in paise
                currency: "INR",
                name: "IITM Booking",
                description: "Booking Payment",

                method: {
                    card: false,
                    netbanking: false,
                    wallet: false,
                    upi: true
                },
                handler: function (response) {
                    alert("Payment successful: " + response.razorpay_payment_id);
                },

                theme: {
                    color: "#667eea"
                }
            };

            var rzp = new Razorpay(options);
            rzp.open();
        }

    </script>

</div>