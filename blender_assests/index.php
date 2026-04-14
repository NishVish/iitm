<?php
set_time_limit(0);

// =========================
// CONFIGURATION
// =========================
// $blender_path = "C:\\Program Files\\Blender Foundation\\Blender 5.1\\blender.exe";
$blender_path = "/usr/bin/blender";
$scene = realpath(__DIR__ . "/scene.blend");
$script = realpath(__DIR__ . "/render.py");
$upload_path = __DIR__ . "/var.png";

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

    if (!file_exists($blender_path)) {
        $message = "Blender not found";
    } else {

        $cmd = "\"$blender_path\" -b \"$scene\" -P \"$script\" -o \"$output_dir/frame_####\" -f 1 2>&1";

        $result = shell_exec($cmd);

        file_put_contents(__DIR__ . "/render_log.txt", $result);

        if (file_exists($output_file)) {
            $message = "Render Complete ✔";
        } else {
            $message = "Render failed (check log)";
        }
    }
}

// =========================
// SCENE INFO (NEW)
// =========================
if (isset($_POST['info'])) {

    if (!file_exists($blender_path)) {
        $message = "Blender not found";
    } else {

        $info_script = __DIR__ . "/scene_info_temp.py";

        file_put_contents($info_script, '
import bpy

print("\n📦 SCENE INFO")
print("=" * 50)

print("\n🧱 Objects:")
for obj in bpy.data.objects:
    print("-", obj.name, "|", obj.type)

print("\n🎨 Materials:")
for mat in bpy.data.materials:
    print("-", mat.name)

print("\n🔗 Material Usage:")
for obj in bpy.data.objects:
    if obj.type == "MESH":
        if not obj.material_slots:
            print(obj.name, "→ ❌ No material")
        for slot in obj.material_slots:
            if slot.material:
                print(obj.name, "→", slot.material.name)

print("\n📷 Cameras:")
for cam in bpy.data.cameras:
    print("-", cam.name)

print("\n💡 Lights:")
for light in bpy.data.lights:
    print("-", light.name)

print("\n📊 SUMMARY:")
print("Objects:", len(bpy.data.objects))
print("Materials:", len(bpy.data.materials))
print("Cameras:", len(bpy.data.cameras))
print("Lights:", len(bpy.data.lights))

print("\n✅ Done")
        ');

        $cmd = "\"$blender_path\" -b \"$scene\" -P \"$info_script\" 2>&1";

        $result = shell_exec($cmd);

        file_put_contents(__DIR__ . "/scene_info_log.txt", $result);

        $message = "<pre style='text-align:left;background:#111;color:#0f0;padding:15px;'>"
            . htmlspecialchars($result) .
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