<?php
date_default_timezone_set('Asia/Kolkata');


$host = '21.157.66.148.host.secureserver.net';
$port = 3306;
$user = 'iitminda_master';
$password = 'gB)%gU}ocn?MCP=}';
$database = 'iitminda_form_data';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Company Details
$company_name = $_POST['company_name'] ?? '';
$address = $_POST['address'] ?? '';
$city = $_POST['city'] ?? '';
$pin = $_POST['pincode'] ?? '';
$state = $_POST['state'] ?? '';

$delegates = $_POST['delegates'] ?? [];

if (empty($delegates)) {
    die("No delegates found.");
}

// Generate Company ID
$company_id = "C" . date("ymdHis");

// Prepared Statement
$sql = "INSERT INTO tradevisitor
(person_key, name, designation, company_name, company_id, category, address, city, pin, state, mobile, email)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

foreach ($delegates as $delegate) {

    $person_key = uniqid("P");

    var_dump($person_key);

    var_dump($delegates);
    exit();
    $name = trim($delegate['name']);
    $designation = trim($delegate['designation']);
    $mobile = trim($delegate['mobile']);
    $email = trim($delegate['email']);

    $category = "Trade";

    $stmt->bind_param(
        "ssssssssssss",
        $person_key,
        $name,
        $designation,
        $company_name,
        $company_id,
        $category,
        $address,
        $city,
        $pin,
        $state,
        $mobile,
        $email
    );

    $stmt->execute();
}

$stmt->close();
$conn->close();

echo "Registration Successful.";
?>