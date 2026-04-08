<!DOCTYPE html>
<html>

<head>
    <title>Lookup Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <h2>Lookup Test</h2>

    <textarea id="lines" rows="10" cols="50" placeholder="Paste text here..."></textarea>
    <br><br>
    <button onclick="lookup()">Parse</button>

    <h3>Result:</h3>
    <pre id="result" style="background: #f4f4f4; padding: 10px; border: 1px solid #ccc;"></pre>

    <script>
        function lookup() {
            const textArea = document.getElementById("lines");
            const resultBox = document.getElementById("result");

            let linesArray = textArea.value
                .split(/[\r\n\t]+/)
                .map(l => l.trim())
                .filter(l => l.length > 0);

            if (linesArray.length === 0) {
                resultBox.innerText = "No lines to parse";
                return;
            }

            resultBox.innerText = "Processing...";

            fetch("{{ route('ocr.lookup') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json", // <--- CRITICAL: Tells Laravel to return JSON errors
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ lines: linesArray })
            })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        // This will now show "CSRF mismatch" or "Table not found" clearly
                        throw new Error(data.message || "Server Error");
                    }
                    return data;
                })
                .then(data => {
                    resultBox.innerText = JSON.stringify(data, null, 2);
                })
                .catch(err => {
                    console.error(err);
                    resultBox.innerText = "Error: " + err.message;
                });
        }
    </script>

</body>

</html>