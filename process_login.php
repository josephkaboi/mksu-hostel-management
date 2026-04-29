<?php
session_start(); // This allows the server to "remember" the user
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admission = $_POST['admission'];
    $password = $_POST['password'];

    // Search for the user
    $sql = "SELECT * FROM users WHERE admission_no = '$admission'";
    $result = mysqli_query($conn, $sql);

    if ($user = mysqli_fetch_assoc($result)) {
        // Verify the hashed password
        if (password_verify($password, $user['password'])) {
            
            // Set session variables (The user's "Passport")
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            // ROLE-BASED REDIRECTION
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: student_portal.php");
            }
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "No user found with that Admission Number!";
    }
}
?>