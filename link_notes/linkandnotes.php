<?php
// Start a session to remember if the user is logged in
session_start();

$linksFile = "links.json";
$notesFile = "note.json";
define('ACCESS_PASSWORD', 'Sphere@245');

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Create files if they don't exist
if (!file_exists($linksFile)) {
    file_put_contents($linksFile, json_encode([], JSON_PRETTY_PRINT));
}
if (!file_exists($notesFile)) {
    file_put_contents($notesFile, json_encode(["note" => ""], JSON_PRETTY_PRINT));
}

$error = "";

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Case 1: User is trying to log in
    if (isset($_POST['login_password'])) {
        if ($_POST['login_password'] === ACCESS_PASSWORD) {
            $_SESSION['authenticated'] = true;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $error = "Incorrect password.";
        }
    }
    
    // Case 2: Logged-in user is saving data
    if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true && isset($_POST['action_save'])) {
        // Save links
        $titles = $_POST['title'] ?? [];
        $urls   = $_POST['url'] ?? [];
        $links  = [];

        for ($i = 0; $i < count($titles); $i++) {
            $title = trim($titles[$i]);
            $url   = trim($urls[$i]);

            if ($title !== "" || $url !== "") {
                if ($url !== "" && !preg_match("~^(?:f|ht)tps?://~i", $url)) {
                    $url = "http://" . $url;
                }
                $links[] = ["title" => $title, "url" => $url];
            }
        }
        file_put_contents($linksFile, json_encode($links, JSON_PRETTY_PRINT));

        // Save note
        $note = $_POST['note'] ?? "";
        file_put_contents($notesFile, json_encode(["note" => $note], JSON_PRETTY_PRINT));

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Load data ONLY if authenticated
$links = [];
$noteText = "";
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    $links    = json_decode(file_get_contents($linksFile), true) ?? [];
    $notes    = json_decode(file_get_contents($notesFile), true) ?? [];
    $noteText = $notes['note'] ?? "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Links & Notes Hub</title>
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --danger: #ef4444;
            --danger-hover: #dc2626;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg);
            color: var(--text-main);
            margin: 0;
            padding: 30px 20px;
        }

        .dashboard-container { max-width: 1100px; margin: 0 auto; }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            border-bottom: 2px solid var(--border);
            padding-bottom: 16px;
        }

        h1 { font-size: 24px; font-weight: 700; margin: 0; }
        h2 { font-size: 16px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 16px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px; }

        .header-actions { display: flex; align-items: center; gap: 12px; }

        .dashboard-grid { display: grid; grid-template-columns: 1fr; gap: 24px; }
        @media (min-width: 768px) { .dashboard-grid { grid-template-columns: 1.2fr 1fr; } }

        .box { background: var(--card-bg); padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); margin-bottom: 24px; }
        .input-group { display: flex; flex-direction: column; gap: 4px; width: 100%; }
        label { font-size: 12px; font-weight: 600; color: var(--text-muted); }

        input[type=text], input[type=password], textarea {
            width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 6px;
            font-size: 14px; color: var(--text-main); outline: none; box-sizing: border-box;
        }
        input:focus, textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15); }
        textarea { height: 180px; resize: vertical; line-height: 1.5; }

        .link-row { display: flex; gap: 12px; align-items: flex-end; padding: 12px; margin-bottom: 12px; border: 1px solid var(--border); border-radius: 6px; background: #fafafa; }
        .row-inputs { display: flex; flex-direction: column; gap: 10px; flex-grow: 1; }
        @media (min-width: 480px) { .row-inputs { flex-direction: row; } }

        .btn { display: inline-flex; align-items: center; justify-content: center; background: var(--primary); color: white; border: none; padding: 10px 16px; font-size: 14px; font-weight: 600; border-radius: 6px; cursor: pointer; }
        .btn:hover { background: var(--primary-hover); }
        .btn-secondary { background: transparent; border: 1px solid var(--border); color: var(--text-muted); }
        .btn-secondary:hover { background: #f1f5f9; color: var(--text-main); }
        .btn-danger { background: transparent; color: var(--danger); border: 1px solid #fee2e2; padding: 8px 12px; font-size: 13px; border-radius: 6px; cursor: pointer; }
        .btn-danger:hover { background: var(--danger); color: white; border-color: var(--danger); }

        .rendered-links { display: flex; flex-direction: column; gap: 8px; }
        .rendered-links a { display: inline-flex; color: var(--primary); text-decoration: none; font-weight: 500; padding: 6px 10px; background: #eff6ff; border-radius: 4px; width: fit-content; }
        .rendered-links a:hover { background: #dbeafe; }

        .empty-state { color: var(--text-muted); font-style: italic; font-size: 14px; }
        .note-preview { white-space: pre-wrap; background: #f8fafc; padding: 12px; border-radius: 6px; border-left: 4px solid var(--border); font-size: 14px; line-height: 1.6; }

        /* Login screen styling */
        .login-box { max-width: 360px; margin: 100px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid var(--border); }
        .error-msg { color: var(--danger); font-size: 13px; margin-bottom: 12px; font-weight: 500; }
    </style>
</head>
<body>

<?php if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true): ?>
    
    <div class="login-box">
        <h2 style="border:none; margin-bottom: 8px; padding:0; text-transform:none; font-size:20px; color:var(--text-main);">Protected Workspace</h2>
        <p style="color:var(--text-muted); font-size:14px; margin-top:0; margin-bottom:20px;">Please enter your password to access dashboard.</p>
        
        <?php if ($error): ?>
            <div class="error-msg"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group" style="margin-bottom: 16px;">
                <label for="login_password">Password</label>
                <input type="password" id="login_password" name="login_password" required autofocus placeholder="••••••••">
            </div>
            <button type="submit" class="btn" style="width: 100%;">Unlock Dashboard</button>
        </form>
    </div>

<?php else: ?>

    <div class="dashboard-container">
        <form method="POST">
            <input type="hidden" name="action_save" value="1">
            <header>
                <h1>Links & Notes Workspace</h1>
                
                <div class="header-actions">
                    <a href="?logout=1" class="btn btn-secondary" style="text-decoration: none;">Logout</a>
                    <button type="submit" class="btn">Save Everything</button>
                </div>
            </header>

            <div class="dashboard-grid">
                <div class="column">
                    <div class="box">
                        <h2>Live Directory</h2>
                        <div class="rendered-links">
                            <?php if (empty($links)): ?>
                                <span class="empty-state">No shortcut links available.</span>
                            <?php else: ?>
                                <?php foreach ($links as $link): ?>
                                    <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank">
                                        <?= htmlspecialchars($link['title'] ?: $link['url']) ?> &rarr;
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="box">
                        <h2>Manage Bookmarks</h2>
                        <div id="links-container">
                            <?php foreach ($links as $link): ?>
                                <div class="link-row">
                                    <div class="row-inputs">
                                        <div class="input-group">
                                            <label>Title</label>
                                            <input type="text" name="title[]" value="<?= htmlspecialchars($link['title']) ?>">
                                        </div>
                                        <div class="input-group">
                                            <label>URL</label>
                                            <input type="text" name="url[]" value="<?= htmlspecialchars($link['url']) ?>">
                                        </div>
                                    </div>
                                    <button type="button" class="btn-danger" onclick="this.closest('.link-row').remove()">Remove</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-secondary" style="margin-top: 8px;" onclick="addLink()">+ Add New Link</button>
                    </div>
                </div>

                <div class="column">
                    <div class="box">
                        <h2>Active Clipboard View</h2>
                        <?php if (trim($noteText) === ""): ?>
                            <span class="empty-state">Your scratchpad is empty.</span>
                        <?php else: ?>
                            <div class="note-preview"><?= htmlspecialchars($noteText) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="box">
                        <h2>Edit Scratchpad</h2>
                        <textarea name="note" placeholder="Type or paste quick notes here..."><?= htmlspecialchars($noteText) ?></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function addLink() {
            const container = document.getElementById("links-container");
            const div = document.createElement("div");
            div.className = "link-row";
            div.innerHTML = `
                <div class="row-inputs">
                    <div class="input-group">
                        <label>Title</label>
                        <input type="text" name="title[]" placeholder="e.g. GitHub">
                    </div>
                    <div class="input-group">
                        <label>URL</label>
                        <input type="text" name="url[]" placeholder="google.com">
                    </div>
                </div>
                <button type="button" class="btn-danger" onclick="this.closest('.link-row').remove()">Remove</button>
            `;
            container.appendChild(div);
        }
    </script>

<?php endif; ?>

</body>
</html>