<?php
include("connection.php");

function uploadFile($key, $folder)
{

    if (!isset($_FILES[$key]) || $_FILES[$key]['error'] != 0) {
        return null;
    }

    $name = time() . "_" . basename($_FILES[$key]['name']);
    $path = "storage/" . $folder . "/" . $name;

    if (!file_exists("storage/" . $folder)) {
        mkdir("storage/" . $folder, 0777, true);
    }

    move_uploaded_file($_FILES[$key]['tmp_name'], $path);

    return $path;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $employee_id = $_POST['employee_id'];

    // =========================
    // TEXT FIELDS
    // =========================
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $category = $_POST['category'];
    $department = $_POST['department'];
    $doj = $_POST['doj'];
    $uan_no = $_POST['uan_no'];
    $fathers_name = $_POST['fathers_name'];
    $aadhaar_card = $_POST['aadhaar_card'];
    $pan_card = $_POST['pan_card'];
    $bank_account_number = $_POST['bank_account_number'];
    $ifsc_code = $_POST['ifsc_code'];
    $user_type = $_POST['user_type'];
    $journal = $_POST['journal'];

    $created_at = date("Y-m-d H:i:s");
    $updated_at = date("Y-m-d H:i:s");

    // =========================
    // FILE UPLOADS
    // =========================
    $resume_file = uploadFile("resume_file", $employee_id);
    $offerletter_file = uploadFile("offerletter_file", $employee_id);
    $aadhaar_front = uploadFile("aadhaar_front", $employee_id);
    $aadhaar_back = uploadFile("aadhaar_back", $employee_id);
    $pan_card_file = uploadFile("pan_card_file", $employee_id);

    $document_1_name = $_POST['document_1_name'];
    $document_2_name = $_POST['document_2_name'];
    $document_3_name = $_POST['document_3_name'];
    $document_4_name = $_POST['document_4_name'];

    $document_1_file = uploadFile("document_1_file", $employee_id);
    $document_2_file = uploadFile("document_2_file", $employee_id);
    $document_3_file = uploadFile("document_3_file", $employee_id);
    $document_4_file = uploadFile("document_4_file", $employee_id);

    // =========================
    // INSERT QUERY
    // =========================
    $sql = "INSERT INTO users (
        employee_id, name, designation, phone, address, email,
        password, category, department, doj, uan_no,
        fathers_name, aadhaar_card, pan_card,
        bank_account_number, ifsc_code, user_type, journal,
        created_at, updated_at,
        resume_file, offerletter_file,
        aadhaar_front, aadhaar_back,
        pan_card_file,
        document_1_name, document_1_file,
        document_2_name, document_2_file,
        document_3_name, document_3_file,
        document_4_name, document_4_file
    ) VALUES (
        '$employee_id', '$name', '$designation', '$phone', '$address', '$email',
        '$password', '$category', '$department', '$doj', '$uan_no',
        '$fathers_name', '$aadhaar_card', '$pan_card',
        '$bank_account_number', '$ifsc_code', '$user_type', '$journal',
        '$created_at', '$updated_at',
        '$resume_file', '$offerletter_file',
        '$aadhaar_front', '$aadhaar_back',
        '$pan_card_file',
        '$document_1_name', '$document_1_file',
        '$document_2_name', '$document_2_file',
        '$document_3_name', '$document_3_file',
        '$document_4_name', '$document_4_file'
    )";

    // var_dump($sql);

    if ($conn->query($sql)) {
        $id = $conn->insert_id;

        header("Location: info.php?id=" . $id);
        exit;
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>