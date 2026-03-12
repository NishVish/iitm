<?php
// Array of motivational quotes
$quotes = [
    "Believe in yourself – you’re capable of amazing things!",
    "Every great exhibitor started with a single booking.",
    "Success is not final; every step counts.",
    "Your passion will make your booth shine!",
    "Small steps today lead to big achievements tomorrow.",
    "Confidence is the key – you’ve got this!",
    "The best way to predict the future is to create it.",
    "Great things never come from comfort zones.",
    "Booking today is the first step towards success.",
    "Every booking is progress – keep moving forward!"
];

// Pick a random quote
$quote = $quotes[array_rand($quotes)];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment Page</title>
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f4f4;
    }

    /* Red background layer */
    .header-bg {
        /* background-color: #a82324; deep red */
        display: flex;
        justify-content: center;
        padding: 10px 0;
    }

    /* White faded layer just bigger than logo */
    .logo-wrapper {
        background: rgba(255, 255, 255, 0.85); /* white faded */
        padding: 10px; /* slightly bigger than logo */
        border-radius: 15px;
        box-shadow: 0 30px 80px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .logo-wrapper img {
        max-width: 110px;
        height: auto;
        display: block;
    }

    .logo-wrapper .quote {
        margin-top: 15px;
        font-style: italic;
        color: #555;
        text-align: center;
        font-size: 1rem;
        max-width: 250px;
    }

    /* Main content container */
    .center-container {
        text-align: center;
        padding: 10px 20px;
    }    
.center-container2 {
    text-align: center;
    border: 2px solid #a82324; /* deep red border */
    padding: 40px 20px;
    border-radius: 10px;       /* optional: rounded corners */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* shadow on all sides */
    background-color: #fff;    /* white background for contrast */
    max-width: 600px;          /* optional: limit width */
    margin: 20px auto;         /* center the box horizontally */
}


    /* Responsive */
    @media (max-width: 768px) {
        .logo-wrapper img {
            max-width: 150px;
        }
        .logo-wrapper .quote {
            max-width: 200px;
        }
    }
</style>
</head>
<body>

<!-- Red background -->

<!-- Main content -->
<div class="center-container">
<div class="center-container2">
<div class="header-bg">
    <!-- White faded layer slightly bigger than logo -->
    <div class="logo-wrapper">
        <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Company Logo">
        <!-- <div class="quote"><?= $quote ?></div> -->
    </div>
</div>
