<?php
include('icook_db.php');

// Get all classes from the database
$classQuery = $pdo->query("SELECT * FROM classes");
$classes = $classQuery->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Classes</title>
    <link rel="stylesheet" href="chef_dashboard.css">
    
</head>
<body>
<div class="dashboard-container">
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="logo">Chef Portal</div>
        <ul class="nav-menu">
            <li><a href="chef_dashboard.php"><i class="icon">📊</i> Dashboard</a></li>
            <li class="active"><a href="chef_class.php"><i class="icon">📝</i> Classes</a></li>
            <li><a href="profile_chef.php"><i class="icon">👨‍🍳</i> Profile</a></li>
        </ul>
    </nav>

    <!-- Main -->
    <main class="main-content">
        <header class="top-bar">
            <h1>All Classes</h1>
        </header>

        <section class="class-list">
            <?php if ($classes): ?>
                <?php foreach ($classes as $class): ?>
                    <div class="class-item">
                        <?php if (!empty($class['class_image'])): ?>
                    <img src="<?php echo htmlspecialchars($class['class_image']); ?>" alt="Class Image">
                        <?php else: ?>
                            <img src="default-image.jpg" alt="No Image">
                        <?php endif; ?>

                        <h3 style="color:#191970;"><?php echo htmlspecialchars($class['class_name']); ?></h3>
                        <p><?php echo htmlspecialchars($class['course_details'] ?: $class['description']); ?></p>
                        <p><strong>Course Type:</strong> <?php echo htmlspecialchars($class['course_type']); ?></p>

                        <p><strong>Venue:</strong>
                            <?php
                            if (!empty($class['online_link'])) {
                                echo '<a href="' . htmlspecialchars($class['online_link']) . '" target="_blank">Join via Webex</a>';
                            } elseif (!empty($class['room_number']) && !empty($class['level']) && !empty($class['building'])) {
                                echo 'Room ' . htmlspecialchars($class['room_number']) . ', Level ' . htmlspecialchars($class['level']) . ', ' . htmlspecialchars($class['building']);
                            } else {
                                echo 'Venue details not yet provided.';
                            }
                            ?>
                        </p>

                        <div class="action-buttons">
                            <a class="details" href="class_details.php?class_id=<?php echo $class['class_id']; ?>">🔍 View Details</a>
                            <a class="edit" href="edit_class.php?class_id=<?php echo $class['class_id']; ?>">✏️ Edit</a>
                            <a class="delete" href="delete_class.php?class_id=<?php echo $class['class_id']; ?>" onclick="return confirm('Are you sure you want to delete this class?');">🗑️ Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No classes available.</p>
            <?php endif; ?>
        </section>
    </main>
</div>
</body>
</html>
