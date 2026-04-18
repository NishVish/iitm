from core import app
import os
from flask import render_template_string

# ==========================
# SAMPLE DATA (MISSING BEFORE)
# ==========================
DEPARTMENTS = {
    "it": {},
    "hr": {},
    "sales": {}
}

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
<p>{{ url }}</p>
</div>

</body>
</html>
'''

# ==========================
# ROUTES
# ==========================

@app.route("/")
def home():
    return render_template_string(HOME_HTML, dept_list=DEPARTMENTS.keys())


@app.route("/info")
def info():
    routes_html = ""

    for rule in app.url_map.iter_rules():
        methods = ", ".join(rule.methods)
        routes_html += f"""
        <tr>
            <td>{rule.endpoint}</td>
            <td>{methods}</td>
            <td>{rule}</td>
        </tr>
        """

    return f"""
    <html>
        <head>
            <title>Flask Routes Info</title>
            <style>
                body {{
                    font-family: Arial, sans-serif;
                    margin: 40px;
                }}
                table {{
                    border-collapse: collapse;
                    width: 100%;
                }}
                th, td {{
                    border: 1px solid #ddd;
                    padding: 10px;
                    text-align: left;
                }}
                th {{
                    background-color: #f4f4f4;
                }}
                h1 {{
                    margin-bottom: 20px;
                }}
            </style>
        </head>
        <body>
            <h1>Available Routes</h1>
            <table>
                <tr>
                    <th>Endpoint</th>
                    <th>Methods</th>
                    <th>Path</th>
                </tr>
                {routes_html}
            </table>
        </body>
    </html>
    """

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

if __name__ == "__main__":
    host = os.getenv("FLASK_HOST", "0.0.0.0")
    port = int(os.getenv("FLASK_PORT", "8000"))
    debug = os.getenv("FLASK_DEBUG", "false").lower() == "true"

    app.run(
        host=host,
        port=port,
        debug=debug,
        use_reloader=debug,
        threaded=True
    )