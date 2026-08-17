<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KPI Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #1e3a5f;
            margin-bottom: 30px;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .card h2 {
            margin: 0;
            font-size: 18px;
            color: #555;
        }

        .score {
            font-size: 42px;
            font-weight: bold;
            margin-top: 10px;
            color: #0b74de;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        th {
            background: #0b74de;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        tr:hover {
            background: #f1f7ff;
        }

        .done {
            color: green;
            font-weight: bold;
        }

        .pending {
            color: red;
            font-weight: bold;
        }

        .progress-bar {
            width: 100%;
            background: #ddd;
            border-radius: 20px;
            overflow: hidden;
            height: 18px;
        }

        .progress {
            height: 100%;
            background: #0b74de;
            text-align: center;
            color: white;
            font-size: 12px;
            line-height: 18px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>

    <h1>KPI Dashboard</h1>

    <div class="dashboard">

        <div class="card">
            <h2>Task Completion KPI</h2>
            <div class="score">60%</div>
        </div>

        <div class="card">
            <h2>Website KPI</h2>
            <div class="score">66.7%</div>
        </div>

        <div class="card">
            <h2>Data KPI</h2>
            <div class="score">75%</div>
        </div>

        <div class="card">
            <h2>Overall KPI</h2>
            <div class="score">68.26%</div>
        </div>

    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Task</th>
                <th>Status</th>
                <th>Completion</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td>27-Apr-2026</td>
                <td>Data Collection</td>
                <td>Collect Himachal Data</td>
                <td class="done">Done</td>
                <td>
                    <div class="progress-bar">
                        <div class="progress" style="width:100%">100%</div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>04-May-2026</td>
                <td>Website</td>
                <td>Registration Module</td>
                <td class="done">Done</td>
                <td>
                    <div class="progress-bar">
                        <div class="progress" style="width:100%">100%</div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>08-May-2026</td>
                <td>Website</td>
                <td>Remove 3D Stall Section</td>
                <td class="pending">Pending</td>
                <td>
                    <div class="progress-bar">
                        <div class="progress" style="width:40%">40%</div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>14-May-2026</td>
                <td>Creative</td>
                <td>Gallery Images Upload</td>
                <td class="pending">Pending</td>
                <td>
                    <div class="progress-bar">
                        <div class="progress" style="width:30%">30%</div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>18-May-2026</td>
                <td>Module</td>
                <td>FTP Server Setup</td>
                <td>In Progress</td>
                <td>
                    <div class="progress-bar">
                        <div class="progress" style="width:70%">70%</div>
                    </div>
                </td>
            </tr>

        </tbody>
    </table>

    <div class="footer">
        KPI Tracking System © 2026
    </div>

</body>

</html>