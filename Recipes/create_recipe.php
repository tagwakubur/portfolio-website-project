<?php
session_start();
$_SESSION['user_id'] = 1;
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view this page.";
    exit;
}

include '../PHP/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $chef_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $steps = mysqli_real_escape_string($conn, $_POST['steps']);

    $query = "INSERT INTO recipes (chef_id, title, ingredients, description, created_at) 
              VALUES ('$chef_id', '$title', '$ingredients', '$steps', NOW())";

    if (mysqli_query($conn, $query)) {
        header("Location: my_recipes.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Recipe</title>
    	<link rel="stylesheet" href="../CSS/add_recipe.css">

</head>
<body>
    <header>
        <h1>Add New Recipe</h1>
        <a class="back-btn" href="my_recipes.php">← Back to My Recipes</a>
    </header>

    <main class="add-recipe-main">
        <form class="add-recipe-form" method="POST" action="">
            <div class="form-group">
                <label for="title">Recipe Title</label>
                <input type="text" name="title" id="title" required>
            </div>

            <div class="form-group">
                <label for="ingredients">Ingredients</label>
                <textarea name="ingredients" id="ingredients" required></textarea>
            </div>

            <div class="form-group">
                <label for="steps">Steps</label>
                <textarea name="steps" id="steps" required></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">Save Recipe</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='my_recipes.php'">Cancel</button>
            </div>
        </form>
    </main>
</body>
</html>
