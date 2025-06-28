<?php
session_start();

// 1. Connect to the database
$conn = mysqli_connect("localhost", "root", "", "icook_db", 3307);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// 2. Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 3. Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 4. Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM learners WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // 5. Check if learner exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // 6. Verify password
        if (password_verify($password, $user['password'])) {
            // ✅ Login successful: Save session
            $_SESSION['learner_email'] = $user['email'];
            $_SESSION['learner_name'] = $user['name']; // ✅ Save learner name for the dashboard

            // ✅ Redirect to learner dashboard
            header("Location: learner_dashboard.php");
            exit();
        } else {
            echo "<script>alert('❌ Incorrect password!'); window.location.href='login_learner.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('❌ Learner not found!'); window.location.href='login_learner.html';</script>";
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
