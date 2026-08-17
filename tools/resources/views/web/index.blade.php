<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'IITM Events' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        
        /* Smooth Transitions for Unlocking */
        .section-step { transition: all 0.5s ease; }
        .locked { opacity: 0.4; pointer-events: none; filter: grayscale(1); }
        .active-section { opacity: 1; pointer-events: auto; filter: none; }

        /* Modern UI Elements */
        .navbar { border-bottom: 1px solid #e2e8f0; }
        .event-card { 
            border: none; border-radius: 20px; background: #fff;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            border-left: 6px solid #6366f1; transition: transform 0.2s;
        }
        .event-card:hover { transform: translateY(-4px); }
        .venue-box { background: #f1f5f9; border-radius: 12px; padding: 15px; }
        
        .step-badge {
            width: 40px; height: 40px; display: flex; align-items: center;
            justify-content: center; border-radius: 50%; font-weight: bold;
        }
        
        .primary-btn { 
            background: #6366f1; color: #fff; border: none; padding: 12px 24px; 
            border-radius: 12px; font-weight: 600; width: 100%; transition: 0.3s;
        }
        .primary-btn:hover { background: #4f46e5; transform: scale(1.02); }
        
        /* Modal Polish */
        .modal-content { border: none; border-radius: 24px; overflow: hidden; }
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #cbd5e1; }
    </style>
</head>
<body>

<nav class="navbar navbar-light bg-white py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1-768x768.png" width="45" height="45" class="me-3">
            <div>
                <span class="fw-bold fs-4 d-block text-primary" style="line-height: 1;">IITM India</span>
                <small class="text-muted uppercase">India International Travel Mart</small>
            </div>
        </a>
    </div>
</nav>

<div class="container mt-5">
    <div class="header-section mb-5">
        @php $firstEvent = $events->first(); @endphp
        <h1 class="fw-bold text-slate-900">{{ $title ?? ($firstEvent->name ?? 'Registration') }}</h1>
        <p class="text-muted">Event Year: {{ $eventYear ?? ($firstEvent->year ?? '2026') }}</p>
    </div>

    <div class="row mb-4 section-step" id="section-1">
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm text-center p-4">
                <div class="step-badge bg-primary text-white mx-auto mb-3" id="badge-1">1</div>
                <h6 class="fw-bold">Verification</h6>
                <small class="text-muted">Select an event and verify your mobile number.</small>
            </div>
        </div>
        <div class="col-md-9">
            @foreach ($events as $event)
                <div class="card event-card mb-3">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="fw-bold mb-2">{{ $event->name }}</h4>
                                <p class="text-secondary mb-3">📅 {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</p>
                                <div class="venue-box">
                                    <small class="fw-bold d-block text-uppercase text-muted">Venue Details</small>
                                    <p class="mb-0 small">{{ $event->venue_details }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 border-start ps-md-4 text-center">
                                <span class="badge bg-soft-primary text-primary mb-2">{{ $event->venue_booking_details }}</span>
                                <button class="primary-btn mt-2" data-bs-toggle="modal" data-bs-target="#otpModal" onclick="prepareRegistration('{{ $event->event_id ?? $event->id }}')">
                                    Register Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row mb-4 section-step locked" id="section-2">
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm text-center p-4">
                <div class="step-badge bg-secondary text-white mx-auto mb-3" id="badge-2">2</div>
                <h6 class="fw-bold">Personal Details</h6>
                <small class="text-muted">Provide your contact information.</small>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card border-0 shadow-sm p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name_input">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email_input">
                    </div>
                    <div class="col-12 text-end">
                        <button class="btn btn-primary px-5 py-2 fw-bold" onclick="unlockSection3()">Next Step</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5 section-step locked" id="section-3">
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm text-center p-4">
                <div class="step-badge bg-secondary text-white mx-auto mb-3" id="badge-3">3</div>
                <h6 class="fw-bold">Professional Profile</h6>
                <small class="text-muted">Details about your company.</small>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card border-0 shadow-sm p-4">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Organization Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-12 text-end">
                        <button class="primary-btn w-auto px-5">Submit Registration</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="otpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="modal-body text-center">
                <h3 class="fw-bold">Mobile Verification</h3>
                <p class="text-muted" id="otp-subtitle">Enter your number to continue</p>
                
                <input type="tel" id="mobile_number" class="form-control mb-3 text-center fs-5" placeholder="10-Digit Mobile" maxlength="10">
                
                <div id="otp-area" style="display:none;">
                    <input type="text" id="otp_input" class="form-control mb-3 text-center fs-4 fw-bold" placeholder="6-Digit OTP" style="letter-spacing: 5px;">
                </div>

                <button type="button" id="btn-send-otp" class="primary-btn" onclick="handleSendOTP()">Send OTP</button>
                <button type="button" id="btn-verify-otp" class="primary-btn" style="display:none;" onclick="handleVerifyOTP()">Verify & Unlock Form</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let activeEventId = null;

    function prepareRegistration(id) {
        activeEventId = id;
    }

    function handleSendOTP() {
    const mobile = document.getElementById('mobile_number').value;
    if(mobile.length < 10) return alert("Enter a valid mobile number");

    // Show loading state
    const btn = document.getElementById('btn-send-otp');
    btn.innerText = "Sending...";
    btn.disabled = true;

    // AJAX Call
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
        if(data.status === 'success'){
            // Show OTP Field
            document.getElementById('otp-area').style.display = 'block';
            document.getElementById('btn-verify-otp').style.display = 'block';
            document.getElementById('btn-send-otp').style.display = 'none';
            document.getElementById('otp-subtitle').innerText = "Code sent to " + mobile;
            
            // Optional: Disable mobile field after sending
            document.getElementById('mobile_number').disabled = true;
        } else {
            alert(data.message);
            btn.innerText = "Send OTP";
            btn.disabled = false;
        }
    })
    .catch(err => {
        console.error(err);
        alert("Something went wrong. Please try again.");
        btn.innerText = "Send OTP";
        btn.disabled = false;
    });
}
    function handleVerifyOTP() {
    const otp = document.getElementById('otp_input').value;
    const mobile = document.getElementById('mobile_number').value;
    
    if(otp.length < 6) return alert("Enter a valid 6-digit OTP");

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
        if(data.status === 'success'){

            const contact = data.contact;
            const company = data.company;

            // Fill Personal Details
            document.getElementById('name_input').value = contact.name || "";
            document.getElementById('email_input').value = contact.emails && contact.emails.length > 0 ? contact.emails[0] : "";

            // Fill Professional Profile (Company Info)
            const companyNameInput = document.querySelector("#section-3 input.form-control");
            if(companyNameInput){
                companyNameInput.value = company ? company.company_name : "";
            }

            // Unlock next sections
            document.getElementById('section-2').classList.remove('locked');
            document.getElementById('section-3').classList.remove('locked');

            
            //set the data
            console.log(data);
            console.log("login Success");
            // Close Modal
            const modalEl = document.getElementById('otpModal');
            const modalBus = bootstrap.Modal.getInstance(modalEl);
            modalBus.hide();

            // Mark Step 1 Complete
            document.getElementById('badge-1').innerHTML = "✓";
            document.getElementById('badge-1').classList.replace('bg-primary', 'bg-success');

            // Unlock Step 2
            const step2 = document.getElementById('section-2');
            step2.classList.remove('locked');
            step2.classList.add('active-section');
            document.getElementById('badge-2').classList.replace('bg-secondary', 'bg-primary');

            // Scroll to next section
            step2.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            alert(data.message);
            btn.innerText = "Verify & Unlock Form";
            btn.disabled = false;
        }
    })
    .catch(err => {
        console.error(err);
        alert("Something went wrong. Please try again.");
        btn.innerText = "Verify & Unlock Form";
        btn.disabled = false;
    });
}
    function unlockSection3() {
        const name = document.getElementById('name_input').value;
        if(!name) return alert("Please enter your name");

        document.getElementById('badge-2').innerHTML = "✓";
        document.getElementById('badge-2').classList.replace('bg-primary', 'bg-success');

        const step3 = document.getElementById('section-3');
        step3.classList.remove('locked');
        step3.classList.add('active-section');
        document.getElementById('badge-3').classList.replace('bg-secondary', 'bg-primary');
        
        step3.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
</script>
</body>
</html>