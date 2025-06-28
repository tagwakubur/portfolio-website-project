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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        echo "<p style='color:red;'>❌ Passwords do not match.</p>";
        exit();
    }

    if (!isset($_SESSION['reset_email'])) {
        echo "<p style='color:red;'>⚠️ Session expired. Please try again from the beginning.</p>";
        exit();
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $email = $_SESSION['reset_email'];

    $stmt = $conn->prepare("UPDATE learners SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashedPassword, $email);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>✅ Password updated successfully! You can <a href='login_learner.html'>login now</a>.</p>";

        // Send confirmation email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tagwaabdullkubur1999915@gmail.com';
            $mail->Password = 'tgqhudmqcvtfqkvw'; // your app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tagwaabdullkubur1999915@gmail.com', 'iCook Support');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "Password Reset Confirmation";
            // Fetch learner's name
$nameQuery = $conn->prepare("SELECT name FROM learners WHERE email = ?");
$nameQuery->bind_param("s", $email);
$nameQuery->execute();
$nameResult = $nameQuery->get_result();
$learnerName = "Learner";
if ($nameResult->num_rows === 1) {
    $row = $nameResult->fetch_assoc();
    $learnerName = $row['name'];
}
$nameQuery->close();

// Now send the email using the actual name
$mail->Body = "Hi Learner  {$learnerName},<br><br>Your password has been <strong>successfully reset</strong>.<br><br>You may now <a href='http://localhost/Cookzey-auth/login_learner.html'>log in</a> using your new credentials.<br><br>Thanks!";

           
            $mail->send();
        } catch (Exception $e) {
            // Optional: silently log error
        }

        unset($_SESSION['reset_code']);
        unset($_SESSION['reset_email']);
        header("Location: login_learner.html");
    } else {
        echo "<p style='color:red;'>❌ Failed to update password. Try again later.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
