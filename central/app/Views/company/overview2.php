<?php include(APPPATH . 'Views/company/side.php'); ?>










<div class="container">

    <h2>Company Overview</h2>

    <div style="display:flex; gap:40px;">
<table border="1">
<tr>
    <th>Entry Type</th>
    <th>Country</th>
    <th>Total</th>
</tr>

<?php foreach ($entry_country as $row): ?>
<tr>
    <td><?= esc($row['entry_type']) ?></td>
    <td><?= esc($row['country']) ?></td>
    <td><?= esc($row['total']) ?></td>
</tr>
<?php endforeach; ?>

</table>
        <!-- STATES -->
<div>

     <h3>Countries</h3>
<ul>
<?php foreach ($countries as $row): ?>
    <li><?= esc($row['country']) ?></li>
<?php endforeach; ?>
</ul>

</div>
   

        <div>
            <h3>States</h3>
            <ul>
                <?php foreach ($states as $row): ?>
                    <li><?= esc($row['state']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- CATEGORIES -->
        <div>
            <h3>Categories</h3>
            <ul>
                <?php foreach ($categories as $row): ?>
                    <li><?= esc($row['category']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- DATABASES -->
        <div>
            <h3>Databases</h3>
            <ul>
                <?php foreach ($databases as $row): ?>
                    <li><?= esc($row['database_name']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>

</div>


