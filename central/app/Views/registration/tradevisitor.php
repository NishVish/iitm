<?=view('form/tradevisitor') ?>

<?php 
$uri = service('uri');
$segment = ($uri->getTotalSegments() >= 3) ? $uri->getSegment(3) : 'General';
?>


    <div class="row mb-3">
        <div class="col-12 text-center">
            <button type="button" class="btn btn-info" id="fillDummyBtn">Fill Dummy Data</button>
            <button type="button" id="registerBtntradetest" class="btn btn-warning">Test Register (Auto-Fill & Submit)</button>
        </div>
    </div>

    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>India International Travel Mart | Ahmedabad | 20 and 21 March 2026</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> -->
    
    <!-- Meta Pixel Code -->

    
    
    <style>
        body {
            background: #f8f9fa;
        }
        .register-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding:10px;
            padding-top: 100px;
        }
        
      
        
        .register-left {
            text-align: center;
            padding: 00px;
         
        }
        
        @media (min-width: 992px) {
    .register-left {
        padding-top: 200px;
    }
}
        .register-left img {
            width: 80%;
            max-width: 250px;
      animation: float 2s infinite ease-in-out;
        }
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }
        .register-form {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btnRegister {
            width: 100%;
            padding: 10px;
            background: #a5251f;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btnRegister:hover {
            background: #8b1e18;
        }
    </style>
</head>
<body>


    <div class="container register-container">
        <div class="row w-100">
            <div class="col-lg-4 col-md-12 register-left">
                <img src="https://iitmindia.com/reg/iitm_chennai/logo.png" alt="IITM Logo">
                <h3 style="color: #a52020;"><strong>India International Travel Mart</strong></h3>
                
                <p><strong>B2B Travel Exhibition</strong></p>
                
<div class="events-list">
    <?php if (!empty($events)): ?>
        <?php foreach ($events as $event): ?>
            <p>
                <strong><?= esc($event['name']) ?></strong> | 
                <?php 
                    // Format dates (assuming YYYY-MM-DD in database)
                    $start = date('j', strtotime($event['start_date']));
                    $end = date('j F Y', strtotime($event['end_date']));
                    echo "$start and $end";
                ?>
            </p>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No events scheduled for <?= esc(ucfirst($location ?? 'this location')) ?>.</p>
    <?php endif; ?>
</div>            </div>
            <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <select class="form-control" name="title" required>
                            <option value="Mr.">Mr</option>
                            <option value="Mrs.">Mrs</option>
                            <option value="Ms.">Ms</option>
                            <option value="Dr.">Dr</option>
                        </select>
                    </div>
                    <!--<div class="form-group">
                        <input type="text" class="form-control" placeholder="First Name *" name="select2" required>
                    </div>-->
                    
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="First Name *" name="select2" value="" required/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Last Name" name="lastname">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Designation *" name="designation" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Company Name *" name="organisation" required>
                    </div>
   <div class="form-group">
    <label class="fw-bold mb-2">Category</label>
    
    <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="PrimaryCategory" value="Travel Agency" id="cat1">
        <label class="form-check-label" for="cat1">Travel Agency / Agent & Transportation</label>
    </div>

    <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="PrimaryCategory" value="Hoteliers" id="cat2">
        <label class="form-check-label" for="cat2">Hospitaltiy</label>
    </div>

    <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="PrimaryCategory" value="Other" id="other_trigger">
        <label class="form-check-label" for="other_trigger">Other</label>
    </div>

    <div id="other_list" style="display: none; margin-left: 25px; border-left: 2px solid #dee2e6; padding-left: 15px;">
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="SubCategory" value="Technology" id="tech">
            <label class="form-check-label" for="tech">Travel or Hotel Technology</label>
        </div>
        
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="SubCategory" value="Insurance" id="insur">
            <label class="form-check-label" for="insur">Travel or Hotel Insurance</label>
        </div>

        <div class="mt-2">
            <input type="text" class="form-control form-control-sm" name="CustomIndustry" id="custom_input" placeholder="Write your industry name">
        </div>
    </div>
</div>

<script>
    // Listen to all radio buttons in the primary group
    document.querySelectorAll('input[name="PrimaryCategory"]').forEach((radio) => {
        radio.addEventListener('change', function() {
            const otherList = document.getElementById('other_list');
            // Show only if 'Other' is selected, hide otherwise
            if (document.getElementById('other_trigger').checked) {
                otherList.style.display = 'block';
            } else {
                otherList.style.display = 'none';
                // Clear sub-selections if user switches back to Travel/Hotel
                document.querySelectorAll('input[name="SubCategory"]').forEach(r => r.checked = false);
                document.getElementById('custom_input').value = "";
            }
        });
    });
</script>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Your Email *" name="email" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Phone *" name="phone" required minlength="10" maxlength="10">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Address" name="address"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="City" name="city">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="State" name="state">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Pincode" name="pincode">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Country" name="country">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Website" name="website">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Your Message" name="Message"></textarea>
                    </div>
<button type="button" class="btnRegister" id="registerBtn">Submit</button>            </div>
        </div>
    </div>
</body>
</html>

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