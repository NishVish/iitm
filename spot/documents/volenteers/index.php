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
        // include('screeningdesk.php');
        include('registration.php');
        include('quiz.php');
        include('hostess.php');
        // include('settelments.php');
        // include('workflow.php');
        
        ?>

        <div style="height: 100px;"></div>
        <!-- 
        <table border="1" cellspacing="0" cellpadding="6" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th>Sl No.</th>
                    <th>Volunteer Name</th>
                    <th>Responsibility</th>
                    <th>Contact Number</th>
                    <th>Remarks / Info</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table> -->
        <div>

            <h2>Operations Checklist</h2>

            <table border="1" cellspacing="0" cellpadding="6" width="100%">
                <tr>
                    <th width="55%">Operation</th>
                    <th width="15%">Day 1</th>
                    <th width="15%">Day 2</th>
                    <th width="15%">Day 3</th>
                </tr>



                <tr>
                    <td colspan="4"><strong>Task 1 - Report On Time</strong></td>
                </tr>
                <tr>
                    <td>Follow up with volunteers to report at 9:00 AM</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Volunteers reported at 9:00 AM</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Prepare volunteer attendance sheet</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="4"><strong>Task 2 - Setup Desk</strong></td>
                </tr>
                <tr>
                    <td>Take out all materials from store room</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Verify tally count of systems and materials</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Complete laptop and printer setup</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Ensure materials are ready on desks</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Ready to distribute exhibitor badges</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Ready for badge printing</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Exhibitor entry starts at 10:00 AM</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Visitor entry starts at 11:00 AM</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="4"><strong>Task 3 - Lunch Break</strong></td>
                </tr>
                <tr>
                    <td>Lunch in rotation - Registration desk never unattended</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="4"><strong>Task 4/5 - Packup</strong></td>
                </tr>
                <tr>
                    <td>Packup starts at 6:00 PM</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Keep two systems ON</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Pack other materials</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Laptop, printer, cable & adapter packed</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Badges, lanyards & pouches packed</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Desk cleaned</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>6:00 PM - Complete backup</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Take feedback</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Leave after all work is completed</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

            </table>

        </div>

</body>

</html>