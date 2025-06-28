<?php
session_start();
// TEMPORARY: simulate a logged-in chef (replace 1 with your actual user ID)
$_SESSION['user_id'] = 1;
$_SESSION['user_role'] = 'chef';
include 'connect.php';

// ✅ Access control
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'chef') {
    die("Access denied.");
}

$chef_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $image_url = $_POST['image_url'];

    $sql = "INSERT INTO recipes (chef_id, title, description, ingredients, instructions, image_url)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $chef_id, $title, $description, $ingredients, $instructions, $image_url);

    if ($stmt->execute()) {
        header("Location: chef_recipes.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Recipe</title>
    <link rel="stylesheet" href="recipes_page_chef.css"> <!-- You can create or reuse this -->
</head>
<body>
    <h1>Add New Recipe</h1>

    <form action="create_recipe.php" method="POST" class="recipe-form">
        <label for="title">Recipe Title:</label><br>
        <input type="text" name="title" id="title" required><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" rows="3" required></textarea><br><br>

        <label for="ingredients">Ingredients:</label><br>
        <textarea name="ingredients" id="ingredients" rows="5" required></textarea><br><br>

        <label for="instructions">Instructions:</label><br>
        <textarea name="instructions" id="instructions" rows="5" required></textarea><br><br>

        <label for="image_url">Image URL (optional):</label><br>
        <input type="text" name="image_url" id="image_url"><br><br>

        <button type="submit">Submit Recipe</button>
        <a href="chef_recipes.php"><button type="button">Cancel</button></a>
    </form>
</body>
</html>
