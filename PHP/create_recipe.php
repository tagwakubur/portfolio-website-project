<?php
session_start();
include '../includes/connect.php';

// Assume chef is logged in
$chef_id = $_SESSION['user_id']; // make sure auth sets this

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $image_url = $_POST['image_url'];

    $sql = "INSERT INTO recipes (chef_id, title, description, ingredients, instructions, image_url)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $chef_id, $title, $desc, $ingredients, $instructions, $image_url);

    if ($stmt->execute()) {
        echo "Recipe added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
