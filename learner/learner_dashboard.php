<?php
session_start();

// No more login check. We'll just set a fake name if not set.
if (!isset($_SESSION['learner_name'])) {
    $_SESSION['learner_name'] = "Guest Learner";
}

$name = $_SESSION['learner_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Learner Dashboard</title>
    <style>
        /* Dashboard button styles */
        .dashboard-links {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin: 30px 0;
        }
        .dashboard-links a {
            background-color: #191970;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .dashboard-links a:hover {
            background-color: #cc462e;
        }

        /* Navbar styles */
        .navbar {
            background-color: #191970;
            padding: 12px 20px;
        }
        .nav-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #ffcc00;
        }
    </style>
</head>
<body>
    <!-- Unified Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="learner_dashboard.php" class="nav-link">Dashboard</a>
            <a href="available_classes.php" class="nav-link">Available Classes</a>
            <a href="my_classes.php" class="nav-link">My Classes</a>
            <a href="../Recipes/view_recipes.php" class="nav-link">Browse Recipes</a>
            <a href="../Recipes/my_saved_recipes.php" class="nav-link">My Saved Recipes</a>
            <a href="logout.php" class="nav-link">Logout</a>
        </div>
    </nav>

    <!-- Main content -->
    <h1>Hi, <?php echo htmlspecialchars($name); ?>! 👋</h1>
    <p>Welcome to your learner dashboard.</p>

    <div class="dashboard-links">
        <a href="../Recipes/my_saved_recipes.php">My Saved Recipes</a>
    </div>
</body>
</html>


