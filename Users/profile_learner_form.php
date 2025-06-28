<?php
$conn = mysqli_connect("localhost", "root", "", "icook_db", 3307);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $bio = $_POST['bio'] ?? '';
    $preferred_cuisine = $_POST['preferred_cuisine'] ?? '';
    $skill_level = $_POST['skill_level'] ?? '';

    // Update the learner’s profile based on the provided email
    $updateQuery = "UPDATE learners SET 
                        name = ?, contact = ?, bio = ?, preferred_cuisine = ?, skill_level = ?
                    WHERE email = ?";

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssss", $name, $phone, $bio, $preferred_cuisine, $skill_level, $email);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        header("Location: profile_learner.html?success=1");
        exit();
    } else {
        echo "❌ Update failed. Please make sure the email exists in the database.";
    }

    $stmt->close();
}

$conn->close();
?>
