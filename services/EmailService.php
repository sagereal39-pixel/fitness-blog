<?php

// Grab path.php first to get the ROOT_PATH constant
require_once dirname(__DIR__) . '/api/path.php';

// Use ROOT_PATH for absolute accuracy on Vercel
require_once(ROOT_PATH . '/app/includes/phpmailer/src/Exception.php');
require_once(ROOT_PATH . '/app/includes/phpmailer/src/PHPMailer.php');
require_once(ROOT_PATH . '/app/includes/phpmailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    /**
     * Helper method to centralize SMTP configuration
     */
    private function setupPHPMailer()
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        // getenv() reads the variables from Vercel's settings once deployed
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('EMAIL_USER') ?: 'sagereal39@gmail.com';
        $mail->Password = getenv('EMAIL_PASS');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->setFrom(getenv('EMAIL_USER') ?: 'sagereal39@gmail.com', 'Fitness & Health');
        return $mail;
    }

    public function sendContactMessage($userEmail, $username, $subject, $message)
    {
        $mail = $this->setupPHPMailer();
        try {
            $mail->addAddress('auduchukwuma82@gmail.com');
            $mail->addReplyTo($userEmail, $username);
            $mail->isHTML(true);
            $mail->Subject = "New Contact: $subject";

            $mail->Body = "
            <div style='background-color: #eceff1; padding: 50px 20px; font-family: sans-serif;'>
                <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);'>
                    <tr>
                        <td style='background-color: #1a202c; padding: 12px 30px; text-align: left;'>
                            <span style='color: #00ff88; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px;'>Priority: User Inquiry</span>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 40px;'>
                            <h1 style='color: #1a202c; margin: 0; font-size: 28px; font-weight: 800;'>Fitness & Health</h1>
                            <p style='color: #718096; font-size: 16px;'>New submission from your contact form.</p>
                            <div style='background-color: #f7fafc; border: 1px solid #edf2f7; border-radius: 8px; padding: 25px; margin-top: 20px;'>
                                <p><strong>From:</strong> $username</p>
                                <p><strong>Email:</strong> $userEmail</p>
                                <hr style='border: none; border-top: 1px solid #eee; margin: 15px 0;'>
                                <p style='line-height: 1.8;'>$message</p>
                            </div>
                            <div style='margin-top: 30px; text-align: center;'>
                                <a href='mailto:$userEmail' style='display: inline-block; background-color: #2d3748; color: #ffffff; padding: 14px 30px; border-radius: 6px; text-decoration: none; font-weight: 700;'>Reply to Sender</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>";

            $mail->send();
            return 202;
        } catch (Exception $e) {
            return 500;
        }
    }

    public function sendRegistrationEmail($toEmail, $username)
    {
        $mail = $this->setupPHPMailer();
        try {
            $mail->addAddress($toEmail, $username);
            $mail->isHTML(true);
            $mail->Subject = "Welcome to Fitness & Health, $username! 🚀";

            $mail->Body = "
            <div style='background-color: #f7fafc; padding: 50px 20px; font-family: sans-serif;'>
                <table align='center' width='100%' style='max-width: 600px; background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #edf2f7;'>
                    <tr>
                        <td style='background: #1a202c; padding: 40px; text-align: center;'>
                            <h1 style='color: #00ff88; margin: 0; font-size: 28px;'>Welcome Aboard!</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 40px;'>
                            <p style='font-size: 18px; color: #2d3748;'>Hi <strong>$username</strong>,</p>
                            <p style='font-size: 16px; color: #4a5568; line-height: 1.6;'>Thanks for joining the Fitness & Health community. Your account is now active.</p>
                            <div style='margin-top: 30px; text-align: center;'>
                                <a href='https://your-domain.com/login' style='background: #2d3748; color: #ffffff; padding: 14px 30px; border-radius: 6px; text-decoration: none; font-weight: bold;'>Access Your Dashboard</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>";

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }

    public function sendPasswordReset($toEmail, $resetToken)
    {
        $mail = $this->setupPHPMailer();
        try {
            $mail->addAddress($toEmail);
            $mail->isHTML(true);
            $mail->Subject = "Reset Your Password - Fitness & Health";

            // When you deploy, replace localhost with your real domain
            $resetLink = "http://localhost/blog/reset_password.php?token=" . $resetToken;

            $mail->Body = "
        <div style='background-color: #f7fafc; padding: 50px 20px; font-family: sans-serif;'>
            <table align='center' width='100%' style='max-width: 600px; background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #edf2f7; box-shadow: 0 10px 25px rgba(0,0,0,0.05);'>
                <tr>
                    <td style='padding: 40px; text-align: center;'>
                        <h2 style='color: #1a202c; margin-top: 0;'>Verification Code</h2>
                        <p style='color: #4a5568; line-height: 1.6;'>Use the 6-digit code below to reset your Fitness & Health password. This code will expire in 15 minutes.</p>
                        
                        <div style='margin: 30px 0; background-color: #f1f5f9; border-radius: 8px; padding: 20px;'>
                            <span style='font-size: 36px; font-weight: 800; letter-spacing: 10px; color: #2d3748;'>$resetToken</span>
                        </div>

                        <p style='color: #a0aec0; font-size: 13px;'>If you did not request this code, you can safely ignore this email.</p>
                    </td>
                </tr>
            </table>
        </div>";

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }
}
