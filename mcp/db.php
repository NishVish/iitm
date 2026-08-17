<?php
$host="21.157.66.148.host.secureserver.net";
$user="iitminda_master";
$password="gB)%gU}ocn?MCP=}";
$database="iitminda_form_data";



$conn=new mysqli(
    $host,
    $user,
    $password,
    $database
);


if($conn->connect_error)
{

    die(
        json_encode([
            "error"=>$conn->connect_error
        ])
    );

}


$conn->set_charset("utf8mb4");


?>