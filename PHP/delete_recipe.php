<?php
session_start();
include 'connect.php';

// ✅ Only logged-in chefs can delete
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'chef') {
    die("Access denied.");
}

$chef_id = $_SESSION['user_id'];

// ✅ Check recipe ID is provided
if (!isset($_GET['id'])) {
    die("No recipe ID specified.");
}

$recipe_id = $_GET['id'];

// ✅ Verify ownership before deleting
$stmt = $conn->prepare("SELECT chef_id FROM recipes WHERE id = ?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();
$recipe = $result->fetch_assoc();

if (!$recipe || $recipe['chef_id'] != $chef_id) {
    die("Unauthorized access.");
}

// ✅ Delete recipe
$deleteStmt = $conn->prepare("DELETE FROM recipes WHERE id = ?");
$deleteStmt->bind_param("i", $recipe_id);

if ($deleteStmt->execute()) {
    header("Location: chef_recipes.php");
    exit;
} else {
    echo "Error deleting recipe: " . $deleteStmt->error;
}
?>
