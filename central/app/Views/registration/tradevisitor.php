<?=view('form/tradevisitor') ?>

<?php 
$uri = service('uri');
$segment = ($uri->getTotalSegments() >= 3) ? $uri->getSegment(3) : 'General';
?>



    
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --brand: #4f46e5;
        --brand-soft: #f0f4ff;
        --success: #10b981;
        --bg: #f8fafc;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --card-radius: 24px;
    }

    body {
        background-color: var(--bg);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-main);
        line-height: 1.6;
        margin: 0;
    }

    /* Hero Section */
    .hero-banner {
        background: linear-gradient(135deg, #1e1b4b 0%, #4338ca 100%);
        color: white;
        padding: 60px 20px;
        text-align: center;
        border-radius: 0 0 40px 40px;
        margin-bottom: -60px;
    }

    .hero-banner h1 {
        font-size: clamp(24px, 5vw, 42px);
        font-weight: 800;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: -1px;
    }

    .hero-banner p {
        opacity: 0.8;
        font-size: 18px;
        margin-top: 10px;
    }

    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        position: relative;
    }

    /* Form Card */
    .reg-card {
        background: white;
        border-radius: var(--card-radius);
        padding: 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        border: 1px solid #e2e8f0;
    }

    /* Section Headers */
    .section-title {
        display: flex;
        align-items: center;
        gap: 15px;
        margin: 40px 0 25px 0;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--brand-soft);
    }

    .section-title .step-num {
        background: var(--brand);
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
    }

    .section-title h2 {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
    }

    /* Grid Layout for Inputs */
    .input-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group { margin-bottom: 20px; }
    .form-group.full { grid-column: span 2; }

    label {
        display: block;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 8px;
        color: var(--text-main);
    }

    input[type="text"], input[type="email"], select, textarea {
        width: 100%;
        padding: 14px 16px;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        font-family: inherit;
        font-size: 15px;
        transition: all 0.3s;
        box-sizing: border-box;
    }

    input:focus {
        outline: none;
        border-color: var(--brand);
        box-shadow: 0 0 0 4px var(--brand-soft);
    }

    /* Checkbox / Choice Buttons */
    .choice-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
    }

    .choice-item {
        position: relative;
    }

    .choice-item input {
        position: absolute;
        opacity: 0;
    }

    .choice-item label {
        background: white;
        border: 1.5px solid #e2e8f0;
        padding: 12px 16px;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 500;
        text-align: center;
        transition: 0.2s;
        margin: 0;
    }

    .choice-item input:checked + label {
        background: var(--brand-soft);
        border-color: var(--brand);
        color: var(--brand);
        font-weight: 700;
    }

    /* Upload Area */
    .upload-box {
        border: 2px dashed #cbd5e1;
        padding: 30px;
        border-radius: 20px;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
    }

    .upload-box:hover { border-color: var(--brand); background: var(--brand-soft); }

    /* Submit Button */
    .btn-submit {
        background: var(--brand);
        color: white;
        width: 100%;
        padding: 18px;
        border-radius: 16px;
        font-size: 18px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        margin-top: 40px;
        transition: 0.3s;
    }

    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3); }

    @media (max-width: 600px) {
        .input-grid { grid-template-columns: 1fr; }
        .form-group.full { grid-column: span 1; }
        .reg-card { padding: 25px; }
    }
</style>

<div class="hero-banner">
    <h1> <?= strtoupper($citySuffix) ?> <?= $eventYear ?></h1>
    <p>Trade Visitor Registration</p>
</div>

<div class="container">
    <div class="reg-card">
        <form action="<?= base_url('register/submit') ?>" method="POST" enctype="multipart/form-data">
            
            <div class="section-title">
                <div class="step-num">1</div>
                <h2>Personal & Professional Details</h2>
            </div>

            <div class="input-grid">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" required placeholder="John Doe">
                </div>
                <div class="form-group">
                    <label>Designation *</label>
                    <input type="text" name="designation" required placeholder="CEO / Manager">
                </div>
                <div class="form-group full">
                    <label>Company Name *</label>
                    <input type="text" name="company_name" required placeholder="Organization Pvt Ltd">
                </div>
                <div class="form-group">
                    <label>City *</label>
                    <input type="text" name="city" value="<?= ucfirst($location) ?>" required>
                </div>
                <div class="form-group">
                    <label>Pincode *</label>
                    <input type="text" name="pincode" required>
                </div>
            </div>

            <div class="section-title">
                <div class="step-num">2</div>
                <h2>Contact Information</h2>
            </div>
            <div class="input-grid">
                <div class="form-group">
                    <label>Mobile Number *</label>
                    <div style="display:flex; gap:10px;">
                        <select name="country_code" style="width:100px;">
                            <option value="+91">IN (+91)</option>
                        </select>
                        <input type="text" name="mobile" required placeholder="9876543210">
                    </div>
                </div>
                <div class="form-group">
                    <label>Email ID *</label>
                    <input type="email" name="email" required placeholder="john@company.com">
                </div>
            </div>

            <div class="section-title">
                <div class="step-num">3</div>
                <h2>Business Interests</h2>
            </div>
            <label>Travel Segments you belong to *</label>
            <div class="choice-grid">
                <?php 
                $segments = ['FIT', 'MICE', 'GIT', 'Ticketing', 'Airlines', 'Cruises', 'Wellness'];
                foreach($segments as $s): ?>
                <div class="choice-item">
                    <input type="checkbox" name="segments[]" value="<?= $s ?>" id="seg_<?= $s ?>">
                    <label for="seg_<?= $s ?>"><?= $s ?></label>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="section-title">
                <div class="step-num">4</div>
                <h2>Verification</h2>
            </div>
            <label>Business Card (Max 2MB) *</label>
            <div class="upload-box" onclick="document.getElementById('card-upload').click()">
                <i class="fa-solid fa-cloud-arrow-up" style="font-size:30px; color:var(--brand); margin-bottom:10px;"></i>
                <p style="margin:0; font-weight:600;">Drag & Drop or Click to Upload</p>
                <p style="font-size:12px; color:var(--text-muted);">PNG, JPG allowed</p>
                <input type="file" name="business_card" id="card-upload" hidden accept="image/*">
            </div>

            <button type="submit" class="btn-submit">Generate Trade Badge</button>
            
            <p style="text-align:center; font-size:12px; color:var(--text-muted); margin-top:20px;">
                By registering, you agree to our Terms & Conditions and Privacy Policy.
            </p>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Elements
    const hiddenForm = document.getElementById('companyFormTv');
    const fillDummyBtn = document.getElementById('fillDummyBtn');
    const registerBtnOfficial = document.getElementById('registerBtn');
    const registerBtnTest = document.getElementById('registerBtntradetest');

    // 2. Function to populate visible UI fields
    const fillVisibleFields = () => {
        document.querySelector('[name="title"]').value = 'Mr.';
        document.querySelector('[name="select2"]').value = 'John';
        document.querySelector('[name="lastname"]').value = 'Doe';
        document.querySelector('[name="designation"]').value = 'Manager';
        document.querySelector('[name="organisation"]').value = 'Acme Corp';
        document.querySelector('[name="email"]').value = 'john.doe@example.com';
        document.querySelector('[name="phone"]').value = '9876543210';
        document.querySelector('[name="address"]').value = '123 Main Street';
        document.querySelector('[name="city"]').value = 'Ahmedabad';
        document.querySelector('[name="state"]').value = 'Gujarat';
        document.querySelector('[name="pincode"]').value = '380001';
        document.querySelector('[name="country"]').value = 'India';
        document.querySelector('[name="website"]').value = 'https://example.com';
        document.querySelector('[name="Message"]').value = 'Trade Visitor Test';
        document.querySelector('[name="Category"]').value = 'None';
    };

    // 3. Function to sync visible UI to Hidden Form and Submit
    const syncAndSubmit = (isTest = false) => {
        if(!hiddenForm) return alert("Hidden Form Not Found!");

        // If it's a test, fill UI first
        if(isTest) fillVisibleFields();

        // Get values from visible UI
        const organisation = document.querySelector('[name="organisation"]').value;
        const firstName = document.querySelector('[name="select2"]').value;
        const lastName = document.querySelector('[name="lastname"]').value;
        const fullName = (document.querySelector('[name="title"]').value + " " + firstName + " " + lastName).trim();

        // Map to Hidden Form (the companies[0] structure)
        hiddenForm.querySelector('[name="companies[0][company_name]"]').value = organisation;
        hiddenForm.querySelector('[name="companies[0][address_1]"]').value = document.querySelector('[name="address"]').value;
        hiddenForm.querySelector('[name="companies[0][city]"]').value = document.querySelector('[name="city"]').value;
        hiddenForm.querySelector('[name="companies[0][state]"]').value = document.querySelector('[name="state"]').value;
        hiddenForm.querySelector('[name="companies[0][pincode]"]').value = document.querySelector('[name="pincode"]').value;
        hiddenForm.querySelector('[name="companies[0][phone]"]').value = document.querySelector('[name="phone"]').value;
        
        hiddenForm.querySelector('[name="companies[0][contact1_name]"]').value = fullName;
        hiddenForm.querySelector('[name="companies[0][contact1_designation]"]').value = document.querySelector('[name="designation"]').value;
        hiddenForm.querySelector('[name="companies[0][contact1_email1]"]').value = document.querySelector('[name="email"]').value;
        hiddenForm.querySelector('[name="companies[0][contact1_mobile1]"]').value = document.querySelector('[name="phone"]').value;

        // Metadata
        let selectedVal = "";
        const primary = document.querySelector('input[name="PrimaryCategory"]:checked');
        const sub = document.querySelector('input[name="SubCategory"]:checked');
        const custom = document.getElementById('custom_input').value;

        if (primary) {
            if (primary.value === "Other") {
                // Priority: Custom Text > Sub-Radio > "Other"
                selectedVal = custom ? custom : (sub ? sub.value : "Other");
            } else {
                selectedVal = primary.value;
            }
        }

        // Paste into your hidden form
        hiddenForm.querySelector('[name="companies[0][category]"]').value = selectedVal || "TradeVisitor";
hiddenForm.querySelector('[name="companies[0][database_name]"]').value = "Online_Registration<?= $eventYear ?>_<?= $citySuffix ?>";
        // hiddenForm.querySelector('[name="companies[0][database_name]"]').value = "Online_Registration";
        hiddenForm.querySelector('[name="companies[0][entry_type]"]').value = "Online_Registration";

        // Setting the value to: "year-2026-cityname"
        hiddenForm.querySelector('[name="companies[0][source]"]').value = "<?= date('Y') ?>-<?= $segment ?>";  
        hiddenForm.querySelector('[name="companies[0][updated_by]"]').value = isTest ? "System-Test" : "Website";
        hiddenForm.querySelector('[name="companies[0][updated_at]"]').value = new Date().toISOString().slice(0,16);

        console.log("Submitting...");
        hiddenForm.submit();
    };

    // 4. Event Listeners
    fillDummyBtn.addEventListener('click', fillVisibleFields);
    registerBtnOfficial.addEventListener('click', () => syncAndSubmit(false));
    registerBtnTest.addEventListener('click', () => syncAndSubmit(true));
});
</script>