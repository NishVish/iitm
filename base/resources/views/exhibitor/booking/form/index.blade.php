<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITM Booking Form</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <style>
        body {
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;

        }

        .main {
            font-family: Arial, sans-serif;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
            max-width: 1100px;
            /* Allows full width on small screens, caps on large */
            padding: 10px;
            box-sizing: border-box;
        }


        .container {
            background-color: #fff;
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border-radius: 8px;
        }

        h3 {
            margin-top: 0px;

            background-color: #d3d3d3;
            /* Light grey */
            border-radius: 4px;
            /* Optional: slight roundness looks better */
            display: block;
            /* Changed from inline-block for full width */
            width: 100%;
            /* Space above the header to separate from previous section */
            padding: 10px 0;
            /* 📌 This creates the "breathing room" inside the bar */
            font-size: 1.1em;
            text-align: center;
            line-height: 1.2;
            /* Normal line height */
            box-sizing: border-box;
        }

        /* If you are using h2 for section titles as well */
        h2 {
            padding: 15px;
            /* 📌 Space around the text */
            margin: 20px 0 10px 0;
            /* Space outside the bar */
            border-radius: 6px;
            text-align: center;
        }


        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            /* Optional spacing between columns */
        }

        .column {
            flex: 1;
            min-width: 280px;
            /* Minimum before stacking occurs */
            box-sizing: border-box;
        }

        .form-line {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 11px;
            flex-wrap: wrap;
        }

        .form-line label {
            white-space: nowrap;
            margin: 0;
        }

        .form-line input,
        .form-line textarea {
            width: auto;
            flex: 1 1 auto;
            min-width: 150px;
        }

        label {
            font-weight: bold;
            display: inline-block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        textarea {
            border: none;
            border-bottom: 1px solid #000;
            border-radius: 0;
            background-color: transparent;
            padding: 4px 0;
            text-align: center;
            /* Center the text */
            /* font-size: 20px;  */

            /* Increase font size */

        }

        #a-rs,
        #b-rs,
        #grand-total {
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            padding: 8px;
        }

        .checkbox-group label {
            font-weight: normal;
            display: block;
            margin-bottom: 10px;
        }

        .image-placeholder {
            width: auto;
            height: auto;
            margin: 40px;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        /* The text container that will adjust automatically */
        .account-info {
            display: block;
            /* Default block-level element behavior */
            padding: 10px;
            /* Optional padding */
            font-size: 1.1em;
            /* Adjust the font size */
            line-height: 1.5;
            /* Ensures line spacing */
            width: auto;
            /* Make width auto adjust to content */
            height: auto;
            /* Allow height to adjust to content */
            text-align: left;
            /* Optional: left-align the text */
        }


        .note {
            background-color: #ffffe0;
            border-left: 4px solid #ccc;
            border-radius: 4px;
        }

        .note p {
            margin: 0;
            /* Remove any margin from paragraphs */
            padding: 0;
            /* Remove any padding from paragraphs */
        }

        .note ol {
            margin: 0;
            /* Remove margin from the ordered list */
            padding-left: 20px;
            /* Default padding for ordered list */
        }

        .note li {
            margin: 0;
            /* Remove margin from list items */
            padding: 0;
            /* Remove padding from list items */
        }

        .footer {
            font-size: 0.9em;
            color: #333;
            margin-top: 10px;
            text-align: center;
        }

        .footer a {
            color: #000;
            text-decoration: none;
        }

        .line {
            border-bottom: 1px solid #000;
            width: 150px;
            margin-top: 10px;
        }

        td {
            text-align: center;
        }

        .submit-button {
            background: none;
            /* Removes background color */
            border: none;
            /* Removes border */
            padding: 0;
            /* Removes padding */
            font-size: inherit;
            /* Inherits font size from parent */
            font-weight: bold;
            /* Keeps the strong text style */
            text-align: left;
            /* Aligns text to the left */
            cursor: pointer;
            /* Ensures the cursor is a pointer if you want interaction */
        }

        .submit-button:hover {
            text-decoration: underline;
            /* Optional: Add hover effect to indicate it's clickable */
        }


        .cropped-header {
            height: 180px;
            /* Height of the visible area */
            overflow: hidden;
            /* Hides everything outside the box */
            position: relative;
        }



        #fascia {
            text-transform: uppercase;
        }


        @media (max-width: 768px) {
            .responsive-title {
                font-size: 3.0vh;
                /* adjust this value as needed */
            }
        }

        @media screen and (max-width: 600px) {



            .form-line {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-line label,
            .form-line input,
            .form-line textarea {
                width: 100%;
            }

            .footer {
                font-size: 0.8em;
            }
        }


        img {
            max-width: 100%;
            height: auto;
        }

        :root {
            --primary: #A62322;
            /* Example: A nice vibrant blue */
        }


        .responsive-title {
            text-align: center;
            color: var(--primary);
            font-weight: 900;
            margin: 6px auto;
            text-decoration: none;
            display: block;
            position: relative;
            padding-bottom: 5px;

            /* 👇 Responsive font size */
            font-size: clamp(22px, 4vw, 48px);
        }

        /* Add room for descenders (g, p, q, y) */
        .form-line label,
        .account-info,
        h3,
        .responsive-subtitle,
        .form-line input {
            line-height: 1.4 !important;
            /* Increase vertical space */
            padding-bottom: 3px !important;
            /* Add tiny buffer at the bottom */
        }

        /* Ensure textareas don't clip */
        textarea {
            line-height: 1.4;
            padding-bottom: 5px;
        }

        /* Force specific containers to not hide overflow during capture */
        .main,
        .container,
        .column {
            overflow: visible !important;
        }
    </style>
</head>

<body>


    <div class="main">

        <div class="container">

            <!-- <form method="POST" action="form2.php"> -->
            <form method="POST" action="" onsubmit="captureForm(event)">


                <style>
                    .logo,
                    .shifted-image {
                        width: 100%;
                        height: auto;
                        max-height: 180px;
                        object-fit: cover;
                    }
                </style>
                <div style="display: flex; align-items: center; background-color: #ffffffff; height: 180px;">
                    <!-- <img src="iitm.png" class="logo" style="width: 20%;">
                    <img src="iitm2.png" class="logo" style="width: 20%;"> -->
                    <img src="iitm3.png" class="logo" style="width: 20%;">

                    <div
                        style="width: 80%; text-align: center; display: flex; flex-direction: column; gap: 10px; margin-top: 15px;">
                        <h1 class="responsive-title" style="margin:0;">BOOKING FORM</h1>
                        <h2 class="responsive-subtitle" style="margin:0; padding:0;">
                            <strong>India's Premier Travel & Tourism Exhibition</strong>
                        </h2>
                    </div>
                </div>
                <div class="form-section">
                    <div class="row">



                        <div class="column">
                            <div class="pricetablecontainer">
                                <style>
                                    .pricetablecontainer {
                                        width: 100%;
                                        text-align: center;
                                        /* Centers the Heading and Inline-block table */
                                    }

                                    .pricetable {
                                        /* Centering the table block */
                                        margin-left: auto;
                                        margin-right: auto;

                                        /* Layout */
                                        width: 60%;
                                        /* Adjust based on how much of the A4 page you want to fill */
                                        border-collapse: collapse;
                                    }

                                    .pricetable th,

                                    .pricetable td {
                                        /* Darker border for better JPEG visibility */
                                        text-align: center;
                                        /* Centers text inside cells */
                                        vertical-align: middle;
                                    }

                                    .pricetable h3 {
                                        margin-bottom: 10px;
                                        color: var(--primary);
                                    }
                                </style>
                                <h3>A. Booking Information</h3>
                                <table class="pricetable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Location</th>
                                            <th>Year</th>
                                            <th>Rate</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="checkbox" name="locations[]" value="Chennai_2026_34000">
                                            </td>
                                            <td>Chennai</td>
                                            <td>2026</td>
                                            <td>-</td>
                                            <td>m² @ ₹34,000/m²</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="locations[]" value="Bengaluru_2026_37000">
                                            </td>
                                            <td>Bengaluru</td>
                                            <td>2026</td>
                                            <td>-</td>
                                            <td>m² @ ₹37,000/m²</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="locations[]" value="Delhi_2026_37000"></td>
                                            <td>Delhi</td>
                                            <td>2026</td>
                                            <td>-</td>
                                            <td>m² @ ₹37,000/m²</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="locations[]" value="Mumbai_2026_37000">
                                            </td>
                                            <td>Mumbai</td>
                                            <td>2026</td>
                                            <td>-</td>
                                            <td>m² @ ₹37,000/m²</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="locations[]" value="Pune_2026_34000"></td>
                                            <td>Pune</td>
                                            <td>2026</td>
                                            <td>-</td>
                                            <td>m² @ ₹34,000/m²</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="locations[]" value="Hyderabad_2026_34000">
                                            </td>
                                            <td>Hyderabad</td>
                                            <td>2026</td>
                                            <td>-</td>
                                            <td>m² @ ₹34,000/m²</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="locations[]" value="Kochi_2027_34000"></td>
                                            <td>Kochi</td>
                                            <td>2027</td>
                                            <td>-</td>
                                            <td>m² @ ₹34,000/m²</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="locations[]" value="Kolkata_2027_34000">
                                            </td>
                                            <td>Kolkata</td>
                                            <td>2027</td>
                                            <td>-</td>
                                            <td>m² @ ₹34,000/m²</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="locations[]" value="Ahmedabad_2027_34000">
                                            </td>
                                            <td>Ahmedabad</td>
                                            <td>2027</td>
                                            <td>-</td>
                                            <td>m² @ ₹37,000/m²</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                            </div>

                        </div>


                    </div>
                </div>
                <div class="form-section">
                    <div class="row">
                        <div class="column" style="height: 240px;">

                            <img src="side-image.png" style="width: 100%; height: 100%;" crossorigin="anonymous">
                        </div>
                        <div class="column">
                            <div class="form-line"><label for="area">Area Required (m²):</label><input type="number"
                                    id="area" name="area" required>
                            </div>
                            <div class="form-line"><label for="amount">Amount Rs:</label><input type="number"
                                    id="amount" name="amount" required>
                            </div>
                            <div class="form-line">
                                <label for="gst-amount">18% GST of the Amount:</label>
                                <input type="number" id="gst-amount" name="gst-amount" readonly>
                            </div>

                            <div class="form-line">
                                <label for="total">Total Amount with 18%:</label>
                                <input type="number" id="total" name="total" readonly>
                            </div>

                            <div class="form-line"><label>A-Rs:</label><input type="number" id="a-rs" name="a-rs"> +
                                <label>B-Rs:</label><input type="number" id="b-rs" name="b-rs">
                            </div>
                            <div class="form-line"><label><strong>Grand Total:</strong></label><input type="number"
                                    id="grand-total" name="grand-total"></div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="row">
                        <div class="column">
                            <h3>Bank Transfer Details:</h3>
                            <div class="account-info">
                                A/C Name: Sphere Travelmedia & Exhibitions Pvt. Ltd.<br>
                                A/C No: 0184 2320 0013 32<br>
                                Bank: HDFC Bank, CMH Road, Indiranagar, Bangalore - 08<br>
                                IFSC: HDFC0000184 <br>
                                RTGS/NEFT/IFSC Code:HDFC0000184
                            </div>

                        </div>
                        <div class="column">
                            <h3>Payment Particulars:</h3>

                            <div class="form-line" style="flex-wrap: nowrap;">
                                <label for="cheque-no" style="min-width: 120px;">Cheque/DD No:</label>
                                <input type="text" id="cheque-no" name="cheque-no" style="flex: 1;">
                                <label for="cheque-date" style="min-width: 60px;">Dated:</label>
                                <input type="date" id="cheque-date" name="cheque-date" style="min-width: 180px;">
                            </div>

                            <div class="form-line"><label for="payment-amount">Amount Rs:</label><input type="number"
                                    id="payment-amount" name="payment-amount"></div>
                            <div class="form-line"><label for="drawn-on">Drawn on:</label><input type="text"
                                    id="drawn-on" name="drawn-on">
                            </div>
                            <p>In Favour of "Sphere Travelmedia & Exhibitions Pvt. Ltd."<br>
                                (Payable at Bangalore)</p>
                        </div>
                    </div>
                </div>

                <h3>Organisation Details</h3>

                <div class="form-line inline-fields">
                    <label for="org-name">Name of Organisation:</label>
                    <input type="text" id="org-name" name="org-name" required>
                </div>

                <div class="form-line inline-fields">
                    <label for="contact-person">Contact Person & Designation:</label>
                    <input type="text" id="contact-person" name="contact-person" required>
                </div>

                <div class="form-line">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" rows="3" required></textarea>
                </div>

                <div class="form-line inline-fields">
                    <label for="telephone">Telephone:</label>
                    <input type="text" id="telephone" name="telephone" required>

                    <label for="fax">Fax:</label>
                    <input type="text" id="fax" name="fax">

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-line inline-fields">
                    <label for="gst">GST No:</label>
                    <input type="text" id="gst" name="gst" required>

                    <label for="website">Website:</label>
                    <input type="text" id="website" name="website">

                    <label for="product-category">Product Category:</label>
                    <input type="text" id="product-category" name="product-category" required>
                </div>

                <div class="form-line">
                    <label for="fascia">Fascia Name:</label>
                    <input type="text" id="fascia" name="fascia" maxlength="60" required>
                </div>


                <div class="form-line inline-fields">

                    <table style="width: 100%; table-layout: fixed;">
                        <tr>
                            <td style="width: 50%;">
                                <input type="text">
                            </td>
                            <td style="width: 50%; text-align: center;">
                                <img id="company-seal-preview" src="" alt="Company Seal"
                                    style="width: 100px; height: 100px; display: none; margin: 0 auto;">
                                <!-- Upload Image for Company Seal -->
                                <input type="file" id="company-seal-upload" accept="image/*"
                                    onchange="displayImage('company-seal-preview', this)">
                            </td>
                            <td style="width: 50%; text-align: center;">
                                <img id="signature-preview" src="" alt="Signature"
                                    style="width: 100px; height: 100; display: none; margin: 0 auto;">
                                <!-- Upload Image for Signature -->
                                <input type="file" id="signature-upload" accept="image/*"
                                    onchange="displayImage('signature-preview', this)">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="date">Date</label></td>
                            <td><label for="company-seal">Company Seal</label></td>
                            <td><label for="signature">Signature</label></td>
                        </tr>
                    </table>


                </div>




                <div class="footer">
                    <button type="submit" id="submit-btn">Submit</button>
                    <br><br>

                    <div style="display: inline-flex; align-items: center; gap: 20px; text-align: left;">

                        <img src="sphere3.png" style="width: 200px; height: auto;">

                        <div style="line-height: 1.5;">
                            <strong>Sphere Travelmedia & Exhibitions Pvt Ltd</strong><br>
                            #245, “Shivashakthi”, 7th Main, Amarjyothi Layout, Domlur, Bangalore - 560071, India<br>
                            Ph: +91-80-4083 4100 | Fax: +91-80-4083 4101<br>
                            Email: <a href="mailto:info@iitmindia.com">info@iitmindia.com</a>
                        </div>

                    </div>
                </div>


                <button type="button" id="autofill-btn" onclick="fillSampleData()"
                    style="background: #0284c7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; margin-right: 10px;">
                    Autofill Sample Data
                </button>


        </div>





        <script>

            function displayImage(previewId, inputElement) {
                const file = inputElement.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    const imageElement = document.getElementById(previewId);
                    imageElement.src = e.target.result;
                    imageElement.style.display = 'block';  // Show the image
                    inputElement.style.display = 'none';  // Hide the upload button
                };

                if (file) {
                    reader.readAsDataURL(file); // Convert the image to a base64 string and display
                }
            }


            document.getElementById('amount').addEventListener('input', function () {

                let amount = parseFloat(document.getElementById('amount').value) || 0;
                let gst = Math.ceil(amount * 0.18); // Round GST up
                let total = Math.ceil(amount + gst); // Round total up

                document.getElementById('gst-amount').value = gst;

                document.getElementById('gst').value = gst;
                document.getElementById('total').value = total;
            });

            function captureForm(event) {
                event.preventDefault(); // Stop the default button click

                const submitBtn = document.getElementById("submit-btn");
                const formElement = document.querySelector(".main");

                // 1. Provide UI Feedback


                // 2. Start the capture
                html2canvas(formElement, {
                    scale: 2,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: "#ffffff",
                    windowWidth: 1200,
                    height: Math.min(formElement.scrollHeight, 1500), onclone: (clonedDoc) => {
                        // Hide buttons in the captured image
                        const clonedMain = clonedDoc.querySelector(".main");
                        if (clonedMain.querySelector("#submit-btn")) clonedMain.querySelector("#submit-btn").style.display = "none";
                        if (clonedMain.querySelector("#autofill-btn")) clonedMain.querySelector("#autofill-btn").style.display = "none";
                    }
                }).then(function (canvas) {
                    // 3. Convert canvas to Base64
                    const imgData = canvas.toDataURL("image/jpeg", 0.8);

                    // 4. Create a dynamic form to POST the data
                    const virtualForm = document.createElement('form');
                    virtualForm.method = 'POST';
                    virtualForm.action = 'submit.php';

                    // 5. Helper function to add fields to our virtual form
                    const addField = (name, value) => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = name;
                        input.value = value;
                        virtualForm.appendChild(input);
                    };

                    // 6. Loop through all existing inputs in your visible form and copy them
                    const originalForm = document.querySelector("form");
                    const inputs = originalForm.querySelectorAll("input, textarea, select");

                    inputs.forEach(input => {
                        if (input.type === "checkbox") {
                            if (input.checked) addField(input.name, input.value);
                        } else if (input.type !== "file") { // Skip file inputs, we have the canvas
                            addField(input.name, input.value);
                        }
                    });

                    // 7. Append the big image data
                    addField('form_image', imgData);

                    // 8. Add to body and submit
                    document.body.appendChild(virtualForm);
                    virtualForm.submit();

                }).catch(function (error) {
                    console.error("Capture failed:", error);
                    alert("Capture failed. Please try again.");
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerText = "Submit";
                    }
                });
            }

            function fillSampleData() {
                // 1. Calculations Section
                const area = 18;
                const ratePerSqMt = 34000;
                const amount = area * ratePerSqMt;
                const gst = Math.ceil(amount * 0.18);
                const total = amount + gst;

                document.getElementById('area').value = area;
                document.getElementById('amount').value = amount;
                document.getElementById('gst-amount').value = gst;
                document.getElementById('total').value = total;
                document.getElementById('a-rs').value = total;
                document.getElementById('b-rs').value = 0;
                document.getElementById('grand-total').value = total;

                // 2. Payment Particulars
                document.getElementById('cheque-no').value = "CHQ123456";
                document.getElementById('cheque-date').value = new Date().toISOString().split('T')[0]; // Today's date
                document.getElementById('payment-amount').value = total;
                document.getElementById('drawn-on').value = "State Bank of India";

                // 3. Organisation Details
                document.getElementById('org-name').value = "Global Travel Solutions Pvt Ltd";
                document.getElementById('contact-person').value = "John Doe (Director)";
                document.getElementById('address').value = "123, Skyline Business Park, MG Road, Bangalore - 560001";
                document.getElementById('telephone').value = "080-12345678";
                document.getElementById('fax').value = "080-87654321";
                document.getElementById('email').value = "john.doe@globaltravel.com";
                document.getElementById('gst').value = "29AAAAA0000A1Z5";
                document.getElementById('website').value = "www.globaltravel.com";
                document.getElementById('product-category').value = "Destination Management";
                document.getElementById('fascia').value = "GLOBAL TRAVEL SOLUTIONS";

                // alert("Form has been autofilled with sample data!");
            }
        </script>

        <style>
            .responsive-subtitle {
                text-align: center;
                color: var(--primary);
                font-size: clamp(1rem, 4vw, 2rem);
                padding: 0;
                /* Change padding-top to margin-top */
                margin-top: 50px;
            }
        </style>
</body>

</html>