<?php

$linksFile = "links.json";
$notesFile = "note.json";

/*
Expected format:

links.json
[
  {
    "title": "Google",
    "url": "https://google.com"
  }
]

note.json
{
  "note": "My notes here..."
}
*/

// Create files if they don't exist
if (!file_exists($linksFile)) {
    file_put_contents($linksFile, json_encode([], JSON_PRETTY_PRINT));
}

if (!file_exists($notesFile)) {
    file_put_contents($notesFile, json_encode([
        "note" => ""
    ], JSON_PRETTY_PRINT));
}

// Save form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Save links
    $titles = $_POST['title'] ?? [];
    $urls = $_POST['url'] ?? [];

    $links = [];

    for ($i = 0; $i < count($titles); $i++) {

        $title = trim($titles[$i]);
        $url = trim($urls[$i]);

        if ($title !== "" || $url !== "") {
            $links[] = [
                "title" => $title,
                "url" => $url
            ];
        }
    }

    file_put_contents(
        $linksFile,
        json_encode($links, JSON_PRETTY_PRINT)
    );

    // Save note
    $note = $_POST['note'] ?? "";

    file_put_contents(
        $notesFile,
        json_encode([
            "note" => $note
        ], JSON_PRETTY_PRINT)
    );

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Load data
$links = json_decode(file_get_contents($linksFile), true);
$notes = json_decode(file_get_contents($notesFile), true);

$noteText = $notes['note'] ?? "";

?>

<!DOCTYPE html>
<html>

<head>
    <title>Links & Notes Manager</title>

    <style>
        body {
            font-family: Arial;
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #f5f5f5;
        }

        h1 {
            margin-bottom: 10px;
        }

        .box {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        input[type=text],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        textarea {
            height: 200px;
        }

        .link-row {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            background: #fafafa;
        }

        button {
            padding: 10px 20px;
            border: none;
            background: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background: #0056b3;
        }

        .rendered-links a {
            display: block;
            margin-bottom: 8px;
            color: #007bff;
            text-decoration: none;
        }

        .rendered-links a:hover {
            text-decoration: underline;
        }
    </style>

    <script>
        function addLink() {

            const container = document.getElementById("links-container");

            const div = document.createElement("div");
            div.className = "link-row";

            div.innerHTML = `
                <label>Title</label>
                <input type="text" name="title[]">

                <label>URL</label>
                <input type="text" name="url[]">
            `;

            container.appendChild(div);
        }
    </script>
</head>

<body>

    <h1>Links & Notes Manager</h1>

    <form method="POST">

        <div class="box">

            <h2>Rendered Links</h2>

            <div class="rendered-links">
                <?php foreach ($links as $link): ?>
                    <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank">
                        <?= htmlspecialchars($link['title']) ?>
                    </a>
                <?php endforeach; ?>
            </div>

        </div>

        <div class="box">

            <h2>Edit Links</h2>

            <div id="links-container">

                <?php foreach ($links as $link): ?>

                    <div class="link-row">

                        <label>Title</label>
                        <input type="text" name="title[]" value="<?= htmlspecialchars($link['title']) ?>">

                        <label>URL</label>
                        <input type="text" name="url[]" value="<?= htmlspecialchars($link['url']) ?>">

                    </div>

                <?php endforeach; ?>

            </div>

            <button type="button" onclick="addLink()">
                Add Link
            </button>

        </div>

        <div class="box">

            <h2>Rendered Note</h2>

            <div style="white-space: pre-wrap;">
                <?= htmlspecialchars($noteText) ?>
            </div>

        </div>

        <div class="box">

            <h2>Edit Note</h2>

            <textarea name="note"><?= htmlspecialchars($noteText) ?></textarea>

        </div>

        <button type="submit">
            Save Everything
        </button>

    </form>

</body>

</html>