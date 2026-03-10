<?php foreach($overview as $row){ ?>

<tr>
    <td><?= $row['database_name'] ?></td>
    <td><?= $row['entry_type'] ?></td>
    <td><?= $row['total_companies'] ?></td>
    <td><?= $row['active_count'] ?></td>
    <td><?= $row['inactive_count'] ?></td>
    <td><?= $row['city_count'] ?></td>
    <td><?= $row['state_count'] ?></td>
    <td><?= $row['category_count'] ?></td>
    <td><?= $row['source_count'] ?></td>
</tr>

<?php } ?>