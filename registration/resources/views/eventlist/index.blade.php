<?php

$events = [

    [
        "year" => "2026",
        "name" => "IITM Delhi / NCR",
        "date" => "24, 25, 26 Sept 2026",
        "location" => "TBA",
        "time" => "TBA",
        "url" => "register/delhi-ncr/2026"
    ],

    [
        "year" => "2026",
        "name" => "IITM Mumbai",
        "date" => "29, 30, 31 Oct 2026",
        "location" => "TBA",
        "time" => "TBA",
        "url" => "register/mumbai/2026"
    ],

    [
        "year" => "2026",
        "name" => "IITM Pune",
        "date" => "26, 27, 28 Nov 2026",
        "location" => "TBA",
        "time" => "11:00 AM - 6:00 PM",
        "url" => "register/pune/2026"
    ],

    [
        "year" => "2026",
        "name" => "IITM Hyderabad",
        "date" => "03, 04, 05 Dec 2026",
        "location" => "TBA",
        "time" => "11:00 AM - 6:00 PM",
        "url" => "register/hyderabad/2026"
    ],

    [
        "year" => "2027",
        "name" => "IITM Kochi",
        "date" => "07, 08, 09 Jan 2027",
        "location" => "TBA",
        "time" => "11:00 AM - 6:00 PM",
        "url" => "register/kochi/2027"
    ],

    [
        "year" => "2027",
        "name" => "IITM Kolkata",
        "date" => "18, 19 Feb 2027",
        "location" => "TBA",
        "time" => "11:00 AM - 6:00 PM",
        "url" => "register/kolkata/2027"
    ],

    [
        "year" => "2027",
        "name" => "IITM Ahmedabad",
        "date" => "12 - 13 March 2027",
        "location" => "TBA",
        "time" => "11:00 AM - 6:00 PM",
        "url" => "register/ahmedabad/2027"
    ],

    [
        "year" => "2026",
        "name" => "IITM Chennai",
        "date" => "16, 17, 18 July 2026",
        "location" => "Convention Center, Chennai Trade Center, CTC Complex, Nandambakkam, Chennai – 600089",
        "time" => "11:00 AM - 6:00 PM",
        "status" => "Successfully Completed",
        "url" => "register/chennai/2026"
    ],

    [
        "year" => "2026",
        "name" => "IITM Bengaluru",
        "date" => "23, 24, 25 July 2026",
        "location" => "Gate No-2, TRIPURA VASINI, Palace Ground, Bengaluru – 560006, Karnataka",
        "time" => "11:00 AM - 6:00 PM",
        "status" => "Successfully Completed",
        "url" => "register/bengaluru/2026"
    ]

];

?>


<div style="
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
    gap:20px;
    padding:20px;
">

    <?php foreach ($events as $event) { ?>

    <div style="
    background:#ffffff;
    border-radius:16px;
    padding:25px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
">

        <div style="
        font-size:42px;
        font-weight:900;
        color:#0f766e;
        margin-bottom:10px;
    ">
            <?= $event['year']; ?>
        </div>


        <h2 style="
        color:#334155;
        margin:0 0 15px;
        text-transform:uppercase;
    ">
            <?= $event['name']; ?>
        </h2>


        <p>
            📅 <strong>Date:</strong><br>
            <?= $event['date']; ?>
        </p>


        <p>
            📍 <strong>Location:</strong><br>
            <?= $event['location']; ?>
        </p>


        <p>
            ⏰ <strong>Time:</strong><br>
            <?= $event['time']; ?>
        </p>


        <?php    if (isset($event['status'])) { ?>

        <p style="
            color:#16a34a;
            font-weight:bold;
        ">
            ✓ <?= $event['status']; ?>
        </p>

        <?php    } ?>


        <a href="<?= url($event['url']); ?>" style="
            display:inline-block;
            margin-top:15px;
            background:#0f766e;
            color:white;
            padding:12px 25px;
            border-radius:30px;
            text-decoration:none;
            font-weight:bold;
       ">
            Register Now →
        </a>


    </div>

    <?php } ?>

</div>