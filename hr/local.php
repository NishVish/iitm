<?php

// Database configuration
$HOST = "127.0.0.1";
$PORT = 3306;
$USER = "root";
$PASSWORD = "";
$DB = "localtesting";

// Create connection
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