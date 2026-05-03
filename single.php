<?php include("path.php"); ?>
<?php include(ROOT_PATH . '/app/controllers/posts.php');
include(ROOT_PATH . "/app/includes/session.php");
include(ROOT_PATH . "/app/controllers/comments.php");

$comments = [];

if (isset($_GET['id'])) {
  $post = selectOne('posts', ['id' => $_GET['id']]);
  $comments = getCommentsByPostId($_GET['id']);
}

if (isset($_GET['id'])) {
  $post = selectOne('posts', ['id' => $_GET['id']]);
}

$posts = selectALL('posts', ['published' => 1]);
$topics = selectALL('topics');


if (isset($_GET['id'])) {
  $post_id = $_GET['id'];
  $sql = "UPDATE posts SET views = views + 1 WHERE id = ?";
  $stmt = $conn->prepare($sql);
  if ($stmt === false) {
    die('SQL error:' . $conn->error);
  }
  $stmt->bind_param("i", $post_id);
  $stmt->execute();
}


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

  <title><?php echo $post['title']; ?> | Fitness And Health</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <?php include(ROOT_PATH . '/app/includes/header.php'); ?>

  <!-- Page Wrapper -->

  <div class="page-wrapper">
    <!-- Content -->
    <div class="content clearfix">
      <!-- Main Content Wrapper-->
      <div class="main-content-wrapper">
        <div class="main-content single">
          <h1 class="post-title"><?php echo $post['title']; ?></h1>
          <hr>

          <div class="post-content">
            <?php echo html_entity_decode($post['body']); ?>
          </div>

        </div>
      </div>
      <!-- // Main Content -->

      <!-- Sidebar -->
      <div class="sidebar single">
        <div class="section popular">
          <h2 class="section-title">Popular</h2>

          <?php foreach ($posts as $p): ?>
            <div class="post clearfix">
              <img src="<?php echo BASE_URL . '/assets/images/' . $p['image']; ?>" alt="" />
              <a href="#" class="title">
                <h4><?php echo $p['title'] ?></h4>
              </a>
            </div>
          <?php endforeach;  ?>

        </div>
        <div class="section topics">
          <h2 class="section-title">Topics</h2>
          <ul>

            <?php foreach ($topics as $topic): ?>
              <li><a href="<?php echo BASE_URL . '/index.php?t_id=' . $topic['id'] . '&name' . $topic['name'] ?>"><?php echo $topic['name']; ?></a></li>
            <?php endforeach; ?>

          </ul>
        </div>
      </div>
      <!-- //sidebar -->
    </div>

    <!-- // Content -->

    <!-- Comment Section -->

    <div class="comments-section">
      <h2>Comments (<?php echo count($comments); ?>)</h2>

      <?php include(ROOT_PATH . '/app/includes/messages.php'); ?>

      <?php if (isset($_SESSION['id'])): ?>
        <form action="" method="POST" class="comment-form">
          <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
          <textarea name="comment" placeholder="Write your comment..." required></textarea>
          <button type="submit" name="add-comment">Post Comment</button>
        </form>
      <?php else: ?>
        <p>Please <a href="<?php echo BASE_URL . '/login.php'; ?>">login</a> to comment.</p>
      <?php endif; ?>

      <div class="comments-list">
        <?php if (!empty($comments)): ?>
          <?php foreach ($comments as $comment): ?>
            <div class="comment-box">
              <h4><?php echo htmlspecialchars($comment['username']); ?></h4>
              <small><?php echo date('F j, Y g:i A', strtotime($comment['created_at'])); ?></small>
              <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>

              <div class="comment-actions">
                <span><?php echo getCommentLikesCount($comment['id']); ?> like(s)</span>

                <?php if (isset($_SESSION['id'])): ?>
                  <?php if (!userLikedComment($comment['id'], $_SESSION['id'])): ?>
                    <form action="" method="POST" style="display:inline;">
                      <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                      <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                      <button type="submit" name="like-comment">Like</button>
                    </form>
                  <?php else: ?>
                    <span class="liked-label">You liked this</span>
                  <?php endif; ?>
                <?php else: ?>
                  <small><a href="<?php echo BASE_URL . '/login.php'; ?>">Login</a> to like</small>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No comments yet. Be the first to comment.</p>
        <?php endif; ?>
      </div>
    </div>

    <!-- //Comment Section -->

    <!-- TODO: INCLUDE FOOTER HERE -->

    <?php include(ROOT_PATH . '/app/includes/footer.php'); ?>

  </div>

  <!-- JQuery -->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>

  <!-- Slick Carousel -->
  <script
    type="text/javascript"
    src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <!-- Custom Script -->
  <script src="assets/js/scripts.js"></script>
</body>

</html>