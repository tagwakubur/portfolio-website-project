<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view this page.";
    exit;
}

include '../PHP/connect.php';

$chef_id = $_SESSION['user_id'];
$recipe_id = $_GET['id'] ?? null;

// Delete recipe only if it belongs to this chef
$query = "DELETE FROM recipes WHERE id = '$recipe_id' AND chef_id = '$chef_id'";
mysqli_query($conn, $query);

header("Location: my_recipes.php");
exit;
?>
