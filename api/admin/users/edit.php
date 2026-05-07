<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . '/app/controllers/users.php');
adminOnly();
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

  <title>Admin Section - Edit Users</title>

  <!-- Custom Styling -->
  <link rel="stylesheet" href="../../assets/css/style.css" />

  <!-- Admin Styling -->
  <link rel="stylesheet" href="../../assets/css/admin.css" />
</head>

<body>
  <div class="main-container">
    <div class="presence" id="editor-presence"></div>
    <div
      class="editor-container editor-container_classic-editor editor-container_include-outline editor-container_include-annotations"
      id="editor-container">
      <div class="editor-container__editor-wrapper">
        <div class="editor-container__sidebar" id="editor-outline"></div>
        <div class="editor-container__editor">
          <div id="editor"></div>
        </div>
        <div class="editor-container__sidebar" id="editor-annotations"></div>
      </div>
    </div>
    <div class="revision-history" id="editor-revision-history">
      <div class="revision-history__wrapper">
        <div
          class="revision-history__editor"
          id="editor-revision-history-editor"></div>
        <div
          class="revision-history__sidebar"
          id="editor-revision-history-sidebar"></div>
      </div>
    </div>
  </div>

  <!-- admin header here -->

  <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>

  <!-- Admin Page Wrapper -->

  <div class="admin-wrapper">
    <!-- Left Sidebar -->


    <!-- //Left Sidebar -->

    <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>

    <!-- Admin Content -->

    <div class="admin-content">
      <div class="btn-group">
        <a href="create.php" class="btn btn-big"> Add Users</a>
        <a href="index.php" class="btn btn-big">Manage Users</a>
      </div>

      <div class="content">
        <h2 class="page-title">Edit Users</h2>

        <?php include(ROOT_PATH . '/app/helpers/formErrors.php'); ?>

        <form action="edit.php" method="post">
          <input type="hidden" name="id" value="<?php echo $id ?>" />
          <div>
            <label for="name">Username</label>
            <input type="text" name="username" value="<?php echo $username; ?>" class="text-input" />
          </div>
          <div>
            <label for="name">Email</label>
            <input type="text" name="email" value="<?php echo $email; ?>" class="text-input" />
          </div>
          <div>
            <label for="name">Password</label>
            <input type="text" name="password" value="<?php echo $password; ?>" class="text-input" />
          </div>
          <div>
            <label for="name">Confirm Password</label>
            <input type="text" name="passwordconf" value="<?php echo $passwordconf; ?>" class="text-input" />
          </div>

          <div>
            <?php if (isset($admin) && $admin == 1):  ?>
              <label>
                <input type="checkbox" name="admin" checked>
                Admin
              </label>
            <?php else: ?>
              <label>
                <input type="checkbox" name="admin">
                Admin
              </label>
            <?php endif; ?>
          </div>

          <div>
            <button type="submit" name="update-user" class="btn btn-big">Update User</button>
          </div>
        </form>
      </div>
    </div>
    <!-- //Admin Content -->
  </div>

  <!-- // Admin Page Wrapper -->

</body>

<!-- JQuery -->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
  integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"></script>

<!-- Custom Script -->
<script src="../../assets/js/scripts.js"></script>


<!-- <script
        src="https://cdn.ckeditor.com/ckeditor5-premium-features/45.0.0/ckeditor5-premium-features.umd.js"
        crossorigin></script> -->
<script src="https://cdn.ckbox.io/ckbox/2.6.1/ckbox.js" crossorigin></script>
<script src="./main.js"></script>

</html>