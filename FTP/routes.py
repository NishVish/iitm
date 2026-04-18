import os
from flask import request, send_from_directory, render_template_string, redirect, url_for
from werkzeug.utils import secure_filename

from core import app, DEPARTMENTS, get_local_ip, generate_qr_base64, open_directory
# ==========================
# HTML (HOME PAGE)
# ==========================
HOME_HTML = '''
<!DOCTYPE html>
<html>
<head>
<title>Departments</title>
<style>
body { font-family: Arial; background:#f1f5f9; text-align:center; padding:40px; }
.grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:20px; max-width:800px; margin:auto; }
.card { background:white; padding:30px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
a { text-decoration:none; font-size:18px; font-weight:bold; color:#6366f1; }
</style>
</head>
<body>
<h1>🏢 Select Department</h1>
<div class="grid">
{% for dept in dept_list %}
<div class="card">
<a href="/{{ dept }}">{{ dept.upper() }}</a>
</div>
{% endfor %}
</div>
</body>
</html>
'''

# ==========================
# HTML (DEPARTMENT PAGE)
# ==========================
DEPT_HTML = '''
<!DOCTYPE html>
<html>
<head>
<title>{{ dept }}</title>
<style>
body { font-family: Arial; background:#f8fafc; text-align:center; padding:20px; }
.card { background:white; padding:20px; margin:20px auto; max-width:600px; border-radius:12px; }
</style>
</head>
<body>

<div class="card">
<h2>{{ dept.upper() }}</h2>
<img src="data:image/png;base64,{{ qr_code_img }}" width="150">
<p>{{ url }}</p>
</div>

<div class="card">
<h3>Files</h3>

<form method="POST" action="/{{ dept }}/open_directory">
<button>Open Folder</button>
</form>

<ul>
{% for file in files %}
<li>
{{ file }}
<a href="/{{ dept }}/download/{{ file }}">Download</a>
</li>
{% endfor %}
</ul>

</div>

<div class="card">
<h3>Upload</h3>
<form id="uploadForm">
<input type="file" name="files" multiple>
<button>Upload</button>
</form>
</div>

<script>
document.getElementById("uploadForm").addEventListener("submit", function(e){
    e.preventDefault();
    let formData = new FormData(this);
    fetch("/{{ dept }}/upload", { method:"POST", body:formData })
    .then(()=>location.reload());
});
</script>

</body>
</html>
'''

# ==========================
# ROUTES
# ==========================

@app.route("/")
def home():
    return render_template_string(HOME_HTML, dept_list=DEPARTMENTS.keys())


@app.route("/<dept>")
def dept_home(dept):
    if dept not in DEPARTMENTS:
        return "Invalid department"

    folder = DEPARTMENTS[dept]["folder"]
    files = os.listdir(folder)

    url = f"http://{get_local_ip()}:8000/{dept}"
    qr = generate_qr_base64(url)

    return render_template_string(DEPT_HTML,
        dept=dept,
        files=files,
        url=url,
        qr_code_img=qr
    )


@app.route("/<dept>/upload", methods=["POST"])
def upload(dept):
    if dept not in DEPARTMENTS:
        return "Invalid department"

    folder = DEPARTMENTS[dept]["folder"]

    for file in request.files.getlist("files"):
        if file.filename:
            file.save(os.path.join(folder, secure_filename(file.filename)))

    return "OK"


@app.route("/<dept>/download/<filename>")
def download(dept, filename):
    folder = DEPARTMENTS[dept]["folder"]
    return send_from_directory(folder, filename, as_attachment=True)


@app.route("/<dept>/open_directory", methods=["POST"])
def open_dir(dept):
    folder = DEPARTMENTS[dept]["folder"]
    open_directory(folder)
    return redirect(url_for("dept_home", dept=dept))