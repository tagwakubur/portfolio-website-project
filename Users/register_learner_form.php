<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// 1. Connect to the new database
$conn = mysqli_connect("localhost", "root", "", "icook_db", 3307);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// 2. Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 3. Get values from form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // 4. Check if passwords match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
        exit();
    }

    // 5. Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 6. Insert into learners table
    $stmt = $conn->prepare("INSERT INTO learners (name, email, contact, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $contact, $hashedPassword);

    if ($stmt->execute()) {

        // 7. Send welcome email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            $mail->Username = 'tagwaabdullkubur1999915@gmail.com'; // Your Gmail
            $mail->Password = 'tgqhudmqcvtfqkvw'; // Your Gmail App Password

            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tagwaabdullkubur1999915@gmail.com', 'ICOOK Team');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Welcome to ICOOK!';
            $mail->Body = "Hi <b>$name</b>,<br><br>Thanks for signing up at <b>ICOOK</b>!<br>We’re thrilled to have you as a learner. 🎓<br><br>Happy exploring!";

            $mail->send();

            // ✅ Success message + Redirect
            echo "<script>alert('✅ Learner registered successfully! Welcome email sent!');</script>";
            header("Refresh:2; url=login_learner.html");
            exit();

        } catch (Exception $e) {
            echo " Email error: {$mail->ErrorInfo}";
        }
    } else {
        echo " Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
