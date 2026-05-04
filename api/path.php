<?php
// blog/api/path.php

// ROOT_PATH should go up one level to reach the folder containing /assets[cite: 2, 5]
define("ROOT_PATH", realpath(dirname(__FILE__) . '/../'));

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];

// If the URL contains 'vercel.app', use the root; otherwise, use the local subfolder[cite: 6]
if (strpos($host, 'vercel.app') !== false) {
  define("BASE_URL", "$protocol://$host");
} else {
  // Standard localhost path[cite: 5]
  define("BASE_URL", "http://localhost:5001/blog");
}
