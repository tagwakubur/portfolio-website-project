<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class_id'];
    $title = $_POST['title'];
    $message = $_POST['body']; // still using $_POST['body'] if the form hasn't changed

    $stmt = $pdo->prepare("INSERT INTO announcements (class_id, title, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$class_id, $title, $message]);

    header("Location: class_details.php?class_id=$class_id");
}
?>
