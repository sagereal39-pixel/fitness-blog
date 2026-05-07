<?php include("../blog/api/path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/topics.php");
adminOnly();
$topics = getTopics(); // Fetch topics from database
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

  <title>Admin Section - Manage Topics</title>

  <!-- Custom Styling -->
  <link rel="stylesheet" href="/assets/css/style.css" />

  <!-- Admin Styling -->
  <link rel="stylesheet" href="/assets/css/admin.css" />
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
        <a href="create.php" class="btn btn-big">Add Topic</a>
        <a href="index.php" class="btn btn-big">Manage Topics</a>
      </div>

      <div class="content">

        <h2 class="page-title">Manage Topics</h2>

        <?php include(ROOT_PATH . '/app/includes/messages.php'); ?>

        <table>
          <thead>
            <th>SN</th>
            <th>Names</th>
            <th colspan="2">Action</th>
          </thead>
          <tbody>
            <?php foreach ($topics as $key => $topic): ?>

              <tr>
                <td><?php echo $key + 1; ?></td>
                <td><?php echo $topic['name']; ?></td>
                <td><a href="edit.php?id=<?php echo $topic['id']; ?>" class="edit">edit</a></td>
                <td><a href="index.php?del_id=<?php echo $topic['id']; ?>" class="delete">delete</a></td>
              </tr>

            <?php endforeach; ?>

          </tbody>
        </table>
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

<!-- CK Editor -->
<script
  src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js"
  crossorigin></script>

<!-- Custom Script -->
<script src="../../assets/js/scripts.js"></script>


<!-- <script
        src="https://cdn.ckeditor.com/ckeditor5-premium-features/45.0.0/ckeditor5-premium-features.umd.js"
        crossorigin></script> -->
<script src="https://cdn.ckbox.io/ckbox/2.6.1/ckbox.js" crossorigin></script>
<script src="./main.js"></script>

</html>