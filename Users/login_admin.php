<?php
session_start();

// Simple hardcoded admin credentials
$admin_email = "admin@gmil.com";
$admin_password = "admin123";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === $admin_email && $password === $admin_password) {
        // Successful login
        $_SESSION['admin'] = $admin_email;
        header("Location: admin_dashboard.html");
        exit();
    } else {
        // Failed login
        echo "❌ Invalid admin credentials!";
    }
}
?>
