
<?= view('form/tradevisitor') ?>


<style>
#companyFormTv {
    width: 100%;
    overflow-x: auto; /* Enables horizontal scroll */
    padding: 20px 0;
}

.company-row {
    display: flex;
    flex-wrap: nowrap;    /* Strict single line */
    align-items: flex-end; /* Aligns inputs and buttons at the bottom */
    gap: 12px;
    margin-bottom: 15px;
    width: max-content;   /* Row expands as wide as the content */
    padding: 10px;
    background: #f9f9f9;
    border-radius: 8px;
}

.field-group {
    display: flex;
    flex-direction: column;
    flex: 0 0 auto;       /* Prevents shrinking */
    min-width: 130px;     /* Uniform width for all fields */
}

.field-group label {
    font-size: 11px;
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
    white-space: nowrap;
}

.field-group input {
    padding: 6px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.field-actions {
    display: flex;
    gap: 5px;
    flex: 0 0 auto;
}

.field-actions button {
    padding: 6px 12px;
    cursor: pointer;
}
</style><script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('companyFormTv');
    // We only need one template row to exist in HTML
    const templateRow = document.querySelector('.company-row');
    let companyIndex = 0;

    const excelPasteArea = document.getElementById('excelPasteArea');
    const clearAllBtn = document.getElementById('clearAllBtn');

    function createRow() {
        companyIndex++;
        // Clone the entire row including all children (labels, inputs, buttons)
        const newRow = templateRow.cloneNode(true); 

        // Update the input names and clear values
        newRow.querySelectorAll('input, textarea').forEach(input => {
            if (input.type === 'checkbox') {
                input.checked = false;
            } else {
                input.value = '';
            }
            // Update the index in the name: companies[0] becomes companies[1]
            if (input.name) {
                input.name = input.name.replace(/\[\d+\]/, `[${companyIndex}]`);
            }
        });

        // Re-attach event listeners to the new buttons
        newRow.querySelector('.removeBtn').onclick = removeRow;
        newRow.querySelector('.clearBtn').onclick = clearRow;

        return newRow;
    }

    // ... (rest of your logic for removeRow and clearRow)
    
    function removeRow(e) {
        const rows = document.querySelectorAll('.company-row');
        if (rows.length > 1) e.target.closest('.company-row').remove();
        else alert("At least one row must remain.");
    }

    function clearRow(e) {
        const row = e.target.closest('.company-row');
        row.querySelectorAll('input, textarea').forEach(el => {
            if (el.type === 'checkbox') el.checked = false;
            else el.value = '';
        });
    }

    // Attachment for initial row
    templateRow.querySelector('.removeBtn').onclick = removeRow;
    templateRow.querySelector('.clearBtn').onclick = clearRow;

    // Excel Paste logic
    excelPasteArea.addEventListener('paste', e => {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        const rows = pastedText.trim().split(/\r?\n/);
        const fragment = document.createDocumentFragment();

        rows.forEach((rowData, i) => {
            const cols = rowData.split('\t');
            let currentRow;

            // Use first row if empty, otherwise create new
            if (i === 0 && companyIndex === 0 && isRowEmpty(templateRow)) {
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
                    input.checked = value.trim().toLowerCase() === 'yes' || value.trim() === '1';
                } else {
                    input.value = value.trim();
                }
            });
        });

        if (fragment.children.length) {
            // Insert before the submit button
            form.insertBefore(fragment, form.querySelector('button[type="submit"]'));
        }
        excelPasteArea.value = '';
    });

    function isRowEmpty(row) {
        return Array.from(row.querySelectorAll('input, textarea')).every(input => {
            return input.type === 'checkbox' ? !input.checked : !input.value.trim();
        });
    }
});
</script>