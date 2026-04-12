from flask import Flask, request, redirect
import json
import os
import subprocess

app = Flask(__name__)

# =========================
# 🔥 ONLY ONE VARIABLE YOU NEED
# =========================
BLEND_FILE = r"C:\xampp\htdocs\iitm\3d\scene.blend"

# Paths
BASE_DIR = r"C:\xampp\htdocs\iitm\3d"
SETTINGS_FILE = os.path.join(BASE_DIR, "settings.json")

BLENDER_EXE = r"C:\Program Files\Blender Foundation\Blender 5.1\blender.exe"

# Default settings
default_settings = {
    "cam_x": 0,
    "cam_y": -5,
    "cam_z": 2,
    "lens": 50,
    "frame_start": 1,
    "frame_end": 20
}

if not os.path.exists(SETTINGS_FILE):
    with open(SETTINGS_FILE, "w") as f:
        json.dump(default_settings, f, indent=4)


# =========================
# RUN BLENDER + INSPECT
# =========================
def run_blender():
    script = f"""
import bpy
from mathutils import Vector

scene = bpy.context.scene
objs = bpy.data.objects

print("Objects:", len(objs))

mesh_objs = [o for o in objs if o.type == 'MESH']

if mesh_objs:
    coords = [
        o.matrix_world @ Vector(corner)
        for o in mesh_objs
        for corner in o.bound_box
    ]

    min_x = min(v.x for v in coords)
    max_x = max(v.x for v in coords)
    min_y = min(v.y for v in coords)
    max_y = max(v.y for v in coords)
    min_z = min(v.z for v in coords)
    max_z = max(v.z for v in coords)

    center = Vector(((min_x+max_x)/2, (min_y+max_y)/2, (min_z+max_z)/2))
    size = max(max_x-min_x, max_y-min_y, max_z-min_z)

    print("CENTER:", center)
    print("SIZE:", size)
"""

    subprocess.run([
        BLENDER_EXE,
        "-b",
        BLEND_FILE,   # 👈 ONLY VARIABLE USED HERE
        "-P",
        "-",
    ], input=script.encode(), cwd=BASE_DIR)


# =========================
# FLASK
# =========================
@app.route("/", methods=["GET", "POST"])
def index():
    with open(SETTINGS_FILE, "r") as f:
        s = json.load(f)

    if request.method == "POST":
        s["cam_x"] = float(request.form["cam_x"])
        s["cam_y"] = float(request.form["cam_y"])
        s["cam_z"] = float(request.form["cam_z"])
        s["lens"] = float(request.form["lens"])
        s["frame_start"] = int(request.form["frame_start"])
        s["frame_end"] = int(request.form["frame_end"])

        with open(SETTINGS_FILE, "w") as f:
            json.dump(s, f, indent=4)

        run_blender()
        return redirect("/")

    return f"""
    <html>
    <body style="background:#111;color:white;font-family:Arial;padding:20px;">

    <h2>Flask Blender</h2>

    <form method="POST">
        X: <input name="cam_x" value="{s['cam_x']}"><br>
        Y: <input name="cam_y" value="{s['cam_y']}"><br>
        Z: <input name="cam_z" value="{s['cam_z']}"><br>
        Lens: <input name="lens" value="{s['lens']}"><br>
        Start: <input name="frame_start" value="{s['frame_start']}"><br>
        End: <input name="frame_end" value="{s['frame_end']}"><br>
        <button type="submit">Render</button>
    </form>

    </body>
    </html>
    """


if __name__ == "__main__":
    app.run(debug=True)