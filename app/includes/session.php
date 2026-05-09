<?php
// Force session cookies to be available across all subdirectories
ini_set('session.cookie_path', '/');
ini_set('session.cookie_domain', ''); // Leave empty for current domain
ini_set('session.cookie_samesite', 'Lax');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
