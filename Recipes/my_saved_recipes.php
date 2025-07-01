<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view your saved recipes.";
    exit;
}

include '../PHP/connect.php';

$learner_id = $_SESSION['user_id'];

// Get all saved recipes for this learner
$query = "SELECT r.*, c.name AS chef_name
          FROM favorites f
          JOIN recipes r ON f.recipe_id = r.id
          LEFT JOIN chefs c ON r.chef_id = c.id
          WHERE f.learner_id = '$learner_id'
          ORDER BY f.created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Saved Recipes</title>
    <link rel="stylesheet" href="../CSS/recipe_page_learner.css">
</head>
<body>
    <header>
        <h1>My Saved Recipes</h1>
        <a href="view_recipes.php" style="font-size:14px;">← Back to All Recipes</a>
    </header>

    <div class="recipe-container">
    <?php
    if (mysqli_num_rows($result) == 0) {
        echo "<p style='padding:20px;'>You haven’t saved any recipes yet.</p>";
    }
    while ($row = mysqli_fetch_assoc($result)) { ?>
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
        </div>
    <?php } ?>
    </div>
</body>
</html>
