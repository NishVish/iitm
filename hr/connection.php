<?php

// Database configuration
$HOST = "21.157.66.148.host.secureserver.net";
$PORT = 3306;
$USER = "iitminda_master";
$PASSWORD = "gB)%gU}ocn?MCP=}";
$DB = "iitminda_testing_server";


$conn = new mysqli($HOST, $USER, $PASSWORD, $DB, $PORT);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set charset
$conn->set_charset("utf8mb4");

// You can now use $conn in other files
// Example: include 'db.php';

?>