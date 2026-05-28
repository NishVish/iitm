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
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: var(--iitm-bg);
            color: var(--iitm-dark);
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: var(--iitm-white);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        }

        h1 {
            font-size: 24px;
            font-weight: 800;
            color: var(--iitm-blue);
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .sub-header {
            font-size: 14px;
            color: #666;
            margin-bottom: 25px;
            display: block;
        }

        /* GRID LAYOUT */
        .btn-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
        }

        /* CARD STYLE BUTTONS */
        .big-btn {
            display: block;
            padding: 18px 16px;
            font-size: 14px;
            font-weight: 700;
            color: var(--iitm-dark);
            text-decoration: none;
            border-radius: 12px;
            background: #fff;
            border: 1px solid #e5e5e5;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
            transition: all 0.25s ease;
            position: relative;
        }

        .big-btn:hover {
            transform: translateY(-4px);
            border-color: var(--iitm-blue);
            color: var(--iitm-blue);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .big-btn::after {
            content: "›";
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #aaa;
        }

        .big-btn:hover::after {
            color: var(--iitm-blue);
        }

        /* ADMIN CARDS */
        .admin {
            background: linear-gradient(135deg, #2d3436, #1e272e);
            color: #fff !important;
            border: none;
        }

        .admin::after {
            color: #fff;
        }

        .admin:hover {
            background: linear-gradient(135deg, #0076bd, #005fa0);
            color: #fff !important;
        }

        /* OPS STYLE */
        .ops {
            background: #fff;
            border: 2px solid var(--iitm-blue);
            color: var(--iitm-blue);
        }

        .ops:hover {
            background: var(--iitm-blue);
            color: #fff;
        }

        .logout-btn {
            margin-top: 20px;
            background: transparent;
            border: none;
            color: #e74c3c;
            font-weight: 800;
            cursor: pointer;
            text-decoration: underline;
        }

        .footer-logo {
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 15px;
            font-size: 12px;
            color: #999;
            text-align: center;
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

            <a href="{{ url('admin') }}" class="big-btn admin">ADMINISTRATION</a>
            <a href="{{ url('database') }}" class="big-btn admin">DATABASE PORTAL</a>
            <a href="{{ url('highlightpage-edit') }}" class="big-btn admin">HIGHLIGHT EDIT</a>
            <a href="{{ url('sponsorship') }}" class="big-btn admin">SPONSORSHIP</a>

            <a href="{{ url('generatebadge/CMP_6a0171efbfa73/318339/iitm-bengaluru-2026') }}"
                class="big-btn admin">BADGE LAYOUT</a>

            <a href="http://localhost/iitm/lara/leadsdetails/33?mobile=7909075195" class="big-btn admin">LEADS EDIT</a>

            <a href="http://localhost/iitm/hr/" class="big-btn admin">HR PORTAL</a>

            <a href="{{ url('../central') }}" class="big-btn ops">OPERATIONS</a>
            <a href="{{ url('/') }}" class="big-btn ops">WEBSITE</a>

        </div>

        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button type="submit" class="logout-btn">SECURE LOGOUT</button>
        </form>

        <div class="footer-logo">
            IITM © 2026 | Travel & Trade Shows
        </div>

    </div>

    @include('backend.operation')

</body>

</html>