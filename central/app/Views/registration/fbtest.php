<?= view('form/exhibitor') ?>

<script>

    document.getElementById('companyFormFb').style.display = 'block';

</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const registerBtn = document.getElementById("registerBtn");
    const companyForm = document.getElementById("companyForm");

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

companyForm.querySelector('[name="companies[0][fascia]"]').value = "Standard Fascia";
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
<!-- <script>
document.addEventListener("DOMContentLoaded", function () {

    const registerBtn = document.getElementById("registerBtn");
    const companyForm = document.getElementById("companyForm");

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

        // Contact details
        companyForm.querySelector('[name="companies[0][contact1_name]"]').value =
            (title + " " + firstName + " " + lastName).trim();

        companyForm.querySelector('[name="companies[0][contact1_designation]"]').value = designation;
        companyForm.querySelector('[name="companies[0][contact1_email1]"]').value = email;
        companyForm.querySelector('[name="companies[0][contact1_mobile1]"]').value = phone;

        // 🔹 Fixed values (Always Same)
        companyForm.querySelector('[name="companies[0][category]"]').value = "Tradevisitor";
        companyForm.querySelector('[name="companies[0][source]"]').value = "Website";
        companyForm.querySelector('[name="companies[0][database_name]"]').value = "IITM 2026";
        companyForm.querySelector('[name="companies[0][updated_by]"]').value = "Website";
        companyForm.querySelector('[name="companies[0][updated_at]"]').value =
            new Date().toISOString().slice(0,16);

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    
    <!-- Meta Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');

  // ✅ Initialize all pixels
  fbq('init', '1528244355229931'); // Pixel 1
  fbq('init', '2163682937395443'); // Pixel 2
  fbq('init', '9300627153319564'); // Pixel 3
  fbq('init', '1109477967336886'); // Pixel 4

  // ✅ Track PageView on all pixels
  fbq('track', 'PageView');

  // ✅ Optional: ViewContent event (use only on product pages)
  fbq('track', 'ViewContent', {
    content_ids: ['123'], // Change dynamically per product ID
    content_type: 'product',
    value: 2499, // Product price (optional)
    currency: 'INR'
  });
</script>

<noscript>
  <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1528244355229931&ev=PageView&noscript=1"/>
  <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=2163682937395443&ev=PageView&noscript=1"/>
  <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=9300627153319564&ev=PageView&noscript=1"/>
  <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1109477967336886&ev=PageView&noscript=1"/>
</noscript>
<!-- End Meta Pixel Code -->
    
    
    
    
    
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


