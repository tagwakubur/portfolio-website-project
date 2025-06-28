<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "icook_db", 3307);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

function getCount($conn, $tableName) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $tableName");
    if ($result) {
        return mysqli_fetch_assoc($result)['count'];
    } else {
        return "Table not found";
    }
}

$learners_count = getCount($conn, "learners");
$chefs_count = getCount($conn, "chefs");
$classes_count = getCount($conn, "classes"); // Table missing is OK, will show message
$recipes_count = getCount($conn, "recipes"); // Table missing is OK, will show message

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <aside class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="#">Dashboard</a></li>
           
            
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </aside>
    <main class="main-content">
        <header>
            <h1>Welcome, MUSA ALI MOHAMMED </h1>
        </header>
        <section class="cards">
            <div class="card">
                <h3>Registered Learners</h3>
                <p><?php echo $learners_count; ?></p>
            </div>
            <div class="card">
                <h3>Registered Chefs</h3>
                <p><?php echo $chefs_count; ?></p>
            </div>
            <div class="card">
                <h3>Available Classes</h3>
                <p><?php echo $classes_count; ?></p>
            </div>
            <div class="card">
                <h3>Available Recipes</h3>
                <p><?php echo $recipes_count; ?></p>
            </div>
        </section>
    </main>
</body>
</html>
