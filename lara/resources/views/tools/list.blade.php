<!DOCTYPE html>
<html>

<head>
    <title>OCR Records</title>
    <style>
        body {
            font-family: Arial;
            background: #0f172a;
            color: white;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #1e293b;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #334155;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: #6366f1;
        }

        tr:nth-child(even) {
            background: #0f172a;
        }

        h2 {
            color: #6366f1;
        }
    </style>
</head>

<body>

    <h2>📄 Scanned Documents</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Company</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Address</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $doc)
                <tr>
                    <td>{{ $doc->id }}</td>
                    <td>{{ $doc->company_name }}</td>
                    <td>{{ $doc->person_name }}</td>
                    <td>{{ $doc->designation }}</td>
                    <td>{{ $doc->mobile }}</td>
                    <td>{{ $doc->email }}</td>
                    <td>{{ $doc->address }}</td>
                    <td>{{ $doc->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>