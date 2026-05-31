<?php
$dir = __DIR__ . "/templates";
if (!file_exists($dir))
    mkdir($dir, 0777, true);

/* SAVE */
if (isset($_POST['save'])) {
    $name = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['name']);
    file_put_contents("$dir/$name.json", $_POST['design']);
    file_put_contents("$dir/$name.html", $_POST['html']);
}

/* LOAD FOR EDIT */
$load = $_GET['load'] ?? "";
$design = "{}";

if ($load && file_exists("$dir/$load.json")) {
    $design = file_get_contents("$dir/$load.json");
}

/* LIST */
$files = array_values(array_filter(scandir($dir), fn($f) => str_ends_with($f, ".json")));
?>

<!DOCTYPE html>
<html>

<head>
    <title>Editor</title>
    <script src="https://editor.unlayer.com/embed.js"></script>
</head>

<body>

    <h3>Template Editor</h3>

    <!-- LIST -->
    <h4>Saved Templates</h4>
    <?php foreach ($files as $f): ?>
        <?php $name = basename($f, ".json"); ?>
        <div>
            ✏️ <a href="?load=<?= $name ?>">Edit</a>
            👁️ <a href="view.php?name=<?= $name ?>">View</a>
        </div>
    <?php endforeach; ?>

    <hr>

    <form method="POST" onsubmit="saveData()">
        Name: <input type="text" name="name" id="name" value="<?= $load ?>" required>

        <input type="hidden" name="design" id="design">
        <input type="hidden" name="html" id="html">

        <button type="submit" name="save">Save</button>
    </form>

    <div id="editor" style="height:80vh;"></div>

    <script>
        unlayer.init({
            id: 'editor',
            displayMode: 'email',
            design: <?= $design ?: '{}' ?>
        });

        function saveData() {
            unlayer.exportHtml(function (data) {
                document.getElementById("design").value = JSON.stringify(data.design);
                document.getElementById("html").value = data.html;
            });
        }
    </script>

</body>

</html>