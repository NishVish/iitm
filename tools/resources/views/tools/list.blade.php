<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCR Records History</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0f172a;
            color: white;
            padding: 20px;
            margin: 0;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        h2 {
            color: #6366f1;
            margin: 0;
            flex-grow: 1;
        }

        .back-btn {
            background: #334155;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            transition: 0.3s;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
        }

        .back-btn:hover {
            background: #6366f1;
        }

        .export-btn {
            background: #10b981;
            /* Green color for export */
        }

        .export-btn:hover {
            background: #059669;
        }

        .table-container {
            background: #1e293b;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #334155;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #6366f1;
            color: white;
            padding: 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #334155;
            font-size: 14px;
            color: #cbd5e1;
        }

        tr:hover {
            background: #1e293b;
            filter: brightness(1.2);
        }

        .badge-operator {
            background: #1e293b;
            color: #818cf8;
            padding: 4px 8px;
            border-radius: 5px;
            border: 1px solid #6366f1;
            font-weight: bold;
            font-size: 12px;
        }

        [contenteditable="true"]:focus {
            outline: 2px solid #6366f1;
            background: #0f172a;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="header-container">
        <h2>📄 Scanned Documents History</h2>
        <div class="header-actions">
            <button onclick="exportTableToCSV('ocr_records.csv')" class="back-btn export-btn">📥 Export CSV</button>
            <a href="{{ url()->previous() }}" class="back-btn">← Back to Scanner</a>
        </div>
    </div>

    <div class="table-container">
        <table id="ocrTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Operator</th>
                    <th>Company</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Website</th>
                    <th>Scanned At</th>
                    <th class="no-export">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                    <tr data-id="{{ $doc->id }}">
                        <td>{{ $doc->id }}</td>
                        <td><span class="badge-operator">{{ $doc->operator ?? 'System' }}</span></td>
                        <td contenteditable="true" class="editable" data-field="company_name">{{ $doc->company_name }}</td>
                        <td contenteditable="true" class="editable" data-field="person_name">
                            <strong>{{ $doc->person_name }}</strong></td>
                        <td contenteditable="true" class="editable" data-field="designation">{{ $doc->designation }}</td>
                        <td contenteditable="true" class="editable" data-field="mobile">{{ $doc->mobile }}</td>
                        <td contenteditable="true" class="editable" data-field="email">{{ $doc->email }}</td>
                        <td contenteditable="true" class="editable" data-field="address">{{ $doc->address }}</td>
                        <td contenteditable="true" class="editable" data-field="website">{{ $doc->website }}</td>
                        <td>{{ \Carbon\Carbon::parse($doc->created_at)->format('d M, Y H:i') }}</td>
                        <td class="no-export">
                            <button class="save-btn back-btn"
                                style="padding:5px 10px; font-size:12px; background:green;">Save</button>
                            <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" style="display:inline;"
                                onsubmit="return confirm('Delete this record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="back-btn"
                                    style="padding:5px 10px; font-size:12px; background:red;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" style="text-align:center; padding:40px;">No documents scanned yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        // --- CSV EXPORT FUNCTION ---
        function exportTableToCSV(filename) {
            const csv = [];
            const rows = document.querySelectorAll("#ocrTable tr");

            for (let i = 0; i < rows.length; i++) {
                const row = [], cols = rows[i].querySelectorAll("td, th");

                for (let j = 0; j < cols.length; j++) {
                    // Skip the 'Actions' column
                    if (cols[j].classList.contains('no-export')) continue;

                    // Clean text and handle commas/quotes for CSV compatibility
                    let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").replace(/"/g, '""');
                    row.push('"' + data + '"');
                }
                csv.push(row.join(","));
            }

            // Download CSV file
            const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
            const downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        // --- EXISTING SAVE LOGIC ---
        document.querySelectorAll('.save-btn').forEach(btn => {
            btn.addEventListener('click', async function () {
                const row = this.closest('tr');
                const id = row.dataset.id;
                const data = {};

                row.querySelectorAll('.editable').forEach(td => {
                    const fieldName = td.getAttribute('data-field');
                    data[fieldName] = td.innerText.trim();
                });

                const originalText = this.innerText;
                this.innerText = 'Saving...';
                this.disabled = true;

                try {
                    const token = '{{ csrf_token() }}';
                    const url = '{{ route("documents.update", ":id") }}'.replace(':id', id);

                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });

                    if (response.ok) {
                        alert('✅ Document ID ' + id + ' updated successfully!');
                    } else {
                        const errorData = await response.json();
                        alert('❌ Update failed: ' + (errorData.message || 'Unknown error'));
                    }
                } catch (err) {
                    console.error(err);
                    alert('Error occurred while updating.');
                } finally {
                    this.innerText = originalText;
                    this.disabled = false;
                }
            });
        });
    </script>
</body>

</html>