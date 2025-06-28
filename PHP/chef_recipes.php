<?php
session_start();
include 'connect.php';

// ✅ Check if user is logged in and is a chef
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'chef') {
    die("Access denied.");
}

$chef_id = $_SESSION['user_id'];

// ✅ Get all recipes created by this chef
$sql = "SELECT * FROM recipes WHERE chef_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $chef_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Collection</title>
    <link rel="stylesheet" href="recipes_page_chef.css">
</head>
<body>
    <header>
        <h1>My Recipe Book</h1>
        <form action="create_recipe.php" method="get">
            <button type="submit" class="add-recipe-btn">+ Add New Recipe</button>
        </form>
    </header>

    <main>
        <div class="recipe-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="recipe-card">
                        <h2><?= htmlspecialchars($row['title']) ?></h2>

                        <div class="ingredients">
                            <h3>Ingredients</h3>
                            <p><?= nl2br(htmlspecialchars($row['ingredients'])) ?></p>
                        </div>

                        <p class="description"><?= htmlspecialchars($row['description']) ?></p>

                        <div class="actions">
                            <a href="edit_recipe.php?id=<?= $row['id'] ?>"><button class="edit-btn">Edit</button></a>
                            <a href="delete_recipe.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this recipe?')">
                                <button class="delete-btn">Delete</button>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No recipes found. Click "Add New Recipe" to create your first one.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>

