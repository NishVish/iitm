<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Backpage</title>

  <style>
    .backpage {
      width: 100%;
      height: 100%;
      /* background-image: url("{{   url('public/assets/1.jpg') }}"); */
      background-color: white;
      background-size: cover;
      background-position: center;
      position: relative;
      font-family: Arial, sans-serif;
      /* background-color: #aa2324; */
      color: #aa2324;

      display: flex;
      justify-content: center;
      align-items: center;
    }

    .backpage-center-logo {
      height: 90px;
    }


    .back-badge-section {
      position: absolute;
      bottom: 0;
      width: 100%;
      /* background: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(224, 8, 8, 0.84)); */
      gap: 12px;
      padding-top: 15px;
      padding-bottom: 15px;
      text-align: center;
    }
  </style>
</head>

<body>

  <div class="backpage">

    <!-- Header -->
    <div class="backpage-header">

      <style>
        .backpage-header {
          position: absolute;
          top: 0;
          /* width: 90%; */
          display: flex;
          justify-content: center;
          align-items: center;
          padding: 10px 10px;
          background: linear-gradient(to bottom, rgba(255, 255, 255, 0.27), rgba(255, 255, 255, 0));
          gap: 12px;
        }

        .info-box {
          border: 2px solid #eaeaeaff;
          padding: 5px;
          align-items: center;
        }


        .backpage-text-block {
          display: flex;
          flex-direction: column;
          line-height: 1.2;
        }

        .backpage-title {
          font-size: 20px;
          font-weight: bold;
          color: white;
        }

        .backpage-sub {
          font-size: 10px;
          color: white;
          margin-top: 4px;
        }

        .event-info-section {
          position: absolute;
          top: 250px;
          width: 90%;
          display: flex;
          justify-content: center;
          align-items: center;
          padding: 15px 18px;
          background: white;
        }
      </style>

      <div class="info-box">
        Dear Visitor,

        This document serves as your access badge. Please keep it safe, as it will allow you to enter the exhibition.
        The badge is non-transferable.

      </div>



    </div>

    <!-- event info -->
    <!-- <div class="event-info-section">
Banglore 22-23-24 July 
</div> -->
    <!-- Center -->
    <!-- <div class="instruction-section">

</div> -->

    <div class="back-badge-section">
      @include('web.registration.successpage.badgecomponent.eventinfofull')

      <div style="line-height:22px; font-family: Arial, sans-serif; text-align:left; padding-left:10px">
        <!-- <strong>Instructions:</strong> -->
        <ul style="margin-top:8px; padding-left:18px;">
          <li>Carry this with you for the exhibition.</li>
          <li>Submit a copy of your business card at the registration desk.</li>
          <li>Insert it into the plastic sleeve provided by the registration desk.</li>
        </ul>
      </div>


      <!--     
    {{ $data['eventname'] }}
<br>{{ implode(", ", $data['all_dates']) }}   -->
      <div class="instruction">
        <style>
          #instruction {
            height: 5px;
            font-size: 10px;
          }
        </style>

      </div>
      <hr style="width:90%; height:1px; background-color:#aa2324; border:none; margin:6px auto;">

      <span style="font-weight: bold;font-size:30px ;justify-content:centre;">TRADE VISITOR</span>
    </div>

  </div>

</body>

</html>