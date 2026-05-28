<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SQL Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-sans p-3">

    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="mb-3">
            <h1 class="text-base font-bold text-gray-900 uppercase">SQL Studio</h1>
            <p class="text-[11px] text-gray-500">Run queries instantly</p>
        </div>

        <!-- Editor -->
        <div class="bg-white border rounded-lg overflow-hidden">

            <textarea id="db-sqlInput-unique" class="w-full h-28 p-3 text-xs font-mono outline-none resize-none"
                placeholder="SELECT * FROM users LIMIT 10;"></textarea>

            <div class="flex justify-between items-center px-3 py-2 bg-gray-50 border-t">

                <span class="text-[10px] text-gray-400 uppercase font-semibold">
                    Editor
                </span>

                <button onclick="executeDbQuery()" id="db-runBtn-unique"
                    class="bg-[#AA2D2C] text-white text-xs px-4 py-1.5 rounded hover:opacity-90">
                    Run
                </button>

            </div>
        </div>

        <!-- Result -->
        <div class="mt-3 bg-white border rounded-lg overflow-auto">

            <div id="db-result-container" class="p-3 text-xs text-gray-500 text-center">
                No results
            </div>

        </div>

    </div>

    <script>
        function executeDbQuery() {

            const btn = document.getElementById('db-runBtn-unique');
            const result = document.getElementById('db-result-container');
            const query = document.getElementById('db-sqlInput-unique').value;

            if (!query.trim()) return;

            btn.innerText = "Running...";
            btn.disabled = true;

            fetch('{{ url("runQuery") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ sql: query })
            })
                .then(r => r.json())
                .then(data => {

                    btn.innerText = "Run";
                    btn.disabled = false;

                    if (!data.success) {
                        result.innerHTML = `<div class="text-red-500">${data.error}</div>`;
                        return;
                    }

                    if (!data.data?.length) {
                        result.innerHTML = `<div>No rows</div>`;
                        return;
                    }

                    const rows = data.data;

                    let html = `<table class="w-full text-xs border-collapse">`;

                    html += `<thead><tr>`;
                    Object.keys(rows[0]).forEach(k => {
                        html += `<th class="text-left p-2 bg-gray-50">${k}</th>`;
                    });
                    html += `</tr></thead><tbody>`;

                    rows.forEach(r => {
                        html += `<tr class="border-t">`;
                        Object.values(r).forEach(v => {
                            html += `<td class="p-2">${v ?? '<span class="text-gray-400">null</span>'}</td>`;
                        });
                        html += `</tr>`;
                    });

                    html += `</tbody></table>`;

                    result.innerHTML = html;
                })
                .catch(() => {
                    btn.innerText = "Run";
                    btn.disabled = false;
                    result.innerHTML = `<div class="text-red-500">Network error</div>`;
                });
        }
    </script>

</body>

</html>