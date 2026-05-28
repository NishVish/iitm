<!DOCTYPE html>
<html>

<head>
    <title>Laravel CMD Runner</title>

    <style>
        body {
            margin: 0;
            background: #0d0d0d;
            font-family: monospace;
            color: #00ff88;
        }

        .terminal {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .output {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            white-space: pre-wrap;
        }

        .input-bar {
            display: flex;
            border-top: 1px solid #222;
            background: #111;
        }

        .prompt {
            padding: 10px;
            color: #00ff88;
        }

        input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            color: #00ff88;
            padding: 10px;
            font-family: monospace;
        }

        button {
            background: #00ff88;
            border: none;
            color: #000;
            padding: 10px 15px;
            cursor: pointer;
        }

        button:hover {
            background: #00cc66;
        }

        .line {
            margin-bottom: 8px;
        }

        .cmd {
            color: #ffffff;
        }

        .out {
            color: #00ff88;
        }

        .error {
            color: #ff5555;
        }
    </style>
</head>

<body>

    <div class="terminal">

        <div class="output" id="output"></div>

        <div class="input-bar">
            <div class="prompt">C:\\&gt;</div>
            <input id="cmd" autocomplete="off" />
            <button onclick="runCmd()">Run</button>
        </div>

    </div>

    <script>
        const output = document.getElementById('output');
        const input = document.getElementById('cmd');

        function append(text, className = 'out') {
            const div = document.createElement('div');
            div.className = className + ' line';
            div.textContent = text;
            output.appendChild(div);
            output.scrollTop = output.scrollHeight;
        }

        async function runCmd() {
            const cmd = input.value.trim();
            if (!cmd) return;

            append(`> ${cmd}`, 'cmd');
            input.value = '';

            try {
                const res = await fetch("{{ url('/run-command') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ cmd })
                });

                const data = await res.json();

                if (data.output) {
                    append(data.output, 'out');
                } else {
                    append('No output', 'error');
                }

            } catch (err) {
                append('Request failed', 'error');
            }
        }

        input.addEventListener("keydown", function (e) {
            if (e.key === "Enter") runCmd();
        });
    </script>

</body>

</html>