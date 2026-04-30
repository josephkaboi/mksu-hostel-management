<?php
session_start();
require 'db_connect.php';

$id = $_GET['id'];
$hostels = ['Hostel A', 'Hostel B', 'Hostel C', 'Hostel D'];
$capacity = 16;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_hostel = $_POST['hostel'];
    
    // FINAL OVERBOOKING CHECK
    $check_sql = "SELECT COUNT(*) as total FROM users WHERE hostel_name = '$selected_hostel' AND status = 'active'";
    $res = mysqli_query($conn, $check_sql);
    $data = mysqli_fetch_assoc($res);

    if ($data['total'] < $capacity) {
        $update_sql = "UPDATE users SET hostel_name = '$selected_hostel', status = 'active' WHERE id = $id";
        mysqli_query($conn, $update_sql);
        header("Location: admin_dashboard.php");
    } else {
        echo "<script>alert('Error: This hostel just became full!'); window.location.href='admin_dashboard.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Hostel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="card mx-auto shadow" style="max-width: 400px;">
        <div class="card-body">
            <h4>Assign Hostel</h4>
            <form method="POST">
                <select name="hostel" class="form-select mb-3" required>
                    <option value="">Select an available hostel...</option>
                    <?php foreach($hostels as $h): 
                        // Only show hostels with space
                        $c_sql = "SELECT COUNT(*) as total FROM users WHERE hostel_name = '$h' AND status = 'active'";
                        $c_res = mysqli_query($conn, $c_sql);
                        $c_data = mysqli_fetch_assoc($c_res);
                        
                        if($c_data['total'] < $capacity): ?>
                            <option value="<?php echo $h; ?>"><?php echo $h; ?> (<?php echo $capacity - $c_data['total']; ?> spaces left)</option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary w-100">Confirm Assignment</button>
            </form>
        </div>
    </div>
</body>
</html>