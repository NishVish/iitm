<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login | IITM India</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Base Reset */
        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', Arial, sans-serif;
            height: 100%;
            background: #F5F7FA;
            color: #2D3436;
        }

        /* Layout Wrapper */
        .page-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            padding: 24px;
        }

        /* Main Card Container */
        .container {
            width: 100%;
            max-width: 350px;
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.06);
            padding: 40px 24px;
            text-align: center;
            animation: slideUp 0.6s ease-out;
        }

        .logo {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            object-fit: contain;
            margin-bottom: 16px;
        }

        .header-section {
            margin-bottom: 28px;
        }

        .title {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 8px 0;
            color: #1A1A1A;
        }

        .subtitle {
            font-size: 14px;
            color: #7F8C8D;
            margin: 0;
        }

        /* Input Fields */
        .input-group {
            margin-bottom: 16px;
            text-align: left;
        }

        input[type="tel"], 
        input[type="password"] {
            width: 100%;
            padding: 16px;
            border-radius: 16px;
            font-size: 16px; /* Prevents iOS auto-zoom */
            border: 2px solid #F1F3F5;
            background: #F8F9FA;
            transition: all 0.2s ease;
            outline: none;
            color: #2D3436;
        }

        input:focus {
            border-color: #6200EE;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(98, 0, 238, 0.08);
        }

        /* Forgot Password Section */
        .forgot-row {
            display: flex;
            justify-content: flex-end;
            margin-top: -8px;
            margin-bottom: 24px;
        }

        .forgot-link {
            font-size: 13px;
            color: #6200EE;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 0;
        }

        /* Buttons */
        .primary-btn {
            width: 100%;
            padding: 16px;
            border: none;
            background: #6200EE;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            border-radius: 16px;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(98, 0, 238, 0.25);
            transition: all 0.2s;
            margin-bottom: 24px;
        }

        .primary-btn:active {
            transform: scale(0.97);
            background: #4B00D1;
        }

        /* Or Divider */
        .divider {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            color: #BDC3C7;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .divider::before, .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #EDF2F7;
        }

        .divider span {
            padding: 0 15px;
        }

        /* Secondary Link (Register) */
        .secondary-btn {
            display: block;
            width: 100%;
            padding: 14px;
            border: 2px solid #E2E8F0;
            background: transparent;
            color: #4A5568;
            font-size: 14px;
            font-weight: 700;
            border-radius: 16px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .secondary-btn:active {
            background: #F7FAFC;
            border-color: #CBD5E0;
            transform: scale(0.98);
        }

        /* Animations */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <div class="container">
        <img class="logo" src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM India Logo">
        
        <div class="header-section">
            <h1 class="title" id="form-title">Secure Login</h1>
            <p class="subtitle" id="form-subtitle">Enter your mobile number to begin</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div style="background: #FFE3E3; color: #D63031; padding: 12px; border-radius: 12px; margin-bottom: 20px; font-size: 13px;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form id="loginForm" method="post" action="<?=site_url('login')?>">
            <div class="input-group">
                <input 
                    type="tel" 
                    id="mobile_number"
                    name="mobile_number" 
                    placeholder="Mobile Number" 
                    pattern="[0-9]{10}" 
                    required
                >
            </div>

            <div id="otp-section" style="display: none;">
                <div class="input-group">
                    <input 
                        type="text" 
                        id="otp_input"
                        name="otp" 
                        placeholder="6-Digit OTP" 
                        maxlength="6"
                        pattern="\d{6}"
                        inputmode="numeric"
                    >
                </div>
            </div>
            
            <button type="button" id="send-otp-btn" class="primary-btn">Send OTP</button>
            <button type="submit" id="verify-btn" class="primary-btn" style="display: none;">Verify & Login</button>
        </form>

        <div id="resend-section" class="forgot-row" style="justify-content: center; display: none;">
            <a href="javascript:void(0)" onclick="sendOtpLogic()" class="forgot-link">Didn't get a code? Resend OTP</a>
        </div>

        <div class="divider"><span>New here?</span></div>
        <a href="<?=site_url('register')?>" class="secondary-btn">Create an Account</a>
    </div>
</div>

<script>
    const sendBtn = document.getElementById('send-otp-btn');
    const verifyBtn = document.getElementById('verify-btn');
    const otpSection = document.getElementById('otp-section');
    const mobileInput = document.getElementById('mobile_number');
    const resendSection = document.getElementById('resend-section');
    const subtitle = document.getElementById('form-subtitle');

    sendBtn.addEventListener('click', function() {
        if (mobileInput.checkValidity()) {
            sendOtpLogic();
        } else {
            alert("Please enter a valid 10-digit mobile number.");
        }
    });

    function sendOtpLogic() {
        const mobile = mobileInput.value;
        
        // Disable button while sending
        sendBtn.innerText = "Sending...";
        sendBtn.disabled = true;

        // Use Fetch API to tell your server to send the OTP
        fetch('<?=site_url("request_otp")?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'mobile_number=' + mobile
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                // UI Changes
                sendBtn.style.display = 'none';
                otpSection.style.display = 'block';
                verifyBtn.style.display = 'block';
                resendSection.style.display = 'flex';
                mobileInput.readOnly = true; // Lock mobile number
                subtitle.innerText = "Enter the 6-digit code sent to " + mobile;
                document.getElementById('otp_input').required = true;
            } else {
                alert(data.message || "Error sending OTP");
                sendBtn.innerText = "Send OTP";
                sendBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Failed to connect to server.");
            sendBtn.innerText = "Send OTP";
            sendBtn.disabled = false;
        });
    }
</script>