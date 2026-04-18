<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Paste to Table Generator</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f4f6f8;
        }

        textarea {
            width: 100%;
            height: 220px;
            padding: 10px;
            font-size: 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            margin-top: 10px;
            margin-right: 8px;
            padding: 10px 16px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 13px;
            text-align: left;
            white-space: nowrap;
        }

        th {
            background: #111827;
            color: white;
            position: sticky;
            top: 0;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }
    </style>

    <!-- SheetJS for real Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

</head>

<body>

    <h2>Paste Data → Auto Table Generator</h2>

    <textarea id="inputData" placeholder="Paste your tab-separated data here..."></textarea>

    <br>

    <button onclick="generateTable()">Generate Table</button>
    <button onclick="downloadCSV()">Download CSV</button>
    <button onclick="downloadExcel()">Download Excel</button>

    <div class="table-container">
        <table id="outputTable"></table>
    </div>

    <script>
        function generateTable() {
            const input = document.getElementById("inputData").value;

            if (!input.trim()) {
                alert("Please paste data first");
                return;
            }

            const rows = input.split(/\n/); // ✅ keeps empty rows

            let tableHTML = "";

            rows.forEach((row, index) => {
                const cols = row.split("\t");

                tableHTML += "<tr>";

                cols.forEach(col => {
                    const value = col === undefined || col === "" ? "-" : col;

                    if (index === 0) {
                        tableHTML += `<th>${value}</th>`;
                    } else {
                        tableHTML += `<td>${value}</td>`;
                    }
                });

                tableHTML += "</tr>";
            });

            document.getElementById("outputTable").innerHTML = tableHTML;
        }

        function downloadCSV() {
            const table = document.getElementById("outputTable");
            let csv = [];

            for (let row of table.rows) {
                let cols = [];
                for (let cell of row.cells) {
                    cols.push('"' + cell.innerText.replace(/"/g, '""') + '"');
                }
                csv.push(cols.join(","));
            }

            const blob = new Blob([csv.join("\n")], { type: "text/csv;charset=utf-8;" });

            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "table.csv";
            link.click();
        }

        function downloadExcel() {
            const table = document.getElementById("outputTable");
            const wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
            XLSX.writeFile(wb, "table.xlsx");
        }
    </script>

</body>

</html>