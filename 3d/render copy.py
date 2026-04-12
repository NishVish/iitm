import bpy
import os
import math

# =========================================================
# GET MESH OBJECTS
# =========================================================
objs = [o for o in bpy.data.objects if o.type == 'MESH']

if not objs:
    raise Exception("No mesh objects found")

# =========================================================
# COMPUTE MODEL SIZE (SAFE CAMERA DISTANCE)
# =========================================================
min_x = min([o.bound_box[0][0] for o in objs])
max_x = max([o.bound_box[6][0] for o in objs])

min_y = min([o.bound_box[0][1] for o in objs])
max_y = max([o.bound_box[6][1] for o in objs])

size = max(max_x - min_x, max_y - min_y)

base_radius = size * 2.5
height = size * 0.6

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
output_dir = os.path.join(os.getcwd(), "output")
os.makedirs(output_dir, exist_ok=True)

scene.render.filepath = os.path.join(output_dir, "frame_")

# =========================================================
# CREATE CENTER TARGET (FOR CAMERA LOOK)
# =========================================================
if "Target" not in bpy.data.objects:
    target = bpy.data.objects.new("Target", None)
    bpy.context.collection.objects.link(target)
    target.location = (0, 0, 0)
else:
    target = bpy.data.objects["Target"]

# add tracking constraint once
if not any(c.type == 'TRACK_TO' for c in cam.constraints):
    con = cam.constraints.new(type='TRACK_TO')
    con.target = target
    con.track_axis = 'TRACK_NEGATIVE_Z'
    con.up_axis = 'UP_Y'

# =========================================================
# CLEAR OLD ANIMATION
# =========================================================
cam.animation_data_clear()

# =========================================================
# CAMERA ANIMATION (20 FRAMES TOTAL)
# =========================================================
frames = 20

for i in range(frames):

    t = i / (frames - 1)

    # smooth angle movement: front-left → front → front-right
    angle = math.radians(45) * math.sin(t * math.pi * 2)

    # smooth zoom breathing (no inside mesh)
    radius = base_radius + math.sin(t * math.pi) * (base_radius * 0.15)

    x = radius * math.cos(angle)
    y = radius * math.sin(angle)

    cam.location = (x, y, height)

    cam.keyframe_insert(data_path="location", frame=i)

# =========================================================
# RENDER SETTINGS
# =========================================================
scene.frame_start = 0
scene.frame_end = frames - 1

# =========================================================
# RENDER ANIMATION
# =========================================================
bpy.ops.render.render(animation=True)

print("✅ Render complete (20-frame smooth animation)")