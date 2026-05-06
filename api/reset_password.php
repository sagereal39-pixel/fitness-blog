<?php // This is the ONLY way to reliably find path.php from any file in the api/ folder[cite: 7]
require_once(__DIR__ . '/path.php'); ?>
<?php include(ROOT_PATH . "/app/controllers/users.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <!-- Add ?v=1 to the end of the URL to force a refresh[cite: 6] -->
  <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/style.css?v=999'; ?>" />
</head>

<body>
  <?php include(ROOT_PATH . '/app/includes/header.php'); ?>
  <div class="auth-content">
    <form action="reset_password.php" method="post">
      <h2 class="form-title">Set New Password</h2>
      <?php include(ROOT_PATH . '/app/helpers/formErrors.php'); ?>
      <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

      <?php if (!isset($_SESSION['code_sent'])): ?>
        <!-- STEP 1: Enter Email -->
        <div>
          <label>Email</label>
          <input type="email" name="email" class="text-input" placeholder="Enter your registered email">
        </div>
        <button type="submit" name="send-code-btn" class="btn btn-big">Send Reset Code</button>
      <?php else: ?>
        <!-- STEP 2: Enter Code & New Password -->
        <p style="color: #1a202c; font-size: 0.9rem;">Enter the 6-digit code sent to <strong><?php echo $_SESSION['reset_email']; ?></strong></p>
        <div>
          <label>6-Digit Code</label>
          <input type="text" name="token" class="text-input" maxlength="6" placeholder="000000">
        </div>
        <div>
          <label>New Password</label>
          <input type="password" name="password" class="text-input">
        </div>
        <div>
          <label>Confirm Password</label>
          <input type="password" name="passwordconf" class="text-input">
        </div>
        <button type="submit" name="verify-code-btn" class="btn btn-big">Update Password</button>
        <p><a href="reset_password.php?resend=true">Didn't get a code? Try again.</a></p>
      <?php endif; ?>
    </form>
  </div>
</body>

</html>