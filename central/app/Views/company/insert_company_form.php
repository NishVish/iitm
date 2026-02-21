
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

    document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('companyFormTv');
    const templateRow = document.querySelector('.company-row');
    let companyIndex = 0;

    const excelPasteArea = document.getElementById('excelPasteArea');
    const clearAllBtn = document.getElementById('clearAllBtn');

    excelPasteArea.addEventListener('paste', e => {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        const rows = pastedText.trim().split(/\r?\n/);

        // Batch update using DocumentFragment for performance
        const fragment = document.createDocumentFragment();

        rows.forEach((rowData, i) => {
            const cols = rowData.split('\t');
            let currentRow;

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

        if (fragment.children.length) form.appendChild(fragment);
        excelPasteArea.value = '';
    });

    function createRow() {
        companyIndex++;
        const newRow = templateRow.cloneNode(false); // shallow clone for speed

        // clone inputs manually
        templateRow.querySelectorAll('input, textarea, .field-actions').forEach(node => {
            const clone = node.cloneNode(true);
            if (clone.tagName === 'INPUT' && clone.type !== 'checkbox') clone.value = '';
            if (clone.tagName === 'INPUT' && clone.type === 'checkbox') clone.checked = false;
            // update names
            if (clone.name) clone.name = clone.name.replace(/\[\d+\]/, `[${companyIndex}]`);
            newRow.appendChild(clone);
        });

        newRow.classList.remove('hidden');
        newRow.style.display = 'flex';

        newRow.querySelector('.removeBtn').onclick = removeRow;
        newRow.querySelector('.clearBtn').onclick = clearRow;

        return newRow;
    }

    function isRowEmpty(row) {
        return Array.from(row.querySelectorAll('input, textarea')).every(input => {
            return input.type === 'checkbox' ? !input.checked : !input.value.trim();
        });
    }

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

    clearAllBtn.addEventListener('click', () => {
        document.querySelectorAll('.company-row input, .company-row textarea').forEach(el => {
            if (el.type === 'checkbox') el.checked = false;
            else el.value = '';
        });
        excelPasteArea.value = '';
    });

    // first row buttons
    templateRow.querySelector('.removeBtn').onclick = removeRow;
    templateRow.querySelector('.clearBtn').onclick = clearRow;
});


    
// document.addEventListener("DOMContentLoaded", function () {
//     let companyIndex = 0; // Start at 0 for the first row
//     const form = document.getElementById('companyFormTv');
//     const templateRow = document.querySelector('.company-row');


//     document.getElementById('excelPasteArea').addEventListener('paste', function (e) {
//     e.preventDefault();
//     const clipboardData = e.clipboardData || window.clipboardData;
//     const pastedText = clipboardData.getData('text');

//     const rows = pastedText.trim().split(/\r?\n/);

//     rows.forEach((rowData, i) => {
//         const cols = rowData.split('\t');
//         let currentRow;

//         // Always create a new row if it's not the first AND template row has content
//         if (i === 0 && isRowEmpty(templateRow)) {
//             currentRow = templateRow;
//         } else {
//             currentRow = createRow();
//         }

//         const inputs = currentRow.querySelectorAll('input, textarea');
//         cols.forEach((value, colIndex) => {
//             if (inputs[colIndex]) {
//                 if (inputs[colIndex].type === 'checkbox') {
//                     inputs[colIndex].checked = (value.toLowerCase() === 'yes' || value === '1');
//                 } else {
//                     inputs[colIndex].value = value.trim();
//                 }
//             }
//         });
//     });

//     this.value = ''; // clear paste area
// });


// function createRow() {
//     companyIndex++;
//     const newRow = templateRow.cloneNode(true);

//     newRow.classList.remove('hidden');
//     newRow.style.display = 'flex'; // or 'block'

//     newRow.querySelectorAll('input, textarea').forEach(input => {
//         if (input.type === 'checkbox') input.checked = false;
//         else input.value = '';
//         input.name = input.name.replace(/\[\d+\]/, `[${companyIndex}]`);
//     });

//     newRow.querySelector('.removeBtn').onclick = removeRow;
//     newRow.querySelector('.clearBtn').onclick = clearRow;

//     form.appendChild(newRow); // safer than insertBefore
//     return newRow;
// }
//     document.getElementById('excelPasteArea').addEventListener('paste', function (e) {
//         e.preventDefault();
//         const clipboardData = e.clipboardData || window.clipboardData;
//         const pastedText = clipboardData.getData('text');
        
//         // Split by new line for rows, then by tab for columns
//         const rows = pastedText.trim().split(/\r?\n/);

//         rows.forEach((rowData, i) => {
//             const cols = rowData.split('\t');
//             let currentRow;

//             // Use the first row if it's empty, otherwise create a new one
//             if (i === 0 && companyIndex === 0 && isRowEmpty(templateRow)) {
//                 currentRow = templateRow;
//             } else {
//                 currentRow = createRow();
//             }

//             const inputs = currentRow.querySelectorAll('input');
//             cols.forEach((value, colIndex) => {
//                 if (inputs[colIndex]) {
//                     if (inputs[colIndex].type === 'checkbox') {
//                         inputs[colIndex].checked = (value.toLowerCase() === 'yes' || value === '1');
//                     } else {
//                         inputs[colIndex].value = value.trim();
//                     }
//                 }
//             });
//         });
        
//         this.value = ''; // Clear textarea after paste
//     });
// function isRowEmpty(row) {
//     return Array.from(row.querySelectorAll('input, textarea')).every(input => {
//         if (input.type === 'checkbox') return !input.checked;
//         return input.value.trim() === '';
//     });
// }
//     // Initial first row button logic
//     templateRow.querySelector('.removeBtn').onclick = function() {
//         if(document.querySelectorAll('.company-row').length > 1) templateRow.remove();
//     };
//     templateRow.querySelector('.clearBtn').onclick = function() {
//         templateRow.querySelectorAll('input').forEach(i => i.value = '');
//     };
    
//     document.getElementById('clearAllBtn').onclick = () => {
//         location.reload(); // Quickest way to reset everything
//     };
// });

// /* ===== REMOVE ROW ===== */
// function removeRow(e) {
//     const rows = document.querySelectorAll('.company-row');
//     if (rows.length > 1) {
//         e.target.closest('.company-row').remove();
//     } else {
//         alert("At least one row must remain.");
//     }
// }

// /* ===== CLEAR ROW ===== */
// function clearRow(e) {
//     const row = e.target.closest('.company-row');
//     row.querySelectorAll('input, textarea').forEach(el => {
//         el.value = '';
//         if (el.type === 'checkbox') el.checked = false;
//     });
// }

// /* ===== CLEAR ALL ===== */
// document.getElementById('clearAllBtn').addEventListener('click', function() {
//     document.querySelectorAll('.company-row input, .company-row textarea')
//         .forEach(el => {
//             el.value = '';
//             if (el.type === 'checkbox') el.checked = false;
//         });
//     document.getElementById('excelPasteArea').value = '';
// });

// /* Attach handlers to first row buttons */
// templateRow.querySelector('.removeBtn').onclick = removeRow;
// templateRow.querySelector('.clearBtn').onclick = clearRow;
</script>