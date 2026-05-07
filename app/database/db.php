<?php

// This ensures PHP looks in the same directory as db.php for connect.php
if (!function_exists('dd')) {
  function dd($value)
  {
    echo "<pre>", print_r($value, true), "</pre>";
    die();
  }
}

if (!function_exists('executeQuery')) {
  function executeQuery($sql, $data)
  {
    global $db;
    $stmt = $db->prepare($sql);
    $values = array_values($data);
    $types = str_repeat('s', count($values));
    $stmt->bind_param($types, ...$values);
    $stmt->execute();
    return $stmt;
  }
}

if (!function_exists('selectAll')) {
  function selectALL($table, $conditions = [])
  {
    global $db;
    if (!$db) {
      require_once __DIR__ . '/connect.php';
    }
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      return $records;
    } else {
      $i = 0;
      foreach ($conditions as $key => $value) {
        if ($i === 0) {
          $sql = $sql . " WHERE $key=?";
        } else {
          $sql = $sql . " AND $key=?";
        }
        $i++;
      }
      $stmt = executeQuery($sql, $conditions);
      $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      return $records;
    }
  }
}

if (!function_exists('selectOne')) {
  function selectOne($table, $conditions)
  {
    global $db;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
      if ($i === 0) {
        $sql = $sql . " WHERE $key=?";
      } else {
        $sql = $sql . " AND $key=?";
      }
      $i++;
    }

    $sql = $sql . " LIMIT 1";

    $stmt = executeQuery($sql, $conditions);
    $records = $stmt->get_result()->fetch_assoc();
    return $records;
  }
}

if (!function_exists('create')) {
  function create($table, $data)
  {
    // $sql = "INSERT INTO users SET username=?, admin=?, email=?, password=?"
    $sql = "INSERT INTO $table SET ";

    $i = 0;
    foreach ($data as $key => $value) {
      if ($i === 0) {
        $sql = $sql . " $key=?";
      } else {
        $sql = $sql . ", $key=?";
      }
      $i++;
    }
    $stmt = executeQuery($sql, $data);
    $id = $stmt->insert_id;
    return $id;
  }
}

if (!function_exists('update')) {
  function update($table, $id, $data)
  {
    // $sql = "UPDATE INTO users SET username=?, admin=?, email=?, password=? WHERE id=?"
    $sql = "UPDATE $table SET ";

    $i = 0;
    foreach ($data as $key => $value) {
      if ($i === 0) {
        $sql = $sql . " $key=?";
      } else {
        $sql = $sql . ", $key=?";
      }
      $i++;
    }

    $sql = $sql . " WHERE id=?";
    $data['id'] = $id;
    $stmt = executeQuery($sql, $data);
    return $stmt->affected_rows;
  }
}

if (!function_exists('delete')) {
  function delete($table, $id)
  {
    // $sql = "DELETE FROM users WHERE id=?"
    $sql = "DELETE FROM $table WHERE id=?";

    $stmt = executeQuery($sql, ['id' => $id]);
    return $stmt->affected_rows;
  }
}

if (!function_exists('getPublishedPosts')) {
  function getPublishedPosts()
  {
    // Added 'ORDER BY created_at DESC' to put newest posts at the top
    $sql = "SELECT p.*, u.username FROM posts AS p 
            JOIN users AS u ON p.user_id=u.id 
            WHERE p.published=? 
            ORDER BY p.created_at DESC";

    $stmt = executeQuery($sql, ['published' => 1]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
  }
}

if (!function_exists('getPostsByTopicId')) {
  function getPostsByTopicId($topic_id)
  {
    $sql = 'SELECT p.*, u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=? AND topic_id=?';
    $stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
  }
}

if (!function_exists('searchPosts')) {
  function searchPosts($term)
  {
    $match = '%' . $term . '%';
    $sql = 'SELECT 
        p.*, u.username 
        FROM posts AS p 
        JOIN users AS u 
        ON p.user_id=u.id
        WHERE p.published=?
        AND p.title LIKE ? OR p.body LIKE ?';

    $stmt = executeQuery($sql, ['published' => 1, 'title' => $match, 'body' => $match]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
  }
}

if (!function_exists('getAllTopics')) {
  function getAllTopics()
  {
    global $db;
    $sql = "SELECT * FROM topics";
    $result = $db->query($sql);
    $topics = array();

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $topics[] = $row;
      }
    }

    return $topics;
  }
}
// ...existing code...
