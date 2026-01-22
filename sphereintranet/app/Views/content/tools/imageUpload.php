<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image for OCR</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        /* Form Styling */
        form {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
            width: 100%;
        }

        input[type="file"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Mobile View */
        @media (max-width: 600px) {
            form {
                padding: 15px;
            }

            input[type="submit"] {
                font-size: 14px;
            }
        }

        /* Success/Error message styling */
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .success {
            background-color: #4CAF50;
            color: white;
        }

        .error {
            background-color: #f44336;
            color: white;
        }

        /* Image display styling */
        .uploaded-image {
            margin-top: 20px;
        }

        .uploaded-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <!-- Display success or error message if present -->
    <?php if ($successMessage): ?>
        <div class="message success">
            <?= $successMessage ?>
        </div>
    <?php elseif ($errorMessage): ?>
        <div class="message error">
            <?= $errorMessage ?>
        </div>
    <?php endif; ?>

    <h2>Upload Image for OCR</h2>
    <form action="<?= site_url('tools/saveImage') ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="image" required>
        <br><br>
        <input type="submit" value="Upload & Convert">
    </form>

    <!-- Display the last uploaded image if available -->
    <?php if ($lastImage): ?>
        <div class="uploaded-image">
            <h3>Last Uploaded Image:</h3>
            <img src="<?= $lastImage ?>" alt="Last uploaded image">
        </div>
    <?php endif; ?>

</body>
</html>
