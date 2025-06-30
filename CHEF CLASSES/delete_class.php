<?php
include('db.php');

if (isset($_GET['class_id'])) {
    $delete = $pdo->prepare("DELETE FROM classes WHERE class_id = :class_id");
    $delete->execute(['class_id' => $_GET['class_id']]);
}

header("Location: class_chef.php");
exit;
