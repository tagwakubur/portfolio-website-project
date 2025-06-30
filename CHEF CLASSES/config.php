<?php
// Database connection settings
$hostname = "localhost";  // Your database server
$username = "root";       // Your database username
$password = "";           // Your database password
$dbname = "cooking_website"; // Your database name

// Create connection
$connection = mysqli_connect($hostname, $username, $password, $dbname);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
