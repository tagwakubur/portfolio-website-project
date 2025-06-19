<?php
session_start();
include 'connect.php';

// Check if learner is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'learner') {
    die("Access denied.");
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT recipes.*, users.name AS chef_name 
        FROM recipes
        JOIN users ON recipes.chef_id = users.id
        ORDER BY recipes.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Recipes</title>
</head>
<body>

<h2>Available Recipes</h2>

<?php while ($row = $result->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <h3><?= htmlspecialchars($row['title']) ?></h3>

        <!-- ✅ Display chef name -->
        <p><strong>By Chef:</strong> <?= htmlspecialchars($row['chef_name']) ?></p>

        <p><strong>Description:</strong> <?= htmlspecialchars($row['description']) ?></p>
        <p><strong>Ingredients:</strong><br><?= nl2br(htmlspecialchars($row['ingredients'])) ?></p>
        <p><strong>Instructions:</strong><br><?= nl2br(htmlspecialchars($row['instructions'])) ?></p>

        <?php if (!empty($row['image_url'])): ?>
            <img src="<?= htmlspecialchars($row['image_url']) ?>" width="200" alt="Recipe Image"><br>
        <?php endif; ?>

        
    </div>
<?php endwhile; ?>


</body>
</html>
