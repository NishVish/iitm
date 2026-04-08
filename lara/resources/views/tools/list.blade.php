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
        }

        h2 {
            color: #6366f1;
            margin: 0;
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
        }

        .back-btn:hover {
            background: #6366f1;
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

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background: #1e293b;
            /* Subtle hover effect */
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

        /* Responsive */
        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
            }

            th,
            td {
                min-width: 120px;
            }
        }
    </style>
</head>

<body>

    <div class="header-container">
        <h2>📄 Scanned Documents History</h2>
        <a href="{{ url()->previous() }}" class="back-btn">← Back to Scanner</a>
    </div>

    <div class="table-container">
        <table>
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
                    <th>Scanned At</th>
                    <th>Actions</th> <!-- New column -->
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                    <tr data-id="{{ $doc->id }}">
                        <td>{{ $doc->id }}</td>
                        <td><span class="badge-operator">{{ $doc->operator ?? 'System' }}</span></td>
                        <td contenteditable="true" class="editable" data-field="company_name">{{ $doc->company_name }}</td>
                        <td contenteditable="true" class="editable" data-field="person_name">
                            <strong>{{ $doc->person_name }}</strong>
                        </td>
                        <td contenteditable="true" class="editable" data-field="designation">{{ $doc->designation }}</td>
                        <td contenteditable="true" class="editable" data-field="mobile">{{ $doc->mobile }}</td>
                        <td contenteditable="true" class="editable" data-field="email">{{ $doc->email }}</td>
                        <td contenteditable="true" class="editable" data-field="address">{{ $doc->address }}</td>
                        <td>{{ \Carbon\Carbon::parse($doc->created_at)->format('d M, Y H:i') }}</td>
                        <td>
                            <button class="save-btn back-btn"
                                style="padding:5px 10px;font-size:12px; background:green;">Save</button>
                            <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="back-btn"
                                    style="padding:5px 10px;font-size:12px; background:red;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 40px;">No documents scanned yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        document.querySelectorAll('.save-btn').forEach(btn => {
            btn.addEventListener('click', async function () {
                const row = this.closest('tr');
                const id = row.dataset.id;
                const data = {};

                row.querySelectorAll('.editable').forEach(td => {
                    const field = td.dataset.field;
                    data[field] = td.innerText.trim();
                });

                try {
                    const token = '{{ csrf_token() }}';
                    const baseUrl = '{{ url('/') }}'; // Base URL of your Laravel app
                    const response = await fetch(`${baseUrl}/tools/update/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify(data)
                    });

                    if (response.ok) {
                        alert('Document updated successfully!');
                    } else {
                        const text = await response.text();
                        console.error(text);
                        alert('Update failed!');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Error occurred while updating.');
                }
            });
        });
    </script>
</body>

</html>