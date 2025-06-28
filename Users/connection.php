<?php
$conn = mysqli_connect("localhost", "root", "", "icook_db", 3307);


if ($conn) {
    echo "Connected successfully";
} else {
    echo "Connection failed: " . mysqli_connect_error();
}
?>
