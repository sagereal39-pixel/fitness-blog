<?php
// blog/api/path.php
define("ROOT_PATH", realpath(dirname(__FILE__) . '/../'));

$host = $_SERVER['HTTP_HOST'];

if ($host == 'localhost:5001') {
  define("BASE_URL", "http://localhost:5001/blog");
} else {
  // Use https explicitly to stop the browser from blocking your styles[cite: 8]
  define("BASE_URL", "https://" . $host);
}
