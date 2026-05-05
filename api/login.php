<?php // This is the ONLY way to reliably find path.php from any file in the api/ folder[cite: 7]
require_once(__DIR__ . '/path.php'); ?>
<?php include(ROOT_PATH . "/app/controllers/users.php");
include(ROOT_PATH . "/app/includes/session.php");

guestsOnly();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Font Awesome -->

  <script
    src="https://kit.fontawesome.com/716cf32068.js"
    crossorigin="anonymous"></script>

  <!-- Google Fonts -->

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Candal&family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Lora:ital,wght@0,400..700;1,400..700&display=swap"
    rel="stylesheet" />

  <title>Login</title>
  <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/style.css'; ?>" />
</head>

<body>
  <!-- TODO: INCLUDE FOOTER HERE -->

  <?php include(ROOT_PATH . '/app/includes/header.php') ?>

  <div class="auth-content">

    <form action="login.php" method="POST">
      <h2 class="form-title">Login</h2>

      <?php include(ROOT_PATH . '/app/helpers/formErrors.php'); ?>

      <div>
        <label for="name">Username</label>
        <input type="text" name="username" value="<?php echo $username; ?>" class="text-input" />
      </div>

      <div>
        <label for="name">Password</label>
        <input type="password" name="password" value="<?php echo $password; ?>" class="text-input" />
      </div>

      <div>
        <button type="submit" name="login-btn" class="btn btn-big">Login</button>
      </div>

      <p>Or <a href="<?php echo BASE_URL .  '/register.php' ?> ">Register</a></p><br>
      <p>Forgot Password? <a href="<?php echo BASE_URL . '/reset_password.php' ?> ">Reset Here</a></p>
    </form>
  </div>

  <!-- JQuery -->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
  <!-- //JQuery -->

  <!-- Custom Script -->
  <script src="assets/js/scripts.js"></script>
  <!-- //Custom Script -->
</body>

</html>