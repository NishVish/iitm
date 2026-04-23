<?= view('leads/side') ?> <!-- loads app/Views/header.php -->

<h2>Leads
    <form action="<?= site_url('leads/clear') ?>" method="post" style="display:inline-block; margin-left:20px;">
        <?= csrf_field() ?>
        <button type="submit" onclick="return confirm('Are you sure you want to delete all leads?');">
            Clear All Leads
        </button>
    </form>
    <form action="<?= site_url('leads/add-random') ?>" method="get" style="display:inline-block; margin-left:10px;">
        <button type="submit" onclick="return confirm('Add a random lead?');">
            ➕ Add Random Lead
        </button>
    </form>
</h2>

<!-- ================= FILTERS ================= -->
<form method="get" action="<?= site_url('leads') ?>" style="margin-bottom:20px;">
    <!-- Location -->
    <select name="location">
        <option value="">All Locations</option>
        <?php foreach ($locations as $row): ?>
            <option value="<?= esc($row['location']) ?>" <?= ($filters['location'] === $row['location']) ? 'selected' : '' ?>>
                <?= esc($row['location']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Year -->
    <select name="year">
        <option value="">All Years</option>
        <?php foreach ($years as $row): ?>
            <option value="<?= esc($row['exhibition_year']) ?>" <?= ($filters['year'] == $row['exhibition_year']) ? 'selected' : '' ?>>
                <?= esc($row['exhibition_year']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Sales Person -->
    <select name="sales_person">
        <option value="">All Sales Persons</option>
        <?php foreach ($salesPersons as $row): ?>
            <option value="<?= esc($row['sales_person']) ?>" <?= ($filters['sales_person'] === $row['sales_person']) ? 'selected' : '' ?>>
                <?= esc($row['sales_person']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Filter</button>
    <a href="<?= site_url('leads') ?>">Reset</a>
</form>


<!-- ================= LEADS TABLE ================= -->
<table id="leadsTable" border="1" cellpadding="8" style="width:100%; border-collapse:collapse;">
    <thead>
        <tr>
            <th>Lead ID</th>
            <th>Company</th>
            <th>Location</th>
            <th>Year</th>
            <th>Contact Person</th>
            <th>Sales Person</th>
            <th>Status</th>
            <th>Payment</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($leads)): ?>
            <?php foreach ($leads as $lead): ?>
                <tr>
                    <td><?= esc($lead['lead_id']) ?></td>
                    <td><?= esc($lead['company_id']) ?></td>
                    <td><?= esc($lead['all_locations'] ?? '-') ?></td>
                    <td><?= esc($lead['exhibition_year'] ?? '-') ?></td>
                    <td>
                        <?= esc($lead['contact_name']) ?>
                        <?= esc($lead['designation']) ?>
                        <?= esc($lead['primary_email']) ?>
                        <?= esc($lead['primary_mobile']) ?>
                    </td>
                    <td><?= esc($lead['sales_person'] ?? '-') ?></td>
                    <td><?= esc($lead['status'] ?? '-') ?></td>
                    <td><?= esc($lead['payment_status'] ?? '-') ?></td>
                    <td>
                        <a href="<?= site_url('lead/details/' . esc($lead['lead_id'])) ?>">View Company</a> |
                        <a href="<?= site_url('booking/instructions/' . $lead['lead_id']) ?>">Book</a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="9" style="text-align:center;">No leads found</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>



<script>
    document.getElementById('copyAllBtn').addEventListener('click', function () {
        let table = document.getElementById('leadsTable');
        let rows = table.querySelectorAll('tr');
        let text = '';

        rows.forEach((row, rowIndex) => {
            let cols = row.querySelectorAll('th, td');
            let rowData = [];

            cols.forEach((col, colIndex) => {
                // Skip last column (Action)
                if (colIndex !== cols.length - 1) {
                    rowData.push(col.innerText.trim());
                }
            });

            text += rowData.join('\t') + '\n';
        });

        navigator.clipboard.writeText(text).then(() => {
            alert('Copied!');
        });
    });
</script>