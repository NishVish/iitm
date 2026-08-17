@php

    $data = [
        'contactName' => 'John Smith',
        'companyName' => 'ABC Travel Solutions',
        'mobile' => '+919876543210',
        'email' => 'john@abctravels.com',
        'eventname' => 'iitm-mumbai-2026',
        'venue' => 'Bombay Exhibition Centre, Mumbai',

        'all_dates' => [
            '2026-10-29',
            '2026-10-30',
            '2026-10-31'
        ]
    ];


    $event = str_replace('iitm-', '', strtolower($data['eventname']));

    $parts = explode('-', $event);

    $year = end($parts);

    array_pop($parts);

    $location = ucfirst(implode(' ', $parts));


    $days = [];
    $month = '';

    foreach ($data['all_dates'] as $d) {
        $days[] = \Carbon\Carbon::parse($d)->format('d');
        $month = \Carbon\Carbon::parse($d)->format('F');
    }

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>A4 Page with Two Divs + Instructions</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #eee;
        }

        /* A4 page */
        .a4 {
            width: 21cm;
            height: 29.7cm;
            padding: 1cm;
            box-sizing: border-box;
            overflow: hidden;
            background: white;
            margin: 0 auto;
        }

        /* top wrapper */
        .wrapper {
            display: flex;
            justify-content: center;
            gap: 0cm;
        }

        .box {
            width: 9.2cm;
            height: 13.4cm;
            border: 1px solid black;
            box-sizing: border-box;
        }



        @media print {
            body {
                background: none;
            }

            .a4 {
                margin: 0;
            }
        }
    </style>
</head>

<body>

    <div class="a4">

        <!-- Top section -->
        <div class="wrapper">
            <div class="box">
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <title>Frontpage</title>

                    <style>
                        .frontpage {
                            width: 100%;
                            height: 100%;
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
                                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1-768x768.png"
                                    alt="Frontpage Logo">
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


                            <div
                                style="display: flex; flex-direction: column; gap: 2.5vh; align-items: center; width: 100%;">

                                <div class="Contact">

                                    <style>
                                        .Contact {
                                            height: 100px;
                                            width: 360px;
                                            overflow: hidden;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            text-align: center;
                                            padding: 0 10px;
                                            box-sizing: border-box;
                                            font-family: "Playfair Display", Georgia, serif;
                                        }

                                        .contact-inner {
                                            width: 100%;
                                        }

                                        .name,
                                        .company {
                                            display: block;
                                            font-weight: 700;
                                            text-transform: uppercase;
                                            word-break: break-word;
                                            line-height: 1.1;
                                            color: #111;
                                        }

                                        .company {
                                            margin-top: 6px;
                                            opacity: 0.8;
                                        }
                                    </style>

                                    @php


                                        $name = trim($data['contactName'] ?? 'John Smith');
                                        $company = trim($data['companyName'] ?? 'ABC Travel Solutions');


                                        $len = max(strlen($name), strlen($company));

                                        // =========================
                                        // FONT CONTROL (PHP ONLY)
                                        // =========================
                                        if ($len <= 18) {
                                            $nameSize = 28;
                                            $companySize = 20;
                                            $shiftDown = 15;
                                        } elseif ($len <= 28) {
                                            $nameSize = 22;
                                            $companySize = 18;
                                            $shiftDown = 15;
                                        } elseif ($len <= 38) {
                                            $nameSize = 18;
                                            $companySize = 15;
                                            $shiftDown = 10;
                                        } elseif ($len <= 50) {
                                            $nameSize = 15;
                                            $companySize = 12;
                                            $shiftDown = 7;
                                        } else {
                                            $nameSize = 13;
                                            $companySize = 11;
                                            $shiftDown = 5;
                                        }

                                    @endphp

                                    <div class="contact-inner" style="transform: translateY({{ $shiftDown }}px);">

                                        <span class="name" style="font-size: {{ $nameSize }}px;">
                                            {{ $name }}
                                        </span>

                                        <span class="company" style="font-size: {{ $companySize }}px;">
                                            {{ $company }}
                                        </span>

                                    </div>

                                </div>
                                <style>
                                    #qrimage {
                                        height: auto;
                                        width: 120px;
                                        display: block;
                                        margin: 0px auto 0 auto;
                                    }
                                </style>

                                <div style="text-align: center; ">

                                    <img id="qrimage"
                                        src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&color=170-35-36&bgcolor=255-255-255&data=BEGIN:VCARD%0AVERSION:3.0%0AFN:{{ urlencode($data['contactName']) }}%0AORG:{{ urlencode($data['companyName']) }}%0ATEL;TYPE=CELL:{{ $data['mobile'] }}%0AEMAIL:{{ urlencode($data['email']) }}%0ANOTE:Met at IITM Exhibition%0AEND:VCARD"
                                        alt="Contact QR">
                                </div>
                                <div class="events-section">
                                    <style>
                                        .events-section {
                                            width: 100%;
                                            color: #aa2324;
                                            /* Center the table within the div */
                                            display: flex;
                                            justify-content: center;
                                        }

                                        .events-section table {
                                            /* Adjust width to control how "spread out" the location and year are */
                                            width: 60%;
                                            border-collapse: collapse;
                                            color: #aa2324;
                                            font-family: "Playfair Display", "Georgia", serif;
                                            font-size: 12px;
                                            font-weight: 700;
                                            text-transform: uppercase;
                                            letter-spacing: 0.15em;
                                        }

                                        .events-section td {
                                            vertical-align: middle;
                                            padding: 8px 0;
                                            /* This ensures the content itself is treated as the center of the page */
                                            text-align: center;
                                        }

                                        .location-container {
                                            display: flex;
                                            justify-content: space-between;
                                            align-items: center;
                                            width: 100%;
                                            font-size: 15px;
                                        }
                                    </style>

                                    <table>
                                        <tr>
                                            <td>
                                                <!-- @php
                    $event = str_replace('iitm-', '', strtolower($data['eventname']));
                    $parts = explode('-', $event);
                    $year = end($parts);
                    array_pop($parts);
                    $location = ucfirst(implode(' ', $parts));
                @endphp -->

                                                @php
                                                    $raw = strtolower(trim($data['eventname'] ?? ''));

                                                    // normalize separators (spaces → hyphens)
                                                    $raw = preg_replace('/\s+/', '-', $raw);

                                                    // remove prefix safely
                                                    $raw = preg_replace('/^iitm-?/', '', $raw);

                                                    $parts = array_values(array_filter(explode('-', $raw)));

                                                    $year = '';
                                                    $locationParts = $parts;

                                                    // detect year safely
                                                    if (!empty($parts) && is_numeric(end($parts))) {
                                                        $year = array_pop($locationParts);
                                                    }

                                                    $location = !empty($locationParts)
                                                        ? ucwords(str_replace('-', ' ', implode(' ', $locationParts)))
                                                        : 'Unknown';
                                                @endphp

                                                <div class="location-container">
                                                    <span>{{ $location }}</span>
                                                    <span
                                                        style="flex-grow: 1; border-bottom: 1px solid rgba(170, 35, 36, 0.2); margin: 0 20px; height: 1px;"></span>
                                                    <span>{{ $year }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- <hr style="width:93%; height:1px; background-color:#aa2324; border:none; margin:6px auto;"> -->


                            <hr style="width:90%; height:1px; background-color:#aa2324; border:none; margin:6px auto;">


                            <span style="font-weight: bold;">TRADE VISITOR</span>

                        </div>

                    </div>

                </body>

                </html>




            </div>

            <div class="box">

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

                                This document serves as your access badge. Please keep it safe, as it will allow you to
                                enter the exhibition.
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
                            <div class="event-wrapper">

                                <style>
                                    .event-wrapper {
                                        width: 100%;
                                        font-family: "Playfair Display", "Georgia", serif;
                                        display: flex;
                                        justify-content: center;
                                    }

                                    .event-card {
                                        width: 100%;
                                        max-width: 600px;
                                        padding: 24px 0;
                                    }

                                    .event-card-body {
                                        display: flex;
                                        flex-direction: column;
                                        gap: 18px;
                                        text-align: center;
                                        align-items: center;
                                    }

                                    .event-name {
                                        font-size: 22px;
                                        font-weight: 700;
                                        color: #aa2324;
                                        text-transform: uppercase;
                                        letter-spacing: 0.04em;
                                        line-height: 1.2;
                                        margin: 0;
                                        text-align: center;
                                    }

                                    /* center meta row */
                                    .event-meta {
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        gap: 14px;
                                        flex-wrap: wrap;
                                    }

                                    .meta-venue-name {
                                        padding: 0px 10px;
                                        font-size: 15px;
                                        font-weight: 700;
                                        color: #aa2324;
                                        letter-spacing: 0.05em;
                                        text-transform: uppercase;
                                        margin: 0;
                                        text-align: center;
                                    }

                                    .meta-days {
                                        font-size: 18px;
                                        font-weight: 700;
                                        color: #aa2324;
                                        letter-spacing: 0.08em;
                                        margin: 0;
                                        text-align: center;
                                        text-transform: uppercase;
                                    }



                                    .meta-month {
                                        font-size: 18px;
                                        font-weight: 700;
                                        color: #aa2324;
                                        letter-spacing: 0.08em;
                                        margin: 0;
                                        text-align: center;
                                        text-transform: uppercase;
                                        opacity: 0.75;
                                    }

                                    .meta-days,
                                    .meta-month {
                                        font-size: 18px;
                                        font-weight: 500;
                                        color: #aa2324;
                                        margin: 0;
                                        text-align: center;
                                        letter-spacing: 0.02em;
                                        text-transform: uppercase;
                                    }
                                </style>

                                @php
                                    $days = [];
                                    $month = '';

                                    foreach ($data['all_dates'] as $d) {
                                        $days[] = \Carbon\Carbon::parse($d)->format('d');
                                        $month = \Carbon\Carbon::parse($d)->format('F');
                                    }
                                @endphp

                                <div class="event-card">

                                    <div class="event-card-body">

                                        <p class="event-name">
                                            {{ $data['eventname'] }}
                                        </p>

                                        <div class="event-meta">

                                            <p class="meta-venue-name">
                                                {{ $data['venue'] }}
                                            </p>

                                            <p class="meta-days">
                                                {{ implode(' · ', $days) }}
                                            </p>

                                            <p class="meta-month">
                                                {{ strtoupper($month) }}
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div
                                style="line-height:22px; font-family: Arial, sans-serif; text-align:left; padding-left:10px">
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



            </div>
        </div>
        <!-- Instruction Box Styles -->
        <style>
            #instructionbox {
                border: 1px solid #d1d5db;
                background: #f9fafb;
                border-radius: 8px;
                padding: 12px 16px;
                margin: 12px;
                font-size: 12px;
                font-family: Arial, sans-serif;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            }

            #instructionbox h4 {
                margin: 0 0 8px 0;
                font-size: 13px;
                color: #111827;
                text-align: center;
                letter-spacing: 0.5px;
            }

            #instructionbox ul {
                padding-left: 18px;
                margin: 0;
                line-height: 1.6;
                color: #374151;
            }

            #instructionbox li {
                margin-bottom: 4px;
            }

            #instructionbox .note {
                margin-top: 10px;
                padding: 8px;
                border-top: 1px solid #e5e7eb;
                font-size: 11px;
                color: #b91c1c;
                text-align: center;
                font-weight: bold;
            }
        </style>

        <!-- Instruction Box -->
        <div id="instructionbox">
            <h4>Visitor Instructions</h4>
            <ul>
                <li>Carry your badge at all times.</li>
                <li>The badge is non-transferable.</li>
                <li>Photography is allowed only in designated areas.</li>
                <li>Please maintain venue decorum.</li>
                <li>Entry rights are reserved by Team IITM.</li>
                <li>Please bring your business card.</li>
                <li>Submit your business card at the registration desk to verify your badge.</li>
            </ul>

            <div class="note">
                Note: This event is strictly for B2B attendees only. No general public entry. A business card is
                required for
                verification.
            </div>
        </div>

        <!-- <script>
function downloadPDF() {
    const element = document.querySelector("#badge");

    const opt = {
        margin: 0,
        filename: 'iitm-entry-badge.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: {
            scale: 2, // Start with 2 to ensure it works, increase to 4 once it's confirmed
            useCORS: true,
            allowTaint: true, // Helps with cross-origin images
            letterRendering: true,
            logging: true // Check console for errors if it's still blank
        },
        jsPDF: {
            unit: 'mm',
            format: 'a4',
            orientation: 'portrait'
        }
    };

    html2pdf().set(opt).from(element).save();
}

window.addEventListener("load", function () {
    // Check if the element exists and has content before running
    if(document.querySelector("#badge")) {
        setTimeout(downloadPDF, 2000); 
    }
});
</script> -->
</body>

</html>