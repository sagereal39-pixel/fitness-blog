<?php
// app/includes/contact_process.php[cite: 4]
session_start();
require_once __DIR__ . '/../../services/EmailService.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Update line 7-10 in app/includes/contact_process.php
  $subject  = isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : "General Inquiry";
  $message  = isset($_POST['message']) ? nl2br(htmlspecialchars($_POST['message'])) : "";
  $userEmail = isset($_POST['email']) ? $_POST['email'] : "";
  $username  = isset($_POST['name']) ? $_POST['name'] : "Guest User";

  // No need for an API key in the constructor anymore
  $emailService = new EmailService();
  $status = $emailService->sendContactMessage($userEmail, $username, $subject, $message);

  if ($status == 202) {
    $_SESSION['success'] = "Message sent successfully ✅";
  } else {
    $_SESSION['error'] = "Failed to send message ❌";
  }

  header("Location: ../../index.php");
  exit();
}
