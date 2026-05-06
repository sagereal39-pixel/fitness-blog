<?php
require_once(ROOT_PATH . "/app/database/db.php");

$table = 'comments';

// Fetch comments for a post
function getCommentsByPostId($post_id)
{
  global $db;

  $sql = "SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("i", $post_id);
  $stmt->execute();

  $result = $stmt->get_result();
  return $result->fetch_all(MYSQLI_ASSOC);
}

// Add comment
if (isset($_POST['add-comment'])) {
  global $db;

  if (!isset($_SESSION['id'])) {
    $_SESSION['error'] = "Please login to comment.";
    header("Location: " . BASE_URL . "/login.php");
    exit();
  }

  $post_id = $_POST['post_id'];
  $comment = trim($_POST['comment']);
  $username = $_SESSION['username'];
  $user_id = $_SESSION['id'];

  if (empty($comment)) {
    $_SESSION['error'] = "Comment cannot be empty.";
    header("Location: " . BASE_URL . "/single.php?id=" . $post_id);
    exit();
  }

  $sql = "INSERT INTO comments (post_id, user_id, username, comment) VALUES (?, ?, ?, ?)";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("iiss", $post_id, $user_id, $username, $comment);

  if ($stmt->execute()) {
    $_SESSION['success'] = "Comment added successfully.";
  } else {
    $_SESSION['error'] = "Failed to add comment.";
  }

  header("Location: " . BASE_URL . "/single.php?id=" . $post_id);
  exit();
}

// Count likes for a comment
function getCommentLikesCount($comment_id)
{
  global $db;

  $sql = "SELECT COUNT(*) AS total_likes FROM comment_likes WHERE comment_id = ?";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("i", $comment_id);
  $stmt->execute();

  $result = $stmt->get_result()->fetch_assoc();
  return $result['total_likes'];
}

// Check if logged-in user already liked the comment
function userLikedComment($comment_id, $user_id)
{
  global $db;

  $sql = "SELECT id FROM comment_likes WHERE comment_id = ? AND user_id = ? LIMIT 1";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("ii", $comment_id, $user_id);
  $stmt->execute();

  $result = $stmt->get_result();
  return $result->num_rows > 0;
}

// Login to like comments
if (isset($_POST['like-comment'])) {
  global $db;

  if (!isset($_SESSION['id'])) {
    $_SESSION['error'] = "Please login to like comments.";
    header("Location: " . BASE_URL . "/login.php");
    exit();
  }

  $comment_id = (int) $_POST['comment_id'];
  $post_id = (int) $_POST['post_id'];
  $user_id = (int) $_SESSION['id'];

  if (!userLikedComment($comment_id, $user_id)) {
    $sql = "INSERT INTO comment_likes (comment_id, user_id) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $comment_id, $user_id);
    $stmt->execute();
  }

  header("Location: " . BASE_URL . "/single.php?id=" . $post_id);
  exit();
}


// Count total comments for a post
function getPostCommentsCount($post_id)
{
  global $db;

  $sql = "SELECT COUNT(*) AS total_comments FROM comments WHERE post_id = ?";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("i", $post_id);
  $stmt->execute();

  $result = $stmt->get_result()->fetch_assoc();
  return $result['total_comments'];
}

// Count total likes for all comments under a post
function getPostCommentLikesCount($post_id)
{
  global $db;

  $sql = "
        SELECT COUNT(comment_likes.id) AS total_likes
        FROM comments
        LEFT JOIN comment_likes ON comments.id = comment_likes.comment_id
        WHERE comments.post_id = ?
    ";

  $stmt = $db->prepare($sql);
  $stmt->bind_param("i", $post_id);
  $stmt->execute();

  $result = $stmt->get_result()->fetch_assoc();
  return $result['total_likes'];
}


// Delete comment and its likes
if (isset($_GET['delete_comment_id'])) {
  global $db;

  adminOnly();

  $comment_id = (int) $_GET['delete_comment_id'];
  $post_id = (int) $_GET['post_id'];

  // delete likes first
  $sql = "DELETE FROM comment_likes WHERE comment_id = ?";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("i", $comment_id);
  $stmt->execute();

  // delete comment
  $sql = "DELETE FROM comments WHERE id = ?";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("i", $comment_id);

  if ($stmt->execute()) {
    $_SESSION['success'] = "Comment deleted successfully.";
  } else {
    $_SESSION['error'] = "Failed to delete comment.";
  }

  header("Location: " . BASE_URL . "/admin/comments/index.php?post_id=" . $post_id);
  exit();
}
