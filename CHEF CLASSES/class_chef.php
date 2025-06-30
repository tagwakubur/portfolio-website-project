<?php
include('db.php');

$chef_id = 1; // Ideally from session

$classQuery = $pdo->prepare("SELECT * FROM classes WHERE chef_id = :chef_id");
$classQuery->execute(['chef_id' => $chef_id]);
$classes = $classQuery->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Classes</title>
    <link rel="stylesheet" href="chef_dashboard.css">
    <style>
        .class-item {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        .class-item img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .action-buttons a {
            display: inline-block;
            margin-right: 10px;
            background-color: #191970;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }
        .action-buttons a.edit { background-color: #007bff; }
        .action-buttons a.delete { background-color: #dc3545; }
        .action-buttons a.details { background-color: #28a745; }
    </style>
</head>
<body>
<div class="dashboard-container">
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="logo">Chef Portal</div>
        <ul class="nav-menu">
            <li><a href="dashboard.php"><i class="icon">📊</i> Dashboard</a></li>
            <li class="active"><a href="class_chef.php"><i class="icon">📝</i> Classes</a></li>
            <li><a href="profile_chef.php"><i class="icon">👨‍🍳</i> Profile</a></li>
        </ul>
    </nav>

    <!-- Main -->
    <main class="main-content">
        <header class="top-bar">
            <h1>Your Classes</h1>
        </header>

        <section class="class-list">
            <?php if ($classes): ?>
                <?php foreach ($classes as $class): ?>
                    <div class="class-item">
                        <?php if (!empty($class['class_image'])): ?>
                            <img src="<?php echo htmlspecialchars($class['class_image']); ?>" alt="Class Image">
                        <?php endif; ?>

                        <h3 style="color:#191970;"><?php echo htmlspecialchars($class['class_name']); ?></h3>
                        <p><?php echo htmlspecialchars($class['course_details']); ?></p>
                        <p><strong>Course Type:</strong> <?php echo htmlspecialchars($class['course_type']); ?></p>

                        <p><strong>Venue:</strong>
                            <?php
                            if (strtolower($class['venue']) === 'online') {
                                echo '<a href="' . htmlspecialchars($class['online_link']) . '" target="_blank">Join via Webex</a>';
                            } elseif ($class['room_number'] && $class['level'] && $class['building']) {
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
