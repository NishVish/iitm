<?php
include("connection.php");

// 1. Get existing data to handle file preservation
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$existing_user = $stmt->get_result()->fetch_assoc();

if (!$existing_user) {
    die("❌ User not found.");
}

function uploadFile($key, $folder, $existing_path = null)
{
    if (!isset($_FILES[$key]) || $_FILES[$key]['error'] != 0) {
        return $existing_path; // Keep the old file if no new one is uploaded
    }

    $name = time() . "_" . basename($_FILES[$key]['name']);
    $path = "storage/" . $folder . "/" . $name;

    if (!file_exists("storage/" . $folder)) {
        mkdir("storage/" . $folder, 0777, true);
    }

    if (move_uploaded_file($_FILES[$key]['tmp_name'], $path)) {
        return $path;
    }
    return $existing_path;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];

    // Only update password if a new one is provided
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $existing_user['password'];

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
    $updated_at = date("Y-m-d H:i:s");

    // FILE UPLOADS (Pass existing path to keep it if no new file selected)
    $resume_file = uploadFile("resume_file", $employee_id, $existing_user['resume_file']);
    $offerletter_file = uploadFile("offerletter_file", $employee_id, $existing_user['offerletter_file']);
    $aadhaar_front = uploadFile("aadhaar_front", $employee_id, $existing_user['aadhaar_front']);
    $aadhaar_back = uploadFile("aadhaar_back", $employee_id, $existing_user['aadhaar_back']);
    $pan_card_file = uploadFile("pan_card_file", $employee_id, $existing_user['pan_card_file']);

    $document_1_name = $_POST['document_1_name'];
    $document_1_file = uploadFile("document_1_file", $employee_id, $existing_user['document_1_file']);
    // ... Repeat for 2, 3, 4 ...

    // PREPARED UPDATE STATEMENT
    $sql = "UPDATE users SET 
        employee_id=?, name=?, designation=?, phone=?, address=?, email=?, 
        password=?, category=?, department=?, doj=?, uan_no=?, 
        fathers_name=?, aadhaar_card=?, pan_card=?, 
        bank_account_number=?, ifsc_code=?, user_type=?, journal=?, 
        updated_at=?, resume_file=?, offerletter_file=?, 
        aadhaar_front=?, aadhaar_back=?, pan_card_file=?, 
        document_1_name=?, document_1_file=?
        WHERE id=?";

    $stmt = $conn->prepare($sql);

    // Bind parameters: 's' for string, 'i' for integer
    // Note: ensure the order matches the SQL statement exactly
    $stmt->bind_param(
        "ssssssssssssssssssssssssssi",
        $employee_id,
        $name,
        $designation,
        $phone,
        $address,
        $email,
        $password,
        $category,
        $department,
        $doj,
        $uan_no,
        $fathers_name,
        $aadhaar_card,
        $pan_card,
        $bank_account_number,
        $ifsc_code,
        $user_type,
        $journal,
        $updated_at,
        $resume_file,
        $offerletter_file,
        $aadhaar_front,
        $aadhaar_back,
        $pan_card_file,
        $document_1_name,
        $document_1_file,
        $id
    );

    if ($stmt->execute()) {
        header("Location: info.php?id=" . $id . "&msg=updated");
        exit;
    } else {
        echo "❌ Error: " . $stmt->error;
    }
}
?>