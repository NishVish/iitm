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
    </style>
</head>

<body>

    <!-- MODAL -->
    <div id="auth-modal" style="
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    background: rgba(0,0,0,0.5);
">

        <div style="
        width: 100%;
        max-width: 400px;
        background: #fff;
        border-radius: 12px;
        padding: 24px;
    ">

            <div style="display:flex;justify-content:space-between;">
                <h3>Secure Login</h3>
                <button onclick="toggleModal()" style="border:none;background:none;font-size:20px;">&times;</button>
            </div>

            <div id="login-section">

                <p id="otp-subtitle">Enter mobile or email</p>

                <!-- ✅ FORM -->
                <form id="otp-form" method="POST" action="{{ url('/request-otp') }}">
                    @csrf

                    <input type="hidden" name="event_id" id="event_id" value="123">

                    <label>Mobile or Email</label>
                    <input type="text" id="user_input" name="input" required
                        style="width:100%;padding:10px;margin-top:5px;border:1px solid #ccc;"
                        placeholder="Enter mobile or email">

                    <button type="submit" id="btn-send-otp"
                        style="width:100%;margin-top:15px;padding:10px;background:#2563eb;color:#fff;border:none;">
                        Get Started
                    </button>
                </form>

            </div>

            <!-- OTP UI (optional after reload/session) -->
            <div id="otp-area" style="display:none;margin-top:20px;">
                <input type="text" maxlength="6" placeholder="Enter OTP"
                    style="width:100%;padding:10px;text-align:center;font-size:20px;">
            </div>

        </div>
    </div>
    <script>
        function toggleModal() {
            const modal = document.getElementById('auth-modal');

            console.log("🔵 toggleModal called");
            console.log("Current display:", modal.style.display);

            modal.style.display = (modal.style.display === 'flex') ? 'none' : 'flex';

            console.log("New display:", modal.style.display);
        }

        window.onclick = function (e) {
            const modal = document.getElementById('auth-modal');

            console.log("🟡 Window click detected");
            console.log("Clicked target:", e.target);

            if (e.target === modal) {
                console.log("🟢 Clicked outside modal → closing");
                toggleModal();
            }
        };

        // ✅ FORM VALIDATION ONLY (NO FETCH)
        document.addEventListener("DOMContentLoaded", function () {

            console.log("🚀 DOM fully loaded");

            const form = document.getElementById('otp-form');
            const btn = document.getElementById('btn-send-otp');

            if (!form) {
                console.error("❌ otp-form not found in DOM");
                return;
            }

            console.log("✅ OTP form found");

            form.addEventListener('submit', function (e) {

                console.log("📨 Form submit triggered");

                const input = document.getElementById('user_input').value.trim();
                console.log("📥 User input:", input);

                const isMobile = /^[0-9]{10}$/.test(input);
                const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input);

                console.log("📊 Validation check");
                console.log("👉 isMobile:", isMobile);
                console.log("👉 isEmail:", isEmail);

                if (!isMobile && !isEmail) {
                    console.warn("⚠️ Invalid input blocked");
                    e.preventDefault();
                    alert("Enter valid 10-digit mobile number or email");
                    return;
                }

                console.log("✅ Input valid, submitting form");

                btn.innerText = "Processing...";
                btn.disabled = true;

                console.log("🔵 Button disabled, UI updated");
            });

            console.log("🎯 Submit listener attached");

            // auto open modal if needed
            @if(session('authenticated_mobile'))
                console.log("🟢 Session detected: authenticated_mobile");
                toggleModal();
                document.getElementById('login-section').style.display = 'none';
                document.getElementById('otp-area').style.display = 'block';
            @else
                console.log("⚪ No session found");
            @endif
});
    </script>

</body>

</html>