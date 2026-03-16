<?= view('form/tradevisitor') ?>
<?php if (isset($error) && $error != ''): ?>
    <div id="error-message" 
         style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
                background-color: #ffe3e3; color: #d63031; padding: 20px 30px;
                border-radius: 12px; font-weight: 600; box-shadow: 0 6px 20px rgba(0,0,0,0.2);
                text-align: center; z-index: 9999; min-width: 250px;">
        
        <!-- Close Button -->
        <span style="position: absolute; top: 5px; right: 10px; cursor: pointer; font-weight: bold; font-size: 18px;"
              onclick="document.getElementById('error-message').style.display='none'">&times;</span>

        <?= $error ?>
    </div>
<?php endif; ?>
<?php 

$uri = service('uri');
$segment = ($uri->getTotalSegments() >= 3) ? $uri->getSegment(3) : 'General';
?>

<div class="container">
    <div class="row mb-3 text-center">
        <button type="button" class="btn btn-info mb-2" id="fillDummyBtn">Fill Dummy Data</button>
        <button type="button" class="btn btn-warning mb-2" id="registerBtntradetest">Test Register (Auto-Fill & Submit)</button>
    </div>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Mobile Trade Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --brand: #2563eb;
            --brand-light: #eff6ff;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --bg-gray: #f3f4f6;
            --border: #d1d5db;
        }

        * { box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-gray);
            margin: 0;
            padding: 20px 15px 100px 15px; /* Bottom padding for sticky button */
            color: var(--text-main);
            line-height: 1.5;
        }

        #mainRegistrationForm {
            max-width: 500px;
            margin: 0 auto;
        }

        /* Section Headers */
        .section-header {
            font-weight: 800;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin: 25px 0 12px 5px;
        }

        /* Layout Grid */
        .input-container { margin-bottom: 16px; }
        
        .input-row {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }
        .input-row > div { flex: 1; }

        /* Labels & Inputs */
        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #374151;
        }

        .mobile-input {
            width: 100%;
            height: 50px; /* Large touch target */
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 16px; /* Essential to prevent iOS zoom */
            background-color: #fff;
            transition: border-color 0.2s;
            -webkit-appearance: none; /* Reset iOS styles */
        }

        .mobile-input:focus {
            outline: none;
            border-color: var(--brand);
            ring: 2px var(--brand-light);
        }

        /* Interests Selection */
        .interests-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .interest-item {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid var(--border);
            cursor: pointer;
        }

        .interest-item input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            accent-color: var(--brand);
        }

        /* Camera Upload Card */
        .upload-card {
            background: #fff;
            border: 2px dashed var(--border);
            border-radius: 15px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .upload-card:active {
            transform: scale(0.98);
            background-color: var(--brand-light);
        }

        #preview-container img {
            max-width: 100%;
            border-radius: 8px;
            margin-top: 10px;
            display: none;
        }

        /* Sticky Footer Action */
        .sticky-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-top: 1px solid var(--border);
            z-index: 100;
        }

        .btn-primary-mobile {
            width: 100%;
            background: var(--brand);
            color: #fff;
            border: none;
            padding: 18px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-primary-mobile:active {
            background: #1d4ed8;
            transform: translateY(1px);
        }
    </style>
</head>
<body>

<form  action="<?= base_url('register/submit') ?>" method="POST" enctype="multipart/form-data">
    
    <div class="section-header">Identity</div>
    
    <div class="input-row">
        <div style="flex: 0 0 90px;">
            <label>Title</label>
            <select name="title" class="mobile-input">
                <option value="Mr.">Mr.</option>
                <option value="Ms.">Ms.</option>
                <option value="Mrs.">Mrs.</option>
            </select>
        </div>
        <div>
            <label>First Name *</label>
            <input type="text" name="select2" class="mobile-input" required placeholder="John">
        </div>
    </div>

    <div class="input-container">
        <label>Last Name *</label>
        <input type="text" name="lastname" class="mobile-input" required placeholder="Doe">
    </div>

    <div class="input-container">
        <label>Designation *</label>
        <input type="text" name="designation" class="mobile-input" required placeholder="e.g. Director">
    </div>

    <div class="section-header">Company Info</div>

    <div class="input-container">
        <label>Organization Name *</label>
        <input type="text" name="organisation" class="mobile-input" required placeholder="Acme Inc">
    </div>

    <div class="input-container">
        <label>Full Address</label>
        <input type="text" name="address" class="mobile-input" placeholder="Street, Area...">
    </div>

    <div class="input-row">
        <div>
            <label>City</label>
            <input type="text" name="city" class="mobile-input" value="New York">
        </div>
        <div>
            <label>Pincode</label>
            <input type="tel" name="pincode" class="mobile-input" placeholder="000000">
        </div>
<div>
            <label>State</label>
            <input type="text" name="state" class="mobile-input" value="New York">
        </div>
    </div>

    <div class="section-header">Contact Details</div>

    <div class="input-container">
        <label>Mobile Number *</label>
        <input type="tel" name="phone" class="mobile-input" required placeholder="9876543210">
    </div>

    <div class="input-container">
        <label>Email Address *</label>
        <input type="email" name="email" class="mobile-input" required placeholder="name@company.com">
    </div>

    <div class="section-header">Interest</div>
    <div class="interests-grid">
        <label class="interest-item" for="seg_FIT">
            <input type="checkbox" name="segments[]" value="FIT" id="seg_FIT"> FIT
        </label>
        <label class="interest-item" for="seg_MICE">
            <input type="checkbox" name="segments[]" value="MICE" id="seg_MICE"> MICE
        </label>
        <label class="interest-item" for="seg_GIT">
            <input type="checkbox" name="segments[]" value="GIT" id="seg_GIT"> GIT
        </label>
        <label class="interest-item" for="seg_Airlines">
            <input type="checkbox" name="segments[]" value="Airlines" id="seg_Airlines"> Airlines
        </label>
    </div>

    <div class="section-header">Verification</div>
    <div class="upload-card" onclick="document.getElementById('card-upload').click()">
        <i class="fa-solid fa-camera" style="font-size:32px; color:var(--brand); margin-bottom:12px;"></i>
        <div style="font-weight:800; font-size:15px;">Business Card</div>
        <div style="font-size:13px; color:var(--text-muted); margin-top:4px;">Snap a photo to verify</div>
        <div id="preview-container">
            <img id="card-preview" src="#" alt="Preview">
        </div>
        <input type="file" name="business_card" id="card-upload" hidden accept="image/*" capture="environment">
    </div>

    <input type="hidden" name="PrimaryCategory" value="TradeVisitor">

    <div class="sticky-footer">
<button type="button" class="btnRegister" id="registerBtn">Submit</button>            </div>
    </div>
</form>

<script>
    // Logic to show image preview after snapping photo
    const fileInput = document.getElementById('card-upload');
    const preview = document.getElementById('card-preview');

    fileInput.onchange = evt => {
        const [file] = fileInput.files;
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>


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

        console.log("Super");

        // Get values from visible UI
const organisationEl = document.querySelector('[name="organisation"]');
const firstNameEl = document.querySelector('[name="select2"]');
const lastNameEl = document.querySelector('[name="lastname"]');
const titleEl = document.querySelector('[name="title"]');
const addressEl = document.querySelector('[name="address"]');
const cityEl = document.querySelector('[name="city"]');
const stateEl = document.querySelector('[name="state"]');
const pincodeEl = document.querySelector('[name="pincode"]');
const phoneEl = document.querySelector('[name="phone"]');
const designationEl = document.querySelector('[name="designation"]');
const emailEl = document.querySelector('[name="email"]');
// const primaryEl = document.querySelector('input[name="PrimaryCategory"]:checked');
// const subEl = document.querySelector('input[name="SubCategory"]:checked');
// const customEl = document.getElementById('custom_input');

console.log("organisation:", organisationEl ? organisationEl.value : "MISSING");
console.log("firstName:", firstNameEl ? firstNameEl.value : "MISSING");
console.log("lastName:", lastNameEl ? lastNameEl.value : "MISSING");
console.log("title:", titleEl ? titleEl.value : "MISSING");
console.log("address:", addressEl ? addressEl.value : "MISSING");
console.log("city:", cityEl ? cityEl.value : "MISSING");
console.log("state:", stateEl ? stateEl.value : "MISSING");
console.log("pincode:", pincodeEl ? pincodeEl.value : "MISSING");
console.log("phone:", phoneEl ? phoneEl.value : "MISSING");
console.log("designation:", designationEl ? designationEl.value : "MISSING");
console.log("email:", emailEl ? emailEl.value : "MISSING");
// console.log("PrimaryCategory:", primaryEl ? primaryEl.value : "MISSING");
// console.log("SubCategory:", subEl ? subEl.value : "MISSING");
// console.log("custom_input:", customEl ? customEl.value : "MISSING");

// Compute full name



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

        // // Metadata
        // let selectedVal = "";
        // const primary = document.querySelector('input[name="PrimaryCategory"]:checked');
        // const sub = document.querySelector('input[name="SubCategory"]:checked');
        // const custom = document.getElementById('custom_input').value;

        // if (primary) {
        //     if (primary.value === "Other") {
        //         // Priority: Custom Text > Sub-Radio > "Other"
        //         selectedVal = custom ? custom : (sub ? sub.value : "Other");
        //     } else {
        //         selectedVal = primary.value;
        //     }
        // }

        // Paste into your hidden form
        hiddenForm.querySelector('[name="companies[0][category]"]').value = "tradeVisitor"; //selectedVal || "TradeVisitor";
        hiddenForm.querySelector('[name="companies[0][database_name]"]').value = "Online_Registration<?= $eventYear ?>_<?= $citySuffix ?>";
        // hiddenForm.querySelector('[name="companies[0][database_name]"]').value = "Online_Registration";
        hiddenForm.querySelector('[name="companies[0][entry_type]"]').value = "Online_Registration";

        // Setting the value to: "year-2026-cityname"
        hiddenForm.querySelector('[name="companies[0][source]"]').value = "<?= date('Y') ?>-<?= $segment ?>";  
        hiddenForm.querySelector('[name="companies[0][updated_by]"]').value = isTest ? "System-Test" : "Website";
        hiddenForm.querySelector('[name="companies[0][updated_at]"]').value = new Date().toISOString().slice(0,16);
        console.log("fullName:", fullName);

        console.log("Submitting...");
        // console.log(hiddenform);
        hiddenForm.submit();
    };

    // 4. Event Listeners
    fillDummyBtn.addEventListener('click', fillVisibleFields);
    registerBtnOfficial.addEventListener('click', () => syncAndSubmit(false));
    registerBtnTest.addEventListener('click', () => syncAndSubmit(true));
});
</script>