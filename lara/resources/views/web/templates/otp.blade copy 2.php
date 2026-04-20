<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITM Chennai 2026 | Register</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Simple hover effect for the trigger button */
        .open-btn:hover {
            background-color: #1d4ed8 !important;
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="bg-gray-100">
    <div id="csrf_holder" style="display:none;">@csrf</div>



    <div id="auth-modal" style="
        position: fixed; 
        inset: 0; 
        z-index: 9999; 
        display: none; /* Initially Hidden */
        align-items: center; 
        justify-content: center; 
        background-color: rgba(0, 0, 0, 0.5); 
        backdrop-filter: blur(4px);
        font-family: sans-serif;
    ">

        <div style="
            width: 100%; 
            max-width: 400px; 
            background: #ffffff; 
            border-radius: 12px; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); 
            overflow: hidden; 
            border: 1px solid #d1d5db;
            margin: 16px;
        ">

            <div style="
                background: linear-gradient(to bottom, #f9fafb, #f3f4f6); 
                padding: 10px 16px; 
                display: flex; 
                align-items: center; 
                justify-content: space-between; 
                border-bottom: 1px solid #d1d5db;
            ">
                <div
                    style="font-size: 10px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 1px;">
                    Secure Login
                </div>
                <div style="width: 40px; text-align: right;">
                    <button onclick="toggleModal()"
                        style="background:none; border:none; color:#9ca3af; cursor:pointer; font-size: 16px;">&times;</button>
                </div>
            </div>

            <div style="padding: 32px;">
                <div id="login-section">
                    <h2 style="margin: 0 0 8px 0; font-size: 24px; font-weight: 700; color: #1f2937;">Welcome</h2>
                    <p id="otp-subtitle" style="margin: 0 0 24px 0; font-size: 14px; color: #6b7280;">Enter your mobile
                        number to continue.</p>

                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <input type="hidden" id="event_id" value="123">

                        <div>
                            <label
                                style="display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px; text-transform: uppercase;">Mobile
                                Number</label>
                            <div style="position: relative; display: flex; align-items: center;">
                                <span
                                    style="position: absolute; left: 12px; color: #9ca3af; font-weight: 500;">+91</span>
                                <input type="tel" id="mobile_number"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    style="width: 100%; padding: 10px 10px 10px 45px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 16px; outline: none;"
                                    placeholder="9876543210" maxlength="10">
                            </div>
                        </div>

                        <div id="otp-area" style="display: none; text-align: center;">
                            <label
                                style="display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 8px; text-transform: uppercase;">Enter
                                6-Digit OTP</label>
                            <input type="text" id="otp_input" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                style="width: 100%; padding: 12px; border: 2px dashed #d1d5db; border-radius: 6px; font-size: 24px; font-weight: 800; text-align: center; letter-spacing: 8px; background: #f9fafb; outline: none;"
                                placeholder="000000" maxlength="6">
                            <button type="button" onclick="location.reload()"
                                style="background: none; border: none; color: #2563eb; font-size: 12px; margin-top: 10px; cursor: pointer; text-decoration: underline;">
                                Change Number?
                            </button>
                        </div>

                        <button id="btn-send-otp" onclick="handleSendOTP()"
                            style="width: 100%; background: #2563eb; color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: background 0.2s;">
                            Get OTP
                        </button>

                        <button id="btn-verify-otp" onclick="handleVerifyOTP()"
                            style="display: none; width: 100%; background: #16a34a; color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 600; cursor: pointer;">
                            Verify & Proceed
                        </button>
                    </div>
                </div>

                <div id="details-section" style="display: none; text-align: center;">
                    <div style="font-size: 48px; color: #16a34a; margin-bottom: 16px;">✓</div>
                    <h2 style="margin: 0; font-size: 24px; color: #1f2937;">Verified!</h2>
                    <p style="color: #6b7280;">Redirecting...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // TOGGLE MODAL FUNCTION
        function toggleModal() {
            const modal = document.getElementById('auth-modal');
            if (modal.style.display === 'none' || modal.style.display === '') {
                modal.style.display = 'flex';
            } else {
                modal.style.display = 'none';
            }
        }

        // Close modal if user clicks the dark background area
        window.onclick = function (event) {
            const modal = document.getElementById('auth-modal');
            if (event.target == modal) {
                toggleModal();
            }
        }

        function handleSendOTP() {
            const mobile = document.getElementById('mobile_number').value;
            const eventId = document.getElementById('event_id').value || 123;
            const btn = document.getElementById('btn-send-otp');

            console.log("DEBUG: Function triggered");
            console.log("DEBUG: Mobile =", mobile);
            console.log("DEBUG: Event ID =", eventId);

            if (mobile.length !== 10) {
                console.warn("DEBUG: Invalid mobile number");
                return alert("Please enter a valid 10-digit mobile number");
            }

            btn.innerText = "Processing...";
            btn.disabled = true;

            const url = "{{ url('/request-otp') }}/" + mobile + '/' + eventId;
            console.log("DEBUG: Request URL =", url);

            fetch(url, {
                method: "GET", // FIXED (was "Get")
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
                // ❌ No body for GET
            })
                .then(async res => {
                    console.log("DEBUG: Raw response =", res);

                    let data;
                    try {
                        data = await res.json();
                    } catch (e) {
                        console.error("DEBUG: JSON parse error", e);
                        throw new Error("Invalid JSON response");
                    }

                    console.log("DEBUG: Parsed response =", data);

                    if (!res.ok) {
                        console.error("DEBUG: Response not OK", res.status);
                        throw new Error(data.message || `Error: ${res.status}`);
                    }

                    return data;
                })
                .then(data => {
                    console.log("DEBUG: Success block", data);

                    if (data.status === 'success' || data.status === 'created') {
                        document.getElementById('otp-area').style.display = 'block';
                        document.getElementById('btn-verify-otp').style.display = 'block';
                        document.getElementById('btn-send-otp').style.display = 'none';
                        document.getElementById('otp-subtitle').innerText = "Code sent to +91 " + mobile;
                        document.getElementById('mobile_number').disabled = true;
                    } else {
                        console.warn("DEBUG: Unexpected status", data.status);
                        throw new Error(data.message || "Unknown error occurred");
                    }
                })
                .catch(err => {
                    console.error("DEBUG: Error caught =", err);
                    alert(err.message);

                    btn.innerText = "Get OTP";
                    btn.disabled = false;
                });
        }

        function handleVerifyOTP() {
            const otp = document.getElementById('otp_input').value;
            const mobile = document.getElementById('mobile_number').value;
            const btn = document.getElementById('btn-verify-otp');

            if (otp.length < 6) return alert("Enter the 6-digit OTP");

            btn.innerText = "Verifying...";
            btn.disabled = true;

            fetch("{{ route('login.verify') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ mobile_number: mobile, otp: otp })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.href = "{{ route('registration.form') }}";
                    } else {
                        alert(data.message || "Invalid OTP");
                        btn.innerText = "Verify & Proceed";
                        btn.disabled = false;
                    }
                })
                .catch(err => {
                    alert("Verification failed.");
                    btn.disabled = false;
                    btn.innerText = "Verify & Proceed";
                });
        }

        document.addEventListener("DOMContentLoaded", function () {
            @if(session('authenticated_mobile'))
                toggleModal(); // Open automatically if session exists
                document.getElementById('login-section').style.display = 'none';
                document.getElementById('details-section').style.display = 'block';
            @endif
        });
    </script>
</body>

</html>