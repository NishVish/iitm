
<!DOCTYPE html>
<html>
<head>
  <title>System Details</title>
  <meta charset="UTF-8">
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .header input[type="text"] {
      padding: 6px;
      width: 300px;
    }

    .header button {
      padding: 6px 12px;
      background-color: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }

    .header button:hover {
      background-color: #0056b3;
    }

    .save-btn {
      background-color: #28a745;
      color: white;
      padding: 4px 8px;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }

    .save-btn:hover {
      background-color: #218838;
    }

    td[contenteditable="true"] {
      background-color: #fff8e1;
    }
  </style>
</head>
<body>

  <div class="header">
    <h2>System Details</h2>
    <div>
      <input type="text" id="search" placeholder="Search employee...">
      <button id="downloadExcelBtn">Download Excel</button>
    </div>
  </div>

  <table id="databasetable">
    <thead>
      <tr>
        <th>Emp No</th>
        <th>Short Name</th>
        <th>Full Name</th>
        <th>Years of Using</th>
        <th>Status</th>
        <th>Device</th>
        <th>Processor</th>
        <th>Gen</th>
        <th>RAM</th>
        <th>Storage</th>
        <th>Graphics</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php if (!empty($system_details)): ?>
      <?php foreach ($system_details as $row): ?>
        <tr data-id="<?= esc($row['emp_no']) ?>">
          <td><?= esc($row['emp_no'] ?? '') ?></td>
          <td contenteditable="true"><?= esc($row['short_name'] ?? '') ?></td>
          <td contenteditable="true"><?= esc($row['full_name'] ?? '') ?></td>
          <td contenteditable="true"><?= esc($row['years_of_using'] ?? '') ?></td>
          <td contenteditable="true"><?= esc($row['status'] ?? '') ?></td>
          <td contenteditable="true"><?= esc($row['device'] ?? '') ?></td>
          <td contenteditable="true"><?= esc($row['processor'] ?? '') ?></td>
          <td contenteditable="true"><?= esc($row['gen'] ?? '') ?></td>
          <td contenteditable="true"><?= esc($row['ram'] ?? '') ?></td>
          <td contenteditable="true"><?= esc($row['storage'] ?? '') ?></td>
          <td contenteditable="true"><?= esc($row['graphics'] ?? '') ?></td>
          <td><button class="save-btn">Save</button></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="12">No data available.</td></tr>
    <?php endif; ?>
    </tbody>
  </table>

  <!-- SheetJS for Excel export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
  // Download as Excel
  document.getElementById("downloadExcelBtn").addEventListener("click", function () {
    const table = document.getElementById("databasetable");
    const wb = XLSX.utils.table_to_book(table, { sheet: "System Details" });
    XLSX.writeFile(wb, "system_details.xlsx");
  });

  // Search filter
  document.getElementById('search').addEventListener('keyup', function () {
    const term = this.value.toLowerCase();
    const rows = document.querySelectorAll('#databasetable tbody tr');

    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(term) ? '' : 'none';
    });
  });

  // Save button functionality (AJAX)
  document.querySelectorAll('.save-btn').forEach(button => {
    button.addEventListener('click', function () {
      const row = this.closest('tr');
      const empNo = row.getAttribute('data-id');
      const cells = row.querySelectorAll('td[contenteditable="true"]');
      const data = {
        emp_no: empNo,
        short_name: cells[0].textContent.trim(),
        full_name: cells[1].textContent.trim(),
        years_of_using: cells[2].textContent.trim(),
        status: cells[3].textContent.trim(),
        device: cells[4].textContent.trim(),
        processor: cells[5].textContent.trim(),
        gen: cells[6].textContent.trim(),
        ram: cells[7].textContent.trim(),
        storage: cells[8].textContent.trim(),
        graphics: cells[9].textContent.trim(),
      };

      console.log('Data to send:', data);


fetch('/sphereintranet/hr/update-system-details', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify(data)
})

.then(response => {
  if (!response.ok) {
    throw new Error(`HTTP error! status: ${response.status} - ${response.statusText}`);
  }
  return response.json();
})
.then(data => {
  if (data.status === 'success') {
    alert('Update successful');
  } else {
    alert('Update failed');
  }
})
.catch(error => console.error('Error:', error));

    });  // <-- closes click listener function
  });  // <-- closes forEach
</script>


</body>
</html>
