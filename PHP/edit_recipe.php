<?php
session_start();
include 'connect.php'; 
// Make sure recipe ID is passed in the URL
if (!isset($_GET['id'])) {
    die("No recipe selected.");
}

$recipe_id = $_GET['id'];

// Fetch recipe for form pre-fill
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $recipe = $result->fetch_assoc();

    if (!$recipe) {
        die("Recipe not found.");
    }
}

// Handle update submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $image_url = $_POST['image_url'];

    $stmt = $conn->prepare("UPDATE recipes SET title = ?, description = ?, ingredients = ?, instructions = ?, image_url = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $title, $description, $ingredients, $instructions, $image_url, $recipe_id);

    if ($stmt->execute()) {
        echo "Recipe updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!-- HTML Edit Form -->
<h2>Edit Recipe</h2>
<form method="post">
    <label>Title:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($recipe['title']) ?>" required><br><br>

    <label>Description:</label><br>
    <textarea name="description"><?= htmlspecialchars($recipe['description']) ?></textarea><br><br>

    <label>Ingredients:</label><br>
    <textarea name="ingredients"><?= htmlspecialchars($recipe['ingredients']) ?></textarea><br><br>

    <label>Instructions:</label><br>
    <textarea name="instructions"><?= htmlspecialchars($recipe['instructions']) ?></textarea><br><br>

    <label>Image URL:</label><br>
    <input type="text" name="image_url" value="<?= htmlspecialchars($recipe['image_url']) ?>"><br><br>

    <button type="submit">Update Recipe</button>
</form>
