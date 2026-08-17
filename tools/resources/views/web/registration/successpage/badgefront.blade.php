<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Frontpage</title>

  <style>
    .frontpage {
      width: 100%;
      height: 100%;
      /* background-image: url("{{   url('public/assets/1.jpg') }}"); */
      /* background-color: red; */
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
    .badge-section {
      position: absolute;
      bottom: 0;
      width: 100%;
      color: #aa2324;

      background: linear-gradient(to bottom, rgba(255, 255, 255, 0.87), rgba(255, 255, 255, 1));
      gap: 12px;
      padding-top: 15px;
      padding-bottom: 15px;
      text-align: center;
      font-size: 30px;
    }

    /* NEW SECTION STYLE */
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
          /* background: linear-gradient(to bottom, rgba(255, 255, 255, 0.09), rgba(255, 255, 255, 0)); */
          background-color: #aa2324;
          gap: 12px;
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
        <img src="{{   url('public/assets/iitm2.png') }}" alt="Frontpage Logo">
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

    <div class="badge-section">


      <div style="display: flex; flex-direction: column; gap: 2.5vh; align-items: center; width: 100%;">

        @include('web.registration.successpage.badgecomponent.details')

        @include('web.registration.successpage.badgecomponent.qr')

        @include('web.registration.successpage.badgecomponent.eventinfo')

      </div>
      <!-- <hr style="width:93%; height:1px; background-color:#aa2324; border:none; margin:6px auto;"> -->


      <hr style="width:90%; height:1px; background-color:#aa2324; border:none; margin:6px auto;">


      <span style="font-weight: bold;">TRADE VISITOR</span>

    </div>

  </div>

</body>

</html>