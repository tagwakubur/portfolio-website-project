<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "icook_db", 3307);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

function getCount($conn, $tableName) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $tableName");
    if ($result) {
        return mysqli_fetch_assoc($result)['count'];
    } else {
        return "Table not found";
    }
}

$learners_count = getCount($conn, "learners");
$chefs_count = getCount($conn, "chefs");
$classes_count = getCount($conn, "classes");
$recipes_count = getCount($conn, "recipes");

$learners_query = mysqli_query($conn, "SELECT * FROM learners");
$chefs_query = mysqli_query($conn, "SELECT * FROM chefs");

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <aside class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header>
            <h1>Welcome, Admin</h1>
        </header>

        <!-- Summary Cards -->
        <section class="cards-grid">
            <div class="card" onclick="toggleSection('learners-section')">
                <h3>Registered Learners</h3>
                <p><?php echo $learners_count; ?></p>
            </div>
            <div class="card" onclick="toggleSection('chefs-section')">
                <h3>Registered Chefs</h3>
                <p><?php echo $chefs_count; ?></p>
            </div>
            <div class="card">
                <h3>Available Classes</h3>
                <p><?php echo $classes_count; ?></p>
            </div>
            <div class="card">
                <h3>Available Recipes</h3>
                <p><?php echo $recipes_count; ?></p>
            </div>
        </section>

        <!-- Learners Section -->
        <section class="user-section hidden" id="learners-section">
            <h2>Learners Details</h2>
            <div class="user-card-container">
                <?php while ($learner = mysqli_fetch_assoc($learners_query)) { ?>
                    <div class="user-card">
                        <h4><?php echo htmlspecialchars($learner['name']); ?></h4>
                        <p>Email: <?php echo htmlspecialchars($learner['email']); ?></p>
                        <p>Contact: <?php echo htmlspecialchars($learner['contact']); ?></p>
                        <p>Bio: <?php echo htmlspecialchars($learner['bio']); ?></p>
                        <p>Preferred Cuisine: <?php echo htmlspecialchars($learner['preferred_cuisine']); ?></p>
                        <p>Skill Level: <?php echo htmlspecialchars($learner['skill_level']); ?></p>
                    </div>
                <?php } ?>
            </div>
        </section>

        <!-- Chefs Section -->
        <section class="user-section hidden" id="chefs-section">
            <h2>Chefs Details</h2>
            <div class="user-card-container">
                <?php while ($chef = mysqli_fetch_assoc($chefs_query)) { ?>
                    <div class="user-card">
                        <h4><?php echo htmlspecialchars($chef['name']); ?></h4>
                        <p>Email: <?php echo htmlspecialchars($chef['email']); ?></p>
                        <p>Contact: <?php echo htmlspecialchars($chef['contact']); ?></p>
                        <p>Experience: <?php echo htmlspecialchars($chef['experience']); ?> years</p>
                        <p>Country: <?php echo htmlspecialchars($chef['country']); ?></p>
                        <p>Culinary School: <?php echo htmlspecialchars($chef['culinary_school']); ?></p>
                        <p>Bio: <?php echo htmlspecialchars($chef['bio']); ?></p>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>

    <script>
        function toggleSection(sectionId) {
            var section = document.getElementById(sectionId);
            section.classList.toggle('hidden');
        }
    </script>
</body>
</html>
