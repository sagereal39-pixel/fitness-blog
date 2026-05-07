<?php

include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/validateUser.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/includes/session.php");
include(ROOT_PATH . "/app/includes/session.php");

require_once(ROOT_PATH . '/services/EmailService.php');

$table = 'users';

$admin_users = selectALL($table);

$errors = array();
$id = '';
$username = '';
$admin = '';
$email = '';
$password = '';
$passwordconf = '';


function loginUser($user)
{
  $_SESSION['id'] = $user['id'];
  $_SESSION['username'] = $user['username'];
  $_SESSION['admin'] = $user['admin'];
  $_SESSION['message'] = 'Login Successful';
  $_SESSION['type'] = 'success';

  if ($_SESSION['admin']) {
    header('location: ' . BASE_URL . '/admin/dashboard.php');
  } else {
    header('location: ' . BASE_URL . '/index.php');
  }
  exit();
}

// Logic to Reset the session if they want to try a different email
if (isset($_GET['resend'])) {
  unset($_SESSION['code_sent'], $_SESSION['reset_email']);
  header('location: reset_password.php');
  exit();
}

// Updated Registration Logic
if (isset($_POST['register-btn']) || isset($_POST['create-admin'])) {
  $errors = validateUser($_POST);

  if (count($errors) === 0) {
    unset($_POST['register-btn'], $_POST['passwordconf'], $_POST['create-admin']);
    $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (isset($_POST['admin'])) {
      $_POST['admin'] = 1;
      $user_id = create($table, $_POST);
      $_SESSION['message'] = 'Admin user created Successfully';
      $_SESSION['type'] = 'success';
      header('location: ' . BASE_URL . '/admin/users/index.php');
      exit();
    } else {
      $_POST['admin'] = 0;
      $user_id = create($table, $_POST);

      if ($user_id) {
        // --- TRIGGER WELCOME EMAIL ---
        $emailService = new EmailService();
        $emailService->sendRegistrationEmail($_POST['email'], $_POST['username']);

        $user = selectOne($table, ['id' => $user_id]);
        loginUser($user); // Redirects to index or dashboard[cite: 7]
      }
    }
  } else {
    // ... error handling ...
    $username = $_POST['username'];
    $admin = isset($_POST['admin']) ? 1 : 0;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordconf = $_POST['passwordconf'];
  }
}


if (isset($_POST['update-user'])) {
  adminOnly();
  $errors = validateUser($_POST);

  if (count($errors) === 0) {
    $id = $_POST['id'];
    unset($_POST['passwordconf'], $_POST['update-user'], $_POST['id']);
    $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $_POST['admin'] = isset($_POST['admin']) ? 1 : 0;
    $count = update($table, $id, $_POST);
    $_SESSION['message'] = 'Admin user updated Successfully';
    $_SESSION['type'] = 'success';
    header('location: ' . BASE_URL . '/admin/users/index.php');
    exit();
  } else {

    $username = $_POST['username'];
    $admin = isset($_POST['admin']) ? 1 : 0;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordconf = $_POST['passwordconf'];
  }
}

if (isset($_GET['id'])) {
  $user = selectOne($table, ['id' => $_GET['id']]);

  $username = $user['username'];
  $id = $user['id'];
  $admin = $user['admin'];
  $email = $user['email'];
}

//  1. Logic to Send the 6-Digit Code
if (isset($_POST['send-code-btn'])) {
  $email = $_POST['email'];
  $user = selectOne($table, ['email' => $email]);

  if ($user) {
    $code = rand(100000, 999999); // Generate 6-digit numeric code
    $expires_at = date("Y-m-d H:i:s", strtotime('+15 minutes')); // Short expiry for codes

    // Clear any old codes for this email first to prevent clutter
    executeQuery("DELETE FROM password_resets WHERE email=?", [$email]);

    create('password_resets', [
      'email' => $email,
      'token' => $code,
      'expires_at' => $expires_at
    ]);

    $emailService = new EmailService();
    $status = $emailService->sendPasswordReset($email, $code);

    if ($status) {
      $_SESSION['code_sent'] = true;
      $_SESSION['reset_email'] = $email;
      $_SESSION['message'] = "Reset code sent! Check your inbox. ✅";
      $_SESSION['type'] = "success";
    } else {
      array_push($errors, "Failed to send email. Please try again.");
    }
  } else {
    array_push($errors, "No account found with that email address.");
  }
}

// 2. Logic to Verify Code and Update Password
if (isset($_POST['verify-code-btn'])) {
  $code = $_POST['token'];
  $password = $_POST['password'];
  $passwordconf = $_POST['passwordconf'];
  $email = $_SESSION['reset_email'];

  if (empty($password) || $password !== $passwordconf) {
    array_push($errors, "Passwords do not match or are empty.");
  }

  if (count($errors) === 0) {
    // Verify code exists for this specific email
    $reset_request = selectOne('password_resets', [
      'token' => $code,
      'email' => $email
    ]);

    $current_time = date("Y-m-d H:i:s");

    if ($reset_request && $reset_request['expires_at'] > $current_time) {
      $new_password = password_hash($password, PASSWORD_DEFAULT);
      $user = selectOne($table, ['email' => $email]);

      if ($user) {
        update($table, $user['id'], ['password' => $new_password]);

        // Cleanup: Delete used code and clear session
        executeQuery("DELETE FROM password_resets WHERE email=?", [$email]);
        unset($_SESSION['code_sent'], $_SESSION['reset_email']);

        $_SESSION['message'] = "Password updated! You can now login. ✅";
        $_SESSION['type'] = "success";
        header('location: ' . BASE_URL . '/login.php');
        exit();
      }
    } else {
      array_push($errors, "Invalid or expired code.");
    }
  }
}

// Login Logic
if (isset($_POST['login-btn'])) {
  $errors = validateLogin($_POST);

  if (count($errors) === 0) {
    $user = selectOne($table, ['username' => $_POST['username']]);

    if ($user && password_verify($_POST['password'], $user['password'])) {
      // log a user in
      loginUser($user);
    } else {
      array_push($errors, 'Invalid username or password');
    }
  }

  $username = $_POST['username'];
  $password = $_POST['password'];
}

if (isset($_GET['delete_id'])) {
  adminOnly();
  $count = delete($table, $_GET['delete_id']);
  $_SESSION['message'] = 'Admin user deleted';
  $_SESSION['type'] = 'success';
  header('location: ' . BASE_URL . '/admin/users/index.php');
  exit();
}

function getAdminUsers()
{
  global $db;
  $sql = "SELECT * FROM users WHERE role = 'admin'";
  $result = mysqli_query($db, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
