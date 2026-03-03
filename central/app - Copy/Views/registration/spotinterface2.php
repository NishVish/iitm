<?php
// --- SIMULATED CONTROLLER LOGIC ---
$badge_color = '#a42627'; 
$uri_segment = "Ahmedabad"; // Static for this example, usually from service('uri')
$mobile = "9876543210";
$reference_no = "IITM-" . strtoupper(substr(md5(time()), 0, 6));

// QR Code API URL
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($mobile);

// Mock Data for Badge
$visitor_name = "John Doe";
$company_name = "Acme Travel Solutions";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IITM | Registration & Badge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f4f4; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Layout Containers */
        .main-wrapper { padding: 50px 0; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; }
        
        /* Form Styling */
        .form-section { background: #fff; padding: 40px; }
        .btn-iitm { background: <?= $badge_color ?>; color: #fff; border: none; padding: 12px 25px; border-radius: 5px; font-weight: bold; width: 100%; }
        .btn-iitm:hover { background: #821e1f; color: #fff; }

        /* Badge Styling */
        .badge-preview-container { 
            width: 320px; 
            height: 480px; 
            background: #fff; 
            border: 1px solid #ddd; 
            border-radius: 10px; 
            margin: 0 auto; 
            position: relative; 
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .badge-header { background: <?= $badge_color ?>; color: #fff; padding: 20px; font-weight: bold; font-size: 1.2rem; }
        .badge-category { background: #333; color: #fff; display: inline-block; padding: 3px 15px; border-radius: 20px; font-size: 0.8rem; margin-top: 15px; }
        .badge-name { font-size: 1.6rem; font-weight: 800; margin-top: 15px; color: #000; padding: 0 10px; }
        .badge-org { color: #666; font-size: 1rem; margin-bottom: 20px; }
        .badge-footer { position: absolute; bottom: 0; width: 100%; padding: 10px; background: #f9f9f9; font-size: 0.7rem; border-top: 1px solid #eee; }

        @media print {
            body * { visibility: hidden; }
            .badge-preview-container, .badge-preview-container * { visibility: visible; }
            .badge-preview-container { position: absolute; left: 0; top: 0; box-shadow: none; border: none; }
        }
    </style>
</head>
<body>

<div class="container main-wrapper">
    <div class="row g-4">
        
        <div class="col-lg-7">
            <div class="card card-custom">
                <div class="form-section">
                    <h3 class="mb-4">Trade Visitor Registration</h3>
                    
                    <div class="mb-3">
                        <button class="btn btn-outline-secondary btn-sm" id="fillDummy">⚡ Fill Dummy Data</button>
                    </div>

                    <form id="mainRegForm">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Title</label>
                                <select class="form-select" name="title"><option>Mr.</option><option>Ms.</option></select>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="fname" placeholder="John">
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lname" placeholder="Doe">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" class="form-control" name="company" placeholder="Acme Corp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="john@example.com">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Mobile</label>
                            <input type="text" class="form-control" name="mobile" placeholder="9876543210">
                        </div>

                        <button type="button" class="btn-iitm" id="submitForm">Register & Update Badge</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5 text-center">
            <h4 class="mb-3">Your Entry Badge</h4>
            <div class="badge-preview-container" id="printableBadge">
                <div class="badge-header">IITM 2026<br><small><?= $uri_segment ?></small></div>
                <div class="badge-body">
                    <span class="badge-category">TRADE VISITOR</span>
                    <div class="badge-name" id="badgeName"><?= strtoupper($visitor_name) ?></div>
                    <div class="badge-org" id="badgeOrg"><?= $company_name ?></div>
                    
                    <div class="qr-zone my-3">
                        <img src="<?= $qr_url ?>" id="badgeQR" width="150" alt="QR Code">
                    </div>
                    
                    <div class="fw-bold">REF: <span id="badgeRef"><?= $reference_no ?></span></div>
                </div>
                <div class="badge-footer">
                    VALID FOR B2B SESSIONS ONLY. PLEASE CARRY ID PROOF.
                </div>
            </div>
            
            <button class="btn btn-dark mt-4 px-4" onclick="window.print()">Print Your Badge</button>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const fillBtn = document.getElementById('fillDummy');
    const submitBtn = document.getElementById('submitForm');
    
    // 1. Fill Dummy Data
    fillBtn.addEventListener('click', () => {
        const f = document.getElementById('mainRegForm');
        f.fname.value = "John";
        f.lname.value = "Doe";
        f.company.value = "Acme Travel Solutions";
        f.email.value = "john.doe@travel.com";
        f.mobile.value = "9988776655";
    });

    // 2. Update Badge Live (Simulation)
    submitBtn.addEventListener('click', () => {
        const f = document.getElementById('mainRegForm');
        
        // Validation check
        if(!f.fname.value || !f.company.value) {
            alert("Please fill the required fields!");
            return;
        }

        // Update Badge UI
        document.getElementById('badgeName').innerText = (f.fname.value + " " + f.lname.value).toUpperCase();
        document.getElementById('badgeOrg').innerText = f.company.value;
        
        // Update QR based on mobile
        const newQr = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" + encodeURIComponent(f.mobile.value);
        document.getElementById('badgeQR').src = newQr;

        alert("Registration Data Synced to Badge!");
    });
});
</script>

</body>
</html>