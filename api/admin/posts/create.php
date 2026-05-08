<?php include(dirname(__DIR__, 2) . "/path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/posts.php");
adminOnly();
$topics = getTopics();
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

  <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> -->


  <!-- Google Fonts -->

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Candal&family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Lora:ital,wght@0,400..700;1,400..700&display=swap"
    rel="stylesheet" />

  <title>Admin Section - Add Posts</title>

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
        <a href="create.php" class="btn btn-big">Add Posts</a>
        <a href="index.php" class="btn btn-big">Manage Posts</a>
      </div>

      <div class="content">
        <h2 class="page-title">Add Posts</h2>

        <?php include(ROOT_PATH . '/app/helpers/formErrors.php'); ?>

        <form action="create.php" method="post" enctype="multipart/form-data">
          <div>
            <label>Title</label>
            <input type="text" name="title" value="<?php echo isset($title) ? $title : '' ?>" class="text-input" />
          </div>
          <div>
            <label>Body</label>
            <textarea name="body" id="body"><?php echo isset($body) ? $body : '' ?></textarea>
          </div>
          <div>
            <label>Image</label>
            <input type="file" name="image" class="text-input" />
          </div>
          <div>
            <label>Topics</label>
            <select name="topic_id" class="text-input">
              <option value=""></option>

              <?php foreach ($topics as $key => $topic): ?>

                <?php if (!empty($topic_id) && $topic_id == $topic['id']): ?>
                  <option selected value="<?php echo $topic['id'] ?>"><?php echo $topic['name'] ?></option>
                <?php else: ?>
                  <option value="<?php echo $topic['id'] ?>"><?php echo $topic['name'] ?></option>
                <?php endif; ?>

              <?php endforeach; ?>

            </select>
          </div>
          <div>
            <?php if (empty($published)): ?>
              <label>
                <input type="checkbox" name="published">
                Publish
              </label>
            <?php else: ?>
              <label>
                <input type="checkbox" name="published" checked>
                Publish
              </label>
            <?php endif; ?>
          </div>

          <div>
            <button type="submit" name="add-post" class="btn btn-big">Add Post</button>
          </div>

        </form>
      </div>
    </div>
    <!-- //Admin Content -->
  </div>

  <!-- // Admin Page Wrapper -->


  <!-- include CKEditor 5 Classic build -->

  <?php
  include(ROOT_PATH . "/blog/upload.php");
  ?>

  <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

  <script>
    ClassicEditor
      .create(document.querySelector('#body'), {
        toolbar: [
          'heading', '|',
          'bold', 'italic', 'link', '|',
          'bulletedList', 'numberedList', 'blockQuote', '|',
          'insertTable', 'undo', 'redo',
          'imageUpload' // <-- add this
        ],
        image: {
          toolbar: [
            'imageTextAlternative', 'imageStyle:full', 'imageStyle:side'
          ]
        },
        simpleUpload: {
          // The endpoint on your server that handles image upload
          uploadUrl: 'upload.php',

          // Optional: if you need to send credentials or headers (CSRF etc.)
          // headers: { 'X-CSRF-TOKEN': '...' }
        }
      })
      .then(editor => {
        console.log('Editor ready with image upload', editor);
      })
      .catch(error => {
        console.error('Error initializing editor with image upload:', error);
      });
  </script>



</body>

<!-- JQuery -->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
  integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer">
</script>

<!-- CK Editor -->
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/47.0.0/ckeditor5.umd.js"></script> -->

<!-- <script
        src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js"
        crossorigin>
    </script> -->

<!-- Custom Script -->
<script src="../../assets/js/scripts.js"></script>


<!-- <script
        src="https://cdn.ckeditor.com/ckeditor5-premium-features/45.0.0/ckeditor5-premium-features.umd.js"
        crossorigin></script> -->
<script src="https://cdn.ckbox.io/ckbox/2.6.1/ckbox.js" crossorigin></script>
<script src="./main.js"></script>

</html>