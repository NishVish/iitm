<?php

$host = '21.157.66.148.host.secureserver.net';
$user = 'iitminda_master';
$password = 'gB)%gU}ocn?MCP=}';
$database = 'iitminda_form_data';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


/* AJAX UPDATE */
if (isset($_POST['ajax'])) {

    $id = $_POST['id'];
    $field = $_POST['field'];
    $value = $_POST['value'];

    $allowed = [
        "name",
        "designation",
        "company_name",
        "city",
        "state",
        "mobile",
        "email",
        "bag_collected"
    ];

    if (in_array($field, $allowed)) {

        $sql = "UPDATE exhibitor SET `$field`=? WHERE id=?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $value,
            $id
        );

        echo mysqli_stmt_execute($stmt) ? "success" : "error";

    }

    exit;
}



$sql = "
SELECT * 
FROM exhibitor
ORDER BY created_at DESC
LIMIT 1000
";

$result = mysqli_query($conn, $sql);

?>


<input type="text" id="liveSearch" placeholder="Search name / mobile / company..."
    style="padding:8px;width:300px;margin-bottom:10px;">


<table id="dataTable" border="1" cellpadding="8" cellspacing="0"
    style="border-collapse:collapse;width:100%;font-family:Arial;font-size:14px;">


    <tr style="background:#f2f2f2;font-weight:bold;">
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

        <tr data-id="<?= $row['id'] ?>">

            <td><?= $row['id'] ?></td>

            <td><?= $row['person_key'] ?></td>


            <td contenteditable="true" class="edit" data-field="name">
                <?= htmlspecialchars($row['name']) ?>
            </td>


            <td contenteditable="true" class="edit" data-field="designation">
                <?= htmlspecialchars($row['designation']) ?>
            </td>


            <td contenteditable="true" class="edit" data-field="company_name">
                <?= htmlspecialchars($row['company_name']) ?>
            </td>


            <td contenteditable="true" class="edit" data-field="city">
                <?= htmlspecialchars($row['city']) ?>
            </td>


            <td contenteditable="true" class="edit" data-field="state">
                <?= htmlspecialchars($row['state']) ?>
            </td>


            <td contenteditable="true" class="edit" data-field="mobile">
                <?= htmlspecialchars($row['mobile']) ?>
            </td>


            <td contenteditable="true" class="edit" data-field="email">
                <?= htmlspecialchars($row['email']) ?>
            </td>


            <td>
                <?= $row['created_at'] ?>
            </td>


            <td contenteditable="true" class="edit" data-field="bag_collected">
                <?= htmlspecialchars($row['bag_collected']) ?>
            </td>


        </tr>

    <?php } ?>


</table>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>


    $("#liveSearch").on("keyup", function () {

        let filter = $(this).val().toLowerCase();

        $("#dataTable tr").each(function (index) {

            if (index == 0) return;

            $(this).toggle(
                $(this).text().toLowerCase().includes(filter)
            );

        });

    });



    $(".edit").on("blur", function () {

        let cell = $(this);

        $.ajax({

            url: "",
            type: "POST",

            data: {
                ajax: 1,
                id: cell.closest("tr").data("id"),
                field: cell.data("field"),
                value: cell.text().trim()
            },


            success: function (res) {

                if (res == "success") {

                    cell.css("background", "#c8f7c5");

                    setTimeout(function () {
                        cell.css("background", "");
                    }, 800);

                } else {

                    cell.css("background", "#ffcccc");

                }

            }


        });


    });


</script>