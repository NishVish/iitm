<?= view('header') ?>  <!-- loads app/Views/header.php -->
<h2>Search Results for: <?= esc($query) ?></h2>

<form action="<?= base_url('search') ?>" method="get" class="search-box">
    <input type="text" name="q" value="<?= esc($query) ?>" placeholder="Search..." required>
    <button type="submit">Search</button>
</form>

<?php if (!empty($results)): ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>Company Name</th>
            <th>Category</th>
            <th>City</th>
            <th>State</th>
            <th>Contacts</th>
        </tr>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= esc($row['company_name']) ?></td>
                <td><?= esc($row['category']) ?></td>
                <td><?= esc($row['city']) ?></td>
                <td><?= esc($row['state']) ?></td>
                <td><pre><?= esc($row['contacts']) ?></pre></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No results found.</p>
<?php endif; ?>
