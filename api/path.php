<?php
// api/path.php[cite: 5]
define("ROOT_PATH", realpath(dirname(__FILE__) . '/../'));

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];

// If on Vercel, the host will NOT be localhost[cite: 6]
if ($host == 'localhost:5001') {
  define("BASE_URL", "http://localhost:5001/blog");
} else {
  define("BASE_URL", $protocol . "://" . $host);
}
