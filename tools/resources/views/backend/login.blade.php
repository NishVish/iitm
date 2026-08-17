<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITM India | Secure Access</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            background: url('https://iitmindia.com/assets/creatives/1.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* Modern Glassmorphism Overlay */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(0, 118, 189, 0.2) 0%, rgba(0, 0, 0, 0.7) 100%);
            backdrop-filter: blur(3px);
        }

        .login-box {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px) saturate(180%);
            -webkit-backdrop-filter: blur(15px) saturate(180%);
            padding: 40px;
            border-radius: 24px;
            width: 360px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .logo {
            width: 140px;
            margin-bottom: 25px;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
        }

        .title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.9;
        }

        /* Minimalist Modern Input */
        input {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid transparent;
            border-radius: 12px;
            text-align: center;
            font-size: 24px;
            letter-spacing: 8px;
            color: #1e3a8a;
            outline: none;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06);
        }

        input:focus {
            border-color: #0076bd;
            transform: scale(1.02);
            background: #ffffff;
        }

        input::placeholder {
            letter-spacing: normal;
            font-size: 16px;
            color: #94a3b8;
        }

        /* IITM Blue Button */
        button {
            width: 100%;
            padding: 15px;
            margin-top: 20px;
            background: #0076bd;
            /* Brand Blue */
            border: none;
            color: white;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 15px -3px rgba(0, 118, 189, 0.4);
        }

        button:hover {
            background: #005fa0;
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 118, 189, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .error {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 13px;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .footer-note {
            margin-top: 25px;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<body>

    <div class="overlay"></div>

    <div class="login-box">
        <img src="https://iitmindia.com/assets/iitm2.png" class="logo" alt="IITM Logo">

        <div class="title">Secure Access</div>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('backend.login') }}">
            @csrf
            <input type="password" name="pin" maxlength="6" placeholder="ENTER PIN" required autocomplete="off">
            <button type="submit">Unlock Portal</button>
        </form>

        <div class="footer-note">
            &copy; 2026 IITM INDIA | Management System
        </div>
    </div>

</body>

</html>