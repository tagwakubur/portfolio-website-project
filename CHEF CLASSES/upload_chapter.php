<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['chapter_file'])) {
    $class_id = $_POST['class_id'];
    $file = $_FILES['chapter_file'];

    $uploadDir = 'chapters/';
    $filePath = $uploadDir . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $stmt = $pdo->prepare("INSERT INTO chapters (class_id, file_name, file_path) VALUES (?, ?, ?)");
        $stmt->execute([$class_id, $file['name'], $filePath]);
        header("Location: class_details.php?class_id=$class_id");
    } else {
        echo "Failed to upload chapter.";
    }
}
?>
