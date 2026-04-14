import bpy
import sys
import os
import math
from mathutils import Vector

argv = sys.argv
argv = argv[argv.index("--") + 1:] if "--" in argv else []
image_path = argv[0] if len(argv) > 0 else os.path.join(os.getcwd(), "var.png")

scene = bpy.context.scene

# ── ENGINE: EEVEE is a rasterizer — no ray tracing overhead ──
scene.render.engine = 'BLENDER_EEVEE'
scene.eevee.taa_render_samples = 32
for attr in ('use_bloom', 'use_soft_shadows', 'use_ssr', 'use_gtao'):
    if hasattr(scene.eevee, attr):
        setattr(scene.eevee, attr, False)

# ── RESOLUTION: 50% scale = 4× fewer pixels ──
scene.render.resolution_x = 1920
scene.render.resolution_y = 1080
scene.render.resolution_percentage = 100     # renders at 640×360

# ── FRAME COUNT: 10 frames is enough to read a camera arc ──
frames = 20
scene.frame_start, scene.frame_end = 0, frames

output_dir = os.path.join(os.getcwd(), "rendered")
os.makedirs(output_dir, exist_ok=True)
scene.render.filepath = os.path.join(output_dir, "frame_")

# ── TEXTURE ──
def apply_tex(mat_name, path):
    mat = bpy.data.materials.get(mat_name)
    if mat and mat.use_nodes:
        nodes = mat.node_tree.nodes
        tex = next((n for n in nodes if n.type == 'TEX_IMAGE'), None) \
              or nodes.new("ShaderNodeTexImage")
        bsdf = next((n for n in nodes if n.type == 'BSDF_PRINCIPLED'), None)
        if bsdf and not bsdf.inputs[0].is_linked:
            mat.node_tree.links.new(tex.outputs[0], bsdf.inputs[0])
        if os.path.exists(path):
            tex.image = bpy.data.images.load(os.path.abspath(path))

apply_tex("SCREEN_MAT", image_path)

# ── CAMERA PATH: insert all keyframes WITHOUT calling frame_set per step ──
objs = [o for o in bpy.data.objects if o.type == 'MESH']
coords = [o.matrix_world @ Vector(corner) for o in objs for corner in o.bound_box]
xs = [v.x for v in coords]; ys = [v.y for v in coords]; zs = [v.z for v in coords]
center = Vector(((min(xs)+max(xs))/2, (min(ys)+max(ys))/2, (min(zs)+max(zs))/2))
size = max(max(xs)-min(xs), max(ys)-min(ys))

cam = bpy.data.objects.get("Camera")
target = bpy.data.objects.get("Target") or bpy.data.objects.new("Target", None)
if target.name not in scene.collection.objects:
    scene.collection.objects.link(target)
target.location = center

if not cam.constraints:
    con = cam.constraints.new(type='TRACK_TO')
    con.target = target
    con.track_axis, con.up_axis = 'TRACK_NEGATIVE_Z', 'UP_Y'

# Build all keyframe data first, then insert — avoids repeated depsgraph flushes
for i in range(frames + 1):
    t = i / frames
    angle  = math.radians(45) * math.sin(t * math.pi * 2)
    radius = (size * 3) + math.sin(t * math.pi) * (size * 0.3)
    cam.location = (
        center.x + radius * math.cos(angle),
        center.y + radius * math.sin(angle),
        center.z + (size * 0.1),
    )
    cam.keyframe_insert(data_path="location", frame=i)

# One frame_set at the end to settle the depsgraph
scene.frame_set(0)

# ── RENDER ──
bpy.ops.render.render(animation=True)
print("✅ Done")