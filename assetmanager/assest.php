<?php
$root = __DIR__ . '/assets';

if (!is_dir($root)) {
    mkdir($root, 0777, true);
}

function relPath($path, $root)
{
    return str_replace('\\', '/', ltrim(str_replace($root, '', $path), '/\\'));
}

function safePath($path, $root)
{
    $full = realpath(dirname($path));
    return $full && strpos($full, realpath($root)) === 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['new_folder'])) {
        $dir = $root . '/' . trim($_POST['parent']);
        $new = trim($_POST['new_folder']);

        if ($new) {
            @mkdir($dir . '/' . $new, 0777, true);
        }
    }

    if (isset($_FILES['image'])) {
        $dir = $root . '/' . trim($_POST['upload_dir']);

        if (is_dir($dir)) {
            foreach ($_FILES['image']['tmp_name'] as $k => $tmp) {
                if ($_FILES['image']['error'][$k] === 0) {
                    move_uploaded_file(
                        $tmp,
                        $dir . '/' . basename($_FILES['image']['name'][$k])
                    );
                }
            }
        }
    }

    if (isset($_POST['rename_old'], $_POST['rename_new'])) {
        $old = $root . '/' . $_POST['rename_old'];
        $new = dirname($old) . '/' . basename($_POST['rename_new']);

        if (file_exists($old)) {
            @rename($old, $new);
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET['delete'])) {
    $file = realpath($root . '/' . $_GET['delete']);

    if ($file && strpos($file, realpath($root)) === 0) {

        if (is_file($file)) {
            unlink($file);
        }

        if (is_dir($file)) {
            @rmdir($file);
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

function renderTree($dir, $root)
{
    $items = scandir($dir);

    echo '<ul>';

    foreach ($items as $item) {

        if ($item === '.' || $item === '..')
            continue;

        $path = $dir . '/' . $item;
        $rel = relPath($path, $root);

        if (is_dir($path)) {

            echo '<li>';
            echo '📁 <strong>' . htmlspecialchars($item) . '</strong> ';
            echo '<a href="?delete=' . urlencode($rel) . '" onclick="return confirm(\'Delete folder?\')">🗑️</a>';

            echo '
            <form method="post" style="display:inline">
                <input type="hidden" name="parent" value="' . htmlspecialchars($rel) . '">
                <input type="text" name="new_folder" placeholder="New Folder">
                <button>Create</button>
            </form>

            <form method="post" enctype="multipart/form-data" style="display:inline">
                <input type="hidden" name="upload_dir" value="' . htmlspecialchars($rel) . '">
                <input type="file" name="image[]" multiple>
                <button>Upload</button>
            </form>';

            renderTree($path, $root);

            echo '</li>';

        } else {

            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {

                echo '<li style="margin:5px 0">';
                echo '<img src="assets/' . $rel . '" style="width:80px;height:80px;object-fit:cover;vertical-align:middle;border:1px solid #ccc">';
                echo ' ' . htmlspecialchars($item);

                echo '
                <form method="post" style="display:inline">
                    <input type="hidden" name="rename_old" value="' . htmlspecialchars($rel) . '">
                    <input type="text" name="rename_new" placeholder="New Name">
                    <button>Rename</button>
                </form>

                <a href="?delete=' . urlencode($rel) . '" onclick="return confirm(\'Delete image?\')">🗑️</a>';

                echo '</li>';
            }
        }
    }

    echo '</ul>';
}

function gallery($dir, $root)
{
    $items = scandir($dir);

    foreach ($items as $item) {

        if ($item === '.' || $item === '..')
            continue;

        $path = $dir . '/' . $item;

        if (is_dir($path)) {
            gallery($path, $root);
            continue;
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {

            $rel = relPath($path, $root);

            echo '
            <div class="card">
                <a href="assets/' . $rel . '" target="_blank">
                    <img src="assets/' . $rel . '">
                </a>
                <div>' . $rel . '</div>
            </div>';
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Assets Manager</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 35%;
            overflow: auto;
            background: #fff;
            padding: 15px;
            border-right: 1px solid #ddd;
        }

        .content {
            width: 65%;
            overflow: auto;
            padding: 15px;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .card {
            width: 220px;
            background: #fff;
            padding: 10px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        ul {
            list-style: none;
            padding-left: 20px;
        }

        input[type=text] {
            padding: 4px;
        }

        button {
            padding: 4px 8px;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="sidebar">
            <h2>Assets Tree</h2>

            <form method="post">
                <input type="hidden" name="parent" value="">
                <input type="text" name="new_folder" placeholder="Root Folder">
                <button>Create</button>
            </form>

            <?php renderTree($root, $root); ?>
        </div>

        <div class="content">
            <h2>Image Gallery</h2>

            <div class="gallery">
                <?php gallery($root, $root); ?>
            </div>
        </div>

    </div>

</body>

</html>