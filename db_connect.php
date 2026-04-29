<?php
$servername = "localhost";
$username = "root"; // Default for XAMPP
$password = "";     // Default for XAMPP is empty
$dbname = "mksu_hostel";

// Create the connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection works
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>