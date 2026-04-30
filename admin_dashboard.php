<?php
session_start();
require 'db_connect.php';

// Security: If not an admin go back to login
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch all students from the database
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    // Search by name OR admission number
    $query = "SELECT * FROM users WHERE role = 'student' AND (full_name LIKE '%$search%' OR admission_no LIKE '%$search%')";
} else {
    // Default: Show all students
    $query = "SELECT * FROM users WHERE role = 'student'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | MKSU Hostel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-left { background-color: #f8d7da !important; color: #721c24; } /* Red for left */
        .status-active { background-color: #d4edda !important; color: #155724; } /* Green for active */
    </style>
</head>
<body class="p-4">
    <?php
// Calculate occupancy for each hostel
$hostels = ['Hostel A', 'Hostel B', 'Hostel C', 'Hostel D'];
$capacity = 16;
?>

<div class="row mb-4">
    <?php foreach ($hostels as $h): 
        // Count active students in this specific hostel
        $count_sql = "SELECT COUNT(*) as total FROM users WHERE hostel_name = '$h' AND status = 'active'";
        $count_res = mysqli_query($conn, $count_sql);
        $count_data = mysqli_fetch_assoc($count_res);
        $current_total = $count_data['total'];
        
        // Determine color
        $color = ($current_total >= $capacity) ? 'danger' : 'primary';
    ?>
    <div class="col-md-3">
        <div class="card bg-<?php echo $color; ?> text-white shadow">
            <div class="card-body text-center">
                <h6><?php echo $h; ?></h6>
                <h3><?php echo $current_total; ?> / <?php echo $capacity; ?></h3>
                <small><?php echo ($capacity - $current_total); ?> Rooms Left</small>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>MKSU Hostel Administration</h2>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <div class="row mb-3">
    <div class="col-md-6">
        <form action="admin_dashboard.php" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by Name or Admission No..." value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-outline-primary">Search</button>
            <?php if($search != ""): ?>
                <a href="admin_dashboard.php" class="btn btn-outline-secondary ms-2">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card shadow">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Full Name</th>
                            <th>Admission No</th>
                            <th>Hostel</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr class="<?php echo ($row['status'] == 'left') ? 'status-left' : ''; ?>">
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['admission_no']; ?></td>
            
                        <td>
                <?php 
                    if(!empty($row['hostel_name'])) {
                        echo $row['hostel_name'];
                    } else {
                       echo '<span class="badge bg-secondary">Unassigned</span>';
                }
                ?>
            </td>

            <td>
                <?php 
                    if($row['status'] == 'active' && !empty($row['hostel_name'])) {
                        echo '<span class="badge bg-success">Active</span>';
                    } elseif ($row['status'] == 'left') {
                        echo '<span class="badge bg-danger">Left</span>';
                    } else {
                        echo '<span class="badge bg-warning text-dark">Pending Room</span>';
                    }
                ?>
            </td>

            <td>
                <?php if(empty($row['hostel_name'])): ?>
                    <a href="assign_room.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Assign Room</a>
                
                <?php elseif($row['status'] == 'active'): ?>
                    <a href="mark_left.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Mark as Left</a>
                
                <?php else: ?>
                    <a href="re_admit.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Re-admit</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>