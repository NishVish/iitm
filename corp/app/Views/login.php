<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Access Key | Sphere Travelmedia</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            height: 100%;
            background: #F8F9FA;
            color: #2D3436;
            overflow: hidden;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 24px;
        }

        .container {
            width: 100%;
            max-width: 340px;
            background: #ffffff;
            border-radius: 30px;
            box-shadow: 0 15px 45px rgba(168, 35, 36, 0.1);
            padding: 45px 25px;
            text-align: center;
            position: relative;
            animation: fadeIn 0.8s ease-out;
        }

        /* The Pulse Effect using your Yellow #f7c41b */
        .pulse-container {
            position: relative;
            display: inline-block;
            margin-bottom: 30px;
        }

        .pulse-circle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80px;
            height: 80px;
            background: #f7c41b; /* Your Yellow */
            border-radius: 50%;
            opacity: 0.3;
            animation: pulse-wave 2s infinite;
            z-index: 1;
        }

        .logo {
            width: 140px;
            position: relative;
            z-index: 2;
        }

        .title {
            font-size: 20px;
            font-weight: 700;
            color: #1A1A1A;
            margin: 0 0 10px 0;
        }

        .subtitle {
            font-size: 14px;
            color: #7F8C8D;
            margin-bottom: 30px;
        }

        /* Password Input Styling */
        input[type="password"] {
            width: 100%;
            padding: 18px;
            margin-bottom: 20px;
            border-radius: 16px;
            font-size: 18px;
            text-align: center;
            letter-spacing: 4px;
            border: 2px solid #F1F3F5;
            background: #F8F9FA;
            transition: all 0.3s ease;
            outline: none;
        }

        input[type="password"]:focus {
            border-color: #f7c41b; /* Sphere Red */
            background: #fff;
            box-shadow: 0 0 0 4px rgba(168, 35, 36, 0.1);
        }

        /* Access Button */
        .access-btn {
            width: 100%;
            padding: 16px;
            border: none;
            background: #f7c41b; /* Sphere Red */
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            border-radius: 16px;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(168, 35, 36, 0.25);
            transition: all 0.2s;
        }

        .access-btn:active {
            transform: scale(0.97);
            background: #8b1c1d;
        }

        /* Bottom Support Link */
        .support-link {
            display: block;
            margin-top: 25px;
            font-size: 13px;
            color: #7F8C8D;
            text-decoration: none;
        }

        .support-link span {
            color: #f7c41b;
            font-weight: 700;
        }

        /* Animations */
        @keyframes pulse-wave {
            0% { transform: translate(-50%, -50%) scale(1); opacity: 0.4; }
            100% { transform: translate(-50%, -50%) scale(2); opacity: 0; }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="container">
        
        <div class="pulse-container">
            <div class="pulse-circle"></div>
            <img class="logo" src="https://spheretravelmedia.com/wp-content/uploads/2025/03/cropped-cropped-38x38inch-Sphere-Logo-Copy-min_prev_ui-300x100.png" alt="Logo">
        </div>

        <div class="header-section">
            <h1 class="title">Secure Access</h1>
            <p class="subtitle">Enter your Exhibition Access Key</p>
        </div>
        
        <form method="post" action="<?=site_url('login')?>">
            <input 
                type="password" 
                name="password" 
                placeholder="••••••••" 
                required
            >
            
            <button type="submit" class="access-btn">Unlock Dashboard</button>
        </form>

        <a href="#" class="support-link">Forgot Key? Contact <span>Sphere Support</span></a>
    </div>
</div>

</body>
</html>