<?php
$title = $_POST['title'];


$select2 = $mysqli->real_escape_string(trim($_POST['select2']));
$name = $mysqli->real_escape_string(trim($_POST['lastname']));
$designation = $mysqli->real_escape_string(trim($_POST['designation']));
$organisation = $mysqli->real_escape_string(trim($_POST['organisation']));
$email = $_POST['email'];
$mobile = $_POST['mobile'];

$pincode = $mysqli->real_escape_string(trim($_POST['pincode']));
$country = $mysqli->real_escape_string(trim($_POST['country']));
$website = $mysqli->real_escape_string(trim($_POST['website']));
$address = $mysqli->real_escape_string(trim($_POST['address']));
$city = $mysqli->real_escape_string(trim($_POST['city']));
$state = $mysqli->real_escape_string(trim($_POST['state']));
$city_name = $mysqli->real_escape_string(trim($_POST['city_name']));
$category = $_POST['category'];
$mobile = trim($_POST['mobile']);
$mobile = preg_replace('/^\+91\s*/', '', $mobile);

$phone = $mobile;
function categorycheck($category)
{

    if ($category === 'other_general') {
        header('Location: ../response/');
        exit;
    }
}
categorycheck($category);


$mysqli->query("INSERT INTO tradev
(title,select2,name,designation,organisation,email,phone,mobile,address,city,state,pincode,country,website,city_name,category)
VALUES ( '$title','$select2', '$name','$designation', '$organisation', '$email','$phone',
'$mobile','$address','$city','$state','$pincode','$country','$website','$city_name','$category')");

// echo "insert done";
?>