from flask import Flask, request, send_from_directory, redirect, abort
import os

app = Flask(__name__)
BASE_DIR = os.path.abspath(".")

def safe_path(subpath):
    path = os.path.abspath(os.path.join(BASE_DIR, subpath))
    if not path.startswith(BASE_DIR):
        abort(403)
    return path

@app.route("/", defaults={"subpath": ""}, methods=["GET"])
@app.route("/<path:subpath>", methods=["GET"])
def index(subpath):
    if subpath.startswith(("mkdir/", "upload/", "download/", "delete/")):
        return "Not Found", 404
    current_path = safe_path(subpath)
    if not os.path.isdir(current_path):
        return abort(404)
    items = os.listdir(current_path)
    folders = sorted([i for i in items if os.path.isdir(os.path.join(current_path, i))])
    files = sorted([i for i in items if os.path.isfile(os.path.join(current_path, i))])
    parent = "/".join(subpath.split("/")[:-1]) if subpath else ""
    html = f"""
    <html>
    <body>
    <h2>NAS /{subpath}</h2>
    <a href="/{parent}">Back</a>
    <hr>
    <form action="/mkdir/{subpath}" method="POST">
        <input name="folder" placeholder="Folder name">
        <button>Create</button>
    </form>
    <form action="/upload/{subpath}" method="POST" enctype="multipart/form-data">
        <input type="file" name="file">
        <button>Upload</button>
    </form>
    <hr>
    <h3>Folders</h3>
    <ul>
    """
    for f in folders:
        path = f"{subpath}/{f}".strip("/")
        html += f'<li><a href="/{path}">{f}</a></li>'
    html += "</ul><h3>Files</h3><ul>"
    for f in files:
        file_path = f"{subpath}/{f}".strip("/")
        html += f"""
        <li>
            {f}
            <a href="/download/{file_path}">Download</a>
            <form action="/delete/{file_path}" method="POST" style="display:inline">
                <button type="submit">Delete</button>
            </form>
        </li>
        """
    html += "</ul></body></html>"
    return html

@app.route("/mkdir/", defaults={"subpath": ""}, methods=["POST"])
@app.route("/mkdir/<path:subpath>", methods=["POST"])
def mkdir(subpath):
    name = request.form.get("folder")
    if name:
        os.makedirs(safe_path(os.path.join(subpath, name)), exist_ok=True)
    return redirect("/" + subpath)

@app.route("/upload/", defaults={"subpath": ""}, methods=["POST"])
@app.route("/upload/<path:subpath>", methods=["POST"])
def upload(subpath):
    file = request.files.get("file")
    if file:
        file.save(os.path.join(safe_path(subpath), file.filename))
    return redirect("/" + subpath)

@app.route("/download/<path:filepath>", methods=["GET"])
def download(filepath):
    full = safe_path(filepath)
    return send_from_directory(os.path.dirname(full), os.path.basename(full), as_attachment=True)

@app.route("/delete/<path:filepath>", methods=["POST"])
def delete(filepath):
    path = safe_path(filepath)
    if os.path.isfile(path):
        os.remove(path)
    return redirect("/" + os.path.dirname(filepath).replace(BASE_DIR, "").lstrip("/"))

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)