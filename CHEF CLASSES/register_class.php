<?php
include('icook_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $learner_id = $_POST['learner_id'] ?? null;  // This should be the "id" from learners table
    $class_id = $_POST['class_id'] ?? null;

    // Basic validation
    if (!$learner_id || !$class_id) {
        die('Invalid request: missing learner or class ID.');
    }

    // Check if already registered
    $checkStmt = $pdo->prepare("
        SELECT * FROM registrations 
        WHERE learner_id = :learner_id AND class_id = :class_id
    ");
    $checkStmt->execute([
        'learner_id' => $learner_id,
        'class_id' => $class_id
    ]);

    if ($checkStmt->fetch()) {
        header("Location: learner_dashboard.php?status=already_registered");
        exit;
    }

    // ✅ Register learner using learner_id and class_id
    $insertStmt = $pdo->prepare("
        INSERT INTO registrations (learner_id, class_id) 
        VALUES (:learner_id, :class_id)
    ");
    $insertStmt->execute([
        'learner_id' => $learner_id,
        'class_id' => $class_id
    ]);

    header("Location: learner_dashboard.php?status=registered");
    exit;
} else {
    die('Invalid access: only POST allowed.');
}
