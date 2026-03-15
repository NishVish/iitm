<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | IITM India</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Base Reset */
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        html, body { margin: 0; padding: 0; font-family: 'Roboto', Arial, sans-serif; height: 100%; background: #F5F7FA; color: #2D3436; }
        .page-wrapper { display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 100vh; width: 100%; padding: 24px; }
        .container { width: 100%; max-width: 350px; background: #ffffff; border-radius: 28px; box-shadow: 0 12px 40px rgba(0,0,0,0.06); padding: 40px 24px; text-align: center; animation: slideUp 0.6s ease-out; }
        .logo { width: 85px; height: 85px; border-radius: 50%; object-fit: contain; margin-bottom: 16px; }
        .header-section { margin-bottom: 28px; }
        .title { font-size: 22px; font-weight: 700; margin: 0 0 8px 0; color: #1A1A1A; }
        .subtitle { font-size: 14px; color: #7F8C8D; margin: 0; }
        .input-group { margin-bottom: 16px; text-align: left; }
        input[type="email"], input[type="password"] { width: 100%; padding: 16px; border-radius: 16px; font-size: 16px; border: 2px solid #F1F3F5; background: #F8F9FA; transition: all 0.2s ease; outline: none; color: #2D3436; }
        input:focus { border-color: #6200EE; background: #fff; box-shadow: 0 0 0 4px rgba(98, 0, 238, 0.08); }
        .forgot-row { display: flex; justify-content: flex-end; margin-top: -8px; margin-bottom: 24px; }
        .forgot-link { font-size: 13px; color: #6200EE; text-decoration: none; font-weight: 500; padding: 8px 0; }
        .primary-btn { width: 100%; padding: 16px; border: none; background: #6200EE; color: #fff; font-size: 16px; font-weight: 700; border-radius: 16px; cursor: pointer; box-shadow: 0 6px 20px rgba(98, 0, 238, 0.25); transition: all 0.2s; margin-bottom: 24px; }
        .primary-btn:active { transform: scale(0.97); background: #4B00D1; }
        .divider { display: flex; align-items: center; margin-bottom: 24px; color: #BDC3C7; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }
        .divider::before, .divider::after { content: ""; flex: 1; height: 1px; background: #EDF2F7; }
        .divider span { padding: 0 15px; }
        .secondary-btn { display: block; width: 100%; padding: 14px; border: 2px solid #E2E8F0; background: transparent; color: #4A5568; font-size: 14px; font-weight: 700; border-radius: 16px; text-decoration: none; transition: all 0.2s; text-align: center; }
        .secondary-btn:active { background: #F7FAFC; border-color: #CBD5E0; transform: scale(0.98); }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
<div class="page-wrapper">
    <div class="container">
        <img class="logo" src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM India Logo">
        
        <div class="header-section">
            <h1 class="title">Secure Login</h1>
            <p class="subtitle">Enter your email and password to login</p>
        </div>

        {{-- Flash Error Message --}}
        @if(session('error'))
            <div style="background: #FFE3E3; color: #D63031; padding: 12px; border-radius: 12px; margin-bottom: 20px; font-size: 13px;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="primary-btn">Login</button>
        </form>

        <div class="divider"><span>New here?</span></div>
        <a href="{{ url('register') }}" class="secondary-btn">Create an Account</a>
    </div>
</div>
</body>
</html>