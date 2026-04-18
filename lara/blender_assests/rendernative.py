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

if not coords:
    raise Exception("Could not compute bounding box")

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

scene.render.engine = 'BLENDER_EEVEE'
scene.render.image_settings.file_format = 'PNG'
scene.render.resolution_x = 1920
scene.render.resolution_y = 1080

# output
output_dir = os.path.join(os.getcwd(), "rendered")
os.makedirs(output_dir, exist_ok=True)
scene.render.filepath = os.path.join(output_dir, "frame_")

# =========================================================
# CAMERA TARGET
# =========================================================
if "Target" not in bpy.data.objects:
    target = bpy.data.objects.new("Target", None)
    bpy.context.collection.objects.link(target)

target = bpy.data.objects["Target"]
target.location = center

# ensure constraint exists
if not any(c.type == 'TRACK_TO' for c in cam.constraints):
    con = cam.constraints.new(type='TRACK_TO')
    con.target = target
    con.track_axis = 'TRACK_NEGATIVE_Z'
    con.up_axis = 'UP_Y'

# =========================================================
# LOGO MATERIAL
# =========================================================
script_dir = os.path.dirname(os.path.abspath(__file__)) if "__file__" in globals() else os.getcwd()
logo_path = os.path.join(script_dir, "logo.png")

mat = bpy.data.materials.get("IITM")

if mat and mat.use_nodes:
    nodes = mat.node_tree.nodes

    img_node = next((n for n in nodes if n.type == 'TEX_IMAGE'), None)
    if not img_node:
        img_node = nodes.new("ShaderNodeTexImage")

    if os.path.exists(logo_path):
        img = bpy.data.images.get("IITM_LOGO")
        if not img:
            img = bpy.data.images.load(logo_path)
            img.name = "IITM_LOGO"

        img_node.image = img
        print("✅ IITM logo applied")
    else:
        print("⚠ logo.png not found")

# =========================================================
# SCREEN MATERIAL
# =========================================================
if not os.path.exists(image_path):
    raise Exception("Image not found: " + image_path)

mat = bpy.data.materials.get("SCREEN_MAT")

if mat:
    mat.use_nodes = True
    nodes = mat.node_tree.nodes
    links = mat.node_tree.links

    img_node = next((n for n in nodes if n.type == 'TEX_IMAGE'), None)

    if not img_node:
        img_node = nodes.new("ShaderNodeTexImage")

        bsdf = next((n for n in nodes if n.type == 'BSDF_PRINCIPLED'), None)
        if bsdf:
            links.new(img_node.outputs.get("Color"), bsdf.inputs.get("Base Color"))

    img_full_path = os.path.abspath(image_path)
    base_name = os.path.basename(image_path)

    if base_name in bpy.data.images:
        img = bpy.data.images[base_name]
        img.filepath = img_full_path
        img.reload()
    else:
        img = bpy.data.images.load(img_full_path)
        img.name = base_name

    img_node.image = img
else:
    print("⚠ SCREEN_MAT not found")

# =========================================================
# CAMERA ANIMATION
# =========================================================
cam.animation_data_clear()

frames = 50
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

print("✅ Render complete (20 frames + image applied)")