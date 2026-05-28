from flask import Flask, request, send_from_directory, redirect
import os

app = Flask(__name__)

BASE_DIR = "storage"
os.makedirs(BASE_DIR, exist_ok=True)

# Safe folder path
def get_path(subpath):
    path = os.path.join(BASE_DIR, subpath)
    os.makedirs(path, exist_ok=True)
    return path

# Home + folder navigation
@app.route("/", defaults={"subpath": ""})
@app.route("/<path:subpath>")
def index(subpath):

    current_path = get_path(subpath)
    items = os.listdir(current_path)

    folders = []
    files = []

    for item in items:
        full = os.path.join(current_path, item)
        if os.path.isdir(full):
            folders.append(item)
        else:
            files.append(item)

    parent = "/".join(subpath.split("/")[:-1]) if subpath else ""

    html = f"""
    <html>
    <head>
        <title>Python NAS</title>
    </head>
    <body>

    <h2>📁 NAS /{subpath}</h2>

    <a href="/{parent}">🔙 Back</a>

    <hr>

    <h3>Create Folder</h3>
    <form action="/mkdir/{subpath}" method="POST">
        <input name="folder" placeholder="Folder name">
        <button>Create</button>
    </form>

    <h3>Upload File</h3>
    <form action="/upload/{subpath}" method="POST" enctype="multipart/form-data">
        <input type="file" name="file">
        <button>Upload</button>
    </form>

    <hr>

    <h3>📂 Folders</h3>
    <ul>
    """

    for f in folders:
        path = f"{subpath}/{f}".strip("/")
        html += f'<li>📁 <a href="/{path}">{f}</a></li>'

    html += "</ul><h3>📄 Files</h3><ul>"

    for f in files:
        file_path = f"{subpath}/{f}".strip("/")
        html += f"""
        <li>
            📄 {f}
            <a href="/download/{file_path}">Download</a>
            <a href="/delete/{file_path}">Delete</a>
        </li>
        """

    html += "</ul></body></html>"

    return html

# Create folder
@app.route("/mkdir/<path:subpath>", methods=["POST"])
def mkdir(subpath):
    name = request.form.get("folder")
    path = os.path.join(BASE_DIR, subpath, name)
    os.makedirs(path, exist_ok=True)
    return redirect("/" + subpath)

# Upload file
@app.route("/upload/<path:subpath>", methods=["POST"])
def upload(subpath):
    file = request.files.get("file")
    if file:
        path = os.path.join(BASE_DIR, subpath, file.filename)
        file.save(path)
    return redirect("/" + subpath)

# Download file
@app.route("/download/<path:filepath>")
def download(filepath):
    dir_path = os.path.join(BASE_DIR, os.path.dirname(filepath))
    filename = os.path.basename(filepath)
    return send_from_directory(dir_path, filename, as_attachment=True)

# Delete file
@app.route("/delete/<path:filepath>")
def delete(filepath):
    path = os.path.join(BASE_DIR, filepath)
    if os.path.exists(path):
        os.remove(path)
    return redirect("/" + os.path.dirname(filepath))

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)