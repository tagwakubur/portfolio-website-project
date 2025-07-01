<?php
session_start();
include('db.php');

// Fake learner session for testing (remove if using real sessions)
$_SESSION['learner_id'] = 1;
$_SESSION['learner_name'] = "Test Learner";

$class_id = $_GET['class_id'] ?? null;
if (!$class_id) die("Class ID missing");

// Fetch class details
$stmt = $pdo->prepare("SELECT * FROM classes WHERE class_id = ?");
$stmt->execute([$class_id]);
$class = $stmt->fetch();
if (!$class) die("Class not found");

// Fetch announcements
$announcements = $pdo->prepare("SELECT * FROM announcements WHERE class_id = ?");
$announcements->execute([$class_id]);
$announcements = $announcements->fetchAll();

// Fetch assignments
$assignments = $pdo->prepare("SELECT * FROM assignments WHERE class_id = ?");
$assignments->execute([$class_id]);
$assignments = $assignments->fetchAll();

// You can repeat similarly for quizzes, chapters, etc.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Details for <?= htmlspecialchars($class['class_name']) ?></title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        h2, h3 {
            color: #191970;
        }
        section {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        a.download-link {
            display: inline-block;
            background: #191970;
            color: white;
            padding: 8px 12px;
            margin: 5px 0;
            text-decoration: none;
            border-radius: 4px;
        }
        a.download-link:hover {
            background: #cc462e;
        }
    </style>
</head>
<body>

    <h2>Details for: <?= htmlspecialchars($class['class_name']) ?></h2>

    <section>
        <h3>📍 Venue</h3>
        <p><?= htmlspecialchars($class['description']) ?></p>
        <p><strong>Venue:</strong> <a href="#">Join via Webex</a></p>
    </section>

    <section>
        <h3>📂 Assignments</h3>
        <?php if (count($assignments) > 0): ?>
            <?php foreach ($assignments as $a): ?>
                <p>
                    <a href="<?= htmlspecialchars($a['file_path']) ?>" class="download-link" download>
                        <?= htmlspecialchars($a['file_name']) ?>
                    </a>
                </p>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No assignments uploaded yet.</p>
        <?php endif; ?>
    </section>

    <section>
        <h3>📝 Announcements</h3>
        <?php if (count($announcements) > 0): ?>
            <?php foreach ($announcements as $ann): ?>
                <h4><?= htmlspecialchars($ann['title']) ?></h4>
                <p><?= htmlspecialchars($ann['message']) ?></p>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No announcements yet.</p>
        <?php endif; ?>
    </section>

</body>
</html>
