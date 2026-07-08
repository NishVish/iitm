<?php

$host = '21.157.66.148.host.secureserver.net';
$user = 'iitminda_master';
$password = 'gB)%gU}ocn?MCP=}';
$database = 'iitminda_form_data';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "
    SELECT * 
    FROM exhibitor
    WHERE created_at > '2026-06-10'
    ORDER BY created_at DESC
    LIMIT 500
";

$result = mysqli_query($conn, $sql);

?>

<!-- SEARCH BOX -->
<input type="text" id="liveSearch" placeholder="Search name / mobile / company..."
    style="padding:8px; width:300px; margin-bottom:10px;">

<!-- TABLE -->
<table id="dataTable" border="1" cellpadding="8" cellspacing="0"
    style="border-collapse:collapse; width:100%; font-family:Arial; font-size:14px;">

    <tr style="background:#f2f2f2; font-weight:bold;">
        <th>ID</th>
        <th>Person Key</th>
        <th>Name</th>
        <th>Designation</th>
        <th>Company</th>
        <th>City</th>
        <th>State</th>

        <th>Mobile</th>
        <th>Email</th>
        <th>Created At</th>
        <th>Bag Collected</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['person_key'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['designation'] ?></td>
            <td><?= $row['company_name'] ?></td>
            <td><?= $row['city'] ?></td>
            <td><?= $row['state'] ?></td>
            <td><?= $row['mobile'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td><?= $row['bag_collected'] ?></td>
        </tr>
    <?php } ?>

</table>

<!-- LIVE SEARCH SCRIPT -->
<script>
    document.getElementById("liveSearch").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#dataTable tr");

        for (let i = 1; i < rows.length; i++) {
            let text = rows[i].innerText.toLowerCase();
            rows[i].style.display = text.includes(filter) ? "" : "none";
        }
    });
</script>