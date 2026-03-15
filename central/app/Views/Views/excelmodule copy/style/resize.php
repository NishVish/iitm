
/* Resizer Wrapper */
.resizer-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
}

/* Resizer Handle */
.resizer {
    width: 5px;
    height: 100%;
    background: transparent;
    cursor: col-resize;
    position: absolute;
    right: -15px; /* Aligns with padding */
    top: 0;
    transition: background 0.2s;
}

.resizer:hover, .resizing {
    background: #3b82f6 !important;
    width: 2px;
}

/* Corner & Index Columns */
.corner-selector, .row-index {
    background-color: #f1f5f9 !important;
    text-align: center !important;
    width: 40px;
    min-width: 40px;
    font-weight: bold;
    color: #64748b;
    border-right: 2px solid #cbd5e1 !important;
    cursor: pointer;
}

.corner-selector:hover {
    background-color: #cbd5e1 !important;
    color: #1e293b;
}

/* Action Column Styling */
.adv-spreadsheet td:last-child {
    background-color: #fff;
    white-space: nowrap;
}

.btn-sm {
    padding: 2px 6px;
    font-size: 11px;
    border-radius: 3px;
    text-decoration: none;
    display: inline-block;
}