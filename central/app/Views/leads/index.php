<?= view('header') ?>  <!-- loads app/Views/header.php -->

<h2>Leads</h2>

<!-- ================= FILTERS ================= -->
<form method="get" action="<?= site_url('leads') ?>">

    <!-- Location -->
    <select name="location">
        <option value="">All Locations</option>
        <?php foreach ($locations as $row): ?>
            <option value="<?= esc($row['location']) ?>"
                <?= ($filters['location'] === $row['location']) ? 'selected' : '' ?>>
                <?= esc($row['location']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Year -->
    <select name="year">
        <option value="">All Years</option>
        <?php foreach ($years as $row): ?>
            <option value="<?= esc($row['exhibition_year']) ?>"
                <?= ($filters['year'] == $row['exhibition_year']) ? 'selected' : '' ?>>
                <?= esc($row['exhibition_year']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Sales Person -->
    <select name="sales_person">
        <option value="">All Sales Persons</option>
        <?php foreach ($salesPersons as $row): ?>
            <option value="<?= esc($row['sales_person']) ?>"
                <?= ($filters['sales_person'] === $row['sales_person']) ? 'selected' : '' ?>>
                <?= esc($row['sales_person']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Filter</button>
    <a href="<?= site_url('leads') ?>">Reset</a>
</form>


<hr>

<!-- ================= LEADS TABLE ================= -->
<table border="1" width="100%" cellpadding="8">
    <thead>
        <tr>
            <th>Lead ID</th>
            <th>Company</th>
            <th>Location</th>
            <th>Year</th>
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
                    <td><?= esc($lead['location']) ?></td>
                    <td><?= esc($lead['exhibition_year']) ?></td>
                    <td><?= esc($lead['sales_person']) ?></td>
                    <td><?= esc($lead['status']) ?></td>
                    <td><?= esc($lead['payment_status']) ?></td>
                    <td>
                        <a href="<?= site_url('lead/details/' . esc($lead['lead_id'])) ?>">
    View Company
</a>

                         <!-- New Button: Open Exhibitor Registration -->
<a href="<?= site_url('exhibitor/instructions/'.$lead['company_id']) ?>" class="btn btn-success btn-sm">
    Book Exhibitor
</a>

                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No leads found</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>

