<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        .page-content {
            display: flex;
            align-items: flex-start;
            width: 100%;
            min-height: calc(100vh - 60px);
            padding: 25px;
        }

        .dashboard-layout {
            display: flex;
            align-items: flex-start;
            width: 100%;
            gap: 20px;
        }

        .dashboard-left {
            width: 240px;
            flex: 0 0 240px;
            position: sticky;
            top: 20px;
        }

        .dashboard-middle {
            flex: 1;
            min-width: 0;
        }

        .dashboard-right {
            flex: 1;
            min-width: 0;
        }

        .deadline {
            width: 100%;
            padding: 14px 20px;
            margin-bottom: 20px;
            background: #fff8e1;
            border: 1px solid #ffe082;
            border-radius: 10px;
            color: #7a5a00;
            font-size: 14px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
        }

        .checklist {
            width: 100%;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
            padding: 25px;
        }

        .checklist h2 {
            margin: 0 0 20px;
            text-align: center;
            color: #333;
            font-size: 20px;
        }

        .info-box {
            width: 100%;
            background: #fff;
            padding: 20px;
            margin: 0 0 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
        }

        .info-box div {
            margin: 10px 0;
            color: #444;
        }

        .item {
            display: flex;
            align-items: center;
            margin: 12px 0;
            font-size: 16px;
            color: #444;
        }

        .item input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            accent-color: #4CAF50;
            cursor: pointer;
        }

        .item label {
            cursor: pointer;
            user-select: none;
        }

        .item input[type="checkbox"]:checked+label {
            text-decoration: line-through;
            color: #999;
        }

        @media (max-width: 1000px) {
            .dashboard-layout {
                flex-wrap: wrap;
            }

            .dashboard-left {
                width: 100%;
                flex: 0 0 100%;
                position: static;
            }

            .dashboard-middle,
            .dashboard-right {
                flex: 1 1 calc(50% - 10px);
            }
        }

        @media (max-width: 700px) {
            .page-content {
                padding: 15px;
            }

            .dashboard-layout {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }

            .dashboard-left,
            .dashboard-middle,
            .dashboard-right {
                width: 100%;
                flex: 0 0 100%;
            }
        }
    </style>

    @include("exhibitor.header")

    <div class="page-content">

        <div style="width:100%;">

            <div class="deadline">
                <strong>Deadline to Update the Details:</strong>
                30-08-2026
            </div>

            @php
                $lastsegment = request()->segment(count(request()->segments()));
            @endphp

            @if($lastsegment == "dashboard")
                @include('exhibitor.dashboard')
            @endif

        </div>

    </div>