<!DOCTYPE html>
<html>
<head>
    <title>Company Data - <?= esc($state) ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <style>
        table { border-collapse: collapse; width: 100%; max-width: 100%; }
        th, td { border: 1px solid #aaa; padding: 5px 10px; text-align: left; }
        th { background: #f2f2f2; }
        button { margin: 10px 5px; padding: 6px 12px; cursor: pointer; }
    </style>
</head>
<body>

<h2>Company Data for <?= esc($state) ?></h2>

<!-- Buttons -->
<button id="copyButton">Copy All Table</button>
<button id="downloadExcel">Download Excel</button>

<!-- Table container -->
<div style="overflow-x:auto;">
<table id="companyTable">
    <thead>
        <tr id="tableHeader"></tr>
    </thead>
    <tbody id="tableBody"></tbody>
</table>
</div>

<script>
    // Parse JSON data passed from PHP
    const data = JSON.parse('<?= addslashes($data) ?>');

    // 1️⃣ Render table
    if (data.length === 0) {
        document.getElementById('tableBody').innerHTML = '<tr><td colspan="100%">No data found</td></tr>';
    } else {
        const headers = Object.keys(data[0]);
        const headerRow = document.getElementById('tableHeader');
        headers.forEach(h => {
            const th = document.createElement('th');
            th.innerText = h.replace(/_/g, ' ');
            headerRow.appendChild(th);
        });

        const tbody = document.getElementById('tableBody');
        data.forEach(row => {
            const tr = document.createElement('tr');
            headers.forEach(h => {
                const td = document.createElement('td');
                td.innerText = row[h] ?? '';
                tr.appendChild(td);
            });
            tbody.appendChild(tr);
        });
    }

    // 2️⃣ Copy table to clipboard
    document.getElementById('copyButton').addEventListener('click', () => {
        let range = document.createRange();
        range.selectNode(document.getElementById('companyTable'));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        try {
            document.execCommand('copy');
            alert('Table copied to clipboard!');
        } catch (err) {
            alert('Failed to copy table.');
        }
        window.getSelection().removeAllRanges();
    });

    // 3️⃣ Download Excel using SheetJS
    document.getElementById('downloadExcel').addEventListener('click', () => {
        const worksheet = XLSX.utils.json_to_sheet(data);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Companies");
        XLSX.writeFile(workbook, `Company_Database_<?= $state ?>.xlsx`);
    });
</script>

</body>
</html>