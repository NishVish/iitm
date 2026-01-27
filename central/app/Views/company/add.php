<?= view('header') ?>
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


<h2>Add Companies (Excel Paste Supported)</h2>

<p><b>Paste Excel rows below (Ctrl + V)</b></p>
<textarea id="excelPasteArea"
          placeholder="Paste from Excel here"
          style="width:100%; height:80px; margin-bottom:10px;"></textarea>

<!-- CLEAR ALL BUTTON -->
<button type="button" id="clearAllBtn"
        style="background:#dc3545;color:#fff;padding:6px 12px;border:none;">
    Clear All Data
</button>

<br><br>

<form action="<?= site_url('company/add_details') ?>" method="post">
    <button type="submit">Submit</button>
<?= csrf_field() ?>
<table border="1" cellpadding="5" cellspacing="0"
       style="width:100%; border-collapse: collapse; font-size:13px;">
    <thead style="background:#f0f0f0;">
    <tr>
        <!-- Company Info -->
        <th>Source</th>
        <th>Database Name</th>
        <th>Outbound</th>
        <th>Company Name</th>
        <th>Category</th>
        <th>Address</th>
        <th>City</th>
        <th>Pincode</th>
        <th>State</th>
        <th>Country</th>
        <th>Phone</th>

        <!-- Contact 1 -->
        <th>Contact 1 Name</th>
        <th>Designation</th>
        <th>Mobile 1</th>
        <th>Mobile 2</th>
        <th>Mobile 3</th>
        <th>Email 1</th>
        <th>Email 2</th>
        <th>Email 3</th>

        <!-- Contact 2 -->
        <th>Contact 2 Name</th>
        <th>Designation</th>
        <th>Mobile 4</th>
        <th>Mobile 5</th>
        <th>Email 4</th>
        <th>Email 5</th>

        <!-- Contact 3 -->
        <th>Contact 3 Name</th>
        <th>Designation</th>
        <th>Mobile 6</th>
        <th>Mobile 7</th>
        <th>Email 6</th>
        <th>Email 7</th>

        <!-- Actions -->
        <th>Actions</th>
    </tr>


    </thead>
<tbody id="companyTableBody">
    <tr class="companyRow">
        <!-- Basic Company Info -->
        <td><input type="text" name="companies[0][source]"></td>
        <td><input type="text" name="companies[0][database_name]"></td>
        <td style="text-align:center">
            <input type="checkbox" name="companies[0][outbound]" value="1">
        </td>
        <td><input type="text" name="companies[0][company_name]" required></td>
        <td><input type="text" name="companies[0][category]"></td>
        <td><textarea name="companies[0][address]"></textarea></td>
        <td><input type="text" name="companies[0][city]"></td>
        <td><input type="text" name="companies[0][pincode]"></td>
        <td><input type="text" name="companies[0][state]"></td>
        <td><input type="text" name="companies[0][country]" value="India"></td>
        <td><input type="text" name="companies[0][phone]"></td>

        <!-- ================= CONTACT 1 ================= -->
        <td><input type="text" name="companies[0][contact1_name]" placeholder="Contact 1 Name"></td>
        <td><input type="text" name="companies[0][contact1_designation]" placeholder="Designation"></td>
        <td><input type="text" name="companies[0][contact1_mobile1]" placeholder="Mobile 1"></td>
        <td><input type="text" name="companies[0][contact1_mobile2]" placeholder="Mobile 2"></td>
        <td><input type="text" name="companies[0][contact1_mobile3]" placeholder="Mobile 3"></td>
        <td><input type="text" name="companies[0][contact1_email1]" placeholder="Email 1"></td>
        <td><input type="text" name="companies[0][contact1_email2]" placeholder="Email 2"></td>
        <td><input type="text" name="companies[0][contact1_email3]" placeholder="Email 3"></td>

        <!-- ================= CONTACT 2 ================= -->
        <td><input type="text" name="companies[0][contact2_name]" placeholder="Contact 2 Name"></td>
        <td><input type="text" name="companies[0][contact2_designation]" placeholder="Designation"></td>
        <td><input type="text" name="companies[0][contact2_mobile1]" placeholder="Mobile 4"></td>
        <td><input type="text" name="companies[0][contact2_mobile2]" placeholder="Mobile 5"></td>
        <td><input type="text" name="companies[0][contact2_email1]" placeholder="Email 4"></td>
        <td><input type="text" name="companies[0][contact2_email2]" placeholder="Email 5"></td>

        <!-- ================= CONTACT 3 ================= -->
        <td><input type="text" name="companies[0][contact3_name]" placeholder="Contact 3 Name"></td>
        <td><input type="text" name="companies[0][contact3_designation]" placeholder="Designation"></td>
        <td><input type="text" name="companies[0][contact3_mobile1]" placeholder="Mobile 6"></td>
        <td><input type="text" name="companies[0][contact3_mobile2]" placeholder="Mobile 7"></td>
        <td><input type="text" name="companies[0][contact3_email1]" placeholder="Email 6"></td>
        <td><input type="text" name="companies[0][contact3_email2]" placeholder="Email 7"></td>

        <!-- Actions -->
        <td>
            <button type="button" class="clearBtn">Clear</button>
            <button type="button" class="removeBtn">Remove</button>
        </td>
    </tr>
</tbody>

</table>


<br>
<button type="submit">Submit</button>
</form>

<h2><h2>Add Company (Preview Only)</h2>

<form action="<?= site_url('company/add') ?>" method="post">
    <?= csrf_field() ?>

    <label>Company Name:</label><br>
    <input type="text" name="companies[0][company_name]" required><br><br>

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
