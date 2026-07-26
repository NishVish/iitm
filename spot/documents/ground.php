<?php

$responsibilities = [
    "Hostess Handling" => [
        "what_it_is" => "Managing all activities related to event hostesses before, during, and after the event.",
        "basic_info" => "Includes coordinating reporting time, attendance, grooming, dress code, briefing, duty allocation, break schedules, communication, issue resolution, and ensuring hostesses perform assigned responsibilities professionally throughout the event."
        ,
        "instructions" => ["Shortlist hostess during the Volenteer Breiefing", "make a sheet to track allotment by date, hostess name and stall number", "each moring of the exhibtion take singature of the concerned exhibitor for the hostess at the stall"],
    ],
    "Volunteer Handling" => [
        "what_it_is" => "Managing all activities related to event volunteers before, during, and after the event.",
        "basic_info" => "Helps with attendee management, logistics, setup, coordination, and task execution as assigned.",
        "instructions" => [
            "Give General Briefing",
            "divide team for hostess operations support and registation desk",
            "after dividing the team ask the team lead handover and maintain proper communication",
            "each Team Have to Maintan the Attendence and of the Team Member and sumbit it at the end of the day with review and changes",
            "on last day sumbit all data to process stipen of volunteers",
            "instruct the volenteer they can't go home or somewhere else with the permission of the coordinator"
        ]
    ],
    "Registration Desk" => [
        "what_it_is" => "The check-in point where attendees register and receive event materials.",
        "basic_info" => "Verifies registrations, handles on-site registrations, provides badges, schedules, and event information."
    ],
    "Badge Distribution" => [
        "what_it_is" => "The process of issuing attendee identification badges.",
        "basic_info" => "Ensures every participant receives the correct badge based on their registration category."
    ],
    "Certificate Distribution" => [
        "what_it_is" => "The process of handing out participation or achievement certificates.",
        "basic_info" => "Distributes certificates to eligible attendees after verification, usually at the end of the event."
    ],
    "Water Distribution" => [
        "what_it_is" => "Providing drinking water to attendees during the event.",
        "basic_info" => "Ensures water is available at designated locations and replenished throughout the event."
    ],
    "Bag Distribution" => [
        "what_it_is" => "The process of giving event kits or welcome bags to attendees.",
        "basic_info" => "Distributes branded bags containing event materials, promotional items, or merchandise."
    ],
    "Fascia" => [
        "what_it_is" => "Printed signage displaying branding or information on booths, registration counters, or stage areas.",
        "basic_info" => "Used for event branding, identification, and directional visibility."
    ],
    "Feedback" => [
        "what_it_is" => "Collection of attendee opinions and event experience.",
        "basic_info" => "Gathered through forms, QR codes, or digital surveys to evaluate event success and identify improvements."
    ],
    "Business Card Collection of Exhibitors" => [
        "what_it_is" => "Collecting business cards from exhibitors.",
        "basic_info" => "Used for maintaining contact records and lead generation."
    ],

    "Testimonial" => [
        "what_it_is" => "Recorded or written attendee feedback about the event.",
        "basic_info" => "Collected as video clips or written statements for future marketing and promotional use."
    ],
    "Extra Requirement" => [
        "what_it_is" => "Additional resources or services requested during the event.",
        "basic_info" => "May include extra staff, furniture, stationery, equipment, power supply, or other operational needs."
    ],
    "Branding" => [
        "what_it_is" => "Visual identity elements displayed throughout the event.",
        "basic_info" => "Includes banners, standees, backdrops, posters, digital displays, logos, and sponsor branding to maintain a consistent event identity."
    ]
];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Event Responsibilities</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #eee;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            height: auto;
            margin: 15px auto;
            padding: 15mm;
            background: #fff;
            page-break-after: always;
            break-after: page;
            position: relative;
            overflow: hidden;
        }

        h1 {
            margin: 0 0 10px;
            text-align: center;
            font-size: 26px;
            padding-bottom: 8px;
        }

        h2 {
            margin-top: 15px;
            margin-bottom: 5px;
            font-size: 18px;
        }

        p {
            font-size: 14px;
            line-height: 1.5;
            margin: 5px 0;
        }

        .instructions p {
            margin: 4px 0;
        }

        textarea {
            width: 100%;
            height: 80mm;
            resize: none;
            padding: 8px;
            font-size: 14px;
        }

        @media print {
            body {
                background: #fff;
            }

            .page {
                margin: 0;
                box-shadow: none;
            }
        }
    </style>

</head>

<body>

    <?php foreach ($responsibilities as $title => $responsibility): ?>

        <div class="page">

            <h1><?= htmlspecialchars($title) ?></h1>

            <!-- <h2>What it is</h2> -->
            <p><?= htmlspecialchars($responsibility['what_it_is']) ?></p>

            <h2>Basic Information</h2>
            <p><?= htmlspecialchars($responsibility['basic_info']) ?></p>

            <h2>Instructions</h2>


            <div class="instructions">
                <?php
                if (!empty($responsibility['instructions'])) {
                    foreach ($responsibility['instructions'] as $instruction) {
                        echo '<p>• ' . htmlspecialchars($instruction) . '</p>';
                    }
                }
                ?>
            </div>

            <textarea name="instruction[<?= htmlspecialchars($title) ?>]"></textarea>
        </div>

    <?php endforeach; ?>

</body>

</html>