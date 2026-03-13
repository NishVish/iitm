



<?= view('form/tradevisitor') ?>




<style>
    /* Spreadsheet Horizontal Layout */
    #companyFormTv {
        width: 100%;
        overflow-x: auto; /* Enable horizontal scrolling */
        padding-bottom: 20px;
    }

    .company-row {
        display: flex;
        flex-wrap: nowrap;    /* Strict single line */
        width: max-content;   /* Row expands as wide as the content */
        align-items: stretch; 
        background: #fff;
        border-bottom: 1px solid #ccc;
    }

    /* Column/Cell Styling */
    .field-group {
        display: flex;
        flex-direction: column;
        flex: 0 0 auto;       /* Prevents shrinking */
        width: 150px;         /* Uniform width for spreadsheet columns */
        border-right: 1px solid #eee;
    }

    /* Spreadsheet Header Logic */
    .field-group label {
        display: none;        /* Hide labels by default */
        font-size: 12px;
        font-weight: bold;
        padding: 8px 5px;
        background: #f2f2f2;
        border-bottom: 1px solid #ccc;
        color: #333;
        white-space: nowrap;
    }

    /* Show labels ONLY on the very first row to act as headers */
    .company-row:first-of-type label {
        display: block;
    }

    /* Cell Input Styling */
    .field-group input, 
    .field-group textarea {
        border: none !important;
        padding: 10px 8px;
        width: 100%;
        box-sizing: border-box;
        outline: none;
        background: transparent;
        font-size: 13px;
    }

    .field-group input:focus {
        background: #e8f0fe;
    }

    /* Action Buttons Area */
    .field-actions {
        display: flex;
        flex-direction: column;
        flex: 0 0 auto;
        width: 120px;
        background: #fafafa;
    }

    .field-actions label {
        display: none;
        background: #f2f2f2;
        padding: 8px 5px;
        border-bottom: 1px solid #ccc;
    }

    .company-row:first-of-type .field-actions label {
        display: block;
    }

    .field-actions div {
        display: flex;
        gap: 5px;
        padding: 5px;
        margin-top: auto; /* Aligns buttons to the bottom of the cell */
    }

    .field-actions button {
        padding: 3px 8px;
        font-size: 11px;
        cursor: pointer;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('companyFormTv');
    // Select the very first row to use as the template for cloning
    const templateRow = document.querySelector('.company-row');
    const excelPasteArea = document.getElementById('excelPasteArea');
    const clearAllBtn = document.getElementById('clearAllBtn');

    // Keep track of the current index based on existing rows
    let companyIndex = document.querySelectorAll('.company-row').length - 1;

    function createRow() {
        companyIndex++;
        const newRow = templateRow.cloneNode(true);

        // Reset all inputs in the cloned row
        newRow.querySelectorAll('input, textarea').forEach(input => {
            if (input.type === 'checkbox') {
                input.checked = false;
            } else {
                input.value = '';
            }
            // Update the index in the name attribute (e.g., companies[0] -> companies[1])
            if (input.name) {
                input.name = input.name.replace(/\[\d+\]/, `[${companyIndex}]`);
            }
        });

        // Re-bind click events to the buttons in the new row
        newRow.querySelector('.removeBtn').onclick = removeRow;
        newRow.querySelector('.clearBtn').onclick = clearRow;

        return newRow;
    }

    function removeRow(e) {
        const rows = document.querySelectorAll('.company-row');
        if (rows.length > 1) {
            e.target.closest('.company-row').remove();
        } else {
            alert("At least one row must remain.");
        }
    }

    function clearRow(e) {
        const row = e.target.closest('.company-row');
        row.querySelectorAll('input, textarea').forEach(el => {
            if (el.type === 'checkbox') el.checked = false;
            else el.value = '';
        });
    }

    function isRowEmpty(row) {
        return Array.from(row.querySelectorAll('input:not([type="checkbox"]), textarea')).every(input => !input.value.trim());
    }

    // Initialize events for the first existing row(s)
    document.querySelectorAll('.company-row').forEach(row => {
        row.querySelector('.removeBtn').onclick = removeRow;
        row.querySelector('.clearBtn').onclick = clearRow;
    });

    // Excel Paste Logic - Fix: Create rows for ALL pasted data
    excelPasteArea.addEventListener('paste', e => {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        const rowsData = pastedText.trim().split(/\r?\n/);
        const fragment = document.createDocumentFragment();

        rowsData.forEach((rowData, i) => {
            const cols = rowData.split('\t');
            let currentRow;

            // If it's the first line of paste and the current first row is empty, use it.
            // Otherwise, create a brand new row.
            if (i === 0 && isRowEmpty(templateRow)) {
                currentRow = templateRow;
            } else {
                currentRow = createRow();
                fragment.appendChild(currentRow);
            }

            const inputs = currentRow.querySelectorAll('input, textarea');
            cols.forEach((value, colIndex) => {
                const input = inputs[colIndex];
                if (!input) return;
                
                if (input.type === 'checkbox') {
                    const val = value.trim().toLowerCase();
                    input.checked = (val === 'yes' || val === '1' || val === 'true');
                } else {
                    input.value = value.trim();
                }
            });
        });

        // Append all new rows to the form (before the submit button)
        if (fragment.children.length > 0) {
            const submitBtn = form.querySelector('button[type="submit"]');
            form.insertBefore(fragment, submitBtn);
        }
        
        // Clear the paste area after processing
        excelPasteArea.value = '';
    });

    // Clear All Global Button
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', () => {
            if (confirm("Clear all data in all rows?")) {
                document.querySelectorAll('.company-row input, .company-row textarea').forEach(el => {
                    if (el.type === 'checkbox') el.checked = false;
                    else el.value = '';
                });
            }
        });
    }
});
</script>