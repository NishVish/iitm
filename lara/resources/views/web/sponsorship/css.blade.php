:root {
--iitm-maroon: #AA2D2C;
--iitm-maroon-dark: #8a2221;
--iitm-white: #ffffff;
--page-shadow: 0 4px 24px rgba(0, 0, 0, 0.18);
}

* {
box-sizing: border-box;
}

body {
margin: 0;
padding: 0;
font-family: 'Helvetica Neue', Arial, sans-serif;
background: #444;
}

/* ─── TOOLBAR ─────────────────────────────────────────── */
#toolbar {
position: fixed;
top: 0;
left: 0;
right: 0;
z-index: 9999;
background: #222;
padding: 10px 20px;
display: flex;
align-items: center;
gap: 12px;
}

#toolbar span {
color: #aaa;
font-size: 13px;
font-family: monospace;
}

.btn {
background: var(--iitm-maroon);
color: white;
border: none;
padding: 9px 22px;
cursor: pointer;
border-radius: 4px;
font-weight: bold;
font-size: 13px;
letter-spacing: 0.5px;
transition: background 0.2s;
}

.btn:hover {
background: var(--iitm-maroon-dark);
}

.btn:disabled {
background: #666;
cursor: not-allowed;
}

/* ─── PAGE WRAPPER ─────────────────────────────────────── */
#pages-wrapper {
padding: 60px 20px 40px;
/* top padding clears toolbar */
}

/* ─── SINGLE PAGE ──────────────────────────────────────── */
.page {
width: 297mm;
min-height: 210mm;
background: white;
display: flex;
flex-direction: column;
position: relative;
box-shadow: var(--page-shadow);
margin: 0 auto 28px;
overflow: hidden;
page-break-after: always;
}

.page-inner {
padding: 14mm 20mm 18mm;
flex: 1;
display: flex;
flex-direction: column;
}

/* ─── CONTENT PAGE HEADER ──────────────────────────────── */
.page-header {
<!-- border-bottom: 4px solid var(--iitm-maroon); -->
margin-bottom: 18px;
padding-bottom: 8px;
}

.page-category {
font-size: 11px;
font-weight: bold;
letter-spacing: 2.5px;
text-transform: uppercase;
color: var(--iitm-maroon);
margin: 0 0 4px;
}

.page-title {
font-size: 26px;
margin: 0;
color: #1a1a1a;
font-weight: 700;
}

/* ─── CARDS ────────────────────────────────────────────── */
.card {
border: 1px solid #e0e0e0;
border-left: 5px solid var(--iitm-maroon);
padding: 14px 16px;
margin-bottom: 12px;
background: #fff;
}

.card h3 {
margin: 0 0 8px;
font-size: 14px;
color: #1a1a1a;
}

.card ul {
margin: 0;
padding-left: 18px;
font-size: 13px;
color: #333;
line-height: 1.6;
}

/* ─── PACKAGE GRID ─────────────────────────────────────── */
.grid-3 {
display: grid;
grid-template-columns: repeat(3, 1fr);
gap: 14px;
}

.package-card {
border: 1px solid #e0e0e0;
border-top: 5px solid var(--iitm-maroon);
padding: 14px;
background: #fff;
}

.package-card h4 {
margin: 0 0 6px;
font-size: 15px;
color: #1a1a1a;
}

.price {
font-size: 20px;
font-weight: bold;
color: var(--iitm-maroon);
margin: 4px 0 8px;
}

.package-card .stall {
font-size: 12px;
color: #555;
margin: 0 0 8px;
}

.package-card ul {
margin: 0;
padding-left: 16px;
font-size: 11px;
color: #444;
line-height: 1.55;
}

/* ─── ITEMS GRID ───────────────────────────────────────── */
.grid-2 {
display: grid;
grid-template-columns: 1fr 1fr;
gap: 12px;
}

.item-card {
border: 1px solid #e0e0e0;
border-left: 5px solid var(--iitm-maroon);
padding: 12px 14px;
display: flex;
justify-content: space-between;
align-items: center;
gap: 10px;
background: #fff;
}

.item-card .item-info strong {
font-size: 13px;
display: block;
margin-bottom: 2px;
}

.item-card .item-info small {
font-size: 11px;
color: #666;
}

.item-card .item-info ul {
margin: 4px 0 0;
padding-left: 15px;
font-size: 11px;
color: #444;
}

.item-price {
font-size: 15px;
font-weight: bold;
color: var(--iitm-maroon);
white-space: nowrap;
flex-shrink: 0;
}

/* ─── PAGE FOOTER ──────────────────────────────────────── */
.page-footer {
position: absolute;
bottom: 8mm;
right: 20mm;
font-size: 11px;
font-weight: bold;
color: var(--iitm-maroon);
letter-spacing: 1px;
}

/* ─── STATUS / LOADER ──────────────────────────────────── */
#status-box {
background: #333;
color: #ccc;
padding: 40px;
text-align: center;
font-family: monospace;
font-size: 14px;
border-radius: 6px;
margin: 40px auto;
max-width: 600px;
}

#status-box.error {
background: #3a1a1a;
color: #f88;
}

/* ─── PRINT STYLES ─────────────────────────────────────── */
@media print {
body {
background: white;
}

#toolbar {
display: none !important;
}

#pages-wrapper {
padding: 0;
}

.page {
box-shadow: none;
margin: 0;
width: 297mm;
height: 210mm;
min-height: unset;
page-break-after: always;
break-after: page;
}

#status-box {
display: none;
}
}