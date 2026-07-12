<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    ;
    die("<h2>Access Denied!</h2> This file is protected and not available to public.");
}



$timezone = "Asia/Calcutta";
if (function_exists('date_default_timezone_set'))
    date_default_timezone_set($timezone);

$mysqli = new mysqli("21.157.66.148.host.secureserver.net", "iitminda_master", "gB)%gU}ocn?MCP=}", "iitminda_iitmindia_2024");


if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}


?>