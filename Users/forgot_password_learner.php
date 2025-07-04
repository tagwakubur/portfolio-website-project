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

    $stmt = $conn->prepare("SELECT * FROM learners WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $code = rand(100000, 999999);
        $_SESSION['reset_code'] = $code;
        $_SESSION['reset_email'] = $email;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tagwaabdullkubur1999915@gmail.com';
            $mail->Password = 'gqhudmqcvtfqkvw';  // Google App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tagwaabdullkubur1999915@gmail.com', 'iCook Support');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'iCook Password Reset Code';
            $mail->Body = "Your verification code is: <strong>$code</strong>";

            $mail->send();
            header("Location: verify_code_learner.html");
            exit();
        } catch (Exception $e) {
            $_SESSION['email_error'] = "❌ Email failed to send: {$mail->ErrorInfo}";
            header("Location: forgot_password_learner.html");
            exit();
        }
    } else {
        $_SESSION['email_error'] = "❌ Email not found in system.";
        header("Location: forgot_password_learner.html");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
