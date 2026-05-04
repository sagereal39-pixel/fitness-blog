<?php
// Use getenv() to pull from Vercel's Environment Variables
$host = getenv('DB_HOST') ?: '127.0.0.1';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'blog';
$port = getenv('DB_PORT') ?: '3306';

// This is likely line 9 where the error is thrown
$conn = new MySQLi($host, $user, $pass, $db_name, $port);

if ($conn->connect_error) {
  die("Database connection error: " . $conn->connect_error);
}
