<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $class = $_POST['class'] ?? '';
    $slot = $_POST['slot'] ?? '';

    // Generate class code
    $classCode = strtoupper(substr($class, 0, 3)) . rand(100, 999);
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Registration Successful</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 40px;
                background-color: #f8f9fa;
            }
            table {
                border-collapse: collapse;
                width: 60%;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 12px;
                text-align: left;
            }
            th {
                background-color: #4CAF50;
                color: white;
            }
            h2 {
                color: #28a745;
            }
            a.button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007BFF;
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
            a.button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>

        <h2>✅ Registration Successful!</h2>

        <table>
            <tr><th>Student Name</th><td><?= htmlspecialchars($name) ?></td></tr>
            <tr><th>Class Name</th><td><?= htmlspecialchars($class) ?></td></tr>
            <tr><th>Time Slot</th><td><?= htmlspecialchars($slot) ?></td></tr>
            <tr><th>Class Code</th><td><?= htmlspecialchars($classCode) ?></td></tr>
        </table>

        <p>You can now explore your classes and more from the dashboard.</p>
        <a href="learner-dashboard.html" class="button">Go to Learner Dashboard</a>

    </body>
    </html>

    <?php
} else {
    echo "<h3>Error: Please register through the form.</h3>";
}
?>
