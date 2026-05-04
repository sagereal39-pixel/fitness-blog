// Use $_SERVER for environment variables as it's often more stable on Vercel[cite: 3]
$host = $_SERVER['DB_HOST'] ?? '127.0.0.1';
$user = $_SERVER['DB_USER'] ?? 'root';
$pass = $_SERVER['DB_PASS'] ?? '';
$db_name = $_SERVER['DB_NAME'] ?? 'blog';
$port = $_SERVER['DB_PORT'] ?? '3306';

// Create connection
$db = mysqli_init();
// Set a timeout to prevent the "Blank Screen" hang[cite: 3]
mysqli_options($db, MYSQLI_OPT_CONNECT_TIMEOUT, 5);

if (!$db->real_connect($host, $user, $pass, $db_name, $port)) {
die("Connection Failed: " . mysqli_connect_error());
}