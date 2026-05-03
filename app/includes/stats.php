<?php
// === FETCH STATS ===

// Total Users
$sqlUsers = "SELECT COUNT(*) AS total_users FROM users";
$totalUsers = $conn->query($sqlUsers)->fetch_assoc()['total_users'];

// Total Posts
$sqlPosts = "SELECT COUNT(*) AS total_posts FROM posts";
$totalPosts = $conn->query($sqlPosts)->fetch_assoc()['total_posts'];

// Published Posts
$sqlPublished = "SELECT COUNT(*) AS published_posts FROM posts WHERE published = 1";
$publishedPosts = $conn->query($sqlPublished)->fetch_assoc()['published_posts'];

// Drafts/Unpublished Posts
$sqlDrafts = "SELECT COUNT(*) AS drafts FROM posts WHERE published = 0";
$drafts = $conn->query($sqlDrafts)->fetch_assoc()['drafts'];

// Total Views
$sqlViews = "SELECT SUM(views) AS total_views FROM posts";
$totalViews = $conn->query($sqlViews)->fetch_assoc()['total_views'];
if (!$totalViews) $totalViews = 0;

// Latest Users
$sqlRecentUsers = "SELECT username, created_at FROM users ORDER BY created_at DESC LIMIT 5";
$recentUsers = $conn->query($sqlRecentUsers);

// Latest Posts
$sqlRecentPosts = "SELECT title, created_at FROM posts ORDER BY created_at DESC LIMIT 5";
$recentPosts = $conn->query($sqlRecentPosts);
?>


<style>
  body {
    font-family: Arial, sans-serif, cursive;
    background: #f4f6f9;
    margin: 0;
    padding: 0;
  }

  .container {
    width: 90%;
    margin: 30px auto;
  }

  h1 {
    text-align: center;
    margin-bottom: 20px;
  }

  .cards {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
  }

  .card {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    flex: 1;
    min-width: 200px;
  }

  .card h2 {
    margin: 0 0 10px;
    font-size: 18px;
    color: #333;
  }

  .card p {
    font-size: 24px;
    font-weight: bold;
    color: #007BFF;
  }

  table {
    width: 100%;
    margin-top: 40px;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }

  th,
  td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
  }

  th {
    background: #007BFF;
    color: #fff;
  }

  tr:nth-child(even) {
    background: #f9f9f9;
  }

  .activity {
    margin-top: 40px;
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
  }

  .activity-box {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    flex: 1;
    min-width: 300px;
  }

  .activity-box h3 {
    margin-top: 0;
    color: #333;
  }

  .activity-box ul {
    list-style: none;
    padding: 0;
  }

  .activity-box li {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
  }

  .activity-box li:last-child {
    border-bottom: none;
  }
</style>

<div class="cards">
  <div class="card">
    <h2>Total Users</h2>
    <p><?php echo $totalUsers; ?></p>
  </div>
  <div class="card">
    <h2>Total Posts</h2>
    <p><?php echo $totalPosts; ?></p>
  </div>
  <div class="card">
    <h2>Published Posts</h2>
    <p><?php echo $publishedPosts; ?></p>
  </div>
  <div class="card">
    <h2>Drafts</h2>
    <p><?php echo $drafts; ?></p>
  </div>
  <div class="card">
    <h2>Total Views</h2>
    <p><?php echo $totalViews; ?></p>
  </div>
</div>

<table>
  <tr>
    <th>Stat</th>
    <th>Count</th>
  </tr>
  <tr>
    <td>Total Users</td>
    <td><?php echo $totalUsers; ?></td>
  </tr>
  <tr>
    <td>Total Posts</td>
    <td><?php echo $totalPosts; ?></td>
  </tr>
  <tr>
    <td>Published Posts</td>
    <td><?php echo $publishedPosts; ?></td>
  </tr>
  <tr>
    <td>Drafts</td>
    <td><?php echo $drafts; ?></td>
  </tr>
  <tr>
    <td>Total Views</td>
    <td><?php echo $totalViews; ?></td>
  </tr>
</table>

<div class="activity">
  <div class="activity-box">
    <h3>Latest Users</h3>
    <ul>
      <?php while ($user = $recentUsers->fetch_assoc()): ?>
        <li><?php echo htmlspecialchars($user['username']); ?> - <small><?php echo $user['created_at']; ?></small></li>
      <?php endwhile; ?>
    </ul>
  </div>
  <div class="activity-box">
    <h3>Latest Posts</h3>
    <ul>
      <?php while ($post = $recentPosts->fetch_assoc()): ?>
        <li><?php echo htmlspecialchars($post['title']); ?> - <small><?php echo $post['created_at']; ?></small></li>
      <?php endwhile; ?>
    </ul>
  </div>
</div>