/* Container: Simple border, no heavy shadows */
#spreadsheet-container {
    max-height: 600px;
    overflow: auto;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    background: #ffffff; /* Single consistent background */
}

.adv-spreadsheet {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    font-size: 13px;
    color: #334155; 
}

/* Header: Muted and flat */
.adv-spreadsheet thead th {
    position: sticky;
    top: 0;
    background-color: #f1f5f9; /* Soft flat gray */
    color: #475569;
    font-weight: 600;
    padding: 10px 12px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
    border-right: 1px solid #e2e8f0;
    z-index: 10;
}

/* Body: Single color for all rows */
.adv-spreadsheet tbody tr {
    background-color: #ffffff; /* Uniform color */
}

.adv-spreadsheet tbody td {
    padding: 8px 12px;
    border-bottom: 1px solid #f1f5f9;
    border-right: 1px solid #f1f5f9;
    white-space: nowrap;
}

/* Hover: A very faint tint so you can still track the row */
.adv-spreadsheet tbody tr:hover {
    background-color: #f8fafc;
}

/* Index Column: Keeps it distinct but low contrast */
.corner-selector, .row-index {
    background-color: #f1f5f9 !important;
    color: #94a3b8;
    width: 35px;
    text-align: center !important;
    font-size: 11px;
    border-right: 1px solid #e2e8f0 !important;
}

/* Editable Focus: Clean border, no shadow */
.adv-spreadsheet td[contenteditable="true"]:focus {
    outline: none;
    background: #fff;
    box-shadow: inset 0 0 0 1px #94a3b8;
    position: relative;
}

/* Action Buttons: Unified Slate color */
.btn-success {
    background: #475569; 
    color: white !important;
    padding: 3px 8px;
    border-radius: 2px;
    font-size: 11px;
    text-decoration: none;
    display: inline-block;
}

.btn-success:hover {
    background: #1e293b;
}


/* Selected Column logic (for when you copy) */
.copying-selection {
    background-color: rgba(59, 130, 246, 0.1) !important;
}

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

/* Highlights the selected column visually */
.selected-column {
    background-color: #f1f5f9 !important; /* Muted Slate */
    position: relative;
}

/* Optional: add a tiny border to the selection */
.selected-column::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    border-left: 1px solid #cbd5e1;
    border-right: 1px solid #cbd5e1;
    pointer-events: none;
}