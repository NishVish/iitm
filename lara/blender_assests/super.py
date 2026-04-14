import bpy
import sys
import os
import math
import multiprocessing
from mathutils import Vector

# =========================================================
# FAST RENDER OPTIMIZATION (CPU ONLY)
# =========================================================
scene = bpy.context.scene
scene.render.engine = 'BLENDER_WORKBENCH'

# Force CPU threads
scene.render.threads_mode = 'FIXED'
scene.render.threads = multiprocessing.cpu_count()

# Quality/Speed balance: Cavity makes stall details pop without heavy lights
scene.display.shading.light = 'STUDIO'
scene.display.shading.color_type = 'TEXTURE'
scene.display.shading.show_cavity = True
scene.display.shading.cavity_type = 'WORLD'

# Performance settings
scene.render.resolution_percentage = 50 
scene.render.image_settings.file_format = 'PNG'

# =========================================================
# INPUT HANDLING
# =========================================================
argv = sys.argv
argv = argv[argv.index("--") + 1:] if "--" in argv else []
image_path = argv[0] if argv else os.path.join(os.getcwd(), "var.png")
image_path = os.path.abspath(image_path)

# =========================================================
# GET MESH & BOUNDING BOX
# =========================================================
objs = [o for o in bpy.data.objects if o.type == 'MESH']
if not objs:
    raise Exception("No mesh objects found")

coords = [o.matrix_world @ Vector(corner) for o in objs for corner in o.bound_box]
min_x, max_x = min(v.x for v in coords), max(v.x for v in coords)
min_y, max_y = min(v.y for v in coords), max(v.y for v in coords)
min_z, max_z = min(v.z for v in coords), max(v.z for v in coords)

center = Vector(((min_x + max_x) / 2, (min_y + max_y) / 2, (min_z + max_z) / 2))
size = max(max_x - min_x, max_y - min_y, max_z - min_z)

base_radius = size * 3

# =========================================================
# CAMERA SETUP
# =========================================================
cam = bpy.data.objects.get("Camera")
if not cam:
    bpy.ops.object.camera_add()
    cam = bpy.context.active_object
scene.camera = cam

# Target logic
target = bpy.data.objects.get("Target") or bpy.data.objects.new("Target", None)
if target.name not in bpy.context.collection.objects:
    bpy.context.collection.objects.link(target)
target.location = center

# Tracking constraint
con = next((c for c in cam.constraints if c.type == 'TRACK_TO'), None) or cam.constraints.new(type='TRACK_TO')
con.target, con.track_axis, con.up_axis = target, 'TRACK_NEGATIVE_Z', 'UP_Y'

# =========================================================
# MATERIAL UPDATES
# =========================================================
def update_texture(mat_name, img_p):
    mat = bpy.data.materials.get(mat_name)
    if mat and mat.use_nodes and os.path.exists(img_p):
        nodes = mat.node_tree.nodes
        tex_node = next((n for n in nodes if n.type == 'TEX_IMAGE'), None) or nodes.new("ShaderNodeTexImage")
        img_name = os.path.basename(img_p)
        img = bpy.data.images.get(img_name) or bpy.data.images.load(img_p)
        tex_node.image = img
        bsdf = next((n for n in nodes if n.type == 'BSDF_PRINCIPLED'), None)
        if bsdf: mat.node_tree.links.new(tex_node.outputs["Color"], bsdf.inputs["Base Color"])

script_dir = os.path.dirname(os.path.abspath(__file__))
update_texture("IITM", os.path.join(script_dir, "logo.png"))
update_texture("SCREEN_MAT", image_path)

# =========================================================
# CAMERA ANIMATION (EYE LEVEL + FRONT START)
# =========================================================
cam.animation_data_clear()
frames = 20
scene.frame_start, scene.frame_end = 0, frames

for i in range(frames + 1):
    t = i / frames
    # Original swing logic
    angle = math.radians(45) * math.sin(t * math.pi * 2)
    # Original zoom logic
    radius = base_radius + math.sin(t * math.pi) * (base_radius * 0.12)

    # OFFSET: Starts at Front (-Y axis) instead of Side (+X axis)
    current_angle = angle - (math.pi / 2)

    cam.location.x = center.x + radius * math.cos(current_angle)
    cam.location.y = center.y + radius * math.sin(current_angle)
    # Eye Level: Strictly locked to center height
    cam.location.z = center.z 

    cam.keyframe_insert(data_path="location", frame=i)

# =========================================================
# OUTPUT & RENDER
# =========================================================
output_dir = os.path.join(os.path.dirname(image_path), "rendered")
os.makedirs(output_dir, exist_ok=True)
scene.render.filepath = os.path.join(output_dir, "frame_")

bpy.ops.render.render(animation=True)
print(f"✅ Fast CPU Showcase Render Complete. Saved in: {output_dir}")