import bpy
import sys
import os
import math
from mathutils import Vector

# =========================================================
# IMAGE INPUT (CLI OR DEFAULT var.png)
# =========================================================
argv = sys.argv
argv = argv[argv.index("--") + 1:] if "--" in argv else []

if len(argv) > 0:
    image_path = argv[0]
else:
    image_path = os.path.join(os.getcwd(), "var.png")

# =========================================================
# GET MESH OBJECTS
# =========================================================
objs = [o for o in bpy.data.objects if o.type == 'MESH']

if not objs:
    raise Exception("No mesh objects found")

# =========================================================
# WORLD BOUNDING BOX (CENTER + SIZE)
# =========================================================
coords = [o.matrix_world @ Vector(corner)
          for o in objs
          for corner in o.bound_box]

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
height = size * 0.2

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

# output folder

output_dir = os.path.join(os.path.dirname(image_path), 'rendered')
os.makedirs(output_dir, exist_ok=True)

scene.render.filepath = os.path.join(output_dir, "frame_")

# =========================================================
# CAMERA TARGET (LOOK AT MODEL CENTER)
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
# APPLY IMAGE TO MATERIAL (SCREEN_MAT)
# =========================================================

if os.path.exists(image_path):
    print("📁 Using image:", image_path)

    mat = bpy.data.materials.get("SCREEN_MAT")

    if mat:
        mat.use_nodes = True
        nodes = mat.node_tree.nodes
        links = mat.node_tree.links

        # -----------------------------
        # GET / CREATE IMAGE NODE
        # -----------------------------
        img_node = next((n for n in nodes if n.type == 'TEX_IMAGE'), None)

        if not img_node:
            img_node = nodes.new("ShaderNodeTexImage")
            img_node.location = (-300, 300)

        # -----------------------------
        # LOAD / RELOAD IMAGE
        # -----------------------------
        img_full_path = os.path.abspath(image_path)
        base_name = os.path.basename(image_path)

        if base_name in bpy.data.images:
            img = bpy.data.images[base_name]
            img.filepath = img_full_path
            img.reload()
            print(f"✅ Reloaded existing image: {base_name}")
        else:
            img = bpy.data.images.load(img_full_path)
            print(f"✅ Loaded new image: {base_name}")

        img_node.image = img

        # -----------------------------
        # ENSURE OUTPUT NODE
        # -----------------------------
        output = next((n for n in nodes if n.type == 'OUTPUT_MATERIAL'), None)
        if not output:
            output = nodes.new("ShaderNodeOutputMaterial")

        # -----------------------------
        # TRY PRINCIPLED BSDF FIRST
        # -----------------------------
        bsdf = next((n for n in nodes if n.type == 'BSDF_PRINCIPLED'), None)

        if bsdf:
            # Remove existing Base Color links
            for link in list(links):
                if link.to_node == bsdf and link.to_socket.name == "Base Color":
                    links.remove(link)

            links.new(img_node.outputs["Color"], bsdf.inputs["Base Color"])
            print("🎨 Connected image → Principled BSDF")

        else:
            # -----------------------------
            # FALLBACK: EMISSION (ALWAYS VISIBLE)
            # -----------------------------
            emission = nodes.new("ShaderNodeEmission")
            emission.location = (0, 300)

            links.new(img_node.outputs["Color"], emission.inputs["Color"])
            links.new(emission.outputs["Emission"], output.inputs["Surface"])

            print("💡 Using Emission (no BSDF found)")

    else:
        print("⚠ SCREEN_MAT not found")

else:
    raise Exception("Image not found: " + image_path)
# =========================================================
# CLEAR ANIMATION
# =========================================================
cam.animation_data_clear()
# =========================================================
# CAMERA ANIMATION (20 FRAMES)
# =========================================================
# =========================================================
# CAMERA ANIMATION (20 FRAMES)
# =========================================================
frames = 20
scene.frame_start = 0
scene.frame_end = 20
scene.frame_step = 1
for i in range(0, frames + 1):

    t = i / frames

    # smooth front → front-right → left → front loop
    angle = math.radians(45) * math.sin(t * math.pi * 2)

    # smooth zoom breathing
    radius = base_radius + math.sin(t * math.pi) * (base_radius * 0.12)

    x = center.x + radius * math.cos(angle)
    y = center.y + radius * math.sin(angle)

    z = center.z + (size * 0.05)

    cam.location = (x, y, z)
    cam.keyframe_insert(data_path="location", frame=i)
# =========================================================
# RENDER SETTINGS
# =========================================================

scene.frame_end = frames
# =========================================================
# RENDER
# =========================================================
bpy.ops.render.render(animation=True)

print("✅ Render complete (20 frames + image applied)")