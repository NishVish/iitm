<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITM India - Portal Dashboard</title>
    <style>
        :root {
            --iitm-blue: #0076bd;
            --iitm-dark: #333333;
            --iitm-bg: #f8f9fa;
            --iitm-white: #ffffff;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif, Arial;
            background-color: var(--iitm-bg);
            color: var(--iitm-dark);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 500px;
            background: var(--iitm-white);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        /* IITM Branding Header */
        h1 {
            font-size: 24px;
            font-weight: 800;
            color: var(--iitm-blue);
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        .sub-header {
            font-size: 14px;
            color: #666;
            margin-bottom: 35px;
            display: block;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .big-btn {
            display: block;
            padding: 16px;
            font-size: 15px;
            font-weight: 700;
            color: var(--iitm-white);
            text-decoration: none;
            border-radius: 8px;
            background: var(--iitm-blue);
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 118, 189, 0.2);
        }

        .big-btn:hover {
            background: #005fa0;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 118, 189, 0.3);
        }

        /* Secondary style for "Website" and "Operations" */
        .ops {
            background: #ffffff;
            color: var(--iitm-blue);
            border: 2px solid var(--iitm-blue);
            box-shadow: none;
        }

        .ops:hover {
            background: var(--iitm-blue);
            color: #fff;
        }

        /* Admin style */
        .admin {
            background: #2d3436;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            margin-top: 30px;
            background: transparent;
            border: none;
            color: #e74c3c;
            font-weight: 800;
            font-size: 13px;
            cursor: pointer;
            text-decoration: underline;
            letter-spacing: 1px;
        }

        .logout-btn:hover {
            color: #c0392b;
        }

        /* Footer Decoration like the site */
        .footer-logo {
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
            font-size: 12px;
            font-weight: bold;
            color: #999;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>IITM INDIA</h1>
        <span class="sub-header">Internal Management Portal</span>

        <div class="btn-group">
            <a href="{{ url('salesportal') }}" class="big-btn">SALES PORTAL</a>
            <a href="{{ url('bookingportal') }}" class="big-btn">BOOKING PORTAL</a>
            <a href="{{ url('admin') }}" class="big-btn admin">ADMINSTRATION</a>
            <a href="{{ url('database') }}" class="big-btn admin">DATABASE PORTAL</a>
            <a href="{{ url('highlightpage-edit') }}" class="big-btn admin">Highlight Page Edit</a>
            <!-- badge Layout :  http://localhost/iitm/lara/generatebadge/CMP_6a0171efbfa73/318339/iitm-bengaluru-2026 -->
            <a href="{{ url('generatebadge/CMP_6a0171efbfa73/318339/iitm-bengaluru-2026') }}"
                class="big-btn admin">Badge
                Layout</a>
            <a href="http://localhost/iitm/lara/leadsdetails/33?mobile=7909075195" class="big-btn admin">Leads Edit</a>

            <a href="http://localhost/iitm/hr/" class="big-btn admin">HR Portal</a>
            <div style="display: flex; gap: 10px;">
                <a href="{{ url('../central') }}" class="big-btn ops" style="flex: 1;">OPERATIONS</a>
                <a href="{{ url('/') }}" class="big-btn ops" style="flex: 1;">WEBSITE</a>
            </div>

            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="logout-btn">SECURE LOGOUT</button>
            </form>
        </div>

        <div class="footer-logo">
            IITM &copy; 2026 | Travel & Trade Shows
        </div>
    </div>