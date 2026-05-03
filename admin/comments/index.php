<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/posts.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/comments.php"); ?>
<?php adminOnly(); ?>

<?php
$post = null;
$comments = [];

if (isset($_GET['post_id'])) {
  $post_id = (int) $_GET['post_id'];
  $post = selectOne('posts', ['id' => $post_id]);
  $comments = getCommentsByPostId($post_id);
} else {
  $_SESSION['error'] = "No post selected.";
  header("Location: " . BASE_URL . "/admin/dashboard.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src="https://kit.fontawesome.com/716cf32068.js" crossorigin="anonymous"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Candal&family=Comic+Neue:wght@300;400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">

  <title>Admin Section - View Comments</title>

  <link rel="stylesheet" href="../../assets/css/style.css">
  <link rel="stylesheet" href="../../assets/css/admin.css">
</head>

<body>

  <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>

  <div class="admin-wrapper">
    <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>

    <div class="admin-content">
      <div class="content">
        <h2 class="page-title">Comments for: <?php echo htmlspecialchars($post['title']); ?></h2>

        <?php include(ROOT_PATH . '/app/includes/messages.php'); ?>

        <table>
          <thead>
            <tr>
              <th>SN</th>
              <th>User</th>
              <th>Comment</th>
              <th>Likes</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($comments)): ?>
              <?php foreach ($comments as $key => $comment): ?>
                <tr>
                  <td><?php echo $key + 1; ?></td>
                  <td><?php echo htmlspecialchars($comment['username']); ?></td>
                  <td><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></td>
                  <td><?php echo getCommentLikesCount($comment['id']); ?></td>
                  <td><?php echo date('F j, Y g:i A', strtotime($comment['created_at'])); ?></td>
                  <td>
                    <a
                      href="<?php echo BASE_URL . '/admin/comments/index.php?post_id=' . $post['id'] . '&delete_comment_id=' . $comment['id']; ?>"
                      class="delete"
                      onclick="return confirm('Delete this comment?');">delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6">No comments for this post yet.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <br>
        <a href="<?php echo BASE_URL . '/admin/dashboard.php'; ?>" class="btn">Back to Dashboard</a>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../../assets/js/scripts.js"></script>
</body>

</html>