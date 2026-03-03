<?php include(APPPATH . 'Views/company/side.php'); ?>

<!-- Toggle Button -->
<button id="toggleBtn">Show/Hide Company Form</button>

<!-- Form Container -->
<div id="companyFormWrapper" class="form-container">
    <?= view('company/insert_company_form') ?>
</div>

<div class="content-wrapper" style="background-color: var(--body-color); padding: 20px;">

    <div class="page-header" style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <h2 style="color: var(--nav-color); margin: 0;">📊 <?= ucfirst($type) ?> Statistics</h2>
        <div class="actions">
            <button onclick="window.print()" class="btn-compact" style="background: var(--button-color); color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">
                Print Report 🖨️
            </button>
        </div>
    </div>

    <div class="data-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow-x: auto;">
<!--         
        <?php if (!empty($statecategorycounts)): ?>
            <?php
                // 1. Identify Dynamic Columns
                // We take the first row and exclude 'state' and 'Grand_Total' 
                // Everything else is a Category column.
                $all_keys = array_keys($statecategorycounts[0]);
                $categories = array_diff($all_keys, ['state', 'Grand_Total']);
            ?>

            <table class="table" style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="background-color: var(--nav-color); color: white; text-align: left;">
                        <th style="padding: 12px; border: 1px solid rgba(255,255,255,0.1);">State</th>
                        <?php foreach ($categories as $cat): ?>
                            <th style="padding: 12px; border: 1px solid rgba(255,255,255,0.1); text-transform: uppercase;">
                                <?= esc($cat) ?>
                            </th>
                        <?php endforeach; ?>
                        <th style="padding: 12px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2);">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $column_totals = array_fill_keys($categories, 0);
                    $overall_total = 0;
                    
                    foreach ($statecategorycounts as $row): 
                        $overall_total += $row['Grand_Total'];
                    ?>
                        <tr style="border-bottom: 1px solid #eee; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f9f9f9'" onmouseout="this.style.backgroundColor='transparent'">
<td style="padding: 12px; font-weight: bold; color: #333;">
    <?php if ($row['state']): ?>
        <?php 
            // 1. Create URL-friendly state name (e.g., "Uttar Pradesh" -> "uttar-pradesh")
            // This matches your normalization logic in the byvar() function
            $state_url = strtolower(str_replace([' & ', ' '], ['-and-', '-'], $row['state'])); 
        ?>
        <a href="<?= site_url("company/byvar/{$type}/state/{$state_url}") ?>" 
           style="color: var(--nav-color); text-decoration: none; border-bottom: 1px dashed transparent;"
           onmouseover="this.style.borderBottomColor='var(--nav-color)'"
           onmouseout="this.style.borderBottomColor='transparent'">
            <?= esc($row['state']) ?>
        </a>
    <?php else: ?>
        <span style="color: #999;">Unknown</span>
    <?php endif; ?>
</td>
                            
                            <?php foreach ($categories as $cat): 
                                $val = $row[$cat] ?? 0;
                                $column_totals[$cat] += $val;
                            ?>
                                <td style="padding: 12px; color: #555;">
                                    <?= number_format($val) ?>
                                </td>
                            <?php endforeach; ?>

                            <td style="padding: 12px; font-weight: bold; background-color: #f8f9fa;">
                                <?= number_format($row['Grand_Total']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                
                <tfoot>
                    <tr style="background: #f1f1f1; font-weight: bold; border-top: 2px solid var(--nav-color);">
                        <td style="padding: 12px;">GRAND TOTAL</td>
                        <?php foreach ($categories as $cat): ?>
                            <td style="padding: 12px;"><?= number_format($column_totals[$cat]) ?></td>
                        <?php endforeach; ?>
                        <td style="padding: 12px; background: #e9ecef;"><?= number_format($overall_total) ?></td>
                    </tr>
                </tfoot>
            </table>

        <?php else: ?>
            <div style="text-align: center; padding: 40px; color: #888;">
                <p>No data found for type: <strong><?= esc($type) ?></strong></p>
            </div>
        <?php endif; ?>

    </div>
</div> -->

  <script>
    const stateData = <?= json_encode($statecategorycounts) ?>;
    const databaseData = <?= json_encode($databasestatecounts) ?>;
    const currentType = "<?= esc($type) ?>";
</script>

<script>
function renderDynamicTable({
    data,
    containerId,
    groupKey,          // 'state' OR 'database_name'
    groupLabel         // 'State' OR 'Database'
}) {
    const container = document.getElementById(containerId);

    if (!data || data.length === 0) {
        container.innerHTML = `<div style="padding:40px;text-align:center;color:#888">
            No data found.
        </div>`;
        return;
    }

    // Identify dynamic category columns
    const allKeys = Object.keys(data[0]);
    const categories = allKeys.filter(
        key => key !== groupKey && key !== 'Grand_Total'
    );
    const baseUrl = "<?= site_url('company/byvar') ?>";

    let columnTotals = {};
    categories.forEach(cat => columnTotals[cat] = 0);

    let overallTotal = 0;

    let html = `
    <div class="data-card">
<table class="dynamic-table">
            <thead>
                <tr style="background:var(--nav-color);color:white">
                    <th style="padding:12px">${groupLabel}</th>
    `;

    categories.forEach(cat => {
        html += `<th style="padding:12px;text-transform:uppercase">${cat}</th>`;
    });

    html += `<th style="padding:12px;background:rgba(0,0,0,0.2)">TOTAL</th>
            </tr>
        </thead>
        <tbody>
    `;

    data.forEach(row => {
        overallTotal += parseInt(row.Grand_Total);

        html += `<tr style="border-bottom:1px solid #eee">`;

        let groupValue = row[groupKey] ?? "Unknown";
        let urlValue = groupValue
            .toLowerCase()
            .replace(/ & /g, '-and-')
            .replace(/\s+/g, '-');

       html += `
    <td>
        <a href="${baseUrl}/${currentType}/${groupKey}/${urlValue}"
           class="table-link">
            ${groupValue}
        </a>
    </td>
`;




        categories.forEach(cat => {
            let val = parseInt(row[cat] ?? 0);
            columnTotals[cat] += val;

            html += `<td style="padding:12px">${val.toLocaleString()}</td>`;
        });

        html += `
            <td style="padding:12px;font-weight:bold;background:#f8f9fa">
                ${parseInt(row.Grand_Total).toLocaleString()}
            </td>
        `;

        html += `</tr>`;
    });

    // Footer totals
    html += `<tfoot>
                <tr style="background:#f1f1f1;font-weight:bold">
                    <td style="padding:12px">GRAND TOTAL</td>`;

    categories.forEach(cat => {
        html += `<td style="padding:12px">${columnTotals[cat].toLocaleString()}</td>`;
    });

    html += `
        <td style="padding:12px;background:#e9ecef">
            ${overallTotal.toLocaleString()}
        </td>
        </tr>
        </tfoot>
    `;

    html += `</tbody></table></div>`;

    container.innerHTML = html;
}
</script>
<div id="stateTable"></div>
<div id="databaseTable" style="margin-top:40px"></div>


<script>

    
renderDynamicTable({
    data: stateData,
    containerId: "stateTable",
    groupKey: "state",
    groupLabel: "State"
});

renderDynamicTable({
    data: databaseData,
    containerId: "databaseTable",
    groupKey: "database_name",
    groupLabel: "Database"
});
</script>

<style>

/* Card Container */
.data-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    overflow-x: auto;
    margin-bottom: 30px;
}

/* Table Base */
.dynamic-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

/* Header */
.dynamic-table thead tr {
    background-color: var(--nav-color);
    color: white;
    text-align: left;
}

.dynamic-table th {
    padding: 12px;
    border: 1px solid rgba(255,255,255,0.1);
    text-transform: uppercase;
}

/* Body Cells */
.dynamic-table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    color: #555;
    transition: background 0.2s ease;
}

/* Hover Effect */
.dynamic-table tbody tr:hover {
    background-color: #f9f9f9;
}

/* First Column (State / Database) */
.dynamic-table td:first-child {
    font-weight: bold;
    color: #333;
}

/* Links */
.dynamic-table a {
    color: var(--nav-color);
    text-decoration: none;
    border-bottom: 1px dashed transparent;
    transition: border-color 0.2s ease;
}

.dynamic-table a:hover {
    border-bottom-color: var(--nav-color);
}

/* Total Column */
.dynamic-table td:last-child {
    font-weight: bold;
    background-color: #f8f9fa;
}

/* Footer */
.dynamic-table tfoot tr {
    background: #f1f1f1;
    font-weight: bold;
    border-top: 2px solid var(--nav-color);
}

.dynamic-table tfoot td:last-child {
    background: #e9ecef;
}

/* Empty Message */
.no-data {
    text-align: center;
    padding: 40px;
    color: #888;
}

/* Responsive */
@media (max-width: 768px) {
    .dynamic-table {
        font-size: 12px;
    }

    .dynamic-table th,
    .dynamic-table td {
        padding: 8px;
    }
}

</style>
<style>
    .table th { letter-spacing: 0.5px; font-weight: 600; }
    .table td { border-bottom: 1px solid #f0f0f0; }
    @media print {
        .btn-compact { display: none; }
        .content-wrapper { padding: 0; }
    }
</style>