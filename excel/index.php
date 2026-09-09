<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paste Data → Table</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f8;
            color: #222;
        }

        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 20px;
        }

        h1 {
            margin-bottom: 8px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 25px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        textarea {
            width: 100%;
            min-height: 220px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 7px;
            resize: vertical;
            font-family: monospace;
            font-size: 14px;
        }

        .controls {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        button {
            border: 0;
            padding: 11px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-success {
            background: #16a34a;
            color: white;
        }

        .btn-dark {
            background: #333;
            color: white;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        button:hover {
            opacity: 0.9;
        }

        .table-wrapper {
            overflow-x: auto;
            border: 1px solid #ddd;
            border-radius: 7px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th {
            background: #1f2937;
            color: white;
            padding: 12px;
            border: 1px solid #374151;
            text-align: left;
            white-space: nowrap;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
            min-width: 100px;
            vertical-align: top;
        }

        td[contenteditable="true"] {
            background: #fffdf2;
            outline: none;
        }

        td[contenteditable="true"]:focus {
            box-shadow: inset 0 0 0 2px #2563eb;
        }

        .empty {
            padding: 30px;
            text-align: center;
            color: #777;
        }

        .status {
            margin-top: 10px;
            color: #555;
            font-size: 13px;
        }

        .separator-info {
            font-size: 13px;
            color: #777;
            margin-top: 8px;
        }

        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: white;
        }

        @media print {
            body {
                background: white;
            }

            .input-section,
            .controls,
            .subtitle {
                display: none !important;
            }

            .card {
                box-shadow: none;
                padding: 0;
            }

            table {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Paste Data → Table</h1>
    <div class="subtitle">
        Paste your data below and convert it into a clean table.
    </div>

    <div class="card input-section">

        <label><strong>Paste your data</strong></label>

        <textarea id="dataInput"
            placeholder="Example:

Name    Age    City
John    25     Delhi
Rahul   30     Mumbai
Amit    28     Bangalore

You can paste data from Excel, Google Sheets, CSV, etc."></textarea>

        <div class="separator-info">
            The tool automatically detects tabs, commas, semicolons or pipes.
        </div>

        <div class="controls">

            <select id="separator">
                <option value="auto">Auto Detect Separator</option>
                <option value="tab">Tab</option>
                <option value=",">Comma (,)</option>
                <option value=";">Semicolon (;)</option>
                <option value="|">Pipe (|)</option>
            </select>

            <button class="btn-primary" onclick="renderTable()">
                Render Table
            </button>

            <button class="btn-dark" onclick="clearAll()">
                Clear
            </button>

        </div>

        <div id="status" class="status"></div>
    </div>


    <div class="card">

        <div class="controls" style="margin-top:0;margin-bottom:15px;">

            <button class="btn-success" onclick="downloadCSV()">
                Download CSV
            </button>

            <button class="btn-primary" onclick="downloadHTML()">
                Download HTML Table
            </button>

            <button class="btn-dark" onclick="window.print()">
                Print / PDF
            </button>

        </div>

        <div class="table-wrapper">
            <div id="tableContainer">
                <div class="empty">
                    Your table will appear here.
                </div>
            </div>
        </div>

    </div>

</div>


<script>

let tableData = [];


/*
|--------------------------------------------------------------------------
| Detect separator
|--------------------------------------------------------------------------
*/

function detectSeparator(text) {

    const lines = text
        .split(/\r?\n/)
        .filter(line => line.trim() !== '');

    if (!lines.length) {
        return '\t';
    }

    const firstLine = lines[0];

    const candidates = [
        '\t',
        ',',
        ';',
        '|'
    ];

    let bestSeparator = '\t';
    let bestCount = 0;

    candidates.forEach(separator => {

        const count = firstLine.split(separator).length - 1;

        if (count > bestCount) {
            bestCount = count;
            bestSeparator = separator;
        }

    });

    return bestSeparator;
}


/*
|--------------------------------------------------------------------------
| Parse CSV properly
|--------------------------------------------------------------------------
*/

function parseCSVLine(line, separator) {

    const result = [];
    let current = '';
    let insideQuotes = false;

    for (let i = 0; i < line.length; i++) {

        const char = line[i];

        if (char === '"') {

            if (
                insideQuotes &&
                line[i + 1] === '"'
            ) {
                current += '"';
                i++;
            } else {
                insideQuotes = !insideQuotes;
            }

        } else if (
            char === separator &&
            !insideQuotes
        ) {

            result.push(current.trim());
            current = '';

        } else {

            current += char;
        }
    }

    result.push(current.trim());

    return result;
}


/*
|--------------------------------------------------------------------------
| Render table
|--------------------------------------------------------------------------
*/

function renderTable() {

    const input = document.getElementById('dataInput').value.trim();

    if (!input) {

        alert('Please paste some data first.');
        return;
    }

    let separatorValue =
        document.getElementById('separator').value;

    let separator;

    if (separatorValue === 'auto') {
        separator = detectSeparator(input);
    } else if (separatorValue === 'tab') {
        separator = '\t';
    } else {
        separator = separatorValue;
    }

    const lines = input
        .split(/\r?\n/)
        .filter(line => line.trim() !== '');

    tableData = lines.map(line =>
        parseCSVLine(line, separator)
    );


    /*
    |--------------------------------------------------------------------------
    | Make all rows same number of columns
    |--------------------------------------------------------------------------
    */

    let maxColumns = 0;

    tableData.forEach(row => {

        if (row.length > maxColumns) {
            maxColumns = row.length;
        }

    });

    tableData.forEach(row => {

        while (row.length < maxColumns) {
            row.push('');
        }

    });


    /*
    |--------------------------------------------------------------------------
    | Build table
    |--------------------------------------------------------------------------
    */

    let html = '<table id="dataTable">';

    // First row as header
    html += '<thead><tr>';

    tableData[0].forEach((cell, index) => {

        html += `
            <th>
                ${escapeHTML(cell || 'Column ' + (index + 1))}
            </th>
        `;

    });

    html += '</tr></thead>';

    // Remaining rows
    html += '<tbody>';

    for (let i = 1; i < tableData.length; i++) {

        html += '<tr>';

        tableData[i].forEach((cell, colIndex) => {

            html += `
                <td
                    contenteditable="true"
                    data-row="${i}"
                    data-col="${colIndex}"
                    oninput="updateCell(this)"
                >
                    ${escapeHTML(cell)}
                </td>
            `;

        });

        html += '</tr>';
    }

    html += '</tbody>';
    html += '</table>';

    document.getElementById('tableContainer').innerHTML = html;

    document.getElementById('status').innerText =
        `${tableData.length} rows × ${maxColumns} columns`;
}


/*
|--------------------------------------------------------------------------
| Update cell after editing
|--------------------------------------------------------------------------
*/

function updateCell(element) {

    const row = parseInt(element.dataset.row);
    const col = parseInt(element.dataset.col);

    tableData[row][col] = element.innerText;
}


/*
|--------------------------------------------------------------------------
| Escape HTML
|--------------------------------------------------------------------------
*/

function escapeHTML(value) {

    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}


/*
|--------------------------------------------------------------------------
| Download CSV
|--------------------------------------------------------------------------
*/

function downloadCSV() {

    if (!tableData.length) {

        alert('Please render a table first.');
        return;
    }

    let csv = '';

    tableData.forEach(row => {

        csv += row.map(cell => {

            cell = String(cell ?? '');

            // Escape quotes
            cell = cell.replace(/"/g, '""');

            return `"${cell}"`;

        }).join(',') + '\r\n';

    });

    const blob = new Blob(
        ['\ufeff' + csv],
        {
            type: 'text/csv;charset=utf-8;'
        }
    );

    const url = URL.createObjectURL(blob);

    const link = document.createElement('a');

    link.href = url;
    link.download = 'table-data.csv';

    document.body.appendChild(link);

    link.click();

    document.body.removeChild(link);

    URL.revokeObjectURL(url);
}


/*
|--------------------------------------------------------------------------
| Download HTML table
|--------------------------------------------------------------------------
*/

function downloadHTML() {

    if (!tableData.length) {

        alert('Please render a table first.');
        return;
    }

    let html = `
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Downloaded Table</title>

<style>

body {
    font-family: Arial, sans-serif;
    margin: 30px;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th {
    background: #1f2937;
    color: white;
}

th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
}

tr:nth-child(even) {
    background: #f5f5f5;
}

</style>

</head>

<body>

<table>
`;

    // Header
    html += '<thead><tr>';

    tableData[0].forEach(cell => {

        html += `<th>${escapeHTML(cell)}</th>`;

    });

    html += '</tr></thead>';

    // Body
    html += '<tbody>';

    for (let i = 1; i < tableData.length; i++) {

        html += '<tr>';

        tableData[i].forEach(cell => {

            html += `<td>${escapeHTML(cell)}</td>`;

        });

        html += '</tr>';
    }

    html += `
</tbody>
</table>

</body>
</html>
`;

    const blob = new Blob(
        [html],
        {
            type: 'text/html;charset=utf-8'
        }
    );

    const url = URL.createObjectURL(blob);

    const link = document.createElement('a');

    link.href = url;
    link.download = 'table.html';

    document.body.appendChild(link);

    link.click();

    document.body.removeChild(link);

    URL.revokeObjectURL(url);
}


/*
|--------------------------------------------------------------------------
| Clear everything
|--------------------------------------------------------------------------
*/

function clearAll() {

    document.getElementById('dataInput').value = '';

    document.getElementById('tableContainer').innerHTML =
        '<div class="empty">Your table will appear here.</div>';

    document.getElementById('status').innerText = '';

    tableData = [];
}

</script>

</body>
</html>
