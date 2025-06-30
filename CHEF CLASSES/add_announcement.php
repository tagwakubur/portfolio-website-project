<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class_id'];
    $title = $_POST['title'];
    $body = $_POST['body'];

    $stmt = $pdo->prepare("INSERT INTO announcements (class_id, title, body, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$class_id, $title, $body]);

    header("Location: class_details.php?class_id=$class_id");
}
?>
