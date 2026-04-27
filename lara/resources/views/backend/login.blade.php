<!DOCTYPE html>
<html>

<head>
    <title>PIN Login</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            height: 100vh;
            background: url('https://iitmindia.com/assets/creatives/1.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }

        .login-box {
            position: relative;
            z-index: 2;
            background: rgba(17, 24, 39, 0.9);
            padding: 30px;
            border-radius: 12px;
            width: 320px;
            text-align: center;
            color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .logo {
            width: 120px;
            margin-bottom: 15px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: none;
            border-radius: 6px;
            text-align: center;
            font-size: 18px;
            letter-spacing: 3px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #2563eb;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #1d4ed8;
        }

        .error {
            color: #ff4d4d;
            margin-top: 10px;
            font-size: 13px;
        }

        .title {
            font-size: 18px;
            margin-bottom: 10px;
            color: #93c5fd;
        }
    </style>
</head>

<body>

    <div class="overlay"></div>

    <div class="login-box">

        <img src="https://iitmindia.com/assets/iitm3.png" class="logo">

        <div class="title">Enter Your PIN</div>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('backend.login') }}">
            @csrf

            <input type="password" name="pin" maxlength="6" placeholder="••••••" required>

            <button type="submit">Login</button>
        </form>

    </div>

</body>

</html>