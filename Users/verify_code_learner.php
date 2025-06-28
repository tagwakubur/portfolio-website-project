<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['code'])) {
        $enteredCode = trim($_POST['code']);
        echo "🔍 Entered Code: " . $enteredCode . "<br>";
        echo "🧠 Session Code: " . ($_SESSION['reset_code'] ?? 'NOT SET') . "<br>";

        if (isset($_SESSION['reset_code']) && $enteredCode == $_SESSION['reset_code']) {
            // ✅ Code is correct
            header("Location: reset_password_learner.html");
            exit();
        } else {
            echo "<p style='color:red;'>❌ Incorrect verification code.</p>";
        }
    } else {
        echo "<p style='color:orange;'>⚠️ No code submitted.</p>";
    }
} else {
    echo "<p style='color:orange;'>⚠️ Invalid request.</p>";
}
?>
