<?php
session_start();
include '../PHP/connect.php';

// Fetch all recipes with optional chef name
$query = "SELECT r.*, c.name AS chef_name 
          FROM recipes r 
          LEFT JOIN chefs c ON r.chef_id = c.id 
          ORDER BY r.created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Available Recipes</title>
    <link rel="stylesheet" href="../CSS/recipe_page_learner.css">
</head>
<body>
    <header>
        <h1>Available Recipes</h1>
    </header>

    <div class="recipe-container">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="recipe-card">
            <h2><?= htmlspecialchars($row['title']) ?></h2>

            <div class="description">
                <h3>Ingredients</h3>
                <p><?= nl2br(htmlspecialchars($row['ingredients'])) ?></p>
            </div>

            <div class="description">
                <h3>Steps</h3>
                <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
            </div>

            <?php if (!empty($row['chef_name'])) { ?>
                <p class="author">By Chef: <?= htmlspecialchars($row['chef_name']) ?></p>
            <?php } ?>

            <?php if (isset($_SESSION['user_id'])) { ?>
            <form method="POST" action="save_recipe.php">
                <input type="hidden" name="recipe_id" value="<?= $row['id'] ?>">
                <button type="submit" class="join-btn">Save to Favorites</button>
            </form>
            <?php } else { ?>
                <p style="font-size: 14px; color: gray;">Login to save this recipe</p>
            <?php } ?>
        </div>
    <?php } ?>
    </div>
</body>
</html>
