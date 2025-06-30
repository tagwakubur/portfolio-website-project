<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $learner_id = $_POST['learner_id'] ?? null;
    $class_id = $_POST['class_id'] ?? null;

    // Basic validation
    if (!$learner_id || !$class_id) {
        die('Invalid request.');
    }

    // Check if already registered
    $checkStmt = $pdo->prepare("SELECT * FROM registrations WHERE learner_id = :learner_id AND class_id = :class_id");
    $checkStmt->execute([
        'learner_id' => $learner_id,
        'class_id' => $class_id
    ]);
    if ($checkStmt->fetch()) {
        // Already registered
        header("Location: learner_dashboard.php?status=already_registered");
        exit;
    }

    // Register learner
    $insertStmt = $pdo->prepare("INSERT INTO registrations (learner_id, class_id) VALUES (:learner_id, :class_id)");
    $insertStmt->execute([
        'learner_id' => $learner_id,
        'class_id' => $class_id
    ]);

    header("Location: learner_dashboard.php?status=registered");
    exit;
} else {
    die('Invalid access.');
}
