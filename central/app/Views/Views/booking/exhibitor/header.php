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

/* Header background (red layer, can enable color if needed) */
.header-bg {
    display: flex;
    justify-content: center;
    text-align: center;
    padding: 0;
    margin-bottom: 30px;
    position: relative;
}

/* White faded layer just bigger than logo */
.logo-wrapper {
    background: rgba(255, 255, 255, 0.85); /* white faded */
    padding: 0; /* slightly bigger than logo */
    border-radius: 15px;
    box-shadow: 0 30px 80px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.logo-wrapper img {
    max-width: 110px; /* unified max-width */
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
    display: flex; /* unified with flex centering */
    justify-content: center;
    text-align: center;
    padding: 20px;
}

.center-container2 {
    width: 100%;
    max-width: 1200px; /* unified max-width */
    border: 2px solid #a82324; /* deep red border */
    padding: 40px 20px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    background-color: #fff;
    margin: 20px auto; /* center horizontally */
}

/* Two-column layout */
.content-row {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.left-container,
.right-container {
    flex: 1;
    min-width: 300px;
}

.left-container img {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.right-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .logo-wrapper img {
        max-width: 150px;
    }
    .logo-wrapper .quote {
        max-width: 200px;
    }
    .content-row {
        flex-direction: column;
    }
}
</style>
</head>
<body>

<!-- Red background -->


<div class="center-container">
  <div class="center-container2">
    <div class="header-bg">
      <!-- White faded layer slightly bigger than logo -->
      <div class="logo-wrapper">
        <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Company Logo">
        <!-- <div class="quote"><?= $quote ?></div> -->
      </div>
    </div>

    <!-- Two-column layout -->
    <div class="content-row">
      <!-- Left container with image -->
      <div class="left-container">
        <img src="https://iitmindia.com/wp-content/uploads/2025/11/WhatsApp-Image-2025-11-12-at-3.18.08-PM-1400x1536.jpeg" alt="Left Image">
      </div>

      <!-- Right container -->
      <div class="right-container">
      <!-- </div>
    </div>
  </div>





</div> -->
