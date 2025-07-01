<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view this page.";
    exit;
}

include '../PHP/connect.php';

$chef_id = $_SESSION['user_id'];
$recipe_id = $_GET['id'] ?? null;

// Fetch the recipe for this chef
$query = "SELECT * FROM recipes WHERE id = '$recipe_id' AND chef_id = '$chef_id'";
$result = mysqli_query($conn, $query);
$recipe = mysqli_fetch_assoc($result);

if (!$recipe) {
    echo "Recipe not found or access denied.";
    exit;
}

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $steps = mysqli_real_escape_string($conn, $_POST['steps']);

    $update = "UPDATE recipes 
               SET title='$title', ingredients='$ingredients', description='$steps' 
               WHERE id='$recipe_id' AND chef_id='$chef_id'";
    mysqli_query($conn, $update);

    header("Location: my_recipes.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Recipe</title>
    <link rel="stylesheet" href="../CSS/add_recipe.css">

</head>
<body>
    <header>
        <h1>Edit Recipe</h1>
        <a class="back-btn" href="my_recipes.php">← Back to My Recipes</a>
    </header>

    <main class="add-recipe-main">
        <form class="add-recipe-form" method="POST" action="">
            <div class="form-group">
                <label for="title">Recipe Title</label>
                <input type="text" name="title" id="title" required
                       value="<?= htmlspecialchars($recipe['title']) ?>">
            </div>

            <div class="form-group">
                <label for="ingredients">Ingredients</label>
                <textarea name="ingredients" id="ingredients" required><?= 
                    htmlspecialchars($recipe['ingredients']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="steps">Steps</label>
                <textarea name="steps" id="steps" required><?= 
                    htmlspecialchars($recipe['description']) ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">Update Recipe</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='my_recipes.php'">Cancel</button>
            </div>
        </form>
    </main>
</body>
</html>
