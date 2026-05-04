define("ROOT_PATH", realpath(dirname(__FILE__) . '/../../'));

// Dynamically determine the Base URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];

// If on localhost, include the subfolder; otherwise, use the root
$base_url = ($host == 'localhost:5001') ? "$protocol://$host/blog" : "$protocol://$host";
define("BASE_URL", $base_url);