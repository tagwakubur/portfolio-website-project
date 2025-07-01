<?php
include('icook_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']) && isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
    $file = $_FILES['file'];

    // Set upload directory
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Create the directory if not exists
    }

    // Sanitize file name to prevent path traversal
    $fileName = basename($file['name']);
    $filePath = $uploadDir . $fileName;

    // Move file and insert into DB
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $stmt = $pdo->prepare("INSERT INTO assignments (class_id, file_name, file_path) VALUES (:class_id, :file_name, :file_path)");
        $stmt->execute([
            'class_id' => $class_id,
            'file_name' => $fileName,
            'file_path' => $filePath
        ]);

        header("Location: class_details.php?class_id=$class_id");
        exit;
    } else {
        echo "❌ File upload failed. Please try again.";
    }
} else {
    echo "⚠️ Invalid request. Please make sure you selected a file.";
}
?>
