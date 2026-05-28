<?php
set_time_limit(0);

// =========================
// OS DETECTION
// =========================
$isWindows = PHP_OS_FAMILY === 'Windows';

// =========================
// CONFIGURATION
// =========================

// IMPORTANT: DO NOT add extra quotes here
$blender_path = $isWindows
    ? 'C:\\Program Files\\Blender Foundation\\Blender 5.1\\blender.exe'
    : '/usr/bin/blender';

// Files
$scene = realpath(__DIR__ . "/scene.blend");
$script = realpath(__DIR__ . "/render.py");
$upload_path = __DIR__ . "/var.png";

// Output
$output_dir = __DIR__ . "/output";
$output_file = $output_dir . "/frame_0001.png";

if (!file_exists($output_dir)) {
    mkdir($output_dir, 0777, true);
}

$message = "";

// =========================
// UPLOAD IMAGE
// =========================
if (isset($_POST['upload'])) {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
            $message = "Image updated successfully ✔";
        } else {
            $message = "Upload failed";
        }
    }
}

// =========================
// RENDER
// =========================
if (isset($_POST['render'])) {

    if (!$scene || !$script) {
        $message = "Invalid scene or script path";
    } elseif (!file_exists($blender_path)) {
        $message = "Blender not found";
    } elseif (!file_exists($scene)) {
        $message = "Scene file not found";
    } elseif (!file_exists($script)) {
        $message = "Render script not found";
    } else {

        // ✅ SAFE CROSS PLATFORM COMMAND (FIXED)
        $cmd =
            escapeshellarg($blender_path) .
            " -b " . escapeshellarg($scene) .
            " -P " . escapeshellarg($script) .
            " -- " . escapeshellarg($upload_path) .
            " 2>&1";

        $result = [];
        exec($cmd, $result);

        file_put_contents(__DIR__ . "/render_log.txt", implode("\n", $result));

        $message = file_exists($output_file)
            ? "Render Complete ✔"
            : "Render failed (check render_log.txt)";
    }
}

// =========================
// SCENE INFO
// =========================
if (isset($_POST['info'])) {

    if (!$scene || !file_exists($scene)) {
        $message = "Scene file not found";
    } elseif (!file_exists($blender_path)) {
        $message = "Blender not found";
    } else {

        $info_script = __DIR__ . "/scene_info_temp.py";

        file_put_contents($info_script, '
import bpy

print("\\n📦 SCENE INFO")
print("=" * 50)

print("\\n🧱 Objects:")
for obj in bpy.data.objects:
    print("-", obj.name, "|", obj.type)

print("\\n🎨 Materials:")
for mat in bpy.data.materials:
    print("-", mat.name)

print("\\n📷 Cameras:")
for cam in bpy.data.cameras:
    print("-", cam.name)

print("\\n💡 Lights:")
for light in bpy.data.lights:
    print("-", light.name)

print("\\n📊 SUMMARY:")
print("Objects:", len(bpy.data.objects))
print("Materials:", len(bpy.data.materials))
print("Cameras:", len(bpy.data.cameras))
print("Lights:", len(bpy.data.lights))

print("\\n✅ Done")
        ');

        // ✅ FIXED COMMAND (NO WINDOWS ERROR)
        $cmd =
            escapeshellarg($blender_path) .
            " -b " . escapeshellarg($scene) .
            " -P " . escapeshellarg($info_script) .
            " 2>&1";

        $result = [];
        exec($cmd, $result);

        $output = implode("\n", $result);

        file_put_contents(__DIR__ . "/scene_info_log.txt", $output);

        $message = "<pre style='text-align:left;background:#111;color:#0f0;padding:15px;'>"
            . htmlspecialchars($output) .
            "</pre>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Blender 5.1 Studio</title>

    <style>
        body {
            font-family: sans-serif;
            background: #1a1a1a;
            color: #eee;
            text-align: center;
            padding: 40px;
        }

        .container {
            background: #2a2a2a;
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #444;
        }

        .btn {
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            border: none;
            font-weight: bold;
        }

        .btn-upload {
            background: #444;
            color: white;
        }

        .btn-render {
            background: #2d72d9;
            color: white;
        }

        .status {
            color: #ffd700;
            margin: 20px;
        }

        img {
            max-width: 100%;
            border: 2px solid #555;
            margin-top: 20px;
        }

        hr {
            border: 0;
            border-top: 1px solid #444;
            margin: 20px 0;
        }
    </style>

</head>

<body>

    <div class="container">

        <h1>Blender 5.1 Studio</h1>

        <!-- UPLOAD -->
        <form method="post" enctype="multipart/form-data">
            <p>1. Upload Texture</p>
            <input type="file" name="image" required>
            <button type="submit" name="upload" class="btn btn-upload">Upload</button>
        </form>

        <hr>

        <!-- RENDER -->
        <form method="post">
            <p>2. Render Scene</p>
            <button type="submit" name="render" class="btn btn-render">Render</button>
        </form>

        <hr>

        <!-- SCENE INFO -->
        <form method="post">
            <p>3. Scene Info</p>
            <button type="submit" name="info" class="btn btn-upload">Get Info</button>
        </form>

        <div class="status">
            <?php echo $message; ?>
        </div>

    </div>

    <?php if (file_exists($output_file)): ?>
            <h2>Output</h2>
            <img src="output/frame_0001.png?t=<?php echo time(); ?>">
    <?php endif; ?>

</body>

</html>