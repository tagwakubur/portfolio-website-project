<?php
session_start();
include 'connect.php';

// Check if user is logged in
$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['user_role'] ?? null; // 'chef' or 'learner'

$sql = "SELECT * FROM recipes ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<h2>All Recipes</h2>

<?php while ($row = $result->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <h3><?= htmlspecialchars($row['title']) ?></h3>
        <p><strong>Description:</strong> <?= htmlspecialchars($row['description']) ?></p>
        <p><strong>Ingredients:</strong><br><?= nl2br(htmlspecialchars($row['ingredients'])) ?></p>
        <p><strong>Instructions:</strong><br><?= nl2br(htmlspecialchars($row['instructions'])) ?></p>
        <?php if ($row['image_url']): ?>
            <img src="<?= htmlspecialchars($row['image_url']) ?>" width="200"><br>
        <?php endif; ?>

        <!-- Show edit/delete buttons if the logged-in user is the chef who created this -->
        <?php if ($user_role === 'chef' && $user_id == $row['chef_id']): ?>
            <a href="edit_recipe.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="delete_recipe.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        <?php endif; ?>

        <!-- Learner: Save recipe button (optional feature) -->
        <?php if ($user_role === 'learner'): ?>
            <form action="save_recipe.php" method="POST" style="display:inline;">
                <input type="hidden" name="recipe_id" value="<?= $row['id'] ?>">
                <button type="submit">Save Recipe</button>
            </form>
        <?php endif; ?>
    </div>
<?php endwhile; ?>

