
    class Spreadsheet {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        this.data = options.data || [];
        this.columns = options.columns || [];
        this.table = null;
        this.createTable();
    }
createTable() {
    this.table = document.createElement('table');
    this.table.className = 'adv-spreadsheet';

    // 1. HEADER & CORNER SELECTOR
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');

    // Corner Selector (Select All)
    const corner = document.createElement('th');
    corner.className = 'corner-selector';
    corner.innerHTML = '&#9635;'; // Square icon
    corner.onclick = () => this.selectAll();
    headerRow.appendChild(corner);

    this.columns.forEach((col, colIndex) => {
        const th = document.createElement('th');
        th.innerHTML = `<div class="resizer-wrapper">
                            <span class="header-text">${col.title || ''}</span>
                            <div class="resizer"></div>
                        </div>`;
        this.initResizer(th);

        // **Add column selection**
        th.onclick = (e) => {
            // Avoid selecting when clicking the resizer
            if (!e.target.classList.contains('resizer')) {
                this.selectColumn(colIndex + 1); // +1 because 0 = Index
            }
        };

        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);
    this.table.appendChild(thead);

    // 2. BODY & INDEX COLUMN
    const tbody = document.createElement('tbody');
    this.data.forEach((rowData, rowIndex) => {
        const tr = document.createElement('tr');

        // Index Column
        const tdIndex = document.createElement('td');
        tdIndex.className = 'row-index';
        tdIndex.textContent = rowIndex + 1;

        // **Add row selection**
        tdIndex.onclick = () => this.selectRow(rowIndex);

        tr.appendChild(tdIndex);

        rowData.forEach((cellData, colIndex) => {
            const td = document.createElement('td');
            if (colIndex === rowData.length - 1) {
                td.innerHTML = cellData; // Action column
                td.contentEditable = false;
            } else {
                td.textContent = cellData;
                td.contentEditable = true;
            }
            tr.appendChild(td);
        });

        tbody.appendChild(tr);
    });
    this.table.appendChild(tbody);
    this.container.appendChild(this.table);
}

// ROW SELECTION
selectRow(rowIndex) {
    const tr = this.table.querySelectorAll('tbody tr')[rowIndex];
    const range = document.createRange();
    range.selectNodeContents(tr);
    const selection = window.getSelection();
    selection.removeAllRanges();
    selection.addRange(range);
}




selectColumn(colIndex) {
    // 1. Remove previous selection
    this.table.querySelectorAll('.selected-column').forEach(el => {
        el.classList.remove('selected-column');
    });

    // 2. Apply visual selection to the cells in that column
    const rows = this.table.querySelectorAll('tbody tr');
    rows.forEach(tr => {
        const cell = tr.cells[colIndex];
        if (cell) cell.classList.add('selected-column');
    });

    // 3. Store the selected column index for your copy logic
    this.currentSelectedColumn = colIndex;
}








    initResizer(th) {
        const resizer = th.querySelector('.resizer');
        let startX, startWidth;

        resizer.addEventListener('mousedown', (e) => {
            startX = e.pageX;
            startWidth = th.offsetWidth;
            document.addEventListener('mousemove', mouseMoveHandler);
            document.addEventListener('mouseup', mouseUpHandler);
            resizer.classList.add('resizing');
        });

        const mouseMoveHandler = (e) => {
            const width = startWidth + (e.pageX - startX);
            th.style.width = `${width}px`;
        };

        const mouseUpHandler = () => {
            document.removeEventListener('mousemove', mouseMoveHandler);
            document.removeEventListener('mouseup', mouseUpHandler);
            resizer.classList.remove('resizing');
        };
    }

    selectAll() {
        const range = document.createRange();
        range.selectNodeContents(this.table.querySelector('tbody'));
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    }

    /**
     * ADVANCED COPY: Skips Index (Col 0) and Action (Last Col)
     * Includes Headers
     */




    copyAll() {
        const headers = this.columns.slice(0, -1).map(c => c.title);
        const rows = Array.from(this.table.querySelectorAll('tbody tr')).map(tr => {
            // slice(1, -1) skips the Index column and the Action column
            const cells = Array.from(tr.cells).slice(1, -1);
            return cells.map(td => td.textContent.trim()).join('\t');
        });

        const result = [headers.join('\t'), ...rows].join('\n');
        navigator.clipboard.writeText(result).then(() => alert("Copied for Excel!"));
    }


}
