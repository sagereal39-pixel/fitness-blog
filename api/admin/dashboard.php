<?php include("../path.php"); ?>
<?php
include(ROOT_PATH . "/app/controllers/posts.php");
adminOnly();

// Comment + like stats for dashboard
$totalComments = 0;
$totalCommentLikes = 0;
$engagementRows = [];

if (isset($db) && $db instanceof mysqli) {
  $commentsResult = $db->query("SELECT COUNT(*) AS total_comments FROM comments");
  if ($commentsResult) {
    $row = $commentsResult->fetch_assoc();
    $totalComments = (int) ($row['total_comments'] ?? 0);
  }

  $likesResult = $db->query("SELECT COUNT(*) AS total_likes FROM comment_likes");
  if ($likesResult) {
    $row = $likesResult->fetch_assoc();
    $totalCommentLikes = (int) ($row['total_likes'] ?? 0);
  }

  $engagementSql = "
        SELECT
            p.id,
            p.title,
            COUNT(DISTINCT c.id) AS comments_count,
            COUNT(cl.id) AS likes_count
        FROM posts p
        LEFT JOIN comments c ON p.id = c.post_id
        LEFT JOIN comment_likes cl ON c.id = cl.comment_id
        GROUP BY p.id, p.title
        ORDER BY comments_count DESC, likes_count DESC, p.id DESC
        LIMIT 10
    ";

  $engagementResult = $db->query($engagementSql);
  if ($engagementResult) {
    while ($row = $engagementResult->fetch_assoc()) {
      $engagementRows[] = $row;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script
    src="https://kit.fontawesome.com/716cf32068.js"
    crossorigin="anonymous"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Candal&family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Lora:ital,wght@0,400..700;1,400..700&display=swap"
    rel="stylesheet" />

  <title>Admin Section - Dashboard</title>

  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/admin.css" />

  <style>
    .dashboard-stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 18px;
      margin: 25px 0 35px;
    }

    .dashboard-stat-card {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      border-left: 5px solid #0ea5b7;
    }

    .dashboard-stat-card h3 {
      margin: 0 0 10px;
      font-size: 18px;
      color: #444;
    }

    .dashboard-stat-card .stat-number {
      font-size: 30px;
      font-weight: 700;
      color: #0ea5b7;
      margin: 0;
    }

    .dashboard-block {
      margin-top: 30px;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .dashboard-block h3 {
      margin-top: 0;
      margin-bottom: 18px;
      color: #444;
    }

    .engagement-table {
      width: 100%;
      border-collapse: collapse;
    }

    .engagement-table th,
    .engagement-table td {
      padding: 12px;
      border-bottom: 1px solid #e5e7eb;
      text-align: left;
      font-size: 14px;
    }

    .engagement-table th {
      background: #f8fafc;
      color: #333;
    }

    .engagement-empty {
      color: #777;
      margin: 0;
    }
  </style>
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

  <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>

  <div class="admin-wrapper">
    <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>

    <div class="admin-content">
      <div class="content">
        <h2 class="page-title">Dashboard</h2>

        <?php include(ROOT_PATH . '/app/includes/messages.php'); ?>
        <?php include(ROOT_PATH . '/app/includes/stats.php'); ?>

        <div class="dashboard-stats-grid">
          <div class="dashboard-stat-card">
            <h3>Total Comments</h3>
            <p class="stat-number"><?php echo $totalComments; ?></p>
          </div>

          <div class="dashboard-stat-card">
            <h3>Total Comment Likes</h3>
            <p class="stat-number"><?php echo $totalCommentLikes; ?></p>
          </div>
        </div>

        <div class="dashboard-block">
          <h3>Post Engagement</h3>

          <?php if (!empty($engagementRows)): ?>
            <table class="engagement-table">
              <thead>
                <tr>
                  <th>Post Title</th>
                  <th>Comments</th>
                  <th>Comment Likes</th>
                  <th>Manage Comments</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($engagementRows as $row): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo (int) $row['comments_count']; ?></td>
                    <td><?php echo (int) $row['likes_count']; ?></td>
                    <td>
                      <a href="<?php echo BASE_URL . '/admin/comments/index.php?post_id=' . $row['id']; ?>" class="edit">
                        View Comments
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php else: ?>
            <p class="engagement-empty">No comment engagement yet.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="../assets/js/scripts.js"></script>
<script
  src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js"
  crossorigin></script>
<script
  src="https://cdn.ckeditor.com/ckeditor5-premium-features/45.0.0/ckeditor5-premium-features.umd.js"
  crossorigin></script>
<script src="https://cdn.ckbox.io/ckbox/2.6.1/ckbox.js" crossorigin></script>
<script src="./main.js"></script>

</html>