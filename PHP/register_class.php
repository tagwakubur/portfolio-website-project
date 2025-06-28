<?php
// register_class.php
$class = $_POST['class'] ?? 'Unknown';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register for <?php echo htmlspecialchars($class); ?> Class</title>
</head>
<body>
    <h2>Register for "<?php echo htmlspecialchars($class); ?>" Class</h2>

    <form action="submit_registration.php" method="POST">
        <input type="hidden" name="class" value="<?php echo htmlspecialchars($class); ?>">

        <label>Name: <input type="text" name="name" required></label><br><br>
        <label>Email: <input type="email" name="email" required></label><br><br>
        
        <label>Choose Time Slot:</label><br>
        <select name="slot" required>
            <option value="">-- Select Slot --</option>
            <option value="Morning (9AM - 11AM)">Morning (9AM - 11AM)</option>
            <option value="Afternoon (1PM - 3PM)">Afternoon (1PM - 3PM)</option>
            <option value="Evening (5PM - 7PM)">Evening (5PM - 7PM)</option>
        </select><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
