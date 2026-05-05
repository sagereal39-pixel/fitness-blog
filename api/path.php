<?php

// This is the ONLY way to reliably find path.php from any file in the api/ folder[cite: 7]
define("ROOT_PATH", realpath(dirname(__FILE__) . '/../'));

$host = $_SERVER['HTTP_HOST'];
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

if ($host === 'localhost:5001') {
  define("BASE_URL", "http://localhost:5001/blog");
} else {
  define("BASE_URL", $protocol . $host); // ✅ no /blog here
}
