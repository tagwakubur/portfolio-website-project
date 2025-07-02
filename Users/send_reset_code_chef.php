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

    $stmt = $conn->prepare("SELECT * FROM chefs WHERE email = ?");
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
            $mail->Username = 'tagwaabdullkubur1999915@gmail.com'; // use your app password
            $mail->Password = 'tgqhudmqcvtfqkvw';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tagwaabdullkubur1999915@gmail.com', 'iCook');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->AddEmbeddedImage('UsersImgs/chefimg.jpg', 'chefimg');

            $mail->Subject = 'iCook Password Reset Code';
 $mail->Body = "
    <div style='font-family: Arial, sans-serif; padding: 20px; text-align: center;'>
        <img src='cid:chefimg' alt='Chef Image' width='80' style='margin-bottom: 20px;'>
        <h2 style='color: #00008B;'>Hello from iCook!</h2>
        <p>We received a request to reset your password for your iCook Chef account.</p>
        <p>Please use the verification code below to proceed with resetting your password:</p>

        <div style='font-size: 24px; font-weight: bold; background-color: #191970; color: white; display: inline-block; padding: 15px 30px; border-radius: 8px; margin: 20px 0;'>
            {$code}
        </div>

        <p>If you did not request a password reset, please ignore this email. Your account is still secure.</p>
        <br>
        <p>Thank you,<br>The iCook Support Team</p>
    </div>
";





            $mail->send();
            header("Location: verify_code_chef.html");
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
