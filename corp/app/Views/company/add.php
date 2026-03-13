<?= view('company/side') ?>

<?php if (session()->getFlashdata('status')): ?>
    <div style="
        padding:10px;
        background:#e9f7ef;
        border:1px solid #28a745;
        color:#155724;
        margin-bottom:15px;
        font-weight:bold;">
        <?= session()->getFlashdata('status') ?>
    </div>
<?php endif; ?>



<?= view('company/insert_company_form') ?>
<?php
//view('company/fb_form') ?>

<h2><h2>Add Company (Preview Only)</h2>

<form action="<?= site_url('company/add') ?>" method="post">
    <?= csrf_field() ?>

    <label>Company Name:</label><br>
    <input type="text" name="companies[0][company_name]" ><br><br>

    <label>Database Name:</label><br>
    <input type="text" name="companies[0][database_name]"><br><br>

    <label>Outbound:</label>
    <input type="checkbox" name="companies[0][outbound]" value="1"><br><br>

    <button type="submit">Preview Company</button>
</form>
<h2>Add Company Source (Preview Only)</h2>

<form action="<?= site_url('company/source_check') ?>" method="post"> 
    <?= csrf_field() ?>

    <!-- Company ID (optional if preview, or auto-generated) -->
    <label>Company ID:</label><br>
    <input type="text" name="companies[0][company_id]" placeholder="Optional for preview"><br><br>

    <!-- Source ID -->
    <label>Source ID:</label><br>
    <input type="number" name="companies[0][source_id]" placeholder="Enter source ID"><br><br>

    <!-- Event Date -->
    <label>Event Date:</label><br>
    <input type="date" name="companies[0][event_date]" value="<?= date('Y-m-d') ?>"><br><br>

    <!-- Notes -->
    <label>Notes:</label><br>
    <input type="text" name="companies[0][notes]" placeholder="Optional notes"><br><br>

    <!-- Created At (optional, default handled by DB) -->
    <!-- We can skip created_at because DB sets current_timestamp() automatically -->

    <button type="submit">Preview Source</button>
</form>

</h2>
<script>
let companyIndex = 1;
const tableBody = document.getElementById('companyTableBody');

/* ===== CREATE NEW ROW ===== */
function createRow() {
    const template = document.querySelector('.companyRow');
    const row = template.cloneNode(true);

    row.querySelectorAll('input, textarea').forEach(el => {
        el.value = '';
        el.name = el.name.replace(/\d+/, companyIndex);
    });

    row.querySelector('.removeBtn').onclick = removeRow;
    row.querySelector('.clearBtn').onclick = clearRow;

    tableBody.appendChild(row);
    companyIndex++;
    return row;
}

/* ===== REMOVE ROW ===== */
function removeRow(e) {
    if (document.querySelectorAll('.companyRow').length > 1) {
        e.target.closest('tr').remove();
    }
}



/* ===== CLEAR ROW (EMPTY CELLS) ===== */
function clearRow(e) {
    const row = e.target.closest('tr');
    row.querySelectorAll('input, textarea').forEach(el => el.value = '');
}

/* ===== EXCEL PASTE HANDLER ===== */
document.getElementById('excelPasteArea').addEventListener('paste', function(e) {
    e.preventDefault();

    const text = (e.clipboardData || window.clipboardData).getData('text');
    const rows = text.trim().split('\n');

    rows.forEach((rowText, rowIndex) => {
        const cols = rowText.split('\t');

        let row;
        if (rowIndex === 0 && companyIndex === 1) {
            row = document.querySelector('.companyRow');
        } else {
            row = createRow();
        }

        const inputs = row.querySelectorAll('input, textarea');

        cols.forEach((value, colIndex) => {
            if (inputs[colIndex]) {
                inputs[colIndex].value = value.trim();
            }
        });
    });

    this.value = '';
});

/* attach buttons to first row */
document.querySelector('.removeBtn').onclick = removeRow;
document.querySelector('.clearBtn').onclick = clearRow;
/* ===== CLEAR ALL (EMPTY ALL CELLS) ===== */
document.getElementById('clearAllBtn').addEventListener('click', function () {
    document.querySelectorAll('#companyTableBody input, #companyTableBody textarea')
        .forEach(el => el.value = '');

    document.getElementById('excelPasteArea').value = '';
});
</script>

<h2>Add Contact</h2>

<form action="<?= site_url('contacts/savePerson') ?>" method="post">
    <input type="text" name="company_id" value="">

    <label for="priority">Priority:</label>
    <select name="priority" id="priority">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>
    <br><br>

    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="designation" placeholder="Designation">

    <input type="text" name="mobiles[]" placeholder="Mobile 1">
    <input type="text" name="mobiles[]" placeholder="Mobile 2">

    <input type="text" name="emails[]" placeholder="Email 1">
    <input type="text" name="emails[]" placeholder="Email 2">

    <button type="submit">Save Contact</button>
</form>
