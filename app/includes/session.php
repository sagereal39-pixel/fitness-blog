<?php
// Only set session parameters if the session hasn't started yet
if (session_status() === PHP_SESSION_NONE) {
  // These must happen BEFORE session_start()
  if (!headers_sent()) {
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_samesite', 'Lax');
  }
  session_start();
}
