<!DOCTYPE html>
<html>

<head>
    <title>Database Schema Viewer</title>

    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        .table-box {
            margin-bottom: 40px;
        }

        h2 {
            background: #333;
            color: #fff;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background: #f4f4f4;
        }
    </style>
</head>

<body>

    <h1>Database Schema (Live JSON)</h1>

    <div id="container">Loading...</div>
    <script>
        fetch('{{ url('getDatabaseSchema') }}')
            .then(res => res.json())
            .then(data => {

                let html = '';

                data.forEach(table => {

                    const columns = table.columns || table.Columns || [];

                    html += `<div class="table-box">`;
                    html += `<h2>Table: ${table.table || table.Table}</h2>`;

                    html += `<table>
                        <thead>
                            <tr>
                                <th>Column Name</th>
                                <th>Type</th>
                                <th>Max Length</th>
                                <th>Primary Key</th>
                                <th>Nullable</th>
                                <th>Default</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    columns.forEach(col => {
                        html += `
    <tr>
        <td>${col['Column Name']}</td>
        <td>${col['Type']}</td>
        <td>${col['Max Length'] ?? ''}</td>
        <td>${col['Primary Key']}</td>
        <td>${col['Nullable']}</td>
        <td>${col['Default'] ?? ''}</td>
    </tr>
    `;
                    });

                    html += `</tbody></table></div>`;
                });

                document.getElementById('container').innerHTML = html;
            })
            .catch(err => {
                console.error(err);
                document.getElementById('container').innerHTML = "Error loading schema";
            });
    </script>

</body>

</html>