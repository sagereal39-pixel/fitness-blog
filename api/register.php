<?php // This is the ONLY way to reliably find path.php from any file in the api/ folder[cite: 7]
require_once(__DIR__ . '/path.php'); ?>
<?php include(ROOT_PATH . "/app/controllers/users.php");
include(ROOT_PATH . "/app/includes/session.php");
// register.php line 4
require_once ROOT_PATH . '/services/EmailService.php'; // Updated to use ROOT_PATH
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

  <title>Register</title>
  <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/style.css'; ?>" />
</head>

<body>
  <!-- TODO: INCLUDE FOOTER HERE -->
  <?php include(ROOT_PATH . '/app/includes/header.php') ?>

  <div class="auth-content">
    <form action="register.php" method="POST">
      <h2 class="form-title">Register</h2>


      <?php include(ROOT_PATH . '/app/helpers/formErrors.php'); ?>


      <div>
        <label for="name">Username</label>
        <input type="text" name="username" class="text-input" value="<?php echo $username; ?>" placeholder="Enter username" />
      </div>
      <div>
        <label for="name">Email</label>
        <input type="email" name="email" class="text-input" value="<?php echo $email; ?>" placeholder="Enter email" />
      </div>
      <div>
        <label for="name">Password</label>
        <input type="password" name="password" class="text-input" value="<?php echo $password; ?>" placeholder="Enter password" />
      </div>
      <div>
        <label for="name">Confirm Password</label>
        <input type="password" name="passwordconf" class="text-input" value="<?php echo $passwordconf; ?>" placeholder="Confirm password" />
      </div>
      <div>
        <button type="submit" name="register-btn" class="btn btn-big">
          Register
        </button>
      </div>
      <p>Or <a href="<?php echo BASE_URL .  '/login.php' ?> "> Sign In</a></p>
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