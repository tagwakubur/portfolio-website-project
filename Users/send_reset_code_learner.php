<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

session_start();
$conn = mysqli_connect("localhost", "root", "", "icook_db", 3307);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Search in learners table (not chefs)
    $stmt = $conn->prepare("SELECT * FROM learners WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $code = rand(100000, 999999);  // 6-digit verification code
        $_SESSION['reset_code'] = $code;
        $_SESSION['reset_email'] = $email;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tagwaabdullkubur1999915@gmail.com'; // your Gmail
            $mail->Password = 'tgqhudmqcvtfqkvw'; // your app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tagwaabdullkubur1999915@gmail.com', 'iCook');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'iCook Password Reset Code';
            $mail->Body = "Your verification code is: <strong>$code</strong>";

            $mail->send();
            header("Location: verify_code_learner.html");
            exit();
        } catch (Exception $e) {
            echo "Email failed: " . $mail->ErrorInfo;
        }
    } else {
        echo "❌ Email not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
