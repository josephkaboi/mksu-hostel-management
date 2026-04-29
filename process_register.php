<?php
// 1. Connect to the database
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2. Get data from the form
    $fullname = $_POST['fullname'];
    $admission = $_POST['admission'];
    // $hostel = $_POST['hostel'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure the password!

    // 3. Prepare the SQL command
    $sql = "INSERT INTO users (full_name, admission_no, password, role, status) 
            VALUES ('$fullname', '$admission', '$password', 'student', 'active')";

    // 4. Execute and check
    if (mysqli_query($conn, $sql)) {
        echo "Registration successful! <a href='index.php'>Login here</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>