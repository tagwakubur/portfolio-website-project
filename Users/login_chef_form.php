<?php
session_start();

// Connect to the icook db database
$conn = mysqli_connect("localhost", "root", "", "icook_db", 3307);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Fetch chef by email
    $stmt = $conn->prepare("SELECT * FROM chefs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if chef exists
    if ($result->num_rows === 1) {
        $chef = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $chef['password'])) {
            $_SESSION['name'] = $chef['name'];

            // ✅ Set session after successful login
            $_SESSION['email'] = $chef['email'];
            $_SESSION['chef_id'] = $chef['id'];

            // ✅ Redirect to dashboard
            header("Location: chef_dashboard.php");
            exit();
        } else {
            // ❌ Password is wrong
            header("Location: login_chef_form.php?error=Invalid Password");
            exit();
        }
    } else {
        // ❌ Email not found
        header("Location: login_chef_form.php?error=Email not found");
        exit();
    }
}
?>
