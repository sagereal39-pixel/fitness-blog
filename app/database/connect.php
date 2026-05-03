<?php

$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db_name = 'blog';
$port = 3307; // change if your MySQL uses a different port

$conn = new mysqli($host, $user, $pass, $db_name, $port);

if ($conn->connect_error) {
  die('Database connection error: ' . $conn->connect_error);
}
