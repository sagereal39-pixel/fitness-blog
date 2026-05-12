<?php
if (session_status() === PHP_SESSION_NONE) {
  // Only set these if a session hasn't started yet
  if (!headers_sent()) {
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_samesite', 'Lax');
    ini_set('session.cookie_httponly', '1');
  }
  session_start();
}
