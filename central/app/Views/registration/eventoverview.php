<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .event-card {
            border-left: 5px solid #0d6efd;
            transition: transform 0.2s;
            border: none;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .venue-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
        }

        .primary-btn {
            background: #6200EE;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 12px;
            width: 100%;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-light bg-white shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1-768x768.png" width="50" height="50"
                    class="me-3">
                <div>
                    <span class="fw-bold fs-4 d-block text-primary" style="line-height: 1;">IITM India</span>
                    <small class="text-muted">International Industrial Trade Fair</small>
                </div>
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="fw-bold text-dark mb-0"><?= esc($title) ?></h1>
                <p class="text-muted">Event Year: <?= $eventYear ?></p>
            </div>
        </div>

        <div class="row">
            <?php foreach ($events as $event): ?>
                <div class="col-12 mb-4">
                    <div class="card event-card shadow-sm">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <h2 class="h3 mb-3"><?= esc($event['name']) ?></h2>
                                    <p class="text-secondary">📅 <?= date('M d, Y', strtotime($event['start_date'])) ?> to
                                        <?= date('M d, Y', strtotime($event['end_date'])) ?>
                                    </p>
                                    <div class="venue-box">
                                        <strong>📍 Venue Details:</strong>
                                        <p class="mb-0 text-muted small"><?= esc($event['venue_details']) ?></p>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex flex-column justify-content-center border-start ps-4">
                                    <h6 class="text-uppercase text-muted fw-bold small">Registration</h6>
                                    <p class="fw-bold text-primary"><?= esc($event['venue_booking_details']) ?></p>

                                    <button type="button" class="btn btn-primary btn-lg mt-2" data-bs-toggle="modal"
                                        data-bs-target="#loginModal">
                                        Register Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 20px;">
                <div class="modal-body p-5 text-center">
                    <h3 class="fw-bold mb-2">Secure Login</h3>
                    <p class="text-muted mb-4" id="otp-subtitle">Enter mobile to continue registration</p>

                    <form id="loginForm" method="post" action="http://localhost/iitm/">
                        <input type="tel" id="mobile_number" name="mobile_number" class="form-control mb-3 p-3"
                            style="border-radius: 12px;" placeholder="10-Digit Mobile Number" pattern="[0-9]{10}"
                            required>

                        <div id="otp-section" style="display: none;">
                            <input type="text" id="otp_input" name="otp" class="form-control mb-3 p-3"
                                style="border-radius: 12px;" placeholder="6-Digit OTP" maxlength="6"
                                inputmode="numeric">
                        </div>

                        <button type="button" id="send-otp-btn" class="primary-btn">Send OTP Code</button>
                        <button type="submit" id="verify-btn" class="primary-btn" style="display: none;">Verify &
                            Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script>
        const sendBtn = document.getElementById('send-otp-btn');
        const verifyBtn = document.getElementById('verify-btn');
        const otpSection = document.getElementById('otp-section');
        const mobileInput = document.getElementById('mobile_number');
        const subtitle = document.getElementById('otp-subtitle');

        sendBtn.addEventListener('click', function () {
            // Validate mobile number
            if (mobileInput.checkValidity()) {
                sendBtn.innerText = "Sending...";
                sendBtn.disabled = true;

                // Simulated AJAX request for OTP
                fetch('<?= site_url("request_otp") ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'mobile_number=' + encodeURIComponent(mobileInput.value)
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Show OTP section and verify button
                            otpSection.style.display = 'block';
                            verifyBtn.style.display = 'block';
                            sendBtn.style.display = 'none';
                            mobileInput.readOnly = true;
                            subtitle.innerText = "OTP sent to " + mobileInput.value;
                        } else {
                            alert("Failed to send OTP. Try again.");
                            sendBtn.innerText = "Send OTP Code";
                            sendBtn.disabled = false;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Error sending OTP.");
                        sendBtn.innerText = "Send OTP Code";
                        sendBtn.disabled = false;
                    });
            } else {
                mobileInput.reportValidity();
            }
        });
    </script> -->

    <script>
        const sendBtn = document.getElementById('send-otp-btn');
        const verifyBtn = document.getElementById('verify-btn');
        const otpSection = document.getElementById('otp-section');
        const mobileInput = document.getElementById('mobile_number');
        const subtitle = document.getElementById('otp-subtitle');

        sendBtn.addEventListener('click', function () {
            if (mobileInput.checkValidity()) {
                // Dummy OTP flow
                otpSection.style.display = 'block';
                verifyBtn.style.display = 'block';
                sendBtn.style.display = 'none';
                mobileInput.readOnly = true;
                subtitle.innerText = "OTP sent to " + mobileInput.value;
            } else {
                mobileInput.reportValidity();
            }
        });
    </script>
</body>

</html>