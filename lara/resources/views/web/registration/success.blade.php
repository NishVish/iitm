<div class="section-2">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap"
        rel="stylesheet">

    <style>
        .section-2 {
            padding: 80px 20px;
            text-align: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #ffffff, #eef2f5);
            min-height: 60vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .logo img {
            width: 180px;
            margin-bottom: 40px;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.05));
        }

        /* Pulsing Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            background: rgba(197, 137, 64, 0.1);
            color: #c58940;
            font-size: 13px;
            font-weight: 700;
            border-radius: 50px;
            letter-spacing: 1.5px;
            margin-bottom: 20px;
            border: 1px solid rgba(197, 137, 64, 0.2);
            animation: pulse-border 2s infinite;
        }

        @keyframes pulse-border {
            0% {
                box-shadow: 0 0 0 0 rgba(197, 137, 64, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(197, 137, 64, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(197, 137, 64, 0);
            }
        }

        .title {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        /* Fancy Glass Card */
        .card {
            position: relative;
            margin-top: 10px;
            background: #ffffff;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04), 0 1px 3px rgba(0, 0, 0, 0.02);
            max-width: 480px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card::before {
            content: "✓";
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 50px;
            background: #10b981;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        .text {
            font-size: 17px;
            color: #475569;
            line-height: 1.8;
        }

        .highlight {
            color: #c58940;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .highlight::after {
            content: "";
            position: absolute;
            bottom: 2px;
            left: 0;
            width: 100%;
            height: 8px;
            background: rgba(197, 137, 64, 0.1);
            z-index: -1;
        }

        .footer-note {
            margin-top: 30px;
            font-size: 13px;
            color: #94a3b8;
        }
    </style>

    <div class="logo">
        <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Logo">
    </div>

    <div class="badge">
        <span style="width: 8px; height: 8px; background: #c58940; border-radius: 50%;"></span>
        {{ $status }}
    </div>

    <div class="title">
        Profile Submitted
    </div>

    <div class="card">
        <div class="text">
            @if(!empty($dbData->name))
                Hello <span class="highlight">{{ $dbData->name }}</span>,
            @endif
            <br><br>
            Your application is now with our verification team.
            We take quality seriously, so we'll review your details carefully.
            <br><br>
            @if($status == 'approved')
                <strong>Your registration has been approved. Mail Confirmation Already Sent.</strong>

            @elseif($status == 'Under Review')
                <strong>Your application is under review. Expect an update via email shortly.</strong>

            @elseif($status == 'rejected')
                <strong>Your application was not approved. You will receive details via email.</strong>

            @else
                <strong>Expect an update via email shortly.</strong>
            @endif
        </div>
    </div>

    <div>
        {{ $eventname }}
    </div>

    <div class="footer-note">
        Reference ID: #{{ time() }}
    </div>
    <button id="sendMailBtn" class="btn btn-primary mt-4">
        Send Confirmation Mail
        <style>
            #sendMailBtn {
                margin-top: 25px;
                padding: 12px 22px;
                background: linear-gradient(135deg, #c58940, #e0a85a);
                color: #fff;
                border: none;
                border-radius: 10px;
                font-weight: 700;
                font-size: 14px;
                cursor: pointer;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
                box-shadow: 0 10px 20px rgba(197, 137, 64, 0.25);
            }

            #sendMailBtn:hover {
                transform: translateY(-2px);
                box-shadow: 0 14px 28px rgba(197, 137, 64, 0.35);
            }

            #sendMailBtn:disabled {
                opacity: 0.6;
                cursor: not-allowed;
                transform: none;
            }
        </style>
    </button>

    <div id="mailStatus" style="margin-top:10px;font-weight:600;"></div>


    <div style="display: none;">
        @include('web.search')
    </div>
</div>

<script>
    document.getElementById("sendMailBtn").addEventListener("click", function () {

        let eventName = "{{ $eventName ?? '' }}"; // or pass from backend
        let btn = this;
        let status = document.getElementById("mailStatus");

        btn.disabled = true;
        status.innerText = "Sending mail...";

        fetch(`{{ url('/send-confirmation') }}/${encodeURIComponent(eventName)}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
            .then(res => res.json())
            .then(data => {

                if (data.status) {
                    status.innerText = "Mail sent successfully!";
                    status.style.color = "green";
                } else {
                    status.innerText = "Failed to send mail.";
                    status.style.color = "red";
                }

                btn.disabled = false;
            })
            .catch(err => {
                status.innerText = "Error sending mail.";
                status.style.color = "red";
                btn.disabled = false;
            });

    });
</script>