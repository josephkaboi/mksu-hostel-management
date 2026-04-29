<?php
// Enable error reporting so we see the "secret" error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db_connect.php';

if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Check if the connection variable $conn exists
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE users SET status = 'left' WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php");
        exit(); // Always use exit() after a header redirect
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    echo "Access Denied or ID missing. Role: " . ($_SESSION['role'] ?? 'None');
}
?>