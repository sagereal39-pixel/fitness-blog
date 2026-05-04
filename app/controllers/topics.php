<?php

include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/validateTopics.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/includes/session.php");


$table = 'topics';

$errors = array();
$id = '';
$name = '';
$description = '';

$topics = selectALL($table);


if (isset($_POST['add-topic'])) {
  adminOnly();
  $errors = validateTopic($_POST);


  if (count($errors) === 0) {
    unset($_POST['add-topic']);
    $topic_id = create($table, $_POST);
    $_SESSION['message'] = 'Topic creation successful';
    $_SESSION['type'] = 'success';
    header('location: ' . BASE_URL . '/admin/topics/index.php');
    exit();
  } else {
    $name = $_POST['name'];
    $description = $_POST['description'];
  }
}


if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $topic = selectOne($table, ['id' => $id]);
  $id = $topic['id'];
  $name = $topic['name'];
  $description = $topic['description'];
}

if (isset($_GET['del_id'])) {
  adminOnly();
  $id = $_GET['del_id'];
  $count = delete($table, $id);
  $_SESSION['message'] = 'Topic deletion successful';
  $_SESSION['type'] = 'success';
  header('location: ' . BASE_URL . '/admin/topics/index.php');
  exit();
}

if (isset($_POST['update-topic'])) {
  adminOnly();
  $errors = validateTopic($_POST);


  if (count($errors) === 0) {
    $id = $_POST['id'];
    unset($_POST['update-topic'], $_POST['id']);
    $topic_id = update($table, $id, $_POST);
    $_SESSION['message'] = 'Topic update successful';
    $_SESSION['type'] = 'success';
    header('location: ' . BASE_URL . '/admin/topics/index.php');
    exit();
  } else {
    $name = $_POST['name'];
    $id = $_POST['id'];
    $description = $_POST['description'];
  }
}

function getTopicById($id)
{
  global $db;
  $sql = 'SELECT * FROM topics WHERE id = ?';
  $stmt = $db->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();

  $result = $stmt->get_result();
  return $result->fetch_assoc();
}
