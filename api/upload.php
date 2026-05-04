<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload'])) {
  $file = $_FILES['upload'];
  $filename = time() . '_' . basename($file['name']);
  $targetDir = 'uploads/';
  $targetFile = $targetDir . $filename;

  // Allow only image files
  $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
  $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

  if (!in_array($ext, $allowed)) {
    http_response_code(403);
    echo json_encode(['error' => ['message' => 'Invalid file type']]);
    exit;
  }

  // Ensure upload directory exists
  if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
  }

  if (move_uploaded_file($file['tmp_name'], $targetFile)) {
    // Return JSON with the image URL (required by CKEditor)
    echo json_encode([
      'url' => '/blog/' . $targetFile // adjust path if needed
    ]);
  } else {
    http_response_code(500);
    echo json_encode(['error' => ['message' => 'Upload failed']]);
  }
} else {
  http_response_code(400);
  echo json_encode(['error' => ['message' => 'No file uploaded']]);
}
