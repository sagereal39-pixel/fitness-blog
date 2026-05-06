<?php
define("ROOT_PATH", realpath(dirname(__FILE__) . '/../'));

$host = $_SERVER['HTTP_HOST'];

if ($host == 'localhost:5001') {
  define("BASE_URL", "http://localhost:5001/blog");
} else {
  // Replace this with your ACTUAL Vercel URL temporarily
  define("BASE_URL", "https://fitness-blog-kdfbsrsfm-sagereal39-3189s-projects.vercel.app");
}
