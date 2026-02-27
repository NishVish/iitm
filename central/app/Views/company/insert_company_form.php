


<!-- <script>
const detachedSubmit = document.getElementById('detachedSubmit');
const companyForm = document.getElementById('companyFormTv');



// Submit the form when detached button is clicked
detachedSubmit.addEventListener('click', () => {
    companyForm.submit();
}); -->
<!-- </script> -->
<?= view('form/tradevisitor') ?>


<style>
/* Layout Fixes for 15,000 rows */
#companyFormTv {
    width: 100%;
    overflow-x: auto;
    padding: 20px 0;
    display: flex;
    flex-direction: column;
}

.company-row {
    display: flex;
    flex-wrap: nowrap;     /* Maintains spreadsheet-style horizontal line */
    align-items: flex-end; 
    gap: 12px;
    margin-bottom: 10px;
    width: max-content;    /* Allows the row to be as wide as its inputs */
    padding: 10px;
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    transition: background 0.1s;
}

.company-row:hover {
    background: #f1f1f1;
}

.field-group {
    display: flex;
    flex-direction: column;
    flex: 0 0 auto;
    min-width: 135px; 
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

/* Sticky top area for the paste box so it follows you as you scroll */
.excel-sticky-top {
    position: sticky;
    top: 0;
    background: #fff;
    padding: 15px;
    z-index: 1000;
    border-bottom: 2px solid #4CAF50;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.sticky-submit {
    position: sticky;   /* Makes it stick */
    top: 10px;          /* Distance from top of viewport */
    background: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    z-index: 1000;      /* Stay on top of other content */
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    cursor: pointer;
}

/* Optional: hover effect */
.sticky-submit:hover {
    background: #45a049;
}


</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('companyFormTv');
    const excelPasteArea = document.getElementById('excelPasteArea');
    const templateRow = document.querySelector('.company-row');
    const submitBtn = form.querySelector('button[type="submit"]');
    let companyIndex = 0;

    // Helper: Is the row empty?
    function isRowEmpty(row) {
        return Array.from(row.querySelectorAll('input, textarea')).every(input => {
            return input.type === 'checkbox' ? !input.checked : !input.value.trim();
        });
    }

    // Helper: Generate a new row correctly indexed
    function createRow(index) {
        const newRow = templateRow.cloneNode(true);
        newRow.querySelectorAll('input, textarea').forEach(input => {
            if (input.type === 'checkbox') input.checked = false;
            else input.value = '';
            
            if (input.name) {
                // Correctly replaces companies[0] with companies[150], etc.
                input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
            }
        });
        // Attach button logic to the new clone
        newRow.querySelector('.removeBtn').onclick = removeRow;
        newRow.querySelector('.clearBtn').onclick = clearRow;
        return newRow;
    }

    function removeRow(e) {
        if (document.querySelectorAll('.company-row').length > 1) {
            e.target.closest('.company-row').remove();
        } else {
            alert("Cannot remove the last row.");
        }
    }

    function clearRow(e) {
        const row = e.target.closest('.company-row');
        row.querySelectorAll('input, textarea').forEach(el => {
            if (el.type === 'checkbox') el.checked = false;
            else el.value = '';
        });
    }

    // Bind original template row buttons
    if (templateRow.querySelector('.removeBtn')) templateRow.querySelector('.removeBtn').onclick = removeRow;
    if (templateRow.querySelector('.clearBtn')) templateRow.querySelector('.clearBtn').onclick = clearRow;

    // Fast Paste Handler
    excelPasteArea.addEventListener('paste', e => {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        const lines = pastedText.trim().split(/\r?\n/);
        
        if (lines.length > 15000) {
            alert("Processing 15,000+ rows. Please wait a moment...");
        }

        const fragment = document.createDocumentFragment();
        // Check if we can overwrite the first row
        const canUseFirstRow = isRowEmpty(templateRow) && companyIndex === 0;

        lines.forEach((line, i) => {
            const cols = line.split('\t');
            let currentRow;

            if (i === 0 && canUseFirstRow) {
                currentRow = templateRow;
            } else {
                companyIndex++;
                currentRow = createRow(companyIndex);
                fragment.appendChild(currentRow);
            }

            const inputs = currentRow.querySelectorAll('input, textarea');
            cols.forEach((value, colIndex) => {
                const input = inputs[colIndex];
                if (!input) return;
                
                if (input.type === 'checkbox') {
                    const checkVal = value.trim().toLowerCase();
                    input.checked = ['yes', '1', 'true', 'on'].includes(checkVal);
                } else {
                    input.value = value.trim();
                }
            });
        });

        // Bulk insert into DOM - this prevents the "not expanding" freeze
        if (fragment.children.length > 0) {
            form.insertBefore(fragment, submitBtn);
        }
        
        excelPasteArea.value = ''; // Reset the paste box
        console.log(`Pasted ${lines.length} rows successfully.`);
    });
});
</script>