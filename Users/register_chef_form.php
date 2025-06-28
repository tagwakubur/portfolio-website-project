<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// 1. Connect to the database
$conn = mysqli_connect("localhost", "root", "", "icook_db", 3307);
if (!$conn) {
    die(" Database connection failed: " . mysqli_connect_error());
}

// 2. Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 3. Get values from form fields
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $experience = $_POST['experience'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // 4. Check if passwords match
    if ($password !== $confirmPassword) {
        echo " Passwords do not match!";
        exit();
    }

    // 5. Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 6. Prepare the INSERT query
    $stmt = $conn->prepare("INSERT INTO chefs (name, email, contact, experience, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $name, $email, $contact, $experience, $hashedPassword);

    // 7. Execute the query
    if ($stmt->execute()) {
        // 8. Send welcome email
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            // Replace with your Gmail + App Password
            $mail->Username = 'tagwaabdullkubur1999915@gmail.com';
            $mail->Password = 'tgqhudmqcvtfqkvw';

            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tagwaabdullkubur1999915@gmail.com', 'iCook Team');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Welcome to iCook!';
            $mail->Body = "Hi <b>$name</b>,<br><br>Thank you for joining <b>Cookzey</b>!<br>We’re excited to have you as a chef.<br><br>Happy cooking! 👨‍🍳";

            $mail->send();

            // ✅ Success message + Redirect
            echo "<script>alert('✅ Chef registered successfully! Welcome email sent!');</script>";
            header("Refresh:2; url=login_chef.html");
            exit();

        } catch (Exception $e) {
            echo " Email error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // 9. Close connection
    $stmt->close();
    $conn->close();
}
?>
