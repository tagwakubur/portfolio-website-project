<?php
session_start();

// ✅ Check if learner is logged in
if (!isset($_SESSION['learner_name'])) {
    header("Location: login_learner.html");
    exit();
}

// ✅ Get the learner's name from session
$name = $_SESSION['learner_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learner Dashboard - iCook</title>
   <link rel="stylesheet" href="learner_dashboard.css">
<!-- Use your existing CSS file -->
</head>
<body>
    <!-- ✅ Navigation Bar -->
    <header>
        <div class="header-content">
            <div class="logo">iCook Dashboard</div>
            <nav class="nav-links">
                <a href="learner_dashboard.php">Dashboard</a> |
                <a href="profile_learner.html">Profile</a> |
                <a href="my_classes.php">My Classes</a> |
                <a href="recipe_page.php">Recipes</a> |
                <a href="logout.php">Logout</a>
            </nav>
            <div class="user-menu">
                <span>Welcome, <?php echo htmlspecialchars($name); ?>!</span>
            </div>
        </div>
    </header>
    
    <div class="container">
        <!-- ✅ Welcome Section -->
        <section class="welcome-section">
            <h2>Welcome Back, <?php echo htmlspecialchars($name); ?>! 👋</h2>
            <p>Continue your culinary journey with our available classes and recipes.</p>
            <!-- You can add your website intro or images here later -->
        </section>

        <!-- ✅ Available Classes -->
        <section class="dashboard-section">
            <div class="section-header">
                <h3>Available Classes</h3>
                <a href="my_classes.php" class="view-all">View All</a>
            </div>
            <div class="cards-grid">
                <!-- Example Class Cards -->
                <div class="card">
                    <div class="card-img" style="background-image: url('https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');"></div>
                    <div class="card-content">
                        <h4 class="card-title">Italian Pasta Masterclass</h4>
                        <div class="card-meta">
                            <span>June 25, 2025</span>
                            <span>6:00 PM</span>
                        </div>
                        <a href="my_classes.php" class="card-button">Join Class</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-img" style="background-image: url('https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');"></div>
                    <div class="card-content">
                        <h4 class="card-title">Vegetarian Cooking Basics</h4>
                        <div class="card-meta">
                            <span>July 2, 2025</span>
                            <span>5:30 PM</span>
                        </div>
                        <a href="my_classes.php" class="card-button">Join Class</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ✅ Available Recipes -->
        <section class="dashboard-section">
            <div class="section-header">
                <h3>Available Recipes</h3>
                <a href="recipe_page.php" class="view-all">View All</a>
            </div>
            <div class="cards-grid">
                <div class="card">
                    <div class="card-img" style="background-image: url('https://images.unsplash.com/photo-1546069901-d5bfd2cbfb1f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');"></div>
                    <div class="card-content">
                        <h4 class="card-title">Spaghetti Carbonara</h4>
                        <div class="card-meta">
                            <span>Italian</span>
                            <span>30 mins</span>
                        </div>
                        <a href="recipe_page.php" class="card-button">View Recipe</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-img" style="background-image: url('https://images.unsplash.com/photo-1518779578993-ec3579fee39f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');"></div>
                    <div class="card-content">
                        <h4 class="card-title">Chocolate Soufflé</h4>
                        <div class="card-meta">
                            <span>Dessert</span>
                            <span>45 mins</span>
                        </div>
                        <a href="recipe_page.php" class="card-button">View Recipe</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ✅ You can add more sections or images later -->
    </div>
</body>
</html>
