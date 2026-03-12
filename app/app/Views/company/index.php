<?php include(APPPATH . 'Views/company/side.php'); 

// Sort rows alphabetically
ksort($pivot);

$baseUrl = site_url('company');
$entryType = $type;
    ?>



<div class="content-wrapper">

    <div class="page-header">
        <h2>📊 <?= ucfirst($type) ?> Statistics</h2>

        <div class="actions">
            <button onclick="window.print()" class="btn-compact">
                Print Report 🖨️
            </button>

            <a href="<?= $baseUrl . '/'.$entryType . '/overview/state' ?>">
                State
            </a>

            <a href="<?= $baseUrl . '/'.$entryType . '/overview/category' ?>">
                Category
            </a>

            <a href="<?= $baseUrl . '/'.$entryType . '/overview/database_name' ?>">
                Database
            </a>

            <a href="<?= $baseUrl . '/'.$entryType . '/overview/country' ?>">
                Country
            </a>
        </div>
    </div>

    <div id="stateTable" class="data-card" style="max-height:700px; width:auto; overflow:auto;">
    <table class="dynamic-table">
        <thead>
            <tr>
                <th class="sticky-col sticky-header"><?= ucfirst($groupby) ?></th>
                <th class="sticky-header">Total</th>

                <?php foreach ($columns as $col): ?>
                    <th class="sticky-header"><?= esc($col ?: 'Uncategorized') ?></th>
                <?php endforeach; ?>

            </tr>
        </thead>

        <tbody>
<?php 


foreach ($pivot as $rowKey => $row): 

    $rowTotal = 0;
    foreach ($columns as $col){
        $rowTotal += $row[$col] ?? 0;
    }
?>
<tr>

<td class="sticky-col">
<?php 

$urlfor = '/all/all/all/';

if ($groupby == "category") {
    $urlfor = "/all/";
}

if ($groupby == "country") {
    $urlfor = '/all/all/all/';
}
if ($groupby == "state") {
    $urlfor = '/all/all/all/all/';
}
?>

<a href="<?= $baseUrl . '/'.$entryType  . $urlfor . urlencode($rowKey) ?>">
    <?= esc($rowKey ?: 'Unknown') ?>
</a>
</td>

    <td class="total-cell"><?= number_format($rowTotal) ?></td>

    <?php foreach ($columns as $col): ?>
        <td><?= number_format($row[$col] ?? 0) ?></td>
    <?php endforeach; ?>

</tr>
<?php endforeach; ?>
        </tbody>

        <tfoot>
<tr>
<td class="sticky-col"><strong>GRAND TOTAL</strong></td>

<td class="grand-total">
<?php
$grandTotal = 0;

foreach ($pivot as $row){
    $grandTotal += array_sum(array_map(fn($v) => $v ?? 0, $row));
}
?>

<strong><?= number_format($grandTotal) ?></strong>
</td>

<?php 
foreach ($columns as $col):

    $colTotal = 0;

    foreach ($pivot as $row){
        $colTotal += $row[$col] ?? 0;
    }
?>

<td><strong><?= number_format($colTotal) ?></strong></td>

<?php endforeach; ?>

</tr>
        </tfoot>

    </table>
</div>

<style>
.data-card {
    background: white;
    /* padding: 20px; */
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-bottom: 40px;
    /* scroll container */
    max-height: 500px;
    width: 1000px;
    overflow: auto;
}

.dynamic-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

/* sticky header */
.dynamic-table thead th {
    position: sticky;
    top: 0;
    background: var(--nav-color);
    color: white;
    z-index: 2;
}

/* sticky first column */
.sticky-col {
    position: sticky;
    left: 0;
    background: #f8f9fa;
    z-index: 3;
    font-weight: bold;
}

/* intersection of sticky header & col */
.sticky-header.sticky-col {
    z-index: 4;
    background: var(--nav-color);
    color: white;
}

/* table cells */
.dynamic-table th, .dynamic-table td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #eee;
}

.dynamic-table tbody tr:hover {
    background: #f9f9f9;
}

.total-cell {
    font-weight: bold;
    background: #f8f9fa;
}

.grand-total {
    background: #e9ecef;
}

.dynamic-table tfoot {
    background: #f1f1f1;
    font-weight: bold;
}

/* print */
@media print {
    .btn-compact, #toggleBtn, .form-container { display: none; }
}
</style>


<button id="toggleBtn">Show/Hide Company Form</button>

<div id="companyFormWrapper" class="form-container">
    <?= view('company/insert_company_form') ?>
</div>


