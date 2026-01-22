<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <style>
        /* Reset some basics */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #888484ff; /* Dark background to highlight yellow & white */
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: white;
        }

        .login-container {
            background: #fff5ddff;
            max-width: 380px;
            width: 100%;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 50px 2000px 50px rgba(255, 220, 97, 0.5);
            text-align: center;
        }

        .logo {
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 24px;
            color: #f6c81a;
            font-weight: 700;
            letter-spacing: 1.2px;
        }

        form {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: white;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 20px;
            border: 1.8px solid #f6c81a;
            border-radius: 6px;
            font-size: 1rem;
            background: #222;
            color: white;
            transition: border-color 0.3s ease;
        }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: #ccc;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #f6c81a;
            outline: none;
            box-shadow: 0 0 8px #f6c81a;
            background: #1a1a1a;
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background-color: #f6c81a;
            border: none;
            border-radius: 6px;
            color: #121212;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #d1a71a;
        }

        hr {
            border: none;
            border-top: 1.5px solid #444;
            margin: 24px 0;
        }

        .flash-error {
            background-color: #ffebeb;
            color: #c00;
            border: 1px solid #c00;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 600;
            text-align: center;
            color: #121212;
            background: #f6c81a;
        }

        /* Login as test user button */
        .test-user-btn {
            width: 100%;
            padding: 14px;
            background-color: #f6c81a;
            border: none;
            border-radius: 6px;
            color: #121212;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .test-user-btn:hover {
            background-color: #d1a71a;
        }

        /* Responsive */
        @media (max-width: 420px) {
            .login-container {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img class="logo" src="https://spheretravelmedia.com/wp-content/uploads/2025/03/cropped-cropped-38x38inch-Sphere-Logo-Copy-min_prev_ui-300x100.png" alt="Company Logo" width="150" />

        <h2>Login</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <p class="flash-error"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>

        <form method="post" action="<?= site_url('login') ?>">

            <input type="password" id="password" name="password" required autofocus placeholder="Enter your password" />

            <button type="submit">Login</button>
        </form>

        <hr>

        <!-- Login as test user form -->
        <form method="post" action="<?= site_url('login') ?>">
            <input type="hidden" name="email" value="test@example.com" />
            <input type="hidden" name="password" value="123" />
            <button type="submit" class="test-user-btn">Login as Test User</button>
        </form>
    </div>
</body>
</html>
