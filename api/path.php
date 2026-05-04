<?php
// Go up one level from /api to reach the project root

define("ROOT_PATH", realpath(dirname(__FILE__) . '/../'));

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];

// Dynamic BASE_URL logic[cite: 6]
$base_url = ($host == 'localhost:5001') ? "$protocol://$host/blog" : "$protocol://$host";
define("BASE_URL", $base_url);
