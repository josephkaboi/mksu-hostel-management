<?php
session_start();
require 'db_connect.php';

// 1. Security Check
if ($_SESSION['role'] == 'admin' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // 2. Find out which hostel this student belongs to
    $user_query = "SELECT hostel_name FROM users WHERE id = $id";
    $user_res = mysqli_query($conn, $user_query);
    $user_data = mysqli_fetch_assoc($user_res);
    $h_name = $user_data['hostel_name'];

    // 3. Count how many ACTIVE students are currently in that hostel
    $count_sql = "SELECT COUNT(*) as total FROM users WHERE hostel_name = '$h_name' AND status = 'active' AND role = 'student'";
    $count_res = mysqli_query($conn, $count_sql);
    $count_data = mysqli_fetch_assoc($count_res);
    
    // 4. Logic Check: Is there space?
    if ($count_data['total'] >= 16) {
        // Stop! The hostel is full.
        echo "<script>
                alert('Error: $h_name is currently FULL (16/16). You cannot re-admit this student until someone else leaves.');
                window.location.href='admin_dashboard.php';
              </script>";
    } else {
        // Success! There is space.
        $sql = "UPDATE users SET status = 'active' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            header("Location: admin_dashboard.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>