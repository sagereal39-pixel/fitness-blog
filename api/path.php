<?php
// blog/api/path.php[cite: 2]
define("ROOT_PATH", realpath(dirname(__FILE__) . '/../'));

$host = $_SERVER['HTTP_HOST'];

if ($host == 'localhost:5001') {
  // Local development remains http[cite: 5, 6]
  define("BASE_URL", "http://localhost:5001/blog");
} else {
  // Force HTTPS for Vercel to fix the Mixed Content error[cite: 6]
  define("BASE_URL", "https://" . $host);
}
