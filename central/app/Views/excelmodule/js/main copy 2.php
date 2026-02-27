class Spreadsheet {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        this.data = options.data || [];
        this.columns = options.columns || [];
        this.pageSize = options.pageSize || 10; // Rows per page
        this.currentPage = 1;
        this.table = null;
        this.paginationContainer = null;
        this.createTable();
        this.createPagination();
        this.renderPage(1);
    }

    createTable() {
        this.table = document.createElement('table');
        this.table.className = 'adv-spreadsheet';
        this.container.appendChild(this.table);
    }

    createPagination() {
        this.paginationContainer = document.createElement('div');
        this.paginationContainer.className = 'pagination';
        this.container.appendChild(this.paginationContainer);
    }

    renderPage(page) {
        this.currentPage = page;

        // Clear table
        this.table.innerHTML = '';

        // 1. Render Header
        const thead = document.createElement('thead');
        const headerRow = document.createElement('tr');

        const corner = document.createElement('th');
        corner.className = 'corner-selector';
        corner.innerHTML = '&#9635;';
        corner.onclick = () => this.selectAll();
        headerRow.appendChild(corner);

        this.columns.forEach((col, colIndex) => {
            const th = document.createElement('th');
            th.innerHTML = `<div class="resizer-wrapper">
                                <span class="header-text">${col.title || ''}</span>
                                <div class="resizer"></div>
                            </div>`;
            this.initResizer(th);
            th.onclick = (e) => {
                if (!e.target.classList.contains('resizer')) {
                    this.selectColumn(colIndex + 1);
                }
            };
            headerRow.appendChild(th);
        });

        thead.appendChild(headerRow);
        this.table.appendChild(thead);

        // 2. Render Body
        const tbody = document.createElement('tbody');
        const start = (page - 1) * this.pageSize;
        const end = Math.min(start + this.pageSize, this.data.length);
        for (let i = start; i < end; i++) {
            const rowData = this.data[i];
            const tr = document.createElement('tr');

            const tdIndex = document.createElement('td');
            tdIndex.className = 'row-index';
            tdIndex.textContent = i + 1;
            tdIndex.onclick = () => this.selectRow(i);
            tr.appendChild(tdIndex);

            rowData.forEach((cellData, colIndex) => {
                const td = document.createElement('td');
                td.textContent = cellData;
                td.contentEditable = true;
                tr.appendChild(td);
            });

            tbody.appendChild(tr);
        }
        this.table.appendChild(tbody);

        this.renderPaginationControls();
    }

    renderPaginationControls() {
        this.paginationContainer.innerHTML = '';
        const totalPages = Math.ceil(this.data.length / this.pageSize);

        const createButton = (text, pageNum, disabled = false) => {
            const btn = document.createElement('button');
            btn.textContent = text;
            btn.disabled = disabled;
            btn.onclick = () => this.renderPage(pageNum);
            return btn;
        };

        this.paginationContainer.appendChild(createButton('<<', 1, this.currentPage === 1));
        this.paginationContainer.appendChild(createButton('<', this.currentPage - 1, this.currentPage === 1));

        for (let i = 1; i <= totalPages; i++) {
            const btn = createButton(i, i, false);
            if (i === this.currentPage) btn.style.fontWeight = 'bold';
            this.paginationContainer.appendChild(btn);
        }

        this.paginationContainer.appendChild(createButton('>', this.currentPage + 1, this.currentPage === totalPages));
        this.paginationContainer.appendChild(createButton('>>', totalPages, this.currentPage === totalPages));
    }

    // Keep your selectRow, selectColumn, initResizer, selectAll methods here...

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
