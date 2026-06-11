<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>India International Travel Mart | Exhibitor | Registration 2026</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
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
            padding: 10px;
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
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
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
                <p>Exhibitor | Registration 2026</p>
            </div>
            <div class="col-lg-6 col-md-12">
                <form action="register.php" method="post" class="register-form">
                    <div class="form-group">
                        <select class="form-control" name="title" required>
                            <option value="Mr.">Mr</option>
                            <option value="Mrs.">Mrs</option>
                            <option value="Ms.">Ms</option>
                            <option value="Dr.">Dr</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="First Name *" name="select2" value=""
                            required />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Last Name *" name="lastname" value="" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Designation *" name="designation"
                            value="" required />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Company Name *" name="organisation"
                            value="" required />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Email *" name="email" value=""
                            required />
                    </div>
                    <div class="form-group">
                        <input type="tel" name="country_code" class="form-control" placeholder="Country Code (e.g. 91)"
                            pattern="[0-9]{1,4}" maxlength="4" inputmode="numeric" required />

                        <small class="form-text text-muted">
                            Example: India = 91, USA = 1, UAE = 971
                        </small>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" class="form-control" placeholder="Phone Number"
                            pattern="[0-9]{7,12}" maxlength="12" inputmode="numeric" required />

                        <small class="form-text text-muted">
                            Enter phone number without country code
                        </small>
                    </div>
                    <div class="form-group">
                        <textarea type="email" class="form-control" placeholder="Address" name="address"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="City" name="city" value="" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="State *" name="state" value="" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Pincode *" name="pincode" value="" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Country" name="country" value="" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Website" name="website" value="" />
                    </div>
                    <!-- Checkbox for Locations -->

                    <p>Interested In:</p>
                    <input type="checkbox" id="chennai" name="chennai" value="True"><label for="chennai">CHENNAI</label>
                    <br>
                    <input type="checkbox" id="bengaluru" name="bengaluru" value="True"><label
                        for="bengaluru">BENGALURU</label>
                    <br>

                    <input type="checkbox" id="delhi" name="delhi" value="True"><label for="delhi">DELHI</label><br>
                    <input type="checkbox" id="mumbai" name="mumbai" value="True"><label for="mumbai">MUMBAI</label><br>


                    <input type="checkbox" id="pune" name="pune" value="True"><label for="pune">PUNE</label> <br>
                    <input type="checkbox" id="hyderabad" name="hyderabad" value="True"><label
                        for="hyderabad">HYDERABAD</label><br>



                    <input type="checkbox" id="kochi" name="kochi" value="True"><label for="kochi">KOCHI</label> <br>

                    <input type="checkbox" id="kolkata" name="kolkata" value="True"><label for="kolkata">KOLKATA</label>
                    <br>
                    <input type="checkbox" id="ahmedabad" name="ahmedabad" value="True"><label
                        for="ahmedabad">AHMEDABAD</label><br><br>

                    <div class="form-group">
                        <textarea type="text" class="form-control" placeholder="Your Message" name="message"></textarea>
                    </div>
                    <input type="hidden" id="user-ip" name="user_ip" value="">


                    <!-- CAPTCHA Validation -->
                    <!-- <div class="captcha-container">
                                    <div class="captcha-box" id="captcha-box"></div>
                                    <input type="text" id="captcha-input" class="captcha-input" placeholder="Enter CAPTCHA" required>
                                    <button type="button" class="refresh-captcha-btn" onclick="refreshCaptcha()">Refresh CAPTCHA</button>
                                    <div id="captcha-error" class="error-message">CAPTCHA is incorrect. Please try again.</div>
                                </div>-->

                    <button type="submit" class="btnRegister">Register</button>
            </div>
        </div>
    </div>
</body>

</html>