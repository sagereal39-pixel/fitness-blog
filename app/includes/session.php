<?php
if (session_status() === PHP_SESSION_NONE) {
  if (!headers_sent()) {
    // Force the session to be valid for the entire project domain
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_samesite', 'Lax');
    ini_set('session.cookie_httponly', '1');

    // This helps Vercel maintain a steady session ID
    session_set_cookie_params([
      'path' => '/',
      'samesite' => 'Lax',
      'httponly' => true
    ]);
  }
  session_start();
}
