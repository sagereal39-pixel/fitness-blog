<?php
// Use getenv() for maximum compatibility with Vercel secrets[cite: 3]
$host = getenv('DB_HOST') ?: '127.0.0.1';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'blog';
$port = getenv('DB_PORT') ?: '3306';

// Create connection
$db = mysqli_init();
mysqli_options($db, MYSQLI_OPT_CONNECT_TIMEOUT, 5);

// Explicitly pass the port as an integer
if (!$db->real_connect($host, $user, $pass, $db_name, (int)$port)) {
  $db->set_charset("utf8mb4");
  die("Connection Failed: " . mysqli_connect_error());
}
