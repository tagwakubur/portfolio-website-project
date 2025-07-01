<?php
//session_start();
$_SESSION['learner_id'] = 1;
$_SESSION['learner_name'] = "Test Learner";

include('db.php');
/*if (!isset($_SESSION['learner_id'])) {
    header("Location: login_learner.html");
    exit();
}*/

$learner_id = $_SESSION['learner_id'];
$class_id = $_GET['class_id'] ?? null;
if (!$class_id) die("Class ID missing");

// Prevent duplicate registrations
$stmt = $pdo->prepare("SELECT COUNT(*) FROM registrations WHERE learner_id = ? AND class_id = ?");
$stmt->execute([$learner_id, $class_id]);
if ($stmt->fetchColumn() > 0) {
    echo "<script>alert('You already joined this class');window.location.href='my_classes.php';</script>";
    exit();
}

// Register
$stmt = $pdo->prepare("INSERT INTO registrations (learner_id, class_id, registered_at) VALUES (?, ?, NOW())");
$stmt->execute([$learner_id, $class_id]);
echo "<script>alert('Joined successfully!');window.location.href='my_classes.php';</script>";
?>
