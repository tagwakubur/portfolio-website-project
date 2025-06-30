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

    $stmt = $conn->prepare("UPDATE chefs SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashedPassword, $email);

    if ($stmt->execute()) {
        // ✅ Password updated
        echo "<p style='color:green;'>✅ Password updated successfully! You can <a href='login_chef.html'>login now</a>.</p>";

        // ✅ Send confirmation email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tagwaabdullkubur1999915@gmail.com';           // your Gmail
            $mail->Password = 'tgqhudmqcvtfqkvw';         // your Google App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tagwaabdullkubur1999915@gmail.com', 'iCook Support');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "Password Reset Confirmation";
            // ✅ Get the chef's name
$nameQuery = $conn->prepare("SELECT name FROM chefs WHERE email = ?");
$nameQuery->bind_param("s", $email);
$nameQuery->execute();
$nameResult = $nameQuery->get_result();
$chefName = "Chef";
if ($nameResult->num_rows === 1) {
    $row = $nameResult->fetch_assoc();
    $chefName = $row['name'];
}
$nameQuery->close();

// ✅ Send confirmation email with name
$mail->Body = "
    <div style='font-family: Arial, sans-serif; padding: 20px;'>
        <h2 style='color: #191970;'>Hello {$chefName},</h2>
        <p>We’re happy to inform you that your password has been <strong>successfully reset</strong>.</p>
        <p>You can now securely log in to your account </p>
        
            
        <br>
        <p>If you did not request this change, please contact our support team immediately.</p>
        <br>
        <p>Thank you,<br>The iCook Support Team</p>
    </div>
";
    

            $mail->send();
        } catch (Exception $e) {
            // Optional: log error silently
            // echo "Mailer Error: " . $mail->ErrorInfo;
        }

        unset($_SESSION['reset_code']);
        unset($_SESSION['reset_email']);
        header("Location: login_chef.html");
exit();

    } else {
        echo "<p style='color:red;'>❌ Failed to update password. Try again later.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
