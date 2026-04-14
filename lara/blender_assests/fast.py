import bpy
import sys
import os
import math
from mathutils import Vector

# =========================================================
# IMAGE INPUT
# =========================================================
argv = sys.argv
argv = argv[argv.index("--") + 1:] if "--" in argv else []

image_path = argv[0] if len(argv) > 0 else os.path.join(os.getcwd(), "var.png")

# =========================================================
# OUTPUT FOLDER (FIXED)
# =========================================================
output_dir = os.path.join(os.getcwd(), "rendered")
os.makedirs(output_dir, exist_ok=True)

# =========================================================
# GET MESH OBJECTS
# =========================================================
objs = [o for o in bpy.data.objects if o.type == 'MESH']
if not objs:
    raise Exception("No mesh objects found")

# =========================================================
# WORLD BOUNDING BOX
# =========================================================
coords = [
    o.matrix_world @ Vector(corner)
    for o in objs
    for corner in o.bound_box
]

min_x = min(v.x for v in coords)
max_x = max(v.x for v in coords)
min_y = min(v.y for v in coords)
max_y = max(v.y for v in coords)
min_z = min(v.z for v in coords)
max_z = max(v.z for v in coords)

center = Vector((
    (min_x + max_x) / 2,
    (min_y + max_y) / 2,
    (min_z + max_z) / 2
))

size = max(max_x - min_x, max_y - min_y, max_z - min_z)
base_radius = size * 3

# =========================================================
# SCENE SETUP
# =========================================================
scene = bpy.context.scene
cam = bpy.data.objects.get("Camera")

if cam is None:
    raise Exception("Camera not found")

scene.camera = cam

# ✔ WORKBENCH ENGINE
scene.render.engine = 'BLENDER_WORKBENCH'

scene.render.image_settings.file_format = 'PNG'
scene.render.resolution_x = 1920
scene.render.resolution_y = 1080

scene.render.filepath = os.path.join(output_dir, "frame_")

# =========================================================
# CAMERA TARGET
# =========================================================
if "Target" not in bpy.data.objects:
    target = bpy.data.objects.new("Target", None)
    bpy.context.collection.objects.link(target)

target = bpy.data.objects["Target"]
target.location = center

if not any(c.type == 'TRACK_TO' for c in cam.constraints):
    con = cam.constraints.new(type='TRACK_TO')
    con.target = target
    con.track_axis = 'TRACK_NEGATIVE_Z'
    con.up_axis = 'UP_Y'

# =========================================================
# CAMERA RESET
# =========================================================
cam.animation_data_clear()

# =========================================================
# CAMERA ANIMATION
# =========================================================
frames = 20
scene.frame_start = 0
scene.frame_end = frames

for i in range(frames + 1):
    scene.frame_set(i)

    t = i / frames

    angle = math.radians(45) * math.sin(t * math.pi * 2)
    radius = base_radius + math.sin(t * math.pi) * (base_radius * 0.12)

    cam.location = (
        center.x + radius * math.cos(angle),
        center.y + radius * math.sin(angle),
        center.z + (size * 0.05)
    )

    cam.keyframe_insert(data_path="location", frame=i)

# =========================================================
# RENDER
# =========================================================
bpy.ops.render.render(animation=True)

print("✅ Render complete (Workbench engine + rendered folder)")