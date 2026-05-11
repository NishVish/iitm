<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pin = $_POST['pin'];

    // In a real app, use password_verify(), but sticking to your logic for now!
    if ($pin === "abcd") {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_type'] = "admin";
        header("Location: index.php");
        exit;
    } else {
        $error = "Access Denied: Invalid Security PIN";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | IITM Admin</title>
    <style>
        :root {
            --iitm-red: #AA2D2C;
            --white: #ffffff;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Using a travel-themed gradient */
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&q=80&w=1200');
            background-size: cover;
            background-position: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 380px;
            text-align: center;
            border-top: 5px solid var(--iitm-red);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card img {
            height: 50px;
            margin-bottom: 20px;
        }

        h2 {
            margin: 0 0 10px;
            color: #333;
            font-size: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        p {
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .error-box {
            background: #ffebee;
            color: var(--iitm-red);
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            border: 1px solid rgba(170, 45, 44, 0.2);
        }

        input[type="password"] {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 2px solid #eee;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 1rem;
            text-align: center;
            letter-spacing: 5px;
            transition: border-color 0.3s;
        }

        input[type="password"]:focus {
            outline: none;
            border-color: var(--iitm-red);
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: var(--iitm-red);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            transition: background 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #8a2423;
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        .footer-text {
            margin-top: 25px;
            font-size: 0.75rem;
            color: #aaa;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <img src="https://iitmindia.com/assets/iitm3.png" alt="IITM Logo">
        <h2>Secure Access</h2>
        <p>Please enter your administration PIN</p>

        <?php if ($error): ?>
            <div class="error-box"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="password" name="pin" placeholder="••••" required autofocus>
            <button type="submit">Unlock System</button>
        </form>
        <a href="form.php">Register</a>

        <div class="footer-text">
            IITM Internal Network &copy; <?= date('Y') ?>
        </div>
    </div>

</body>

</html>