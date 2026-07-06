<?php

$host = '21.157.66.148.host.secureserver.net';
$port = 3306;
$user = 'iitminda_master';
$password = 'gB)%gU}ocn?MCP=}';

// Connect once to the server (no default DB)
$conn = mysqli_connect($host, $user, $password, '', $port);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$mobile = '';

$hello = False;
$search_result = null;
$auto_print = false;

$name = "Nishant Vishwakarma";
$c = "Sphere Travel Media Pvt. Ltd.";



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mobile'])) {

    echo "
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tempDiv = document.getElementById('temp');
        if (tempDiv) {
            tempDiv.style.display = 'none';
            setTimeout(() => {
                tempDiv.remove();
            }, 1000);
        }
    });
</script>
";
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);


    // Query for first DB (iitminda_form_data) - union exhibitor and tradevisitor ordered by created_at
    $query1 = "
(SELECT
id,
person_key,
name,
designation,
company_name,
NULL AS category, -- not present in exhibitor
address,
city,
pin,
state,
mobile,
email,
created_at,
'iitminda_form_data' AS db_name,
'exhibitor' AS table_name
FROM iitminda_form_data.exhibitor
WHERE mobile LIKE '%$mobile%')

UNION ALL

(SELECT
id,
person_key,
name,
designation,
company_name,
category,
address,
city,
pin,
state,
mobile,
email,
created_at,
'iitminda_form_data' AS db_name,
'tradevisitor' AS table_name
FROM iitminda_form_data.tradevisitor
WHERE mobile LIKE '%$mobile%')

ORDER BY created_at DESC
LIMIT 1
";

    $result1 = mysqli_query($conn, $query1);
    $row1 = ($result1 && mysqli_num_rows($result1) > 0) ? mysqli_fetch_assoc($result1) : null;

    if (!$row1) {

        $query2 = "
(SELECT
id,
person_key,
name,
designation,
company_name,
NULL AS category,
address,
city,
pin,
state,
mobile,
email,
created_at,
'iitminda_form_data' AS db_name,
'exhibitor' AS table_name
FROM iitminda_form_data.exhibitor
WHERE person_key = '$mobile')

UNION ALL

(SELECT
id,
person_key,
name,
designation,
company_name,
category,
address,
city,
pin,
state,
mobile,
email,
created_at,
'iitminda_form_data' AS db_name,
'tradevisitor' AS table_name
FROM iitminda_form_data.tradevisitor
WHERE person_key = '$mobile')

ORDER BY created_at DESC
LIMIT 1
";

        $result1 = mysqli_query($conn, $query2);
        $row1 = ($result1 && mysqli_num_rows($result1) > 0)
            ? mysqli_fetch_assoc($result1)
            : null;
    }
    // Query for second DB (iitminda_iitmindia_2024) - union exhibitor2025 and tradev ordered by date_reg
    $query2 = "
(SELECT id, title, select2, name, designation, organisation AS company_name, email, phone, mobile, date_reg AS
created_at,
'iitminda_iitmindia_2024' AS db_name, 'exhibitor2025' AS table_name
FROM iitminda_iitmindia_2024.exhibitor2025
WHERE phone LIKE '%$mobile%' OR mobile LIKE '%$mobile%')
UNION ALL
(SELECT id, title, select2, name, designation, organisation AS company_name, email, phone, mobile, date_reg AS
created_at,
'iitminda_iitmindia_2024' AS db_name, 'tradev' AS table_name
FROM iitminda_iitmindia_2024.tradev
WHERE phone LIKE '%$mobile%' OR mobile LIKE '%$mobile%')
ORDER BY created_at DESC
LIMIT 1
";

    $result2 = mysqli_query($conn, $query2);
    $row2 = ($result2 && mysqli_num_rows($result2) > 0) ? mysqli_fetch_assoc($result2) : null;

    // Compare the results from both DBs and pick the latest
    if ($row1 && $row2) {
        $time1 = strtotime($row1['created_at']);
        $time2 = strtotime($row2['created_at']);
        $search_result = ($time1 >= $time2) ? [$row1] : [$row2];
        $auto_print = true;

    } elseif ($row1) {
        $search_result = [$row1];
        $auto_print = true;
    } elseif ($row2) {
        $search_result = [$row2];
        $auto_print = true;
    } else {
        echo "<p>No results found for mobile number: " . htmlspecialchars($mobile) . "</p>";
        $auto_print = false;
    }

    if (!empty($search_result)) {
        $final = $search_result[0];
        $final_db = mysqli_real_escape_string($conn, $final['db_name']);
        $final_table = mysqli_real_escape_string($conn, $final['table_name']);
        $final_id = (int) $final['id'];

        $insert_query = "
INSERT INTO iitminda_visitor.visitor (database_name, table_name, id)
VALUES ('$final_db', '$final_table', $final_id)
";


        if (mysqli_query($conn, $insert_query)) {
            echo "<div
    style='margin-top: 15px; padding: 10px 15px; background-color: #e9f5ff; border-left: 4px solid #007bff; color: #333; font-family: sans-serif; border-radius: 4px;'>
    <strong>Last Searched Mobile Number:</strong> " . htmlspecialchars($mobile) . "
</div>";
        } else {
            echo "<p>Error inserting into visitor table: " . mysqli_error($conn) . "</p>";
        }
        $hello = True;


    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qrcode'])) {
    $hello = True;

    echo "
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tempDiv = document.getElementById('temp');
        if (tempDiv) {
            tempDiv.style.display = 'none';
            setTimeout(() => {
                tempDiv.remove();
            }, 1000);
        }
    });
</script>
";

    $qrcode = mysqli_real_escape_string($conn, $_POST['qrcode']);

    // 1st try: QR code match
    $query = "
SELECT *, 'iitmindia_form_data' AS db_name, 'tradevisitor' AS table_name
FROM iitminda_form_data.tradevisitor
WHERE person_key = '$qrcode'
LIMIT 1
";

    $result = mysqli_query($conn, $query);

    // 2nd try: fallback if no rows found
    if (mysqli_num_rows($result) == 0) {

        $query = "
SELECT *, 'iitmindia_form_data' AS db_name, 'exhibitor' AS table_name
FROM iitminda_form_data.exhibitor
WHERE mobile = '$qrcode'
LIMIT 1
";

        $result = mysqli_query($conn, $query);
    }

    // $search_result = ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;

    // echo '
// <pre>';
// var_dump($search_result);
// echo '</pre>';
    $search_result = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $search_result[] = $row; // push each row to the result array
        }
    }

    if (!empty($search_result)) {
        // Extract data from search_result
        $final_db = "iitmindia_form_data";
        $final_table = "tradevisitor";
        $final_id = (int) $search_result[0]['id'];

        // Insert into visitor log
        $insert_query = "
INSERT INTO iitminda_visitor.visitor (database_name, table_name, id)
VALUES ('$final_db', '$final_table', $final_id)
";

        if (mysqli_query($conn, $insert_query)) {
            echo "<div
    style='margin-top: 15px; padding: 10px 15px; background-color: #e9f5ff; border-left: 4px solid #007bff; color: #333; font-family: sans-serif; border-radius: 4px;'>
    <strong>Scanned QR Code:</strong> " . htmlspecialchars($qrcode) . "
</div>";
        } else {
            echo "<p>Error inserting into visitor table: " . mysqli_error($conn) . "</p>";
        }

        $auto_print = true;

    } else {



        echo "<p>No visitor found for QR code: " . htmlspecialchars($qrcode) . "</p>";
        $auto_print = false;
    }
}

?>