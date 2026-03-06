<?php
session_start();

// ==== CONFIG ====
$password = 'nin'; // Change this to your secret password
$baseDir = __DIR__;
$bookmarksFile = __DIR__ . '/.bookmarks.json'; // stores bookmarks
// =================
// Load bookmarks (always an array)
$bookmarks = [];
if (file_exists($bookmarksFile)) {
    $bookmarks = json_decode(file_get_contents($bookmarksFile), true);
    if (!is_array($bookmarks)) $bookmarks = []; // safety check
}
// ==== SAVE BOOKMARK & ADD LINK TO master.php ====
if (isset($_GET['bookmark'])) {
    $file = safePath($_GET['bookmark'], $baseDir);
    if ($file) {
        // Add to bookmarks file
        if (!in_array($file, $bookmarks)) {
            $bookmarks[] = $file;
            file_put_contents($bookmarksFile, json_encode($bookmarks));
        }

        // Add link to master.php
        $masterFile = $baseDir . '/master.php';
        $relPath = trim(str_replace($baseDir . '/', '', $file), '/');

        if (file_exists($masterFile)) {
            $linkHtml = "<p><a href='" . htmlspecialchars($relPath) . "'>" . basename($file) . "</a></p>\n";
            
            // Only add if link not already in master.php
            $masterContent = file_get_contents($masterFile);
            if (strpos($masterContent, $relPath) === false) {
                file_put_contents($masterFile, $masterContent . "\n" . $linkHtml);
            }
        }
    }
    header("Location: file_manager_secure.php");
    exit;
}

// ==== PASSWORD CHECK ====
if (!isset($_SESSION['authenticated'])) {
    if (isset($_POST['password'])) {
        if ($_POST['password'] === $password) {
            $_SESSION['authenticated'] = true;
        } else {
            $error = "Incorrect password!";
        }
    }

    if (!isset($_SESSION['authenticated'])) {
        // Show password form
        ?>
        <h2>Enter Password to Access File Manager</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post">
            <input type="password" name="password" placeholder="Password">
            <button type="submit">Login</button>
        </form>
        <?php
        exit;
    }
}

// ==== HELPERS ====
function safePath($path, $baseDir) {
    $real = realpath($baseDir . '/' . $path);
    return ($real && strpos($real, $baseDir) === 0) ? $real : false;
}

// Load bookmarks
$bookmarks = file_exists($bookmarksFile) ? json_decode(file_get_contents($bookmarksFile), true) : [];

// ==== SAVE BOOKMARK ====
if (isset($_GET['bookmark'])) {
    $file = safePath($_GET['bookmark'], $baseDir);
    if ($file && !in_array($file, $bookmarks)) {
        $bookmarks[] = $file;
        file_put_contents($bookmarksFile, json_encode($bookmarks));
    }
    header("Location: file_manager_secure.php");
    exit;
}

// ==== REMOVE BOOKMARK ====
if (isset($_GET['remove_bookmark'])) {
    $file = safePath($_GET['remove_bookmark'], $baseDir);
    if ($file) {
        $bookmarks = array_filter($bookmarks, fn($b) => $b !== $file);
        file_put_contents($bookmarksFile, json_encode(array_values($bookmarks)));
    }
    header("Location: file_manager_secure.php");
    exit;
}

// ==== SAVE FILE ====
if (isset($_POST['file']) && isset($_POST['content'])) {
    $file = safePath($_POST['file'], $baseDir);
    if ($file) {
        file_put_contents($file, $_POST['content']);
        echo "<p style='color:green;'>Saved!</p>";
    }
}

// ==== EDIT FILE ====
if (isset($_GET['edit'])) {
    $file = safePath($_GET['edit'], $baseDir);
    if ($file) {
        $content = htmlspecialchars(file_get_contents($file));
        ?>
        <h2>Editing: <?php echo $file; ?></h2>
        <form method="post">
            <input type="hidden" name="file" value="<?php echo $file; ?>">
            <textarea name="content" style="width:100%;height:500px;font-family:monospace;"><?php echo $content; ?></textarea><br><br>
            <button type="submit">Save File</button>
        </form>
        <br>
        <a href="file_manager_secure.php">Back</a>
        <?php
        exit;
    }
}

// ==== SHOW DIRECTORY ====
$path = isset($_GET['path']) ? safePath($_GET['path'], $baseDir) : $baseDir;
$files = scandir($path);
?>

<h2>File Manager</h2>
<p><a href="?logout=1">Logout</a></p>

<?php if(!empty($bookmarks)): ?>
<h3>Bookmarks</h3>
<ul>
    <?php foreach($bookmarks as $bm): 
        $rel = trim(str_replace($baseDir, '', $bm), '/');
    ?>
    <li>📄 <a href="?edit=<?php echo urlencode($rel); ?>"><?php echo basename($bm); ?></a>
        - <a href="?remove_bookmark=<?php echo urlencode($rel); ?>" style="color:red;">Remove</a>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

<h3>Directory: <?php echo $path; ?></h3>
<ul>
<?php
foreach ($files as $file) {
    if ($file == ".") continue;
    $fullPath = $path . '/' . $file;
    $relPath = trim(str_replace($baseDir, '', $fullPath), '/');

    if (is_dir($fullPath)) {
        echo "<li>📁 <a href='?path=" . urlencode($relPath) . "'>$file</a></li>";
    } else {
        echo "<li>📄 $file - <a href='?edit=" . urlencode($relPath) . "'>Edit</a>
              - <a href='?bookmark=" . urlencode($relPath) . "' style='color:green;'>Bookmark</a></li>";
    }
}
?>
</ul>