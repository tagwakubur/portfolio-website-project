<?php
include('icook_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class_id'];
    $quiz_title = $_POST['quiz_title'];

    $questions = [];
    for ($i = 1; $i <= 5; $i++) {
        $questions[] = $_POST["q$i"] ?? '';
    }

    $stmt = $pdo->prepare("INSERT INTO quizzes (class_id, quiz_title, q1, q2, q3, q4, q5) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$class_id, $quiz_title, ...$questions]);

    header("Location: class_details.php?class_id=$class_id");
}
?>
