<?php
$conn = mysqli_connect("localhost", "root", "", "icook_db", 3307);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $experience = $_POST['experience'] ?? '';
    $bio = $_POST['bio'] ?? '';
    $country = $_POST['country'] ?? '';
    $culinary_school = $_POST['culinary_school'] ?? '';
    $facebook_link = $_POST['facebook_link'] ?? '';
    $instagram_link = $_POST['instagram_link'] ?? '';
    $linkedin_link = $_POST['linkedin_link'] ?? '';

    // Update the chef’s profile based on the entered email
    $updateQuery = "UPDATE chefs SET 
                        name = ?, contact = ?, experience = ?, bio = ?, 
                        country = ?, culinary_school = ?, facebook_link = ?, 
                        instagram_link = ?, linkedin_link = ?
                    WHERE email = ?";

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssssssss", $name, $contact, $experience, $bio, $country, $culinary_school, $facebook_link, $instagram_link, $linkedin_link, $email);

    if ($stmt->execute()) {
        header("Location: profile_chef.html?success=1");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
