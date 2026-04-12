import subprocess

# =========================
# CONFIG (ONLY VARIABLES)
# =========================
BLENDER_EXE = r"C:\Program Files\Blender Foundation\Blender 5.1\blender.exe"
BLEND_FILE = r"C:\xampp\htdocs\iitm\3d\scene.blend"
SCRIPT_FILE = r"C:\xampp\htdocs\iitm\3d\inspect.py"

# =========================
# AUTO RUN BLENDER
# =========================
subprocess.run([
    BLENDER_EXE,
    "-b",
    BLEND_FILE,
    "-P",
    SCRIPT_FILE
])