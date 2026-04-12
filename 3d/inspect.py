import bpy
from mathutils import Vector

OUTPUT_FILE = "scene_info.txt"

lines = []

scene = bpy.context.scene
objs = bpy.data.objects

lines.append("SCENE INFO")
lines.append(f"Scene: {scene.name}")
lines.append(f"Objects: {len(objs)}")

for o in objs:
    lines.append(f"{o.name} | {o.type} | {o.location}")

mesh_objs = [o for o in objs if o.type == "MESH"]

if mesh_objs:
    coords = [
        o.matrix_world @ Vector(corner)
        for o in mesh_objs
        for corner in o.bound_box
    ]

    center = Vector((
        sum(v.x for v in coords) / len(coords),
        sum(v.y for v in coords) / len(coords),
        sum(v.z for v in coords) / len(coords)
    ))

    lines.append(f"\nCENTER: {center}")

with open(OUTPUT_FILE, "w") as f:
    f.write("\n".join(lines))

print("Saved:", OUTPUT_FILE)