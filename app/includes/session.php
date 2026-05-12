<?php
if (session_status() === PHP_SESSION_NONE) {
  // Only set these if we don't have an active session cookie yet
  if (!headers_sent() && !isset($_COOKIE[session_name()])) {
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_samesite', 'Lax');
    ini_set('session.cookie_httponly', '1');
  }
  session_start();
}
