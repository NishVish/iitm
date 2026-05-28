from http.server import BaseHTTPRequestHandler, HTTPServer
import subprocess
import json

class Handler(BaseHTTPRequestHandler):

    def do_POST(self):
        length = int(self.headers['Content-Length'])
        body = self.rfile.read(length)
        data = json.loads(body)

        cmd = data.get("cmd", "")

        try:
            output = subprocess.check_output(
                cmd,
                shell=True,
                cwd="C:\\",   # runs from C:\
                stderr=subprocess.STDOUT,
                text=True
            )
        except subprocess.CalledProcessError as e:
            output = e.output

        self.send_response(200)
        self.send_header('Content-Type', 'application/json')
        self.end_headers()

        self.wfile.write(json.dumps({
            "output": output
        }).encode())

HTTPServer(("127.0.0.1", 5050), Handler).serve_forever()