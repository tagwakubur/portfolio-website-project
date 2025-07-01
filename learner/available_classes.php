<?php
// session_start();
$_SESSION['learner_id'] = 1;
$_SESSION['learner_name'] = "Test Learner";

include('db.php');
/*if (!isset($_SESSION['learner_id'])) {
    header("Location: login_learner.html");
    exit();
}*/
$classes = $pdo->query("SELECT * FROM classes ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Available Classes</title>
  <link rel="stylesheet" href="learner_dashboard.css">
</head>
<body>
  <header>…</header>
  <div class="container">
    <h2>All Available Classes</h2>
    <div class="cards-grid">
      <?php foreach ($classes as $class): ?>
      <div class="card">
        <div class="card-img" style="background-image: url('class_default.jpg');"></div>
        <div class="card-content">
          <h4><?= htmlspecialchars($class['class_name']) ?></h4>
          <div class="card-meta">
            <span><?= isset($class['class_date']) ? htmlspecialchars($class['class_date']) : '' ?></span>
            <span><?= isset($class['class_time']) ? htmlspecialchars($class['class_time']) : '' ?></span>
          </div>
          <a href="register_class.php?class_id=<?= $class['class_id'] ?>" class="card-button">Join Class</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>

