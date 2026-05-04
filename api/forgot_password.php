<?php include("path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/users.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <?php include(ROOT_PATH . '/app/includes/header.php'); ?>

  <div class="auth-content">
    <form action="reset_password.php" method="post">
      <h2 class="form-title">Set New Password</h2>

      <?php include(ROOT_PATH . '/app/helpers/formErrors.php'); ?>

      <!-- Hidden field to keep track of the token[cite: 5] -->
      <input type="hidden" name="token" value="<?php echo $_GET['token'] ?? $_POST['token']; ?>">

      <div>
        <label>Email</label>
        <input type="email" name="email" class="text-input" placeholder="Enter Your Email">
      </div>

      <div>
        <label>Password</label>
        <input type="password" name="password" class="text-input">
      </div>
      <div>
        <label>Confirm Password</label>
        <input type="password" name="passwordconf" class="text-input">
      </div>
      <div>
        <button type="submit" name="reset-password-btn" class="btn btn-big">Update Password</button>
      </div>
    </form>
  </div>
</body>

</html>