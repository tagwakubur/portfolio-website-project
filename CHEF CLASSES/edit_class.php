<?php
include('icook_db.php');

// Fetch class data
$class_id = $_GET['class_id'];
$classQuery = $pdo->prepare("SELECT * FROM classes WHERE class_id = :class_id");
$classQuery->execute(['class_id' => $class_id]);
$class = $classQuery->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['class_name'];
    $type = $_POST['course_type'];
    $details = $_POST['course_details'];
    $venue = $_POST['venue'];
    $online_link = $_POST['online_link'];
    $room = $_POST['room_number'];
    $level = $_POST['level'];
    $building = $_POST['building'];

    // Image upload
    $class_image = $class['class_image'];
    if ($_FILES['image']['name']) {
        $target_dir = "uploads/";
        $new_path = $target_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $new_path)) {
            $class_image = $new_path;
        }
    }

    $updateQuery = $pdo->prepare("
        UPDATE classes 
        SET 
            class_name = :class_name,
            course_type = :course_type,
            course_details = :course_details,
            venue = :venue,
            online_link = :online_link,
            room_number = :room_number,
            level = :level,
            building = :building,
            class_image = :class_image
        WHERE class_id = :class_id
    ");

    $updateQuery->execute([
        'class_name' => $name,
        'course_type' => $type,
        'course_details' => $details,
        'venue' => $venue,
        'online_link' => $online_link,
        'room_number' => $room,
        'level' => $level,
        'building' => $building,
        'class_image' => $class_image,
        'class_id' => $class_id
    ]);

    header("Location: class_chef.php?updated=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Class</title>
    <link rel="stylesheet" href="chef_dashboard.css">
    
</head>
<body>

<h2 style="text-align:center; margin-top:20px;">Edit Class: <?php echo htmlspecialchars($class['class_name']); ?></h2>

<form method="post" enctype="multipart/form-data">
    <label>Class Name</label>
    <input type="text" name="class_name" value="<?php echo htmlspecialchars($class['class_name']); ?>" required>

    <label>Course Type</label>
    <input type="text" name="course_type" value="<?php echo htmlspecialchars($class['course_type']); ?>" required>

    <label>Course Details</label>
    <textarea name="course_details" required><?php echo htmlspecialchars($class['course_details']); ?></textarea>

    <label>Venue</label>
    <select name="venue">
    <option value="Online" <?php echo (isset($class['venue']) && $class['venue'] === 'Online') ? 'selected' : ''; ?>>Online</option>
    <option value="Offline" <?php echo (isset($class['venue']) && $class['venue'] === 'Offline') ? 'selected' : ''; ?>>Offline</option>
</select>


    <label>Online Link (Webex)</label>
    <input type="url" name="online_link" value="<?php echo htmlspecialchars($class['online_link']); ?>">

    <label>Room Number</label>
    <input type="text" name="room_number" value="<?php echo htmlspecialchars($class['room_number']); ?>">

    <label>Level</label>
    <input type="text" name="level" value="<?php echo htmlspecialchars($class['level']); ?>">

    <label>Building</label>
    <input type="text" name="building" value="<?php echo htmlspecialchars($class['building']); ?>">

    <label>Change Image</label>
    <input type="file" name="image" accept="image/*" onchange="previewImage(event)">

    <div class="image-preview">
        <?php if (!empty($class['class_image']) && file_exists($class['class_image'])): ?>
            <img id="preview" src="<?php echo $class['class_image']; ?>" onclick="openLightbox(this.src)">
        <?php else: ?>
            <img id="preview" src="#" style="display:none;">
        <?php endif; ?>
    </div>

    <div class="btn-group">
        <button type="submit">💾 Save</button>
        <a href="class_chef.php"><button type="button">❌ Cancel</button></a>
    </div>
</form>

<!-- Lightbox modal -->
<div class="lightbox" onclick="closeLightbox()" id="lightbox">
    <img id="lightbox-img" src="">
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}

function openLightbox(src) {
    document.getElementById('lightbox').style.display = 'flex';
    document.getElementById('lightbox-img').src = src;
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
}
</script>

</body>
</html>
