

<h1>Dashboard</h1>
<?php
// echo "<p>";

// // Run ipconfig
// $output = shell_exec('ipconfig');

// // Search for IPv4 address using regex
// if (preg_match('/IPv4 Address[.\s]*:\s*([\d\.]+)/', $output, $matches)) {
//     echo $matches[1]."/iitm/central/";
// } else {
//     echo "IPv4 Address not found";
// }

// echo "</p>";
?>

<h2>Company Counts by Database</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Database Name</th>
        <th>Total Companies</th>
    </tr>
    <?php foreach($databasedetails as $db): ?>
    <tr>
        <td><?= esc($db->database_name) ?></td>
        <td><?= esc($db->total) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Company Counts by Database and Source</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Database Name</th>
        <th>Source (Notes)</th>
        <th>Total Companies</th>
    </tr>
    <?php foreach($databasedetailsgroupbysource as $db): ?>
    <tr>
        <td><?= esc($db->database_name) ?></td>
        <td><?= esc($db->source ?? 'N/A') ?></td>
        <td><?= esc($db->total) ?></td>
    </tr>
    <?php endforeach; ?>
</table>    