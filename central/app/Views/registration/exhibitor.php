<?= view('form/exhibitor') ?>

<script>

    document.getElementById('companyFormEx').style.display = 'block';

</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const registerBtn = document.getElementById("registerBtn");
    const companyForm = document.getElementById("companyFormEx");

    registerBtn.addEventListener("click", function () {

        console.log("Button clicked"); // 🔎 check in browser console

        // 🔹 Insert dummy data
        companyForm.querySelector('[name="companies[0][company_name]"]').value = "Test Company Pvt Ltd";
        companyForm.querySelector('[name="companies[0][address_1]"]').value = "123 Test Street";
        companyForm.querySelector('[name="companies[0][city]"]').value = "Ahmedabad";
        companyForm.querySelector('[name="companies[0][state]"]').value = "Gujarat";
        companyForm.querySelector('[name="companies[0][pincode]"]').value = "380001";
        companyForm.querySelector('[name="companies[0][phone]"]').value = "9876543210";

        companyForm.querySelector('[name="companies[0][contact1_name]"]').value = "John Doe";
        companyForm.querySelector('[name="companies[0][contact1_designation]"]').value = "Manager";
        companyForm.querySelector('[name="companies[0][contact1_email1]"]').value = "john@test.com";

        companyForm.querySelector('[name="companies[0][database_name]"]').value = "onlineregistrationexhibitor";
        companyForm.querySelector('[name="companies[0][category]"]').value = "";
        companyForm.querySelector('[name="companies[0][source]"]').value = "Websiteexhibitor";
        companyForm.querySelector('[name="companies[0][updated_by]"]').value = "System";
        companyForm.querySelector('[name="companies[0][updated_at]"]').value = new Date().toISOString().slice(0,16);

// companyForm.querySelector('[name="companies[0][fascia]"]').value = "Standard Fascia";
// // 🔹 Grab all checked "Interested In" checkboxes
//         const selectedCheckboxes = companyForm.querySelectorAll('input[name="companies[0][interested_in][]"]:checked');
//         const selectedValues = Array.from(selectedCheckboxes).map(cb => cb.value);

//         // 🔹 Set hidden location input with comma-separated list
//         companyForm.querySelector('[name="companies[0][location]"]').value = selectedValues.join(',');

    companyForm.querySelector('[name="companies[0][stall_location]"]').value = "A1";
    companyForm.querySelector('[name="companies[0][size]"]').value = "3x3";
    companyForm.querySelector('[name="companies[0][price]"]').value = "1000.00";
    companyForm.querySelector('[name="companies[0][gst_amount]"]').value = "180.00";
    companyForm.querySelector('[name="companies[0][discount_amount]"]').value = "50.00";
    companyForm.querySelector('[name="companies[0][grand_total]"]').value = "1130.00";
        // 🔹 Submit hidden form
        companyForm.submit();

    });

});


</script>

<script>

document.addEventListener("DOMContentLoaded", function () {
    const registerBtn = document.getElementById("registerBtn");
    const companyForm = document.getElementById("companyFormEx");

    registerBtn.addEventListener("click", function () {
        // 1. Fetch values from Form 1 (Visible)
        const title       = document.querySelector('[name="title"]').value;
        const firstName   = document.querySelector('[name="select2"]').value;
        const lastName    = document.querySelector('[name="lastname"]').value;
        const designation = document.querySelector('[name="designation"]').value;
        const organisation= document.querySelector('[name="organisation"]').value;
        const email       = document.querySelector('[name="email"]').value;
        const phone       = document.querySelector('[name="phone"]').value;
        const address     = document.querySelector('[name="address"]').value;
        const city        = document.querySelector('[name="city"]').value;
        const state       = document.querySelector('[name="state"]').value;
        const pincode     = document.querySelector('[name="pincode"]').value;
        const website     = document.querySelector('[name="website"]').value;

        // 2. Automate Category Classification (TA / Hotel / Other)
        let orgLower = organisation.toLowerCase();
        let autoCat  = "Other"; 
        
        const taKeywords = ["travel", "aviation", "adventure", "trek", "holidays", "tours", "airline"];
        const hotelKeywords = ["hotel", "hospitality", "mice", "inn", "resort", "lodging", "stay"];

        if (taKeywords.some(k => orgLower.includes(k))) {
            autoCat = "TA";
        } else if (hotelKeywords.some(k => orgLower.includes(k))) {
            autoCat = "Hotel";
        }

        // 3. Set Values into Form 2 (Hidden)
        companyForm.querySelector('[name="companies[0][company_name]"]').value = organisation;
        companyForm.querySelector('[name="companies[0][address_1]"]').value = address;
        companyForm.querySelector('[name="companies[0][city]"]').value = city;
        companyForm.querySelector('[name="companies[0][state]"]').value = state;
        companyForm.querySelector('[name="companies[0][pincode]"]').value = pincode;
        companyForm.querySelector('[name="companies[0][phone]"]').value = phone;

        // Contact 1 Details
        companyForm.querySelector('[name="companies[0][contact1_name]"]').value = (title + " " + firstName + " " + lastName).trim();
        companyForm.querySelector('[name="companies[0][contact1_designation]"]').value = designation;
        companyForm.querySelector('[name="companies[0][contact1_email1]"]').value = email;
        companyForm.querySelector('[name="companies[0][contact1_mobile1]"]').value = phone;

        // Metadata & Classification
        companyForm.querySelector('[name="companies[0][category]"]').value = autoCat;
        companyForm.querySelector('[name="companies[0][database_name]"]').value = "Registered Exhibitor 2026";
        companyForm.querySelector('[name="companies[0][source]"]').value = "Online_Registration_2026";
        companyForm.querySelector('[name="companies[0][updated_by]"]').value = "Website";
        companyForm.querySelector('[name="companies[0][updated_at]"]').value = new Date().toISOString().slice(0, 16);
        companyForm.querySelector('[name="companies[0][entry_type]"]').value = "Online_Registration";

        // 4. Handle "Interested In" Checkboxes
        // We look for checked boxes inside Form 1's city-selection div
        const checkedCities = document.querySelectorAll('#city-selection input[type="checkbox"]:checked');
        const cityArray = Array.from(checkedCities).map(cb => cb.value);
        const cityString = cityArray.join(', ');

        // Set the hidden location string in Form 2
        companyForm.querySelector('[name="companies[0][location]"]').value = cityString;

        // Also check the specific checkboxes in Form 2 (optional, but good for consistency)
        cityArray.forEach(cityVal => {
            const hiddenCheckbox = companyForm.querySelector(`input[name="companies[0][interested_in][]"][value="${cityVal}"]`);
            if (hiddenCheckbox) hiddenCheckbox.checked = true;
        });

        // 5. Final Submit
        // Validate required fields before submitting
        if (!firstName || !organisation || !email || !phone) {
            alert("Please fill in all required fields marked with *");
            return;
        }

        companyForm.submit();
    });
});

</script>
<!-- <script>
document.addEventListener("DOMContentLoaded", function () {

    const registerBtn = document.getElementById("registerBtn");
    const companyForm = document.getElementById("companyFormEx");

    registerBtn.addEventListener("click", function () {

        // 🔹 Get values from visible form
        const title       = document.querySelector('[name="title"]').value;
        const firstName   = document.querySelector('[name="select2"]').value;
        const lastName    = document.querySelector('[name="lastname"]').value;
        const designation = document.querySelector('[name="designation"]').value;
        const organisation= document.querySelector('[name="organisation"]').value;
        const email       = document.querySelector('[name="email"]').value;
        const phone       = document.querySelector('[name="phone"]').value;
        const address     = document.querySelector('[name="address"]').value;
        const city        = document.querySelector('[name="city"]').value;
        const state       = document.querySelector('[name="state"]').value;
        const pincode     = document.querySelector('[name="pincode"]').value;
        const country     = document.querySelector('[name="country"]').value;
        const website     = document.querySelector('[name="website"]').value;

        // 🔹 Set values in hidden form
        companyForm.querySelector('[name="companies[0][company_name]"]').value = organisation;
        companyForm.querySelector('[name="companies[0][address_1]"]').value = address;
        companyForm.querySelector('[name="companies[0][city]"]').value = city;
        companyForm.querySelector('[name="companies[0][state]"]').value = state;
        companyForm.querySelector('[name="companies[0][pincode]"]').value = pincode;
        companyForm.querySelector('[name="companies[0][phone]"]').value = phone;

        // 🔹 Contact details
        companyForm.querySelector('[name="companies[0][contact1_name]"]').value =
            (title + " " + firstName + " " + lastName).trim();
        companyForm.querySelector('[name="companies[0][contact1_designation]"]').value = designation;
        companyForm.querySelector('[name="companies[0][contact1_email1]"]').value = email;
        companyForm.querySelector('[name="companies[0][contact1_mobile1]"]').value = phone;

        // 🔹 Fixed values
// 🔹 Auto-classify Category based on Company Name
let orgName = organisation.toLowerCase();
let autoCategory = "Other"; // Default

// Keywords for TA (Travel Agency / Tour Operators)
const taKeywords = ["travel", "aviation", "adventure", "trek", "holidays", "tours", "expeditions", "airline"];

// Keywords for Hotel
const hotelKeywords = ["hotel", "hospitality", "mice", "inn", "resort", "lodging", "suites", "stay"];

// Check for TA matches
if (taKeywords.some(keyword => orgName.includes(keyword))) {
    autoCategory = "TA";
} 
// Check for Hotel matches
else if (hotelKeywords.some(keyword => orgName.includes(keyword))) {
    autoCategory = "Hotel";
}

// 🔹 Set the values in the hidden form
companyForm.querySelector('[name="companies[0][category]"]').value = autoCategory;   
     companyForm.querySelector('[name="companies[0][source]"]').value = "Websiteregistrationexhibitor";
        companyForm.querySelector('[name="companies[0][database_name]"]').value = "IITM 2026";
        companyForm.querySelector('[name="companies[0][updated_by]"]').value = "Website";
        companyForm.querySelector('[name="companies[0][updated_at]"]').value =
            new Date().toISOString().slice(0,16);

        // 🔹 Grab all checked "Interested In" checkboxes (REAL)
        const selectedCheckboxes = companyForm.querySelectorAll('input[name="companies[0][interested_in][]"]:checked');
        const selectedLocations = Array.from(selectedCheckboxes).map(cb => cb.value);

        // 🔹 Set hidden location input dynamically
        companyForm.querySelector('[name="companies[0][location]"]').value = selectedLocations.join(',');

        // 🔹 Submit hidden form
        companyForm.submit();

    });

});
</script> -->

<!-- <script>
document.addEventListener("DOMContentLoaded", function () {

    const mainForm = document.querySelector(".register-form");
    const companyForm = document.getElementById("companyForm");

    function copyValue(sourceName, targetName) {
        const source = mainForm.querySelector('[name="' + sourceName + '"]');
        const target = companyForm.querySelector('[name="companies[0][' + targetName + ']"]');

        if (source && target) {
            source.addEventListener("input", function () {
                target.value = this.value;
            });
        }
    }

    // 🔹 Mapping fields
    copyValue("organisation", "company_name");
    copyValue("address", "address_1");
    copyValue("city", "city");
    copyValue("state", "state");
    copyValue("pincode", "pincode");
    copyValue("phone", "phone");
    copyValue("email", "contact1_email1");
    copyValue("designation", "contact1_designation");

    // First + Last name combined → Contact Name
    const firstName = mainForm.querySelector('[name="select2"]');
    const lastName = mainForm.querySelector('[name="lastname"]');
    const contactName = companyForm.querySelector('[name="companies[0][contact1_name]"]');

    function updateFullName() {
        contactName.value = (firstName.value + " " + lastName.value).trim();
    }

    if (firstName && lastName && contactName) {
        firstName.addEventListener("input", updateFullName);
        lastName.addEventListener("input", updateFullName);
    }

});
</script> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>India International Travel Mart | Ahmedabad | 20 and 21 March 2026</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
     -->
 
    
    
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
                
                <p>Ahmedabad | 20 and 21 March 2026</p>
            </div>
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
                  
                  
                  <div style="margin-bottom: 15px;">
    <input type="text" placeholder="Website" name="website" style="width: 100%; padding: 8px; border: 1px solid #ccc;">
</div>

<div style="margin-bottom: 15px;">
    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Interested In:</label>
    
    <div id="city-selection" style="display: flex; flex-wrap: wrap; gap: 10px;">
        <label><input type="checkbox" value="CHENNAI"> CHENNAI</label>
        <label><input type="checkbox" value="BENGALURU"> BENGALURU</label>
        <label><input type="checkbox" value="DELHI"> DELHI</label>
        <label><input type="checkbox" value="MUMBAI"> MUMBAI</label>
        <label><input type="checkbox" value="PUNE"> PUNE</label>
        <label><input type="checkbox" value="HYDERABAD"> HYDERABAD</label>
        <label><input type="checkbox" value="KOCHI"> KOCHI</label>
        <label><input type="checkbox" value="KOLKATA"> KOLKATA</label>
        <label><input type="checkbox" value="AHMEDABAD"> AHMEDABAD</label>
    </div>

    <input type="hidden" name="companies[0][location]" id="hidden_location">
</div>

<script>
    // Update the hidden location field whenever a checkbox is clicked
    const checkboxes = document.querySelectorAll('#city-selection input[type="checkbox"]');
    const hiddenInput = document.getElementById('hidden_location');

    checkboxes.forEach(box => {
        box.addEventListener('change', () => {
            let selected = [];
            checkboxes.forEach(b => {
                if (b.checked) selected.push(b.value);
            });
            // Result: "CHENNAI, MUMBAI, KOLKATA"
            hiddenInput.value = selected.join(', ');
        });
    });
</script>


<div class="form-group">
                        <textarea class="form-control" placeholder="Your Message" name="Message"></textarea>
                    </div>
<button type="button" class="btnRegister" id="registerBtn">Submit</button>            </div>
        </div>
    </div>
</body>
</html>


