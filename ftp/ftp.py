from flask import Flask, request, jsonify, send_from_directory, render_template_string
import os
import shutil

app = Flask(__name__)

BASE_DIR = os.path.dirname(os.path.abspath(__file__))


def safe_path(path: str):
    path = (path or "").strip().lstrip("/")
    full_path = os.path.abspath(os.path.join(BASE_DIR, path))

    if not full_path.startswith(BASE_DIR):
        return BASE_DIR

    return full_path


HTML = """
<!DOCTYPE html>
<html>
<head>
<title>File Explorer</title>
<style>
body { margin:0; font-family: Arial; display:flex; height:100vh; }
#left { width:60%; padding:15px; border-right:1px solid #ddd; overflow-y:auto; }
#right { width:40%; padding:15px; }
.file { padding:8px; cursor:pointer; }
.file:hover { background:#f0f0f0; }
.folder { font-weight:bold; color:blue; }
.topbar { margin-bottom:10px; }
</style>
</head>
<body>

<div id="left">
    <div class="topbar">
        <button onclick="goBack()">⬅ Back</button>
        <span id="path"></span>
    </div>

    <button onclick="downloadFolder()">📦 Download Folder</button>
    <div id="fileList"></div>
</div>

<div id="right">
    <h3>Chat</h3>
    <textarea id="chat" rows="25" style="width:100%"></textarea>
</div>

<script>

let currentPath = "";

function normalize(p){
    return (p || "").replace(/^\\/+/, "");
}

function loadFiles(path=""){
    path = normalize(path);
    currentPath = path;

    fetch("/list?path=" + encodeURIComponent(path))
    .then(r => r.json())
    .then(data => {
        document.getElementById("fileList").innerHTML = "";
        document.getElementById("path").innerText = path;

        data.forEach(item => {
            let div = document.createElement("div");
            div.className = "file " + (item.is_dir ? "folder" : "");
            div.innerText = item.name;

            if(item.is_dir){
                div.onclick = () => {
                    let next = path ? path + "/" + item.name : item.name;
                    loadFiles(next);
                }
            } else {
                div.onclick = () => {
                    let f = path ? path + "/" + item.name : item.name;
                    window.open("/download?file=" + encodeURIComponent(f));
                }
            }

            document.getElementById("fileList").appendChild(div);
        });
    });
}

function goBack(){
    if(!currentPath) return;
    let parts = currentPath.split("/").filter(x => x);
    parts.pop();
    loadFiles(parts.join("/"));
}

function downloadFolder(){
    if(!currentPath) return alert("Root cannot be zipped");
    window.open("/download_folder?path=" + encodeURIComponent(currentPath));
}

loadFiles("");

</script>

</body>
</html>
"""


@app.route("/")
def home():
    return render_template_string(HTML)


@app.route("/list")
def list_files():
    path = request.args.get("path", "")
    full_path = safe_path(path)

    if not os.path.exists(full_path):
        return jsonify([])

    items = []
    for name in os.listdir(full_path):
        items.append({
            "name": name,
            "is_dir": os.path.isdir(os.path.join(full_path, name))
        })

    return jsonify(items)


@app.route("/download")
def download():
    file_path = request.args.get("file", "")
    full_path = safe_path(file_path)

    directory = os.path.dirname(full_path)
    filename = os.path.basename(full_path)

    return send_from_directory(directory, filename, as_attachment=True)


@app.route("/download_folder")
def download_folder():
    folder_path = request.args.get("path", "")
    full_path = safe_path(folder_path)

    zip_base = os.path.join(BASE_DIR, "folder_zip_temp")

    if os.path.exists(zip_base + ".zip"):
        os.remove(zip_base + ".zip")

    shutil.make_archive(zip_base, "zip", full_path)

    return send_from_directory(BASE_DIR, "folder_zip_temp.zip", as_attachment=True)


@app.route("/chat", methods=["POST"])
def chat():
    msg = request.json.get("message", "")
    return jsonify({"reply": "You said: " + msg})


if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0", port=5000)