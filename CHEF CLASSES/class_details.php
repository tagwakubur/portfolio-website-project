<?php
include('icook_db.php');

$class_id = $_GET['class_id'] ?? null;
if (!$class_id) {
    echo "Class ID not provided.";
    exit;
}

// Get class info
$classQuery = $pdo->prepare("SELECT * FROM classes WHERE class_id = :class_id");
$classQuery->execute(['class_id' => $class_id]);
$class = $classQuery->fetch();
if (!$class) {
    echo "Class not found!";
    exit;
}

// Get assignments
$assignments = $pdo->prepare("SELECT * FROM assignments WHERE class_id = :class_id");
$assignments->execute(['class_id' => $class_id]);
$assignments = $assignments->fetchAll();

// Get announcements
$announcements = $pdo->prepare("SELECT * FROM announcements WHERE class_id = :class_id ORDER BY created_at DESC");
$announcements->execute(['class_id' => $class_id]);
$announcements = $announcements->fetchAll();

// FIX: learners.id not learner_id
$learners = $pdo->prepare("
    SELECT l.name, l.email 
    FROM learners l 
    JOIN registrations r ON l.id = r.learner_id 
    WHERE r.class_id = :class_id
");
$learners->execute(['class_id' => $class_id]);
$learners = $learners->fetchAll();

// Get quizzes
$quizzes = $pdo->prepare("SELECT * FROM quizzes WHERE class_id = :class_id");
$quizzes->execute(['class_id' => $class_id]);
$quizzes = $quizzes->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Class Details</title>
    
</head>
<body>

<h1>📚 Class Details: <?php echo htmlspecialchars($class['class_name']); ?></h1>
<section>
    <h2>📍 Venue</h2>
    <p><strong>Course Type:</strong> <?php echo htmlspecialchars($class['course_type'] ?? 'Not specified'); ?></p>
    <p><strong>Venue:</strong>
        <?php
        // Check if class is online
        if (!empty($class['online_link'])) {
            echo '<a href="' . htmlspecialchars($class['online_link']) . '" target="_blank">Join via Webex</a>';
        }
        // If offline and details available
        elseif (!empty($class['room_number']) && !empty($class['level']) && !empty($class['building'])) {
            echo 'Room ' . htmlspecialchars($class['room_number']) . ', Level ' . htmlspecialchars($class['level']) . ', ' . htmlspecialchars($class['building']);
        }
        // Fallback
        else {
            echo 'Venue details not yet provided.';
        }
        ?>
    </p>
</section>

<section>
    <h2>📂 Assignments</h2>
    <ul>
        <?php foreach ($assignments as $a): ?>
            <li><a href="<?php echo htmlspecialchars($a['file_path']); ?>" target="_blank"><?php echo htmlspecialchars($a['file_name']); ?></a></li>
        <?php endforeach; ?>
    </ul>
    <form action="upload_assignment.php" method="post" enctype="multipart/form-data" class="upload-form">
        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
        <input type="file" name="file" required>
        <button type="submit">Upload Assignment</button>
    </form>
</section>

<section>
    <h2>📘 Upload Chapter</h2>
    <form action="upload_chapter.php" method="post" enctype="multipart/form-data" class="upload-form">
        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
        <input type="file" name="chapter_file" required>
        <button type="submit">Upload Chapter</button>
    </form>
</section>

<section>
    <h2>📣 Announcements</h2>
    <ul>
        <?php foreach ($announcements as $a): ?>
            <li><strong><?php echo htmlspecialchars($a['title']); ?>:</strong> <?php echo htmlspecialchars($a['content']); ?> <em>(<?php echo $a['created_at']; ?>)</em></li>
        <?php endforeach; ?>
    </ul>
    <form action="add_announcement.php" method="post" class="upload-form">
        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="body" placeholder="Your announcement..." rows="3" required></textarea>
        <button type="submit">Post Announcement</button>
    </form>
</section>

<section>
    <h2>👨‍🎓 Registered Learners</h2>
    <table>
        <thead>
            <tr><th>Name</th><th>Email</th></tr>
        </thead>
        <tbody>
            <?php foreach ($learners as $l): ?>
                <tr>
                    <td><?php echo htmlspecialchars($l['name']); ?></td>
                    <td><?php echo htmlspecialchars($l['email']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<section>
    <h2>📝 Create Quiz (5 Questions)</h2>
    <form action="create_quiz.php" method="post" class="upload-form">
        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
        <input type="text" name="quiz_title" placeholder="Quiz Title" required>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <input type="text" name="q<?php echo $i; ?>" placeholder="Question <?php echo $i; ?>" required>
        <?php endfor; ?>
        <button type="submit">Create Quiz</button>
    </form>
</section>

<section>
    <h2>📋 Quizzes</h2>
    <ol>
        <?php foreach ($quizzes as $q): ?>
            <li><?php echo htmlspecialchars($q['quiz_title']); ?></li>
        <?php endforeach; ?>
    </ol>
</section>

</body>
</html>
