<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Volunteer Briefing</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            margin: 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
        }

        h1,
        h2 {
            color: #003366;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: top;
        }

        th {
            background: #003366;
            color: #fff;
        }

        ul {
            margin: 0;
            padding-left: 20px;
        }

        .workflow {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            line-height: 2;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">

        <?php
        include('intro.php');
        include('screeningdesk.php');
        include('registration.php');
        include('hostess.php');
        include('settelments.php');
        include('workflow.php');

        ?>

        <div>

            <h2>Volunteer Attendance & Duty Register</h2>

            <table>
                <tr>
                    <th width="12%">Day</th>
                    <th width="25%">Volunteer Name</th>
                    <th width="28%">Responsibility</th>
                    <th width="20%">Contact Number</th>
                    <th>Comments</th>
                </tr>

                <tr>
                    <td>Day 1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>Day 2</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>Day 3</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

            </table>

        </div>







    </div>

</body>

</html>