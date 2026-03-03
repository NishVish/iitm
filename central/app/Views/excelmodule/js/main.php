class Spreadsheet {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);

        // Data
        this.fullData = options.data || [];   // All data (client mode)
        this.data = [];                        // Current page data

        this.columns = options.columns || [];
this.onCellEdit = options.onCellEdit || null;
        // Pagination
        this.currentPage = 1;
        this.pageSize = options.pageSize || 5000;
        this.totalRows = this.fullData.length;

        // Server-side mode
        this.serverMode = options.serverMode || false;
        this.fetchFunction = options.fetchFunction || null;

        // Table elements
        this.table = null;
        this.tbody = null;
        this.paginationContainer = null;

        // Initialize
        this.createTable();
        this.initPagination();
        this.loadPage(1);
    }

    // ── CREATE TABLE HEADER ONLY ─────────────────────────────────────────────
    createTable() {
        // Table element
        this.table = document.createElement('table');
        this.table.className = 'adv-spreadsheet';

        // HEADER & CORNER SELECTOR
        const thead = document.createElement('thead');
        const headerRow = document.createElement('tr');

        const corner = document.createElement('th');
        corner.className = 'corner-selector';
        corner.innerHTML = '&#9635;';
        corner.onclick = () => this.selectAll();
        headerRow.appendChild(corner);

        // Columns
        this.columns.forEach((col, colIndex) => {
            const th = document.createElement('th');
            th.innerHTML = `
                <div class="resizer-wrapper">
                    <span class="header-text">${col.title || ''}</span>
                    <div class="resizer"></div>
                </div>
            `;

            this.initResizer(th);

            // Column selection
            th.onclick = (e) => {
                if (!e.target.classList.contains('resizer')) {
                    this.selectColumn(colIndex + 1); // +1 because 0=index
                }
            };

            headerRow.appendChild(th);
        });

        thead.appendChild(headerRow);
        this.table.appendChild(thead);

        // Empty tbody (rows added dynamically)
        this.tbody = document.createElement('tbody');
        this.table.appendChild(this.tbody);

        // Append table to container
        this.container.appendChild(this.table);
    }

    // ── INIT PAGINATION CONTAINER ─────────────────────────────────────────────
    initPagination() {
        this.paginationContainer = document.createElement('div');
        this.paginationContainer.className = 'spreadsheet-pagination';
        this.container.appendChild(this.paginationContainer);
    }

    // ── LOAD SPECIFIC PAGE ───────────────────────────────────────────────────
    async loadPage(page) {
        this.currentPage = page;

        if (this.serverMode && this.fetchFunction) {
            // Server-side: fetch only the current page
            const result = await this.fetchFunction(page, this.pageSize);
            this.fullData = result.data;  // optional: could store all pages
            this.totalRows = result.total;
            this.data = result.data;
        } else {
            // Client-side: slice fullData
            const start = (page - 1) * this.pageSize;
            const end = start + this.pageSize;
            this.data = this.fullData.slice(start, end);
            this.totalRows = this.fullData.length;
        }

        this.renderRows();
        this.renderPagination();
    }

    // ── RENDER CURRENT PAGE ROWS ─────────────────────────────────────────────
renderRows() {
    this.tbody.innerHTML = '';

    this.data.forEach((rowData, rowIndex) => {
        const tr = document.createElement('tr');

        const realIndex = (this.currentPage - 1) * this.pageSize + rowIndex;

        // Index column
        const tdIndex = document.createElement('td');
        tdIndex.className = 'row-index';
        tdIndex.textContent = realIndex + 1;
        tdIndex.onclick = () => this.selectRow(rowIndex);
        tr.appendChild(tdIndex);

        // Data columns
        rowData.forEach((cellData, colIndex) => {
            const td = document.createElement('td');
            const colDef = this.columns[colIndex];
            const isHtmlType = colDef && colDef.type === 'html';

            if (isHtmlType) {
                td.innerHTML = cellData;
                td.contentEditable = false;
            } else {
                td.textContent = cellData;
                td.contentEditable = true;

                // ✅ SAVE ON BLUR
                td.addEventListener('blur', () => {
                    const newValue = td.textContent.trim();
                    const oldValue = cellData;

                    // Prevent unnecessary request
                    if (newValue === oldValue) return;

                    const eventId = rowData[0]; // First column = ID
                    const field = this.columns[colIndex]?.field;

                    if (this.onCellEdit && field) {
                        this.onCellEdit({
                            id: eventId,
                            field: field,
                            value: newValue,
                            oldValue: oldValue
                        });
                    }
                });
            }

            tr.appendChild(td);
        });

        this.tbody.appendChild(tr);
    });
}

    // ── PAGINATION BUTTONS ──────────────────────────────────────────────────
    renderPagination() {
        const totalPages = Math.ceil(this.totalRows / this.pageSize);
        this.paginationContainer.innerHTML = '';

        if (totalPages <= 1) return;

        const createBtn = (label, page) => {
            const btn = document.createElement('button');
            btn.textContent = label;
            btn.onclick = () => this.loadPage(page);
            return btn;
        };

        // Previous
        if (this.currentPage > 1) {
            this.paginationContainer.appendChild(createBtn('«', this.currentPage - 1));
        }

        // Page numbers (current ±2)
        const start = Math.max(1, this.currentPage - 2);
        const end = Math.min(totalPages, this.currentPage + 2);

        for (let i = start; i <= end; i++) {
            const btn = createBtn(i, i);
            if (i === this.currentPage) btn.classList.add('active');
            this.paginationContainer.appendChild(btn);
        }

        // Next
        if (this.currentPage < totalPages) {
            this.paginationContainer.appendChild(createBtn('»', this.currentPage + 1));
        }
    }

    // ── ROW SELECTION ───────────────────────────────────────────────────────
    selectRow(rowIndex) {
        const tr = this.tbody.querySelectorAll('tr')[rowIndex];
        const range = document.createRange();
        range.selectNodeContents(tr);
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    }

    // ── COLUMN SELECTION ───────────────────────────────────────────────────
    selectColumn(colIndex) {
        this.table.querySelectorAll('.selected-column').forEach(el => el.classList.remove('selected-column'));

        const rows = this.tbody.querySelectorAll('tr');
        rows.forEach(tr => {
            const cell = tr.cells[colIndex];
            if (cell) cell.classList.add('selected-column');
        });

        this.currentSelectedColumn = colIndex;
    }

    // ── SELECT ALL ─────────────────────────────────────────────────────────
    selectAll() {
        const range = document.createRange();
        range.selectNodeContents(this.tbody);
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    }

    // ── RESIZER ────────────────────────────────────────────────────────────
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

    // ── COPY ALL (skip index and last column) ───────────────────────────────
    copyAll() {
        const headers = this.columns.slice(0, -1).map(c => c.title);
        const rows = Array.from(this.tbody.querySelectorAll('tr')).map(tr => {
            const cells = Array.from(tr.cells).slice(1, -1);
            return cells.map(td => td.textContent.trim()).join('\t');
        });

        const result = [headers.join('\t'), ...rows].join('\n');
        navigator.clipboard.writeText(result).then(() => alert("Copied for Excel!"));
    }

    // ── GET DATA (current visible table) ───────────────────────────────────
    getData() {
        return Array.from(this.tbody.querySelectorAll('tr'))
            .filter(tr => tr.style.display !== 'none')
            .map(tr => Array.from(tr.cells).slice(1).map(td => td.textContent.trim()));
    }
}