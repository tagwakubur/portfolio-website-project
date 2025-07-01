<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to save recipes.";
    exit;
}

include '../PHP/connect.php';

$learner_id = $_SESSION['user_id'];
$recipe_id = $_POST['recipe_id'] ?? null;

// Check if already saved
$check = mysqli_query($conn, "SELECT * FROM favorites 
    WHERE learner_id = '$learner_id' AND recipe_id = '$recipe_id'");
if (mysqli_num_rows($check) == 0) {
    mysqli_query($conn, "INSERT INTO favorites (learner_id, recipe_id) 
        VALUES ('$learner_id', '$recipe_id')");
}

header("Location: view_recipes.php");
exit;
?>
