<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
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
  z-index: 1;
}


.logo-wrapper {
  width: 100%;
  background: #fff;
  padding: 15px 25px;
  border-radius: 15px;
  box-shadow: 0 7px 5px rgba(16, 16, 16, 0.1);

  display: flex;
  align-items: center;          /* vertical center */
  gap: 10%;
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

      .container {
        width: 100%;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        border-radius: 10px;
    }
</style>
</head>
<body>

<div class="center-container">
  <div class="center-container2">
    
    <!-- Logo/Header -->
    <div class="header-bg">
<div class="logo-wrapper">
<a href="<?= base_url('company/add') ?>">
    <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" 
         alt="Company Logo">
</a>

<div class="steps">

  <a href="<?= site_url('booking/instructions/'.$lead['lead_id']) ?>"
     class="step <?= ($step >= 1) ? 'active' : '' ?>">
     Instructions
  </a>

  <a href="<?= site_url('booking/company/'.$lead['lead_id']) ?>"
     class="step <?= ($step >= 2) ? 'active' : '' ?>">
     Company
  </a>

  <a href="<?= site_url('booking/booking_details/'.$lead['lead_id']) ?>"
     class="step <?= ($step >= 3) ? 'active' : '' ?>">
     Booking Details
  </a>

  <a href="<?= site_url('booking/summary/'.$lead['lead_id']) ?>"
     class="step <?= ($step >= 4) ? 'active' : '' ?>">
Summary  </a>
  <!-- Payment should NOT be clickable yet -->
  <span class="step <?= ($step >= 5) ? 'active' : '' ?>">
     Payment
  </span>


</div>

</div>

    </div>

    <!-- Two-column layout -->
    <div class="content-row">
<!-- <div class="left-container">
  <div class="image-wrapper">
    <img src="https://iitmindia.com/wp-content/uploads/2025/11/WhatsApp-Image-2025-11-12-at-3.18.08-PM-1400x1536.jpeg" alt="Image 1">
    <img src="https://iitmindia.com/wp-content/uploads/2026/01/IITM-Ahmedabad-2024-1.jpeg" alt="Image 2">
    <img src="https://iitmindia.com/wp-content/uploads/2023/05/1-1-1.jpg" alt="Image 3">
  </div>
</div> -->

<style>

.steps {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 60px;
  padding: 20px 0;
}

/* background line */
.steps::before {
  content: "";
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  height: 4px;
  background: #d6d6d6;
  border-radius: 2px;
  transform: translateY(-50%);
  z-index: 0;
}

/* step pill */
.step {
  position: relative;
  z-index: 1;                 /* ABOVE the line */
  padding: 10px 24px;
  border-radius: 30px;
  background: #b49393;
  color: #ffffff;
  font-size: 16px;
  font-weight: 600;
  text-decoration: none;
  white-space: nowrap;
  transition: all 0.25s ease;
}

/* active step */
.step.active {
  background: linear-gradient(135deg, #c03b31, #bd3b08);
  color: #fff;
  box-shadow: 0 6px 15px rgba(172, 64, 31, 0.35);
}

/* hover */
a.step:hover {
  transform: translateY(-1px);
}




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

<style>

    .btn-next,.btn-primary ,.btn-secondary {

  display: inline-block;
  padding: 10px 25px;
  background: linear-gradient(135deg, #c03b31, #bd3b08);
  color: #fff;
  border-radius: 6px;
  text-decoration: none;
  font-weight: 600;
  font-size: 15px;
  transition: all 0.25s ease;
}

.btn-next:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 15px rgba(172, 64, 31, 0.35);
}

.btn-next:active {
  transform: translateY(0);
  box-shadow: 0 6px 15px rgba(172, 64, 31, 0.35);
}


/* Buttons */
/* .btn-primary {
  padding: 10px 20px;
  background: #c03b31;
  color: #fff;
  border: none;
  border-radius: 5px;
  font-weight: 600;
  cursor: pointer;
} */

  /* padding: 10px 20px;
  background: #c03b31;
  color: #fff;
  border-radius: 5px;
  text-decoration: none;
  font-weight: 600;
  margin-left: 10px;
  display: inline-block;
} */

.btn-primary:hover,
.btn-secondary:hover {
  opacity: 0.9;
}


.pay-btn {
        margin-top: 25px;
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #c03b31, #bd3b08);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .pay-btn:hover {
        transform: translateY(-1px);
  box-shadow: 0 6px 15px rgba(172, 64, 31, 0.35);
    }

</style>
      <!-- <div class="right-container"> -->
<div class="container">
