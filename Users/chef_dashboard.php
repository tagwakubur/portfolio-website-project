<?php
session_start();

// If not logged in, redirect to login page
if (!isset($_SESSION['name'])) {
    header("Location: chef-login.html");
    exit();
}

$chefName = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chef Dashboard</title>
    <link rel="stylesheet" href="chef_dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Navigation Sidebar -->
        <nav class="sidebar">
            <div class="logo">Chef Portal</div>
            <ul class="nav-menu">
                <li class="active"><a href="#"><i class="icon">📊</i> Dashboard</a></li>
                <li><a href="class_chef.html"><i class="icon">📝</i> Classes</a></li>
                <li><a href="profile_chef.html"><i class="icon">👨‍🍳</i> Profile</a></li>
                <li><a href="logout.php"><i class="icon">🚪</i> Log out</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-bar">
                <!-- ✅ Chef's Name Displayed Here -->
                <h1>
    Welcome,<br>
    <span style="font-weight: bold; font-size: 2.5rem; color: darkblue;">Chef <?php echo htmlspecialchars($chefName); ?> 👨‍🍳</span>
</h1>

            </header>

            <div class="stats-container">
                <!-- Total Classes Card -->
                <div class="stat-card">
                    <div class="stat-icon">👨‍🍳</div>
                    <div class="stat-info">
                        <h3>Total Classes</h3>
                        <p class="stat-number">8</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <section class="recent-activity">
                <h2>Recent Activity</h2>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon">👥</div>
                        <div class="activity-text">12 students joined your "Italian Basics" class</div>
                        <div class="activity-time">1 day ago</div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
