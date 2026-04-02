<?php
session_start();

/** * SECURITY NOTE: In a real app, never hardcode passwords. 
 * Use password_hash() and store it in a config file.
 */
$password_hash = '$2y$10$S6A3N9pE/6Z7p8l5Xq7BGe7z3l6v7E9yO1fG6R3M0hJ2kL4uP9w6.'; // "nin" hashed
$showContent = false;

// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: " . basename(__FILE__));
    exit;
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simple direct comparison for your specific request
    if (!empty($_POST['password']) && $_POST['password'] === "nin") {
        $_SESSION['auth'] = true;
        header("Location: " . basename(__FILE__)); // Prevent form resubmission
        exit;
    }
}

if (!empty($_SESSION['auth']) && $_SESSION['auth'] === true) {
    $showContent = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $showContent ? 'IITM Directory' : '404 Not Found'; ?></title>
    <style>
        :root {
            --bg: #0f172a;
            --card-bg: #1e293b;
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
            --accent: #38bdf8;
            --danger: #f43f5e;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            text-align: center;
            width: 100%;
            max-width: 600px;
            padding: 2rem;
        }

        /* 404 Styling */
        .error-code {
            font-size: 8rem;
            font-weight: 900;
            margin: 0;
            cursor: pointer;
            user-select: none;
            transition: color 0.3s ease;
            color: var(--card-bg);
        }
        
        .error-code:hover { color: var(--accent); }

        .error-msg { color: var(--text-dim); margin-bottom: 2rem; }

        /* Login Box */
        #loginBox {
            display: none;
            background: var(--card-bg);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.4s ease;
        }

        input[type="password"] {
            background: var(--bg);
            border: 1px solid #334155;
            color: white;
            padding: 12px 16px;
            border-radius: 6px;
            width: 200px;
            outline: none;
        }

        button {
            background: var(--accent);
            color: var(--bg);
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        button:hover { opacity: 0.9; }

        /* Directory UI */
        .directory-card {
            background: var(--card-bg);
            border-radius: 12px;
            text-align: left;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        }

        .dir-header {
            padding: 1.5rem;
            border-bottom: 1px solid #334155;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dir-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .dir-item {
            padding: 12px 20px;
            border-bottom: 1px solid #334155;
            display: flex;
            align-items: center;
        }

        .dir-item:last-child { border-bottom: none; }

        .dir-item a {
            color: var(--accent);
            text-decoration: none;
            flex-grow: 1;
        }

        .dir-item a:hover { text-decoration: underline; }

        .dir-item strong { color: var(--text-dim); font-weight: 500; }

        .logout-btn {
            color: var(--danger);
            text-decoration: none;
            font-size: 0.9rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <script>
        function toggleLogin() {
            const box = document.getElementById("loginBox");
            const msg = document.getElementById("statusMsg");
            box.style.display = "block";
            msg.style.display = "none";
        }
    </script>
</head>
<body>

<div class="container">
    <?php if(!$showContent): ?>
        <h1 class="error-code" onclick="toggleLogin()">404</h1>
        <div id="statusMsg">
            <p class="error-msg">The requested URL was not found on this server.</p>
        </div>

        <div id="loginBox">
            <form method="post">
                <input type="password" name="password" placeholder="System Key" required autofocus>
                <button type="submit">Verify</button>
            </form>
        </div>

    <?php else: ?>
        <div class="directory-card">
            <div class="dir-header">
                <h2 style="margin:0; font-size: 1.25rem;">IITM Directory</h2>
                <a href="?logout=1" class="logout-btn">Disconnect</a>
            </div>
            
            <ul class="dir-list">
                <?php
                $files = scandir(__DIR__);
                foreach($files as $file){
                    if ($file === "." || $file === ".." || $file === basename(__FILE__)) continue;

                    echo '<li class="dir-item">';
                    if (is_dir($file)) {
                        echo "<strong>📁 " . htmlspecialchars($file) . "/</strong>";
                    } else {
                        echo "📄 <a href='" . htmlspecialchars($file) . "'>" . htmlspecialchars($file) . "</a>";
                    }
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

</body>
</html>