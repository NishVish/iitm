<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Frontpage</title>

  <style>
    .frontpage {
      width: 100%;
      height: 100%;
      background-image: url("{{   url('public/assets/1.jpg') }}");
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
          background: linear-gradient(to bottom, rgba(255, 255, 255, 0.09), rgba(255, 255, 255, 0));
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


      <div>

        <div class="events-section">
          <style>
            .events-section {

              width: 100%;
              color: #aa2324;

              gap: 12px;
              padding-top: 15px;
              padding-bottom: 15px;
              text-align: center;
              font-size: 30px;
            }

            /* Fancy Events Section - Preserving Original Dimensions */
            .events-section table {
              width: 90%;
              margin: 0 auto;
              border-collapse: collapse;
              color: #ffffffff;
              background-color: #aa2324;

              /* High-end typography */
              font-family: "Playfair Display", "Georgia", serif;
              font-size: 12px;
              font-weight: 700;
              text-transform: uppercase;
              letter-spacing: 0.15em;
              /* This creates the "boutique" look */
            }

            /* Elegant cell styling */
            .events-section td {
              vertical-align: middle;
              padding: 8px 0;
              /* Maintains vertical height, removes side padding for edge-to-edge look */
            }

            /* Specific Alignment - First Column */
            .events-section td:first-child {
              text-align: left;
              font-size: 15px;
              /* Adds a decorative flourish before the text */
            }

            /* Specific Alignment - Last Column */
            .events-section td:last-child {
              text-align: right;
              font-style: italic;
              font-weight: 400;
              /* Lighter weight for balance */
              opacity: 0.8;
            }

            /* Subtle hover interaction that doesn't break layout */
          </style>

          <table>
            <tr>
              <td>
                {{ $data['eventname'] }}
              </td>

              <td style="text-align:center;">
                @php
                  $days = [];
                  $month = '';

                  foreach ($data['all_dates'] as $d) {
                    $days[] = \Carbon\Carbon::parse($d)->format('d');
                    $month = \Carbon\Carbon::parse($d)->format('F'); // same for all dates
                  }
                @endphp

                {{ implode(' | ', $days) }}
                <br>
                <span style="border-top:1px solid #aa2324; display:inline-block; padding-top:4px; margin-top:4px;">
                  {{ strtoupper($month) }}
                </span>
              </td>
            </tr>
            <!-- 
  <tr>
    <td colspan="2">
      <br>{{ $data['venue'] }}
    </td>
  </tr> -->
          </table>
        </div>
      </div>
      <hr style="width:93%; height:1px; background-color:#aa2324; border:none; margin:6px auto;">
      <div class="Contact">
        <style>
          .Contact {
            height: auto;
            overflow: visible;
          }

          .name,
          .company {
            display: block;
            font-weight: bold;
            text-transform: uppercase;

            /* IMPORTANT: prevents overflow */
            word-break: break-word;
            overflow-wrap: anywhere;
            white-space: normal;
          }
        </style>

        @php
          $nameSize = 35;
          $companySize = 30;

          if (!function_exists('getFontSize')) {
            function getFontSize($text, $max, $min)
            {
              $length = strlen($text);

              if ($length <= 10)
                return $max;
              if ($length <= 20)
                return $max - 5;
              if ($length <= 30)
                return $max - 10;
              if ($length <= 40)
                return $max - 15;

              return $min;
            }
          }

          $nameSize = getFontSize($data['contactName'] ?? '', 35, 14);
          $companySize = getFontSize($data['companyName'] ?? '', 30, 12);
        @endphp

        <span class="name" style="font-size: {{ $nameSize }}px;">
          {{ $data['contactName'] }}
        </span>



        <span class="company" style="font-size: {{ $companySize }}px;">
          {{ $data['companyName'] }}
        </span>
      </div>

      <hr style="width:90%; height:1px; background-color:#aa2324; border:none; margin:6px auto;">


      <span style="font-weight: bold;">TRADE VISITOR</span>

    </div>

  </div>

</body>

</html>