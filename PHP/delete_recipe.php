<?php
session_start();
include 'connect.php'; 

if (!isset($_GET['id'])) {
    die("No recipe selected.");
}

$recipe_id = $_GET['id'];



$stmt = $conn->prepare("DELETE FROM recipes WHERE id = ?");
$stmt->bind_param("i", $recipe_id);

if ($stmt->execute()) {
    echo "Recipe deleted successfully.";
} else {
    echo "Error deleting recipe: " . $stmt->error;
}
?>
