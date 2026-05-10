<?php
if (session_status() === PHP_SESSION_NONE) {
  // These MUST come before session_start()
  ini_set('session.cookie_path', '/');
  ini_set('session.cookie_samesite', 'Lax');
  ini_set('session.cookie_httponly', '1');
  session_start();
}
