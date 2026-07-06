<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Big Iframe Page</title>

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        iframe {
            width: 100vw;
            /* full screen width */
            height: 100vh;
            /* full screen height */
            border: none;
            display: block;
        }
    </style>
</head>

<body>

    <body>

        <h1>Select a Form</h1>

        <ul>
            <li><a href="sanjay.php">Sanjay Form</a></li>
            <li><a href="dilip.php">Dilip Form</a></li>
            <li><a href="rohit.php">Rohit Form</a></li>
            <li><a href="usha.php">Usha Form</a></li>
            <li><a href="indira.php">Indira Form</a></li>
        </ul>

    </body>
    <?php

    include('../formex.php');

    ?>
</body>

</html>