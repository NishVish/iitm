<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IITM Directory</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { color: #2c3e50; }
        ul { list-style-type: none; padding-left: 0; }
        li { margin: 8px 0; }
        a { text-decoration: none; color: #2980b9; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>IITM Directory</h1>
    <ul>
        <?php
        // Read current directory
        $files = scandir(__DIR__);
        foreach ($files as $file) {
            if ($file === "." || $file === "..") continue;

            // Optional: skip this master.php file itself
            if ($file === basename(__FILE__)) continue;

            echo "<li><a href='" . htmlspecialchars($file) . "'>" . htmlspecialchars($file) . "</a></li>";
        }
        ?>
    </ul>
</body>
</html>