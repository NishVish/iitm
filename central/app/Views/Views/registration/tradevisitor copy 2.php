<?=view('form/tradevisitor') ?>

    
<?php 
$uri = service('uri');

// Check if segment 3 even exists before trying to use it
if ($uri->getTotalSegments() >= 3) {
    $segment = $uri->getSegment(3);
    // ... do your logic ...
} else {
    $segment = null; // or handle the error gracefully
}

?>

    
<button type="button" class="btnRegister" id="fillDummyBtn">Fill Dummy Data</button>

 <button type="button" id="registerBtntradetest" class="btn btn-success">
            Register as Trade Visitor
        </button>
<script>

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('companyFormTv');
    const fillBtn = document.getElementById('fillDummyBtn');

    if (form && fillBtn) {
        fillBtn.style.display = 'block';
        form.style.display = 'block';

        fillBtn.addEventListener('click', function() {
            form.querySelector('select[name="title"]').value = 'Mr.';
            form.querySelector('input[name="select2"]').value = 'John';
            form.querySelector('input[name="lastname"]').value = 'Doe';
            form.querySelector('input[name="designation"]').value = 'Software Engineer';
            form.querySelector('input[name="organisation"]').value = 'Acme Corp';
            form.querySelector('input[name="email"]').value = 'john.doe@example.com';
            form.querySelector('input[name="phone"]').value = '1234567890';
            form.querySelector('textarea[name="address"]').value = '123 Main Street';
            form.querySelector('input[name="city"]').value = 'Metropolis';
            form.querySelector('input[name="state"]').value = 'NY';
            form.querySelector('input[name="pincode"]').value = '10001';
            form.querySelector('input[name="country"]').value = 'USA';
            form.querySelector('input[name="website"]').value = 'https://example.com';
            form.querySelector('textarea[name="Message"]').value = 'This is a dummy message.';
        });
    }

    const registerBtntradetest = document.getElementById("registerBtntradetest");
    if (form && registerBtntradetest) {
        registerBtntradetest.addEventListener("click", function () {
            console.log("Button clicked");

            form.querySelector('[name="companies[0][company_name]"]').value = "Test Company Pvt Ltd";
            form.querySelector('[name="companies[0][address_1]"]').value = "123 Test Street";
            form.querySelector('[name="companies[0][city]"]').value = "Ahmedabad";
            form.querySelector('[name="companies[0][state]"]').value = "Gujarat";
            form.querySelector('[name="companies[0][pincode]"]').value = "380001";
            form.querySelector('[name="companies[0][phone]"]').value = "9876543210";
            form.querySelector('[name="companies[0][contact1_name]"]').value = "John Doe";
            form.querySelector('[name="companies[0][contact1_designation]"]').value = "Manager";
            form.querySelector('[name="companies[0][contact1_email1]"]').value = "john@test.com";
            form.querySelector('[name="companies[0][contact1_mobile1]"]').value = 7909075195;
            form.querySelector('[name="companies[0][database_name]"]').value = "onlineregistrationtradevisitor";
            form.querySelector('[name="companies[0][category]"]').value = "TradeVisitor";
// Correct Way
form.querySelector('[name="companies[0][source]"]').value = "onlinetradevisitor-<?php echo $segment; ?>";

form.querySelector('[name="companies[0][updated_by]"]').value = "System";
            form.querySelector('[name="companies[0][updated_at]"]').value = new Date().toISOString().slice(0,16);

            form.submit();
        });
    }
});




    document.getElementById('companyFormTv').style.display = 'Block';
    document.getElementById('fillDummyBtn').style.display = 'Block';

// Set Values to the Main Form
document.getElementById('fillDummyBtn').addEventListener('click', function() {
    const form = document.getElementById('companyFormTv'); // target by ID
    form.querySelector('select[name="title"]').value = 'Mr.';
    form.querySelector('input[name="select2"]').value = 'John';
    form.querySelector('input[name="lastname"]').value = 'Doe';
    form.querySelector('input[name="designation"]').value = 'Software Engineer';
    form.querySelector('input[name="organisation"]').value = 'Acme Corp';
    form.querySelector('input[name="email"]').value = 'john.doe@example.com';
    form.querySelector('input[name="phone"]').value = '1234567890';
    form.querySelector('textarea[name="address"]').value = '123 Main Street';
    form.querySelector('input[name="city"]').value = 'Metropolis';
    form.querySelector('input[name="state"]').value = 'NY';
    form.querySelector('input[name="pincode"]').value = '10001';
    form.querySelector('input[name="country"]').value = 'USA';
    form.querySelector('input[name="website"]').value = 'https://example.com';
    form.querySelector('textarea[name="Message"]').value = 'This is a dummy message.';
});

    



    // Set Values to the form but dont Submit


// // Submit Dummy Data form
//     const registerBtntradetest = document.getElementById("registerBtntradetest");
//     const companyFormTv = document.getElementById("companyFormTv");

//     registerBtntradetest.addEventListener("click", function () {

//         console.log("Button clicked"); // 🔎 check in browser console

//         // 🔹 Insert dummy data
//         companyFormTv.querySelector('[name="companies[0][company_name]"]').value = "Test Company Pvt Ltd";
//         companyFormTv.querySelector('[name="companies[0][address_1]"]').value = "123 Test Street";
//         companyFormTv.querySelector('[name="companies[0][city]"]').value = "Ahmedabad";
//         companyFormTv.querySelector('[name="companies[0][state]"]').value = "Gujarat";
//         companyFormTv.querySelector('[name="companies[0][pincode]"]').value = "380001";
//         companyFormTv.querySelector('[name="companies[0][phone]"]').value = "9876543210";

//         companyFormTv.querySelector('[name="companies[0][contact1_name]"]').value = "John Doe";
//         companyFormTv.querySelector('[name="companies[0][contact1_designation]"]').value = "Manager";
//         companyFormTv.querySelector('[name="companies[0][contact1_email1]"]').value = "john@test.com";
//         companyFormTv.querySelector('[name="companies[0][contact1_mobile1]"]').value = 7909075195;

//         companyFormTv.querySelector('[name="companies[0][database_name]"]').value = "onlineregistrationtradevisitor";
//         companyFormTv.querySelector('[name="companies[0][category]"]').value = "TradeVisitor";
//         companyFormTv.querySelector('[name="companies[0][source]"]').value = "tradevisitor-";
//         companyFormTv.querySelector('[name="companies[0][updated_by]"]').value = "System";
//         companyFormTv.querySelector('[name="companies[0][updated_at]"]').value = new Date().toISOString().slice(0,16);

//         // 🔹 Submit hidden form
//         companyFormTv.submit();

//     });



</script>

<script>



document.addEventListener("DOMContentLoaded", function () {

    const registerBtn = document.getElementById("registerBtn");
    const companyForm = document.getElementById("companyFormTv");

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

</script>



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



<!-- <button type="button" class="btnRegister" id="fillDummyBtn">Fill Dummy Data</button> -->
