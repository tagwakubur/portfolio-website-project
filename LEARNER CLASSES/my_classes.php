<?php
//session_start();
$_SESSION['learner_id'] = 1;
$_SESSION['learner_name'] = "Test Learner";


include('db.php');
/*if (!isset($_SESSION['learner_id'])) {
    header("Location: login_learner.html");
    exit();
}*/
$learner_id = $_SESSION['learner_id'];
$stmt = $pdo->prepare("
  SELECT c.* FROM classes c
  JOIN registrations r ON c.class_id = r.class_id
  WHERE r.learner_id = ?
  
  ORDER BY r.registered_at DESC

");
$stmt->execute([$learner_id]);
$myclasses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Classes</title>
  <link rel="stylesheet" href="learner_dashboard.css">
</head>
<body>
  <header>…</header>
  <div class="container">
    <h2>My Enrolled Classes</h2>
    <div class="cards-grid">
      <?php if ($myclasses): ?>
        <?php foreach ($myclasses as $class): ?>
        <div class="card">
          <div class="card-img" style="background-image: url('class_default.jpg');"></div>
          <div class="card-content">
            <h4><?= htmlspecialchars($class['class_name']) ?></h4>
            <div class="card-meta">
              <span><?= isset($class['class_date']) ? htmlspecialchars($class['class_date']) : '' ?></span>
              <span><?= isset($class['class_time']) ? htmlspecialchars($class['class_time']) : '' ?></span>

            </div>
            <a href="class_details.php?class_id=<?= $class['class_id'] ?>" class="card-button">Go To Class</a>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>You haven't joined any classes yet.</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
