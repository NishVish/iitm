
<?= view('backend/sidemenu') ?>  <!-- loads app/Views/header.php -->


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Spreadsheet Class Documentation</title>
<style>
h1, h2, h3 { color: #2c3e50; }
code { background: #ecf0f1; padding: 2px 4px; border-radius: 3px; }
pre { background: #ecf0f1; padding: 10px; border-radius: 5px; overflow-x: auto; }
ul { margin: 0 0 20px 20px; }
</style>
</head>
<body>

<h1>Spreadsheet Class Documentation</h1>

<h2>Overview</h2>
<p>The <code>Spreadsheet</code> class is a lightweight, interactive JavaScript table component that mimics Excel-like behavior. Features include:</p>
<ul>
    <li>Row and column selection</li>
    <li>Resizable columns</li>
    <li>Editable cells</li>
    <li>Index and action columns</li>
    <li>Copying table data to clipboard (Excel-ready)</li>
    <li>Corner "select all" functionality</li>
</ul>

<h2>Constructor</h2>
<pre><code>new Spreadsheet(containerId, options = {})</code></pre>

<h3>Parameters</h3>
<ul>
    <li><code>containerId</code> (string) – The <code>id</code> of the container &lt;div&gt; where the spreadsheet will render.</li>
    <li><code>options</code> (object) – Optional configuration:
        <ul>
            <li><code>data</code> (array) – Array of row arrays. Each row contains cell values (can include HTML).</li>
            <li><code>columns</code> (array) – Array of column definitions. Each object should have:
                <ul>
                    <li><code>title</code> (string) – Header text of the column.</li>
                </ul>
            </li>
        </ul>
    </li>
</ul>

<h3>Example</h3>
<pre><code>
const data = [
  ['&lt;input type="radio"&gt;','&lt;input type="radio"&gt;','John','Doe','Developer','&lt;button&gt;Edit&lt;/button&gt;'],
  ['&lt;input type="radio"&gt;','&lt;input type="radio"&gt;','Jane','Smith','Designer','&lt;button&gt;Edit&lt;/button&gt;']
];

const columns = [
  { title: 'Select 1' },
  { title: 'Select 2' },
  { title: 'First Name' },
  { title: 'Last Name' },
  { title: 'Role' },
  { title: 'Action' }
];

const sheet = new Spreadsheet('mySpreadsheet', { data, columns });
</code></pre>

<h2>Table Structure</h2>
<ul>
    <li><strong>Header Row:</strong> includes a corner selector (select all) and clickable column headers with resizers.</li>
    <li><strong>Body Rows:</strong> includes index column (clickable), editable data cells, and action column for buttons.</li>
</ul>

<h2>Public Methods</h2>

<h3>1. selectRow(rowIndex)</h3>
<p>Highlights and selects an entire row.</p>
<pre><code>sheet.selectRow(0); // selects the first row</code></pre>

<h3>2. selectColumn(colIndex)</h3>
<p>Highlights all cells in a column (skips index column).</p>
<pre><code>sheet.selectColumn(2); // selects third column</code></pre>

<h3>3. selectAll()</h3>
<p>Selects all rows in the spreadsheet.</p>
<pre><code>sheet.selectAll();</code></pre>

<h3>4. copyAll()</h3>
<p>Copies table data to clipboard in Excel-friendly format. Skips index and action columns, includes headers.</p>
<pre><code>sheet.copyAll();</code></pre>

<h3>5. initResizer(th)</h3>
<p>Internal method to enable resizable columns by dragging the resizer handle inside the header.</p>

<h2>Usage Example (HTML)</h2>
<pre><code>
&lt;div id="mySpreadsheet"&gt;&lt;/div&gt;
&lt;button onclick="sheet.copyAll()"&gt;Copy All&lt;/button&gt;

&lt;script&gt;
const data = [
  ['&lt;input type="radio"&gt;','&lt;input type="radio"&gt;','John','Doe','Developer','&lt;button&gt;Edit&lt;/button&gt;'],
  ['&lt;input type="radio"&gt;','&lt;input type="radio"&gt;','Jane','Smith','Designer','&lt;button&gt;Edit&lt;/button&gt;']
];

const columns = [
  { title: 'Select 1' },
  { title: 'Select 2' },
  { title: 'First Name' },
  { title: 'Last Name' },
  { title: 'Role' },
  { title: 'Action' }
];

const sheet = new Spreadsheet('mySpreadsheet', { data, columns });
&lt;/script&gt;
</code></pre>

<h2>Features</h2>
<ul>
    <li>Editable cells (except radio/action columns)</li>
    <li>Resizable columns</li>
    <li>Row selection via index column</li>
    <li>Column selection via header click</li>
    <li>Select all via corner button</li>
    <li>Copy to clipboard for Excel</li>
    <li>Supports HTML in cells (buttons, radio inputs)</li>
</ul>

<h2>Notes</h2>
<ul>
    <li>Index column is readonly and used for row selection.</li>
    <li>Last column is readonly and intended for buttons or links.</li>
    <li>Columns containing HTML are not editable.</li>
    <li>Always provide a valid container ID that exists in your HTML.</li>
</ul>

</body>
</html>