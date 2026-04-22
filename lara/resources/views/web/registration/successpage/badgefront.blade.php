<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Frontpage</title>

<style>
  .frontpage {
    width: 100%;
    height: 100%;
    background-image: url('https://iitmindia.com/assets/creatives/1.jpg');
    background-size: cover;
    background-position: center;
    position: relative;
    font-family: Arial, sans-serif;
    color: white;

    display: flex;
    justify-content: center;
    align-items: center;
  }

  .frontpage-center-logo {
    height: 90px;
  }

  /* NEW SECTION STYLE */
  .Contact-section {
    position: absolute;
    bottom: 130px;
    width: 60%;
    background: rgba(255, 255, 255, 0.5);
    padding: 15px;
    text-align: center;
    border: 1px solid white;
    color: #aa2324;
    border-radius: 8px;
    font-size: 14px;
  }

    /* NEW SECTION STYLE */
  .badge-section {
    position: absolute;
    bottom: 0;
    width: 100%;
        color: #aa2324;

background: linear-gradient(to bottom, rgba(255, 255, 255, 0.87), rgba(255, 255, 255, 1));      gap: 12px;
    padding-top: 15px;
    padding-bottom: 15px;
    text-align: center;
    font-size: 30px;
  }
</style>
</head>

<body>

<div class="frontpage">

<!-- Header -->
<div class="frontpage-header">

  <style>
    .frontpage-header {
      position: absolute;
      top: 0;
      width: 90%;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 15px 18px;
background: linear-gradient(to bottom, rgba(255, 255, 255, 0.09), rgba(255, 255, 255, 0));      gap: 12px;
    }

    .logo-box {
      border: 2px solid #ffffffff;
      padding: 5px;
      display: flex;
      align-items: center;   
      justify-content: center;
    }

    .logo-box img {
      height: 80px;
      width: auto;
      display: block;
      flex-shrink: 0;
    }

    .frontpage-text-block {
      display: flex;
      flex-direction: column;
      line-height: 1.2;
          color: #ffffffff;

    }

    .frontpage-title {
      font-size: 20px;
      font-weight: bold;
      color: white;
          color: #ffffffff;

    }

    .frontpage-sub {
      font-size: 10px;
      color: white;
      margin-top: 4px;
          color: #ffffffff;

    }
  </style>

  <div class="logo-box">
    <img src="https://iitmindia.com/assets/iitm2.png" alt="Frontpage Logo">
  </div>

  <div class="frontpage-text-block">
    <span class="frontpage-title">
      INDIA <br>INTERNATIONAL <br>TRAVEL MART
    </span>
    <span class="frontpage-sub">
      India's premier travel & toursim exhibition
    </span>
  </div>

</div>

<!-- Center Logo -->
<!-- ✅ NEW SECTION ADDED -->
<!-- <div class="Contact-section">


</div> -->

<div class="badge-section">
    <div class="Contact">
<style>
    #Contact{
        height: 10px;
    }
</style>
<span style="font-size: 35px;">{{$data['contactName']}} </span>
<br>
<span style="font-size: 30px;">{{$data['companyName']}} </span>
</div>
    
<hr style="width:90%;">
    <span style="font-weight: bold;">TRADE VISITOR</span>

</div>

</div>

</body>
</html>