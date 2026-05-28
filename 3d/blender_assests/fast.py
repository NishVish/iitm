import bpy
import sys
import os
from mathutils import Vector
import math

# =========================================================
# FAST MODE SETTINGS (CRITICAL)
# =========================================================
scene = bpy.context.scene

scene.render.engine = 'BLENDER_EEVEE'
scene.eevee.taa_render_samples = 1
scene.eevee.taa_samples = 1

scene.render.resolution_x = 1280
scene.render.resolution_y = 720
scene.render.resolution_percentage = 50

scene.render.use_persistent_data = True

# disable heavy stuff
scene.eevee.use_ssr = False
scene.eevee.use_gtao = False
scene.eevee.use_bloom = False
scene.eevee.use_motion_blur = False

# =========================================================
# IMAGE INPUT
# =========================================================
argv = sys.argv
argv = argv[argv.index("--") + 1:] if "--" in argv else []

image_path = argv[0] if argv else os.path.join(os.getcwd(), "var.png")

if not os.path.exists(image_path):
    raise Exception("Image not found: " + image_path)

# =========================================================
# GET CAMERA FAST
# =========================================================
cam = bpy.data.objects.get("Camera")
if not cam:
    raise Exception("Camera not found")

scene.camera = cam
cam.animation_data_clear()

# =========================================================
# FAST MATERIAL (NO NODE SEARCH LOOP)
# =========================================================
mat = bpy.data.materials.get("SCREEN_MAT")

if mat:
    mat.use_nodes = True
    nodes = mat.node_tree.nodes

    # clear nodes ONCE (fast reset)
    for n in list(nodes):
        if n.type not in ('OUTPUT_MATERIAL',):
            nodes.remove(n)

    tex = nodes.new("ShaderNodeTexImage")
    tex.location = (-300, 0)

    img = bpy.data.images.load(os.path.abspath(image_path))
    tex.image = img

    output = nodes.get("Material Output")
    if not output:
        output = nodes.new("ShaderNodeOutputMaterial")

    emission = nodes.new("ShaderNodeEmission")

    mat.node_tree.links.new(tex.outputs["Color"], emission.inputs["Color"])
    mat.node_tree.links.new(emission.outputs["Emission"], output.inputs["Surface"])

# =========================================================
# FAST CAMERA SETUP (NO BOUNDING BOX LOOP)
# =========================================================
objs = [o for o in bpy.data.objects if o.type == 'MESH']
if objs:
    center = sum((o.location for o in objs), Vector()) / len(objs)
else:
    center = Vector((0, 0, 0))

cam.location = (center.x + 5, center.y + 5, center.z + 2)

target = bpy.data.objects.get("Target")
if not target:
    target = bpy.data.objects.new("Target", None)
    bpy.context.collection.objects.link(target)

target.location = center

if not any(c.type == 'TRACK_TO' for c in cam.constraints):
    con = cam.constraints.new('TRACK_TO')
    con.target = target
    con.track_axis = 'TRACK_NEGATIVE_Z'
    con.up_axis = 'UP_Y'

# =========================================================
# FAST RENDER (REDUCED FRAMES)
# =========================================================
frames = 10   # 🔥 reduced from 20

scene.frame_start = 1
scene.frame_end = frames

# output fast path
output_dir = "/tmp/render"
os.makedirs(output_dir, exist_ok=True)
scene.render.filepath = os.path.join(output_dir, "frame_")

# =========================================================
# RENDER
# =========================================================
bpy.ops.render.render(animation=True)

print("✅ FAST render complete")