<?php
// On Vercel, use the $_ENV superglobal for more reliable secret loading
$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$db_name = $_ENV['DB_NAME'] ?? 'blog';
$port = $_ENV['DB_PORT'] ?? '3306';

$db = new mysqli($host, $user, $pass, $db_name, $port);

if ($db->connect_error) {
  // This will force the error to show on the screen[cite: 1]
  die("Live Connection Failed: " . $db->connect_error);
}
