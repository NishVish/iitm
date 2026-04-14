
import bpy

print("\n📦 SCENE INFO")
print("=" * 50)

print("\n🧱 Objects:")
for obj in bpy.data.objects:
    print("-", obj.name, "|", obj.type)

print("\n🎨 Materials:")
for mat in bpy.data.materials:
    print("-", mat.name)

print("\n📷 Cameras:")
for cam in bpy.data.cameras:
    print("-", cam.name)

print("\n💡 Lights:")
for light in bpy.data.lights:
    print("-", light.name)

print("\n📊 SUMMARY:")
print("Objects:", len(bpy.data.objects))
print("Materials:", len(bpy.data.materials))
print("Cameras:", len(bpy.data.cameras))
print("Lights:", len(bpy.data.lights))

print("\n✅ Done")
        