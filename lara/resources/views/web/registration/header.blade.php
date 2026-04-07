<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITM Chennai 2026 | Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap"
        rel="stylesheet">
    <style>
        /* Modern Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        :root {
            --primary: #007AFF;
            --accent: #6366f1;
            --bg-dark: #0f172a;
            --glass: rgba(255, 255, 255, 0.03);
            --border: rgba(255, 255, 255, 0.1);
            --success: #10b981;
        }

        body {
            background-color: var(--bg-dark);
            background-image:
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(0, 122, 255, 0.1) 0px, transparent 50%);
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .layout-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .left-panel {
            flex: 0 0 35%;
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 20px;
            display: flex;
            align-items: center;
        }

        .hero-img-container {
            width: 100%;
            height: 95%;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid var(--border);
        }

        .hero-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .right-panel {
            flex: 1;
            padding: 80px 10% 80px 5%;
        }

        h1 {
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 30px;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Registration Box & OTP Logic */
        .registration-box {
            background: var(--glass);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            padding: 40px;
            border-radius: 24px;
            margin-bottom: 40px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            padding: 16px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: white;
            font-size: 16px;
            transition: 0.3s;
        }

        .form-group label {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            pointer-events: none;
            transition: 0.3s;
        }

        .form-group input:focus+label,
        .form-group input:not(:placeholder-shown)+label {
            top: 12px;
            font-size: 12px;
            color: var(--primary);
        }

        .form-group input:focus {
            border-color: var(--primary);
            outline: none;
            padding-top: 24px;
            padding-bottom: 8px;
        }

        #otp-subtitle {
            color: var(--success);
            font-size: 14px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .btn-main {
            width: 100%;
            padding: 16px;
            border-radius: 12px;
            border: none;
            background: var(--primary);
            color: white;
            font-weight: 800;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        .btn-main:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Meta & Footer */
        .event-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .meta-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 20px;
            background: var(--glass);
            border-radius: 16px;
            border: 1px solid var(--border);
        }

        .meta-text h5 {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .benefits-container {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin: 24px 0 48px 0;
        }

        .benefit-chip {
            background: rgba(255, 255, 255, 0.05);
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 14px;
            border: 1px solid var(--border);
        }

        .contact-footer {
            background: linear-gradient(135deg, var(--accent), var(--primary));
            padding: 30px;
            border-radius: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        @media (max-width: 1024px) {
            .layout-wrapper {
                flex-direction: column;
            }

            .left-panel {
                height: 350px;
                flex: none;
                position: static;
            }

            .right-panel {
                padding: 40px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="layout-wrapper">
        <aside class="left-panel">
            <div class="hero-img-container">
                <img src="https://iitmindia.com/wp-content/uploads/2025/11/WhatsApp-Image-2025-11-12-at-3.18.08-PM.jpeg"
                    alt="IITM 2026">
            </div>
        </aside>

        <main class="right-panel">
            @foreach ($events as $event)
                <span style="color: var(--accent); font-weight: 800; text-transform: uppercase; letter-spacing: 2px;">Trade
                    Visitor Access</span>
                <h1>{{ $event->name }}</h1>

                <div class="registration-box">

                    <div id="login-section">
                        <div class="form-group">
                            <input type="number" id="mobile_number" placeholder=" " required>
                            <label for="mobile_number">Mobile Number</label>
                        </div>

                        <div id="otp-area" style="display: none;">
                            <p id="otp-subtitle"></p>
                            <div class="form-group">
                                <input type="number" id="otp_input" placeholder=" " required>
                                <label for="otp_input">Enter 6-Digit OTP</label>
                            </div>
                        </div>

                        <button id="btn-send-otp" onclick="handleSendOTP()" class="btn-main">Get OTP</button>
                        <button id="btn-verify-otp" onclick="handleVerifyOTP()" class="btn-main"
                            style="display: none; background: var(--success);">Verify & Unlock Form</button>

                        <p id="change-number"
                            style="display:none; text-align: center; margin-top: 15px; font-size: 13px; color: #94a3b8; cursor: pointer;"
                            onclick="location.reload()">Change Number</p>

                    </div>

                    <div id="details-section" style="display: none;">
                        <h4 style="margin-bottom: 20px; color: var(--success);">✓ Number Verified</h4>
                        <form id="final-registration-form">
                            <div class="form-group">
                                <input type="text" id="name_input" placeholder=" " required>
                                <label for="name_input">Full Name</label>
                            </div>
                            <div class="form-group">
                                <input type="email" id="email_input" placeholder=" " required>
                                <label for="email_input">Email Address</label>
                            </div>
                            <div class="form-group">
                                <input type="text" id="company_input" placeholder=" " required>
                                <label for="company_input">Company Name</label>
                            </div>
                            <button type="submit" class="btn-main">Complete Registration</button>
                        </form>
                    </div>
                </div>
                <div class="event-meta">
                    <div class="meta-item">
                        <span>📅</span>
                        <div class="meta-text">
                            <h5>DATE</h5>
                            <p>{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="meta-item">
                        <span>📍</span>
                        <div class="meta-text">
                            <h5>VENUE</h5>
                            <p>{{ $event->venue_details }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

            <h3>Event Highlights</h3>
            <div class="benefits-container">
                <div class="benefit-chip">⚡ Networking</div>
                <div class="benefit-chip">📈 B2B Leads</div>
                <div class="benefit-chip">🌍 Global Exposure</div>
            </div>

            <div class="contact-footer">
                <div class="contact-info">
                    <h4>Need Assistance?</h4>
                    <p>Support is available 24/7 for attendees.</p>
                </div>
                <div class="contact-links" style="text-align: right;">
                    <p><strong>🌐 iitmindia.com</strong></p>
                    <p><strong>📧 info@iitmindia.com</strong></p>
                </div>
            </div>
        </main>
    </div>

    <script>
        function handleSendOTP() {
            const mobile = document.getElementById('mobile_number').value;
            if (mobile.length < 10) return alert("Enter a valid 10-digit mobile number");

            const btn = document.getElementById('btn-send-otp');
            btn.innerText = "Processing...";
            btn.disabled = true;

            fetch("{{ route('login.otp') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ mobile_number: mobile })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('otp-area').style.display = 'block';
                        document.getElementById('btn-verify-otp').style.display = 'block';
                        document.getElementById('btn-send-otp').style.display = 'none';
                        document.getElementById('change-number').style.display = 'block';
                        document.getElementById('otp-subtitle').innerText = "Code sent to +91 " + mobile;
                        document.getElementById('mobile_number').disabled = true;
                    } else {
                        alert(data.message);
                        btn.innerText = "Get OTP";
                        btn.disabled = false;
                    }
                })
                .catch(err => {
                    alert("Server error. Please try again.");
                    btn.disabled = false;
                    btn.innerText = "Get OTP";
                });
        }
        // 1. On Page Load: Check if session exists (optional check)
        document.addEventListener("DOMContentLoaded", function () {
            // If your backend passes a variable like $isVerified, you can skip to form
            @if(session('authenticated_mobile'))
                showRegistrationForm();
            @endif
});

        function showRegistrationForm() {
            document.getElementById('login-section').style.display = 'none';
            document.getElementById('details-section').style.display = 'block';
        }
        function handleVerifyOTP() {
            const otp = document.getElementById('otp_input').value;
            const mobile = document.getElementById('mobile_number').value;

            if (otp.length < 6) return alert("Enter the 6-digit OTP");

            const btn = document.getElementById('btn-verify-otp');
            btn.innerText = "Verifying...";
            btn.disabled = true;

            fetch("{{ route('login.verify') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ mobile_number: mobile, otp: otp })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        // SUCCESS: Redirect to the registration form page
                        // Replace 'registration.form' with your actual route name or URL
                        window.location.href = "{{ route('registration.form') }}";
                    } else {
                        alert(data.message || "Invalid OTP");
                        btn.innerText = "Verify & Proceed";
                        btn.disabled = false;
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Verification failed.");
                    btn.disabled = false;
                    btn.innerText = "Verify & Proceed";
                });
        }
    </script>
</body>

</html>