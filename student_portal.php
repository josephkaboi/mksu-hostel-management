<?php
session_start();
require 'db_connect.php';

// Security: If not logged in as a student, send to login
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Hostel Portal | MKSU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-header { background: #0d6efd; color: white; padding: 30px; border-radius: 10px; }
        .status-box { padding: 20px; border-radius: 10px; text-align: center; font-weight: bold; }
    </style>
</head>
<body class="bg-light p-4">
    <div class="container" style="max-width: 600px;">
        <div class="profile-header mb-4 shadow">
            <h2>Hello, <?php echo $student['full_name']; ?>!</h2>
            <p>Admission: <?php echo $student['admission_no']; ?></p>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <h5>My Accommodation</h5>
                <hr>
                <p><strong>Hostel:</strong> <?php echo $student['hostel_name']; ?></p>
                
                <?php if($student['status'] == 'active'): ?>
                    <div class="status-box bg-success text-white">
                        ✓ Your Accommodation is ACTIVE
                    </div>
                <?php else: ?>
                    <div class="status-box bg-danger text-white">
                        X You have checked out (LEFT)
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center">
            <a href="logout.php" class="btn btn-secondary">Sign Out</a>
        </div>
    </div>
</body>
</html>