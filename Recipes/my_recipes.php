<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view this page.";
    exit;
}

include '../PHP/connect.php';

$chef_id = $_SESSION['user_id'];
$query = "SELECT * FROM recipes WHERE chef_id = '$chef_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Recipes</title>
    <link rel="stylesheet" href="../CSS/add_recipe.css">

</head>
<body>
    <header>
        <h1>My Recipes</h1>
        <a class="add-recipe-btn" href="create_recipe.php">+ Add New Recipe</a>
    </header>

    <div class="recipe-container">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="recipe-card">
            <h2><?= htmlspecialchars($row['title']) ?></h2>
            
            <div class="ingredients">
                <h3>Ingredients</h3>
                <p><?= nl2br(htmlspecialchars($row['ingredients'])) ?></p>
            </div>

            <div class="description">
                <h3>Steps</h3>
                <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
            </div>

            <div class="actions">
                <a class="edit-btn" href="edit_recipe.php?id=<?= $row['id'] ?>">Edit</a>
                <a class="delete-btn" href="delete_recipe.php?id=<?= $row['id'] ?>"
                   onclick="return confirm('Are you sure you want to delete this recipe?')">Delete</a>
            </div>
        </div>
    <?php } ?>
    </div>
</body>
</html>
