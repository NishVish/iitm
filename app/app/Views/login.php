<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PIN Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #F5F5F5; /* light Android background */
            color: #212121;
        }

        /* Logo */
        .logo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 40px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }

        /* Form container */
        form {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 320px;
            transition: all 0.3s ease;
        }

        form:hover {
            box-shadow: 0 12px 32px rgba(0,0,0,0.25);
        }

        /* Input fields */
        input[type="text"] {
            padding: 14px 16px;
            width: 100%;
            border-radius: 12px;
            border: 1px solid #BDBDBD;
            margin-bottom: 20px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
            color: #212121;
        }

        input[type="text"]::placeholder {
            color: #9E9E9E;
        }

        input[type="text"]:focus {
            border-color: #6200EE; /* Material purple accent */
            box-shadow: 0 0 8px rgba(98,0,238,0.3);
            background: #FAFAFA;
        }

        /* Submit button */
        input[type="submit"] {
            padding: 14px 16px;
            width: 100%;
            border-radius: 12px;
            border: none;
            background: #6200EE;
            color: #fff;
            font-weight: 500;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(98,0,238,0.4);
        }

        input[type="submit"]:hover {
            background: #3700B3;
            transform: translateY(-2px);
        }

        input[type="submit"]:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }

        /* Small subtitle */
        .subtitle {
            font-size: 14px;
            color: #616161;
            margin-bottom: 10px;
        }

        @media(max-width: 400px) {
            form {
                width: 90%;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Company Logo -->
    <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Company Logo" class="logo">

    <!-- Optional subtitle -->
    <div class="subtitle">Enter your 4-digit PIN to continue</div>

    <!-- PIN input form -->
    <form method="post" action="<?=site_url('login')?>">
        <input type="text" name="pin" placeholder="PIN" maxlength="4" required>
        <input type="submit" value="Login">
    </form>

</body>
</html>