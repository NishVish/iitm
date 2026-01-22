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
    <title>Page Header</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Header quote */
        .header-quote {
            background: #f1f8ff;
            padding: 10px 20px;
            border-left: 4px solid #3498db;
            margin-bottom: 20px;
            font-style: italic;
        }

        /* Container to center all following content */
        .center-container {
            display: flex;
            flex-direction: column;
            justify-content: center; /* vertical centering */
            align-items: center;     /* horizontal centering */
            width: 100%;
            min-height: calc(100vh - 60px); /* full viewport minus header height */
            text-align: center;
        }
    </style>
</head>
<body>



    <!-- Container to center all content after header -->
    <div class="center-container">
        <!-- All your page content goes here in the main view -->
<!-- Display the quote -->
<div style="background:#f1f8ff; padding:10px 20px; border-left:4px solid #3498db; margin-bottom:20px; font-style:italic;">
    <?= $quote ?>
</div>