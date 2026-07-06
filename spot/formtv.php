<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trade Visitor Registration </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background-color: white;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        img.logo {
            display: block;
            max-width: 150px;
            margin: 0 auto 20px auto;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-top: 15px;
            color: #555;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background-color: #0073e6;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #005bb5;
        }
    </style>
</head>
<body>

<div class="container">
    <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM Logo" class="logo">
    <h2>Trade Visitor Form</h2>
    <form method="post" action="submittv.php">
        <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>

    <label for="designation">Designation:</label>
    <input type="text" name="designation" id="designation" required>

    <label for="company_name">Company Name:</label>
    <input type="text" name="company_name" id="company_name" required>

    <!--<label for="address">Address:</label>-->
    <!--<input type="text" name="address" id="address" required>-->

    <label for="city">City:</label>
    <input type="text" name="city" id="city" required>

    <!--<label for="pin">PIN:</label>-->
    <!--<input type="text" name="pin" id="pin" required>-->

    <!--<label for="state">State:</label>-->
    <!--<input type="text" name="state" id="state" required>-->

    <label for="mobile">Mobile:</label>
    <input type="text" name="mobile" id="mobile" placeholder="+91" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <br><br>
    <input type="submit" value="Submit">
    </form>
</div>

</body>
</html>
