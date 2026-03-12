<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PIN Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent; /* Removes blue highlight on tap */
        }

        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', Arial, sans-serif;
            height: 100%;
            background: #F5F7FA;
            overflow: hidden; /* Prevents accidental scrolling */
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            padding: 24px;
        }

        .container {
            width: 100%;
            max-width: 340px;
            background: #ffffff;
            border-radius: 24px; /* Softer corners for modern mobile feel */
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 40px 30px;
            text-align: center;
        }

        .logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: contain;
            margin-bottom: 24px;
            /* Simple pulse animation to feel alive */
            animation: fadeIn 0.8s ease-out;
        }

        .subtitle {
            font-size: 16px;
            font-weight: 500;
            color: #424242;
            margin-bottom: 30px;
        }

        /* Input styling */
        input[type="tel"] {
            width: 100%;
            padding: 16px;
            margin-bottom: 20px;
            border-radius: 14px;
            font-size: 24px; /* Larger font for PIN visibility */
            letter-spacing: 8px; /* Space between PIN digits */
            text-align: center;
            border: 2px solid #E0E0E0;
            background: #FAFAFA;
            transition: border-color 0.2s;
            outline: none;
        }

        input[type="tel"]:focus {
            border-color: #6200EE;
            background: #fff;
        }

        input[type="submit"] {
            width: 100%;
            padding: 16px;
            border: none;
            background: #6200EE;
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            border-radius: 14px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(98, 0, 238, 0.3);
            transition: transform 0.1s, background 0.2s;
        }

        /* Mobile specific feedback when button is pressed */
        input[type="submit"]:active {
            transform: scale(0.98);
            background: #4B00D1;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="container">
        <img class="logo" src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Logo">
        
        <div class="subtitle">Secure PIN Login</div>
        
        <form method="post" action="<?=site_url('login')?>">
            <input 
                type="tel" 
                name="pin" 
                placeholder="••••" 
                maxlength="4" 
                pattern="[0-9]*" 
                inputmode="numeric" 
                autocomplete="one-time-code"
                required
            >
            
            <input type="submit" value="Sign In">
        </form>
    </div>
</div>

</body>
</html>