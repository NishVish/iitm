<?php
$segment1 = service('uri')->getSegment(2); 
$formVisible = ($segment1 === 'add'); // visible only for 'add'
?>

<form id="companyForm" action="<?= site_url('company/add_details') ?>" method="post">
    <?= csrf_field() ?>


    <button type="submit">Submit</button>
    <textarea id="excelPasteArea" placeholder="Paste from Excel here"></textarea>

    <!-- CLEAR ALL BUTTON -->
    <button type="button" id="clearAllBtn">Clear All Data</button>

    <!-- Table -->
    <div>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Database Name</th>
                    <th>Category</th>
                    <th>Source</th>
                    <th>Updated By</th>
                    <th>Updated At</th>
                    <th>Outbound</th>
                    
                    <th>Company Name</th>
                    <th>Address 1</th>
                    <th>Address 2</th>
                    <th>City</th>
                    <th>Pincode</th>
                    <th>State</th>
                    <th>Phone</th>
                    <th>Fax</th>

                    <!-- Contact 1 -->
                    <th>Contact Name</th>
                    <th>Designation</th>
                    <th>Mobile 1</th>
                    <th>Mobile 2</th>
                    <th>Mobile 3</th>
                    <th>Email 1</th>
                    <th>Email 2</th>
                    <th>Email 3</th>

                    <!-- Contact 2 -->
                    <th>Contact Name 2</th>
                    <th>Designation 2</th>
                    <th>Email 4</th>
                    <th>Email 5</th>
                    <th>Mobile 4</th>
                    <th>Mobile 5</th>

                    <!-- Contact 3 -->
                    <th>Contact Name 3</th>
                    <th>Designation 3</th>
                    <th>Email 6</th>
                    <th>Email 7</th>
                    <th>Mobile 6</th>
                    <th>Mobile 7</th>

                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="companyTableBody">
                <tr class="companyRow">
                    <td><input type="text" name="companies[0][database_name]"></td>
                    <td><input type="text" name="companies[0][category]"></td>
                    <td><input type="text" name="companies[0][source]"></td>
                    <td><input type="text" name="companies[0][updated_by]"></td>
                    <td><input type="datetime-local" name="companies[0][updated_at]"></td>
                    <td><input type="checkbox" name="companies[0][outbound]" value="1"></td>

                    <td><input type="text" name="companies[0][company_name]"></td>
                    <td><input type="text" name="companies[0][address_1]"></td>
                    <td><input type="text" name="companies[0][address_2]"></td>
                    <td><input type="text" name="companies[0][city]"></td>
                    <td><input type="text" name="companies[0][pincode]"></td>
                    <td><input type="text" name="companies[0][state]"></td>
                    <td><input type="text" name="companies[0][phone]"></td>
                    <td><input type="text" name="companies[0][fax]"></td>

                    <!-- Contact 1 -->
                    <td><input type="text" name="companies[0][contact1_name]"></td>
                    <td><input type="text" name="companies[0][contact1_designation]"></td>
                    <td><input type="text" name="companies[0][contact1_mobile1]"></td>
                    <td><input type="text" name="companies[0][contact1_mobile2]"></td>
                    <td><input type="text" name="companies[0][contact1_mobile3]"></td>
                    <td><input type="text" name="companies[0][contact1_email1]"></td>
                    <td><input type="text" name="companies[0][contact1_email2]"></td>
                    <td><input type="text" name="companies[0][contact1_email3]"></td>

                    <!-- Contact 2 -->
                    <td><input type="text" name="companies[0][contact2_name]"></td>
                    <td><input type="text" name="companies[0][contact2_designation]"></td>
                    <td><input type="text" name="companies[0][contact2_email1]"></td>
                    <td><input type="text" name="companies[0][contact2_email2]"></td>
                    <td><input type="text" name="companies[0][contact2_mobile1]"></td>
                    <td><input type="text" name="companies[0][contact2_mobile2]"></td>

                    <!-- Contact 3 -->
                    <td><input type="text" name="companies[0][contact3_name]"></td>
                    <td><input type="text" name="companies[0][contact3_designation]"></td>
                    <td><input type="text" name="companies[0][contact3_email1]"></td>
                    <td><input type="text" name="companies[0][contact3_email2]"></td>
                    <td><input type="text" name="companies[0][contact3_mobile1]"></td>
                    <td><input type="text" name="companies[0][contact3_mobile2]"></td>

                    <td>
                        <button type="button" class="clearBtn">Clear</button>
                        <button type="button" class="removeBtn">Remove</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>
    <button type="submit">Submit</button>
</form>

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