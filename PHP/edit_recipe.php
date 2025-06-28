<?php
session_start();
include 'connect.php';

// ✅ Access control: only chefs allowed
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'chef') {
    die("Access denied.");
}

$chef_id = $_SESSION['user_id'];

// ✅ Check if recipe ID is provided
if (!isset($_GET['id'])) {
    die("Recipe ID is missing.");
}

$recipe_id = $_GET['id'];

// ✅ Fetch recipe from DB
$stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();
$recipe = $result->fetch_assoc();

// ✅ Ownership check
if (!$recipe || $recipe['chef_id'] != $chef_id) {
    die("Unauthorized access.");
}

// ✅ If form submitted, update recipe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $image_url = $_POST['image_url'];

    $updateStmt = $conn->prepare("UPDATE recipes SET title = ?, description = ?, ingredients = ?, instructions = ?, image_url = ? WHERE id = ?");
    $updateStmt->bind_param("sssssi", $title, $description, $ingredients, $instructions, $image_url, $recipe_id);

    if ($updateStmt->execute()) {
        header("Location: chef_recipes.php");
        exit;
    } else {
        echo "Error: " . $updateStmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Recipe</title>
    <link rel="stylesheet" href="recipes_page_chef.css">
</head>
<body>
    <h1>Edit Recipe</h1>

    <form action="edit_recipe.php?id=<?= $recipe_id ?>" method="POST" class="recipe-form">
        <label for="title">Recipe Title:</label><br>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($recipe['title']) ?>" required><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" rows="3" required><?= htmlspecialchars($recipe['description']) ?></textarea><br><br>

        <label for="ingredients">Ingredients:</label><br>
        <textarea name="ingredients" id="ingredients" rows="5" required><?= htmlspecialchars($recipe['ingredients']) ?></textarea><br><br>

        <label for="instructions">Instructions:</label><br>
        <textarea name="instructions" id="instructions" rows="5" required><?= htmlspecialchars($recipe['instructions']) ?></textarea><br><br>

        <label for="image_url">Image URL (optional):</label><br>
        <input type="text" name="image_url" id="image_url" value="<?= htmlspecialchars($recipe['image_url']) ?>"><br><br>

        <button type="submit">Update Recipe</button>
        <a href="chef_recipes.php"><button type="button">Cancel</button></a>
    </form>
</body>
</html>

