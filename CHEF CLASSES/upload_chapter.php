<?php
include('icook_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['chapter_file']) && isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
    $file = $_FILES['chapter_file'];

    // Define target upload directory
    $uploadDir = 'chapters/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Create directory if not exists
    }

    // Sanitize the file name
    $fileName = basename($file['name']);
    $filePath = $uploadDir . $fileName;

    // Move uploaded file and insert into database
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $stmt = $pdo->prepare("INSERT INTO chapters (class_id, file_name, file_path) VALUES (:class_id, :file_name, :file_path)");
        $stmt->execute([
            'class_id' => $class_id,
            'file_name' => $fileName,
            'file_path' => $filePath
        ]);

        header("Location: class_details.php?class_id=$class_id");
        exit;
    } else {
        echo "❌ Failed to upload chapter. Please try again.";
    }
} else {
    echo "⚠️ Invalid request. Missing file or class ID.";
}
?>
