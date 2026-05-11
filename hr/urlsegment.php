<?php

$uri = $_SERVER['REQUEST_URI'];   // full URL path
$path = parse_url($uri, PHP_URL_PATH); // remove query string
$segments = explode('/', trim($path, '/'));

$lastSegment = end($segments);

// echo $lastSegment;

?>