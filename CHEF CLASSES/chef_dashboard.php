<?php
include('icook_db.php');

$chef_id = 1; // Replace with session value if needed

// ✅ Fix here: use `id` instead of `chef_id`
$chefQuery = $pdo->prepare("SELECT * FROM chefs WHERE id = :chef_id");
$chefQuery->execute(['chef_id' => $chef_id]);
$chef = $chefQuery->fetch();

// Classes table should still use chef_id if that's how it's defined in your DB
$classQuery = $pdo->prepare("SELECT COUNT(*) as total_classes FROM classes WHERE chef_id = :chef_id");
$classQuery->execute(['chef_id' => $chef_id]);
$classCount = $classQuery->fetch()['total_classes'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chef Dashboard</title>
  <link rel="stylesheet" href="chef_dashboard.css" />
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <nav class="sidebar">
      <div class="logo">Chef Portal</div>
      <ul class="nav-menu">
        <li class="active"><a href="chef_dashboard.php"><i class="icon">📊</i> Dashboard</a></li>
        <li><a href="class_chef.php"><i class="icon">📝</i> Classes</a></li>
        <li><a href="profile_chef.php"><i class="icon">👨‍🍳</i> Profile</a></li>
      </ul>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
      <header class="top-bar">
        <h1>Welcome<?php echo isset($chef['name']) ? ', ' . htmlspecialchars($chef['name']) : '!'; ?></h1>
      </header>

      <div class="stats-container">
        <div class="stat-card">
          <div class="stat-icon">👨‍🍳</div>
          <div class="stat-info">
            <h3>Total Classes</h3>
            <p class="stat-number"><?php echo $classCount; ?></p>
          </div>
        </div>
      </div>

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
