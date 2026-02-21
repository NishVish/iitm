
<?= view('form/tradevisitor') ?>


 
<style>
form {
    width: 100%;
    overflow-x: auto;
    font-family: Arial, sans-serif;
}

textarea {
    width: 100%;
    min-height: 80px;
    margin-bottom: 10px;
    padding: 5px;
}

.company-row {
    display: flex;
    flex-wrap: nowrap; /* all fields in a single row */
    gap: 10px;
    align-items: flex-start;
    margin-bottom: 20px;
}

.field-group {
    display: flex;
    flex-direction: column;
    min-width: 120px; /* adjust field width */
}

.field-group label {
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 2px;
}

.field-group input {
    padding: 3px 5px;
    font-size: 12px;
}

.field-actions {
    display: flex;
    gap: 5px;
    margin-left: 10px;
    align-items: flex-end;
}
</style> 

<script>
document.addEventListener("DOMContentLoaded", function () {
    let companyIndex = 0; // Start at 0 for the first row
    const form = document.getElementById('companyForm');
    const templateRow = document.querySelector('.company-row');

    function createRow() {
        companyIndex++;
        const newRow = templateRow.cloneNode(true);
        
        // Update indices in name attributes: companies[0][...] -> companies[1][...]
        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
            input.name = input.name.replace(/\[\d+\]/, `[${companyIndex}]`);
            if (input.type === 'checkbox') input.checked = false;
        });

        // Add event listeners to buttons in the new row
        newRow.querySelector('.removeBtn').onclick = function() { newRow.remove(); };
        newRow.querySelector('.clearBtn').onclick = function() {
            newRow.querySelectorAll('input').forEach(i => i.value = '');
        };

        // Insert before the Submit button
        form.insertBefore(newRow, form.querySelector('button[type="submit"]'));
        return newRow;
    }

    document.getElementById('excelPasteArea').addEventListener('paste', function (e) {
        e.preventDefault();
        const clipboardData = e.clipboardData || window.clipboardData;
        const pastedText = clipboardData.getData('text');
        
        // Split by new line for rows, then by tab for columns
        const rows = pastedText.trim().split(/\r?\n/);

        rows.forEach((rowData, i) => {
            const cols = rowData.split('\t');
            let currentRow;

            // Use the first row if it's empty, otherwise create a new one
            if (i === 0 && companyIndex === 0 && isRowEmpty(templateRow)) {
                currentRow = templateRow;
            } else {
                currentRow = createRow();
            }

            const inputs = currentRow.querySelectorAll('input');
            cols.forEach((value, colIndex) => {
                if (inputs[colIndex]) {
                    if (inputs[colIndex].type === 'checkbox') {
                        inputs[colIndex].checked = (value.toLowerCase() === 'yes' || value === '1');
                    } else {
                        inputs[colIndex].value = value.trim();
                    }
                }
            });
        });
        
        this.value = ''; // Clear textarea after paste
    });

    function isRowEmpty(row) {
        const firstInput = row.querySelector('input[type="text"]');
        return firstInput ? firstInput.value === '' : true;
    }

    // Initial first row button logic
    templateRow.querySelector('.removeBtn').onclick = function() {
        if(document.querySelectorAll('.company-row').length > 1) templateRow.remove();
    };
    templateRow.querySelector('.clearBtn').onclick = function() {
        templateRow.querySelectorAll('input').forEach(i => i.value = '');
    };
    
    document.getElementById('clearAllBtn').onclick = () => {
        location.reload(); // Quickest way to reset everything
    };
});

/* ===== REMOVE ROW ===== */
function removeRow(e) {
    const rows = document.querySelectorAll('.company-row');
    if (rows.length > 1) {
        e.target.closest('.company-row').remove();
    } else {
        alert("At least one row must remain.");
    }
}

/* ===== CLEAR ROW ===== */
function clearRow(e) {
    const row = e.target.closest('.company-row');
    row.querySelectorAll('input, textarea').forEach(el => {
        el.value = '';
        if (el.type === 'checkbox') el.checked = false;
    });
}

/* ===== CLEAR ALL ===== */
document.getElementById('clearAllBtn').addEventListener('click', function() {
    document.querySelectorAll('.company-row input, .company-row textarea')
        .forEach(el => {
            el.value = '';
            if (el.type === 'checkbox') el.checked = false;
        });
    document.getElementById('excelPasteArea').value = '';
});

/* Attach handlers to first row buttons */
templateRow.querySelector('.removeBtn').onclick = removeRow;
templateRow.querySelector('.clearBtn').onclick = clearRow;
</script>