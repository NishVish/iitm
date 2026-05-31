<?php
$dir = __DIR__ . "/templates";

$name = $_GET['name'] ?? "";

$file = "$dir/$name.html";

$html = file_exists($file) ? file_get_contents($file) : "Template not found";
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Template</title>
</head>

<body>

    <h2>Viewing:
        <?= htmlspecialchars($name) ?>
    </h2>

    <a href="template_builder.php">⬅ Back to Editor</a>

    <hr>

    <div style="border:1px solid #ccc; padding:20px;">
        <?= $html ?>
    </div>

</body>

</html>