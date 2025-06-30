<?php
include('db.php');

$chef_id = 1; // ideally from session

// Get chef name
$chefQuery = $pdo->prepare("SELECT name FROM chefs WHERE chef_id = :chef_id");
$chefQuery->execute(['chef_id' => $chef_id]);
$chef = $chefQuery->fetch();

// Stats
$classQuery = $pdo->prepare("SELECT COUNT(*) as total FROM classes WHERE chef_id = :chef_id");
$classQuery->execute(['chef_id' => $chef_id]);
$classCount = $classQuery->fetch()['total'];

$learnerQuery = $pdo->prepare("
    SELECT COUNT(DISTINCT r.learner_id) as total
    FROM registrations r
    JOIN classes c ON r.class_id = c.class_id
    WHERE c.chef_id = :chef_id
");
$learnerQuery->execute(['chef_id' => $chef_id]);
$learnerCount = $learnerQuery->fetch()['total'];

// Upcoming classes
$upcomingQuery = $pdo->prepare("
    SELECT class_name, course_type, class_date
    FROM classes
    WHERE chef_id = :chef_id
      AND class_date >= CURDATE()
    ORDER BY class_date
    LIMIT 3
");
$upcomingQuery->execute(['chef_id' => $chef_id]);
$upcomingClasses = $upcomingQuery->fetchAll();

// Recent announcements
$announcementQuery = $pdo->prepare("
    SELECT a.title, a.created_at
    FROM announcements a
    JOIN classes c ON a.class_id = c.class_id
    WHERE c.chef_id = :chef_id
    ORDER BY a.created_at DESC
    LIMIT 3
");
$announcementQuery->execute(['chef_id' => $chef_id]);
$recentAnnouncements = $announcementQuery->fetchAll();

// Class thumbnails
$classThumbs = $pdo->prepare("
    SELECT class_name, class_image
    FROM classes
    WHERE chef_id = :chef_id
      AND class_image IS NOT NULL
    ORDER BY class_date DESC
    LIMIT 3
");
$classThumbs->execute(['chef_id' => $chef_id]);
$thumbnails = $classThumbs->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chef Dashboard</title>
    <link rel="stylesheet" href="chef_dashboard.css">
    <style>
        .stat-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            flex: 1;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            min-width: 220px;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .stat-icon {
            font-size: 36px;
        }
        .stat-number {
            font-size: 28px;
            color: #191970;
            font-weight: bold;
        }
        .stat-label {
            color: #555;
            font-size: 16px;
        }
        section { margin-bottom: 30px; }
        section h2 { margin-bottom: 10px; color: #191970; }
        .resource-list { padding-left: 20px; }
        .thumb-container img {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        #learnerChart { max-width: 600px; margin: 30px auto; }
        #topBtn {
            display: none;
            position: fixed; bottom: 30px; right: 30px;
            background: #191970; color: white;
            padding: 12px; border: none; border-radius: 50%; cursor: pointer;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <nav class="sidebar">
        <div class="logo">Chef Portal</div>
        <ul class="nav-menu">
            <li class="active"><a href="dashboard.php"><i class="icon">📊</i> Dashboard</a></li>
            <li><a href="class_chef.php"><i class="icon">📝</i> Classes</a></li>
            <li><a href="profile_chef.php"><i class="icon">👨‍🍳</i> Profile</a></li>
        </ul>
    </nav>
    <main class="main-content">
        <header class="top-bar">
            <h1>Welcome Back, <?php echo htmlspecialchars($chef['name']); ?> 👋</h1>
        </header>

        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon">👨‍🍳</div>
                <div>
                    <div class="stat-number"><?php echo $classCount; ?></div>
                    <div class="stat-label">Total Classes</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👨‍🎓</div>
                <div>
                    <div class="stat-number"><?php echo $learnerCount; ?></div>
                    <div class="stat-label">Registered Learners</div>
                </div>
            </div>
        </div>

        <section>
            <h2>📅 Upcoming Classes</h2>
            <?php if ($upcomingClasses): ?>
                <ul class="resource-list">
                    <?php foreach ($upcomingClasses as $c): ?>
                        <li><strong><?php echo htmlspecialchars($c['class_name']); ?></strong> (<?php echo htmlspecialchars($c['course_type']); ?>) on <em><?php echo $c['class_date']; ?></em></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No upcoming classes.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>📣 Recent Announcements</h2>
            <?php if ($recentAnnouncements): ?>
                <ul class="resource-list">
                    <?php foreach ($recentAnnouncements as $a): ?>
                        <li><strong><?php echo htmlspecialchars($a['title']); ?></strong> <em>(<?php echo $a['created_at']; ?>)</em></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No recent announcements.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>🖼️ Class Thumbnails</h2>
            <div class="thumb-container" style="display:flex; gap:15px;">
                <?php foreach ($thumbnails as $t): ?>
                    <div>
                        <img src="<?php echo htmlspecialchars($t['class_image']); ?>" alt="">
                        <p style="text-align:center;"><?php echo htmlspecialchars($t['class_name']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <canvas id="learnerChart"></canvas>
        <button id="topBtn" onclick="scrollToTop()">⬆</button>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('learnerChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Week 1','Week 2','Week 3','Week 4'],
        datasets: [{
            label: 'Learners',
            data: [5, 8, 12, 18],
            borderColor: '#191970',
            fill: false
        }]
    },
    options: { responsive: true }
});

let topBtn = document.getElementById("topBtn");
window.onscroll = () => {
    topBtn.style.display = (document.documentElement.scrollTop > 300 ? "block" : "none");
};
function scrollToTop(){
    window.scrollTo({ top:0, behavior:'smooth' });
}
</script>

</body>
</html>
