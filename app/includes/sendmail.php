<?php

require 'config.php';
require 'services/EmailService.php';

$emailService = new EmailService(SENDGRID_API_KEY);

$status = $emailService->sendWelcomeEmail(
  "auduchukwuma82@gmail.com",
  "Gregory"
);

echo "HTTP Status Code: " . $status;
