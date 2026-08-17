<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tools Dashboard</title>
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg: #0f172a;
            --card-bg: #1e293b;
            --text: #f8fafc;
            --text-muted: #94a3b8;
            --border: #334155;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 800px;
        }

        h1 {
            color: var(--primary);
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        h3 {
            margin-top: 0;
            color: var(--text);
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .btn-container {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #334155;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        /* Input Section Styling */
        .input-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        input[type="text"] {
            flex-grow: 1;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--bg);
            color: white;
            outline: none;
            transition: border 0.2s;
        }

        input[type="text"]:focus {
            border-color: var(--primary);
        }

        .empty-state {
            color: var(--text-muted);
            font-style: italic;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>🛠️ Admin Tools</h1>

        @include('tools.whatsapp')

        <div class="card">
            <h3>🖨️ Badge Printing</h3>
            <p>Direct thermal printing for event attendee badges and labels.</p>
            <div class="btn-container">
                <a href="{{ url('badgeprint') }}" class="btn">Launch Badge Module</a>
            </div>
        </div>

        <div class="card">
            <h3>📄 Image to Text (OCR)</h3>
            <p>Select an operator to scan new documents or view their historical records.</p>

            <div class="btn-container"
                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px;">
                @forelse($operators as $operator)
                    <div
                        style="background: var(--bg); padding: 15px; border-radius: 10px; border: 1px solid var(--border); display: flex; flex-direction: column; gap: 10px;">
                        <span style="font-weight: bold; color: var(--primary); font-size: 1.1rem;">👤 {{ $operator }}</span>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ url('scanner/' . $operator) }}" class="btn"
                                style="flex: 1; font-size: 12px; padding: 8px;">
                                🚀 Scan New
                            </a>
                            <a href="{{ url('ocrdata/' . $operator) }}" class="btn btn-secondary"
                                style="flex: 1; font-size: 12px; padding: 8px;">
                                📊 View Data
                            </a>
                        </div>
                    </div>
                @empty
                    <span class="empty-state">No active operator sessions found.</span>
                @endforelse
            </div>

            <div class="input-group">
                <input type="text" id="new-operator-name" placeholder="Enter new operator name...">
                <button onclick="openScanner()" class="btn">Start New Session</button>
            </div>
        </div>
    </div>

    <script>
        function openScanner() {
            const nameInput = document.getElementById('new-operator-name');
            const name = nameInput.value.trim();

            if (name) {
                // Construct the dynamic URL
                const targetUrl = "{{ url('scanner') }}/" + encodeURIComponent(name);
                window.location.href = targetUrl;
            } else {
                nameInput.style.borderColor = "#ef4444";
                setTimeout(() => nameInput.style.borderColor = "#334155", 2000);
            }
        }

        // Allow 'Enter' key support
        document.getElementById('new-operator-name').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                openScanner();
            }
        });
    </script>
</body>

</html>