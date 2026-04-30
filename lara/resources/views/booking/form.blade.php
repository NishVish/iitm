<form method="POST" action="{{url('/finalize-lead')}}">
    @csrf

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1e1e2f, #2b2b45);
            margin: 0;
            color: #333;
        }

        .container-box {
            max-width: 700px;
            margin: 30px auto;
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding-bottom: 90px;
        }

        /* Steps */
        .step {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tabs */
        .step-tabs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            background: #f1f1f1;
            padding: 6px;
            border-radius: 50px;
        }

        .step-tabs button {
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 500;
            transition: 0.3s;
        }

        .step-tabs button.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .step-tabs button:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        /* Footer */
        .form-footer {
            position: sticky;
            bottom: 0;
            background: #fff;
            padding: 15px;
            border-top: 1px solid #eee;
            text-align: right;
        }

        .form-footer button {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: #fff;
            padding: 10px 22px;
            border-radius: 25px;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        .form-footer button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
    </style>

    <div class="container-box">

        {{-- STEP BUTTONS --}}
        <div class="step-tabs">
            <button type="button" onclick="showStep(1)" id="tab-1">1</button>
            <button type="button" onclick="showStep(2)" id="tab-2">2</button>
            <button type="button" onclick="showStep(3)" id="tab-3">3</button>
        </div>

        <div class="container-box">

            <div id="step-1" class="step">
                <h3>Personal Info</h3>
                @include('booking.personalinfo')


            </div>

            <div id="step-2" class="step">
                <h3>Company Info</h3>

                @include('booking.companyinfo')

            </div>

            <div id="step-3" class="step">
                <h3>Lead Info</h3>
                @include('booking.leadinfo')


            </div>

            <div id="step-4" class="step">

                <style>
                    .summary-box {
                        background: #f9fafc;
                        border-radius: 12px;
                        padding: 20px;
                        box-shadow: inset 0 0 0 1px #eee;
                    }

                    .summary-title {
                        font-size: 20px;
                        margin-bottom: 15px;
                        font-weight: 600;
                    }

                    .summary-row {
                        display: flex;
                        justify-content: space-between;
                        padding: 10px 0;
                        border-bottom: 1px solid #eee;
                        font-size: 15px;
                    }

                    .summary-row:last-child {
                        border-bottom: none;
                    }

                    .summary-label {
                        color: #666;
                    }

                    .summary-value {
                        font-weight: 500;
                        color: #111;
                    }

                    .summary-total {
                        margin-top: 15px;
                        padding-top: 15px;
                        border-top: 2px solid #ddd;
                        font-size: 17px;
                        font-weight: 600;
                        display: flex;
                        justify-content: space-between;
                    }
                </style>

                <div class="summary-box">
                    <div class="summary-title">Order Summary</div>

                    <div class="summary-row">
                        <div class="summary-label">Name</div>
                        <div class="summary-value" id="summary-name">-</div>
                    </div>

                    <div class="summary-row">
                        <div class="summary-label">Email</div>
                        <div class="summary-value" id="summary-email">-</div>
                    </div>

                    <div class="summary-row">
                        <div class="summary-label">Phone</div>
                        <div class="summary-value" id="summary-phone">-</div>
                    </div>

                    <div class="summary-row">
                        <div class="summary-label">Date</div>
                        <div class="summary-value" id="summary-date">-</div>
                    </div>

                    <div class="summary-row">
                        <div class="summary-label">Slot</div>
                        <div class="summary-value" id="summary-slot">-</div>
                    </div>

                    <div class="summary-total">
                        <div>Total</div>
                        <div id="summary-total">₹0</div>
                    </div>
                </div>

                <script>
                    function updateSummary() {
                        document.getElementById('summary-name').innerText =
                            document.querySelector('[name="name"]')?.value || '-';

                        document.getElementById('summary-email').innerText =
                            document.querySelector('[name="email"]')?.value || '-';

                        document.getElementById('summary-phone').innerText =
                            document.querySelector('[name="phone"]')?.value || '-';

                        document.getElementById('summary-date').innerText =
                            document.querySelector('[name="date"]')?.value || '-';

                        document.getElementById('summary-slot').innerText =
                            document.querySelector('[name="slot"]')?.value || '-';

                        // Example static price (replace with your logic)
                        document.getElementById('summary-total').innerText = '₹500';
                    }

                    // Call when step 4 is opened
                    document.getElementById('tab-4').addEventListener('click', updateSummary);
                </script>

            </div>

        </div>


        @include('booking.formstructure')

    </div>

    <div class="form-footer">
        <button type="submit">Submit →</button>
    </div>

    <script>
        let currentStep = 1;

        function showStep(step) {
            currentStep = step;

            document.querySelectorAll('.step').forEach(el => {
                el.style.display = 'none';
            });

            document.getElementById('step-' + step).style.display = 'block';

            document.querySelectorAll('.step-tabs button').forEach(btn => {
                btn.classList.remove('active');
            });

            document.getElementById('tab-' + step).classList.add('active');
        }

        showStep(1);
    </script>

</form>