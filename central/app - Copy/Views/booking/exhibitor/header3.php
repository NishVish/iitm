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

  /* Main container with background image */
  .center-container {
    display: flex;
    justify-content: center;
    padding: 40px 20px;
  }

  .center-container2 {
    width: 100%;
    max-width: 1200px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    overflow: hidden;
    background: url('https://iitmindia.com/wp-content/uploads/2025/11/WhatsApp-Image-2025-11-12-at-3.18.08-PM-1400x1536.jpeg') center/cover no-repeat;
    position: relative;
    padding: 40px 20px;
    color: #1d1d1d;
  }

  /* Overlay to make text readable */
  .center-container2::before {
    content: "";
    position: absolute;
    inset: 0;
    background-color: rgba(255, 254, 254, 0.89);
    z-index: 0;
  }

  /* Header/logo */
  .header-bg {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
    position: relative;
    z-index: 1; /* Above overlay */
  }

  .logo-wrapper {
  width: 100%;       /* allows responsive scaling */
    background: rgb(255, 255, 255);
    padding: 15px 25px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(16, 16, 16, 0.3);
    display: flex;
    flex-direction: column;
    align-items: left;
  }

  .logo-wrapper img {
    max-width: 110px;
    height: auto;
    display: block;
  }

  .logo-wrapper .quote {
    margin-top: 10px;
    font-style: italic;
    color: #555;
    text-align: center;
    font-size: 1rem;
    max-width: 250px;
  }

  .content-row {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  position: relative;
  z-index: 1; /* Above overlay */
  align-items: stretch; /* Ensures both columns have same height */
}

.left-container,
.right-container {
  flex: 1;
  min-width: 300px;
  display: flex;
  flex-direction: column;
}

/* Make image-wrapper fill left container height */
.left-container .image-wrapper {
  flex: 1;
}

.left-container {
  flex: 1;
  min-width: 300px;
}

.image-wrapper {
  width: 100%;
  /* Maintain image aspect ratio */
  position: relative;
  background-color: grey; /* grey background */
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

/* Image inside wrapper */
.image-wrapper img {
  width: 100%;
  height: auto;
  display: block;
  opacity: 0.5; /* optional transparency */
}

  .left-container img {
    width: 100%;
    height: auto;
    opacity: 0.5; /* 50% transparency */
    background-color:grey;

    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
  }

  .right-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  /* Example text inside right container */
  .right-container p {
    font-size: 1.1rem;
    line-height: 1.6;
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

<div class="center-container">
  <div class="center-container2">
    
    <!-- Logo/Header -->
    <div class="header-bg">
      <div class="logo-wrapper">
        <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Company Logo">
      </div>
    </div>

    <!-- Two-column layout -->
    <div class="content-row">
<div class="left-container">
  <div class="image-wrapper">
    <img src="https://iitmindia.com/wp-content/uploads/2025/11/WhatsApp-Image-2025-11-12-at-3.18.08-PM-1400x1536.jpeg" alt="Image 1">
    <img src="https://iitmindia.com/wp-content/uploads/2026/01/IITM-Ahmedabad-2024-1.jpeg" alt="Image 2">
    <img src="https://iitmindia.com/wp-content/uploads/2023/05/1-1-1.jpg" alt="Image 3">
  </div>
</div>

<style>
.image-wrapper {
  position: relative; /* important for stacking images */
  width: 100%;
  padding-top: 75%; /* maintain aspect ratio */
  overflow: hidden;
  border-radius: 10px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

.image-wrapper img {
  position: absolute; /* stack images on top of each other */
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0;
  transition: opacity 1.5s ease-in-out;
}
</style>

<script>
const images = document.querySelectorAll('.image-wrapper img');
let current = 0;

// Show first image
images[current].style.opacity = 1;

setInterval(() => {
  // Fade out current image
  images[current].style.opacity = 0;
  
  // Move to next image
  current = (current + 1) % images.length;
  
  // Fade in next image
  images[current].style.opacity = 1;
}, 4000); // change image every 4 seconds
</script>


      <div class="right-container">

