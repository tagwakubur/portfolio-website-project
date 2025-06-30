<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $class_id = $_POST['class_id'];

    $uploadDir = 'uploads/';
    $filePath = $uploadDir . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $stmt = $pdo->prepare("INSERT INTO assignments (class_id, file_name, file_path) VALUES (?, ?, ?)");
        $stmt->execute([$class_id, $file['name'], $filePath]);
        header("Location: class_details.php?class_id=$class_id");
    } else {
        echo "Upload failed.";
    }
}
?>
