<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PIN Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
            background: #ca9999; /* your deep red palette */
            color: #fff;
        }

        /* Logo */
        .logo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.1) rotate(5deg);
        }

        /* Form container */
        form {
            background: rgba(255, 255, 255, 0.15);
            padding: 30px 40px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 300px;
            transition: transform 0.3s ease;
        }

        form:hover {
            transform: scale(1.02);
        }

        /* Inputs */
        input[type="text"] {
            padding: 12px;
            width: 100%;
            border-radius: 12px;
            border: none;
            margin-bottom: 15px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
            background: rgb(255, 255, 255);
            color: #ffffff;
        }

        input[type="text"]::placeholder {
            color: #ff0000;
        }

        input[type="text"]:focus {
            background: rgba(255,255,255,0.3);
            box-shadow: 0 0 10px rgba(255,255,255,0.5);
        }

        /* Submit button */
        input[type="submit"] {
            padding: 12px;
            width: 100%;
            border-radius: 12px;
            border: none;
            background: #a82324;
            color: #fff;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        input[type="submit"]:hover {
            background: #8b1d20;
            transform: translateY(-3px);
        }

        @media(max-width: 400px) {
            form {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Company Logo -->
    <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Company Logo" class="logo">

    <!-- PIN input form -->
    <form method="post" action="<?=site_url('login')?>">
        <input type="text" name="pin" placeholder="Enter PIN" required>
        <input type="submit" value="Submit">
    </form>

</body>
</html>
