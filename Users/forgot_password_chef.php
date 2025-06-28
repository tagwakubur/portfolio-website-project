<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

session_start();
$conn = mysqli_connect("localhost", "root", "", "icook_db", 3307);
if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Check if email exists in chefs table
    $stmt = $conn->prepare("SELECT * FROM chefs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Generate 6-digit code
        $code = rand(100000, 999999);
        $_SESSION['reset_code'] = $code;
        $_SESSION['reset_email'] = $email;

        // Send code to email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tagwaabdullkubur1999915@gmail.com'; // Your Gmail address
            $mail->Password = 'gqhudmqcvtfqkvw'; // Your Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tagwaabdullkubur1999915@gmail.com', 'iCook Support');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'iCook Password Reset Code';
            $mail->Body = "Your verification code is: <strong>$code</strong>";

            $mail->send();
            // ✅ Redirect AFTER setting session values, with no output before it
            header("Location: verify_code_chef.html");
            exit();
        } catch (Exception $e) {
            $_SESSION['email_error'] = "❌ Email failed to send: {$mail->ErrorInfo}";
            header("Location: forgot_password_chef.php"); // Redirect back to form
            exit();
        }
    } else {
        $_SESSION['email_error'] = "❌ Email not found in system.";
        header("Location: forgot_password_chef.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
