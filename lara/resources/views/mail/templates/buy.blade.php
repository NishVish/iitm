<?php
$dir = __DIR__ . "/templates";
if (!file_exists($dir))
    mkdir($dir, 0777, true);

/* SAVE */
if (isset($_POST['save'])) {
    $name = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['name']);
    file_put_contents("$dir/$name.json", $_POST['design']);
    file_put_contents("$dir/$name.html", $_POST['html']);
    $msg = "Saved!";
}

/* LOAD */
$load = $_GET['load'] ?? "";
$design = "{}";
$viewHtml = "";

if ($load && file_exists("$dir/$load.json")) {
    $design = file_get_contents("$dir/$load.json");
}
if ($load && file_exists("$dir/$load.html")) {
    $viewHtml = file_get_contents("$dir/$load.html");
}

/* LIST */
$files = array_values(array_filter(scandir($dir), fn($f) => str_ends_with($f, ".json")));
?>

<!DOCTYPE html>
<html>

<head>
    <title>Template Builder</title>
    <script src="https://editor.unlayer.com/embed.js"></script>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            display: flex;
            height: 100vh;
        }

        #left {
            width: 260px;
            background: #111;
            color: white;
            padding: 10px;
            overflow: auto;
        }

        #main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        #editor {
            flex: 1;
        }

        .topbar {
            background: #222;
            color: white;
            padding: 10px;
        }

        button,
        input {
            padding: 6px;
            margin: 2px;
        }

        .item {
            background: #222;
            padding: 8px;
            margin: 5px 0;
        }

        .item a {
            color: #4fc3f7;
            text-decoration: none;
            display: block;
            margin-bottom: 5px;
        }

        .preview {
            background: #f5f5f5;
            padding: 10px;
            height: 200px;
            overflow: auto;
            border-top: 1px solid #ccc;
        }
    </style>
</head>

<body>

    <!-- LEFT PANEL -->
    <div id="left">
        <h3>Saved Templates</h3>

        <?php foreach ($files as $f): ?>
        <?php    $name = basename($f, ".json"); ?>

        <div class="item">
            <a href="?load=<?= $name ?>">✏️ Edit: <?= $name ?></a>

            <a href="?view=<?= $name ?>">👁️ View</a>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- MAIN -->
    <div id="main">

        <div class="topbar">
            <form method="POST" onsubmit="saveData()">
                Name:
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($load) ?>" required>

                <input type="hidden" name="design" id="design">
                <input type="hidden" name="html" id="html">

                <button type="submit" name="save">Save</button>
                <button type="button" onclick="preview()">Preview</button>

                <?php if (!empty($msg))
    echo "<span style='color:lightgreen'>$msg</span>"; ?>
            </form>
        </div>

        <div id="editor"></div>

        <!-- VIEW MODE -->
        <?php if (isset($_GET['view'])): ?>
        <div class="preview">
            <h3>Preview: <?= htmlspecialchars($_GET['view']) ?></h3>
            <?= $viewHtml ?>
        </div>
        <?php endif; ?>

    </div>

    <script>
        unlayer.init({
            id: 'editor',
            displayMode: 'email',
            design: <?= $design ?: '{}' ?>
        });

        /* SAVE DATA */
        function saveData() {
            unlayer.exportHtml(function (data) {
                document.getElementById("design").value = JSON.stringify(data.design);
                document.getElementById("html").value = data.html;
            });
        }

        /* PREVIEW */
        function preview() {
            unlayer.exportHtml(function (data) {
                alert("Preview below editor");
                console.log(data.html);
            });
        }
    </script>

</body>

</html>