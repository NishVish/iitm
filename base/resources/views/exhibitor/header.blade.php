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


    <div class="top-header">

        <img class="logo" src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png">

        <!-- <div class="menu">

        <a href="#">Home</a>

        <a href="#">Booking</a>

        <a href="#">Details</a>

        <a href="#">Raise A Ticket</a>

        <a href="#">Info</a>

        <a href="#">Pending</a>

    </div> -->


        <div class="spacer"></div>


        <a href="#" class="logout">
            Logout
        </a>

    </div>


    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }


        .top-header {

            height: 60px;
            width: 100%;

            display: flex;
            align-items: center;

            background: white;

            border-bottom: 1px solid #ddd;

            padding: 0 20px;

            box-sizing: border-box;

        }


        .logo {

            height: 45px;

            width: auto;

            margin-right: 35px;

        }


        .menu {

            display: flex;

            align-items: center;

            gap: 25px;

        }


        .menu a {

            text-decoration: none;

            color: #333;

            font-size: 15px;

        }


        .menu a:hover {

            color: #0066cc;

        }


        .spacer {

            flex: 1;

        }


        .logout {

            background: #d9534f;

            color: white;

            text-decoration: none;

            padding: 8px 18px;

            border-radius: 4px;

            font-size: 15px;

        }


        .logout:hover {

            background: #c9302c;

        }
    </style>


    <style>
        .booking-layout {
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
            gap: 24px;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 24px;
            box-sizing: border-box;
        }

        .booking-sidebar {
            position: sticky;
            top: 20px;
            height: fit-content;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
        }

        .booking-sidebar-title {
            margin: 0 0 18px;
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        .booking-sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .booking-sidebar-nav a {
            display: block;
            padding: 11px 13px;
            border-radius: 8px;
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .booking-sidebar-nav a:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .booking-sidebar-nav a.active {
            background: #4f46e5;
            color: #ffffff;
        }

        .booking-main {
            min-width: 0;
        }

        .booking-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            padding: 18px 20px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
        }

        .booking-title {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }

        .booking-id {
            margin-top: 5px;
            font-size: 13px;
            color: #6b7280;
        }

        .open-booking-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 16px;
            background: #4f46e5;
            color: #ffffff;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        .open-booking-btn:hover {
            background: #4338ca;
            color: #ffffff;
        }

        .deadline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 20px;
            padding: 16px 20px;
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 12px;
            color: #9a3412;
        }

        .deadline-text {
            font-size: 14px;
        }

        .deadline-timer {
            font-weight: 700;
            color: #c2410c;
            white-space: nowrap;
        }

        @media (max-width: 900px) {
            .booking-layout {
                grid-template-columns: 1fr;
            }

            .booking-sidebar {
                position: static;
            }

            .booking-sidebar-nav {
                flex-direction: row;
                overflow-x: auto;
            }

            .booking-sidebar-nav a {
                white-space: nowrap;
            }
        }

        @media (max-width: 600px) {
            .booking-layout {
                padding: 12px;
                gap: 15px;
            }

            .booking-topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .open-booking-btn {
                width: 100%;
                justify-content: center;
            }

            .deadline {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <div class="page-content">

        <div class="booking-layout">

            <aside class="booking-sidebar">

                <h4 class="booking-sidebar-title">
                    Booking Details
                </h4>