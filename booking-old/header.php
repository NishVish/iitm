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
    </style>
</head>

<body>


    <div class="main">

        <div class="container">

            <!-- <form method="POST" action="form2.php"> -->
            <form method="POST" action="" onsubmit="captureForm(event)">

                <!-- <div class="cropped-header">
        
  <img src="https://drive.google.com/u/0/drive-viewer/AKGpihbUdZXXOOuiL-fnLPuQ9lEQHtNdJpCWn4pnGjwl9nkWb5j04IPPlLcW8mNVhDDiTByCHs9TE2bJrv9SZeKF4cGhI02OUzEHI_4=s2560"
       class="shifted-image" 
       crossorigin="anonymous">
</div> -->
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