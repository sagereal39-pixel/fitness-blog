<?php
// Instead of defining ROOT_PATH here, include the path file[cite: 2]
require_once(__DIR__ . '/path.php');

// 2. Use that ROOT_PATH for all includes
include(ROOT_PATH . "/app/controllers/topics.php");
include(ROOT_PATH . "/app/includes/session.php");

$posts = array();
$postsTitle = 'Recent Posts';
$topics = getAllTopics();


// require_once __DIR__ . '/../index.php';

if (isset($_GET['t_id'])) {
  $posts = getPostsByTopicId($_GET['t_id']);
  $topic = getTopicById($_GET['t_id']);
  $postsTitle = "Posts under '" . $topic['name'] . "'";
} else if (isset($_POST['search-term'])) {
  $postsTitle = "You Searched For '" . $_POST['search-term'] .  "'";
  $posts = searchPosts($_POST['search-term']);
} else {
  $posts = getPublishedPosts();
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

  <title>Fitness and Health</title>
  <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/style.css' ?>" />
</head>

<body>

  <!-- TODO: INCLUDE CODE HERE -->
  <?php include(ROOT_PATH . '/app/includes/header.php'); ?>
  <?php include(ROOT_PATH . '/app/includes/messages.php'); ?>


  <!-- Page Wrapper -->

  <div class="page-wrapper">
    <!-- Post Slider -->

    <div class="post-slider">
      <h1 class="slider-title">Trending Posts</h1>
      <!-- <i class="fas fa-chevron-left prev"></i>
      <i class="fas fa-chevron-right next"></i> -->

      <div class="post-wrapper">

        <?php foreach ($posts as $post): ?>

          <div class="post">
            <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>"
              style="width: 100%; height: 200px; object-fit: cover;"
              class="slider-image" />
            <div class="post-info">
              <h4>
                <a href="single.php?id=<?php echo $post['id'] ?>"><?php echo $post['title']; ?></a>
              </h4>
              <i class="far fa-user"> <?php echo $post['username']; ?></i>
              &nbsp;
              <i class="far fa-calendar"> <?php echo date('F, j, Y', strtotime($post['created_at'])); ?></i>
            </div>
          </div>

        <?php endforeach; ?>

      </div>

      <!-- // Post Slider -->

      <!-- Content -->

      <div class="content clearfix">
        <!-- Main Content -->

        <div class="main-content">
          <h1 class="recent-post"><?php echo $postsTitle ?></h1>

          <?php foreach ($posts as $post): ?>

            <div class="post clearfix">
              <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" class="slider-image" />
              <div class="post-preview">
                <h3>
                  <a href="single.php?id=<?php echo $post['id'] ?>"><?php echo $post['title']; ?></a>
                </h3>
                <i class="far fa-user"> <?php echo $post['username']; ?></i>
                &nbsp;
                <i class="far fa-calendar"> <?php echo date('F, j, Y', strtotime($post['created_at'])); ?></i>
                <p class="preview-text">
                  <?php echo strip_tags(substr(html_entity_decode($post['body']), 0, 150)) . '...'; ?>
                </p>
                <a href="single.php?id=<?php echo $post['id'] ?>" class="btn read-more">Read More</a>
              </div>
            </div>

          <?php endforeach; ?>

        </div>
        <!-- / Main Content -->

        <div class="sidebar">
          <div class="section search">
            <h2 class="section-title">Search</h2>
            <form action="index.php" method="post">
              <input type="text" name="search-term" class="text-input" placeholder="Search..." />
            </form>
          </div>

          <div class="section topics">
            <h2 class="section-title">Topics</h2>
            <ul>

              <?php foreach ($topics as $key => $topic): ?>

                <li><a href="<?php echo BASE_URL . '/index.php?t_id=' . $topic['id'] . '&name' . $topic['name'] ?>"><?php echo $topic['name']; ?></a></li>

              <?php endforeach; ?>


            </ul>
          </div>
        </div>
      </div>
      <!-- // Content -->

    </div>
  </div>
  <!-- // Page Wrapper -->

  <!-- TODO: INCLUDE FOOTER HERE -->

  <?php include(ROOT_PATH . '/app/includes/footer.php'); ?>

  <?php if (isset($_GET['success'])): ?>
    <p style="color:green;">Message sent successfully ✅</p>
  <?php endif; ?>


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