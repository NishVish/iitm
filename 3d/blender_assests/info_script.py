import bpy

print("\n📦 SCENE INFO")
print("=" * 50)

# =========================
# OBJECTS
# =========================
print("\n🧱 Objects:")
if bpy.data.objects:
    for obj in bpy.data.objects:
        print(f"- {obj.name} | {obj.type}")
else:
    print("⚠ No objects found")

# =========================
# MATERIALS
# =========================
print("\n🎨 Materials:")
if bpy.data.materials:
    for mat in bpy.data.materials:
        print(f"- {mat.name}")
else:
    print("⚠ No materials found")

# =========================
# MATERIAL USAGE (IMPORTANT)
# =========================
print("\n🔗 Material Usage:")

found = False

for obj in bpy.data.objects:
    if obj.type == 'MESH':

        if not obj.material_slots:
            print(f"{obj.name} → ❌ No material")
            continue

        for slot in obj.material_slots:
            if slot.material:
                print(f"{obj.name} → {slot.material.name}")
                found = True
            else:
                print(f"{obj.name} → ⚠ Empty slot")

if not found:
    print("⚠ No materials assigned to any mesh")

# =========================
# CAMERAS
# =========================
print("\n📷 Cameras:")
cams = bpy.data.cameras
if cams:
    for cam in cams:
        print(f"- {cam.name}")
else:
    print("⚠ No cameras found")

# =========================
# LIGHTS
# =========================
print("\n💡 Lights:")
lights = bpy.data.lights
if lights:
    for light in lights:
        print(f"- {light.name}")
else:
    print("⚠ No lights found")

# =========================
# ACTIVE SCENE SUMMARY
# =========================
print("\n📊 SUMMARY:")
print(f"- Total Objects: {len(bpy.data.objects)}")
print(f"- Total Materials: {len(bpy.data.materials)}")
print(f"- Total Cameras: {len(bpy.data.cameras)}")
print(f"- Total Lights: {len(bpy.data.lights)}")

print("\n✅ Scene scan complete")