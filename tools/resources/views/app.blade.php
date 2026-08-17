@php
    $segments = request()->segments();
    $segment = request()->segment(1) ?? 'home'; // Adjusted to 3 based on your previous output
@endphp

<!-- <div style="background: #222; color: #0f0; padding: 15px; font-family: monospace; border-radius: 8px; margin: 10px; line-height: 1.6;">
    <strong>🔍 Debugging All Segments:</strong><br>
    @foreach($segments as $index => $value)
        [{{ $index + 1 }}] => "{{ $value }}" <br>
    @endforeach
    <hr style="border: 0; border-top: 1px solid #444;">
    <strong>Current Logic Target ($segment):</strong> "{{ $segment }}"
</div> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Exhibitor Dashboard | IITM India</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #F8F9FA;
            color: #2D3436;
            padding-bottom: 90px;
        }

        /* --- Header Section --- */
        .header {
            background: #a82324;
            padding: 60px 24px 80px 24px;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            color: white;
            display: flex;
            gap:10px;
            align-items: center;
        }

        .user-info h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .user-info p {
            margin: 4px 0 0 0;
            opacity: 0.9;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 15px;
            padding: 5px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* --- Main Stats Card --- */
        .stats-container {
            padding: 0 20px;
            margin-top: -45px;
        }

        .stats-card {
            background: white;
            border-radius: 25px;
            padding: 25px 15px;
            display: flex;
            justify-content: space-around;
            box-shadow: 0 15px 35px rgba(168, 35, 36, 0.1);
            border: 1px solid rgba(168, 35, 36, 0.05);
        }

        .stat-item { text-align: center; flex: 1; }
        .stat-item:not(:last-child) { border-right: 1px solid #EEE; }

        .stat-value { display: block; font-weight: 700; font-size: 22px; color: #a82324; }
        .stat-label { font-size: 11px; color: #95a5a6; margin-top: 5px; font-weight: 700; text-transform: uppercase; }

        /* --- Grid Menu --- */
        .section-header {
            padding: 30px 24px 15px 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .section-title { margin: 0; font-size: 18px; font-weight: 700; color: #2C3E50; }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 columns look better for travel icons */
            gap: 15px;
            padding: 0 20px;
            padding-bottom:20px
        }

        .menu-item {
            background: white;
            padding: 25px 20px;
            border-radius: 25px;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* Left aligned like a pro app */
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            border: 1px solid #FFF;
            transition: all 0.2s;
        }

        .menu-item:active {
            background: #FDF2F2;
            border-color: #a82324;
            transform: translateY(2px);
        }

        .icon-box {
            width: 45px;
            height: 45px;
            background: rgba(168, 35, 36, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .icon-box span { color: #a82324; font-size: 26px; }

        .menu-label { font-size: 15px; font-weight: 700; color: #2D3436; }
        .menu-sub { font-size: 11px; color: #7F8C8D; margin-top: 2px; }

        /* --- Bottom Navigation --- */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: white;
            display: flex;
            justify-content: space-around;
            padding: 15px 0 25px 0; /* Extra padding for modern gesture bars */
            box-shadow: 0 -10px 30px rgba(0,0,0,0.05);
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
        }

        .nav-item { text-align: center; color: #BDC3C7; text-decoration: none; flex: 1; }
        .nav-item.active { color: #a82324; }
        .nav-item span { display: block; font-size: 10px; margin-top: 5px; font-weight: 700; }
    </style>
</head>
<body>
<!-- 
<div style="background: yellow; color: black; padding: 10px; border: 1px solid #000;">
    TEST PRINT: Current Segment is "{{ $segment }}"
</div> -->

{{-- Conditional content --}}
@if ($segment === 'calendar')
    @include('mobile.calendar')
@elseif ($segment === 'home' || $segment === null || $segment === '')


@include('mobile.header')

    @include('mobile.mainmenu')
@elseif ($segment === 'layout')
    @include('mobile.header')
    @include('mobile.layout')
@elseif ($segment === 'profile')
    @include('mobile.profile')
@elseif ($segment === 'register')
    @include('register.index')
@else
    <!-- <div style="color: red; padding: 20px;">
        DEBUG: No match found for segment "{{ $segment }}". 
        Check if your URL is exactly localhost/iitm/lara/home
    </div> -->
@endif

{{-- Footer --}}
@include('mobilefooter')

</body>
</html>

