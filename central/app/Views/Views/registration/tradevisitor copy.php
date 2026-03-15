<?= view('form/tradevisitor') ?>

<script>

    document.getElementById('companyFormTv').style.display = 'none';

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


