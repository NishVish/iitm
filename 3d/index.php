<?php
// 1. Prevent the script from timing out during the render
set_time_limit(0);

// =========================
// CONFIGURATION
// =========================
// Updated path for Blender 5.1
$blender_path = "C:\\Program Files\\Blender Foundation\\Blender 5.1\\blender.exe";

// Use realpath to ensure Windows paths are perfectly formatted for the shell
$scene       = realpath(__DIR__ . "/scene.blend");
$script      = realpath(__DIR__ . "/render.py");
$upload_path = __DIR__ . "/var.png";
$output_dir  = __DIR__ . "/output";
$output_file = $output_dir . "/frame_0001.png";

// Create output directory if it doesn't exist
if (!file_exists($output_dir)) {
    mkdir($output_dir, 0777, true);
}

$message = "";

// =========================
// UPLOAD HANDLER
// =========================
if (isset($_POST['upload'])) {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
            $message = "Image 'var.png' updated successfully! ✔";
        } else {
            $message = "Error uploading image. Check folder permissions.";
        }
    }
}

// =========================
// RENDER HANDLER
// =========================
if (isset($_POST['render'])) {
    if (!file_exists($blender_path)) {
        $message = "Error: Blender 5.1 not found at $blender_path";
    } else {
        // Construct the command using absolute paths and quoting them for Windows
        // -o defines output pattern, -f 1 renders the first frame
        $cmd = "\"$blender_path\" -b \"$scene\" -P \"$script\" -o \"$output_dir/frame_####\" -f 1 2>&1";

        // Execute command and capture full output
        $result = shell_exec($cmd);

        // Save log for debugging
        file_put_contents(__DIR__ . "/render_log.txt", $result);

        if (file_exists($output_file)) {
            $message = "Render Complete! ✔";
        } else {
            $message = "Render failed. See render_log.txt for details.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blender 5.1 Render Panel</title>
    <style>
        body { font-family: sans-serif; background: #1a1a1a; color: #eee; text-align: center; padding: 40px; }
        .container { background: #2a2a2a; max-width: 600px; margin: auto; padding: 20px; border-radius: 10px; border: 1px solid #444; }
        .btn { padding: 10px 20px; margin: 10px; cursor: pointer; border-radius: 5px; border: none; font-weight: bold; }
        .btn-upload { background: #444; color: white; }
        .btn-render { background: #2d72d9; color: white; }
        .status { color: #ffd700; margin: 20px; }
        img { max-width: 100%; border: 2px solid #555; margin-top: 20px; }
        hr { border: 0; border-top: 1px solid #444; margin: 20px 0; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Blender 5.1 Studio</h1>
        
        <form method="post" enctype="multipart/form-data">
            <p>1. Update Texture (var.png)</p>
            <input type="file" name="image" required>
            <button type="submit" name="upload" class="btn btn-upload">Upload Image</button>
        </form>

        <hr>

        <form method="post">
            <p>2. Run Render Script</p>
            <button type="submit" name="render" class="btn btn-render">Start Render</button>
        </form>

        <div class="status"><?php echo $message; ?></div>
    </div>

    <?php if (file_exists($output_file)): ?>
        <h2>Output:</h2>
        <img src="output/frame_0001.png?t=<?php echo time(); ?>">
    <?php endif; ?>

</body>
</html>