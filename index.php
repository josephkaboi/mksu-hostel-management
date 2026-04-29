<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MKSU Hostel | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .login-card { max-width: 400px; margin: 100px auto; }
    </style>
</head>
<body>
    <div class="card login-card shadow">
        <div class="card-header bg-success text-white text-center">
            <h4>MKSU Hostel Login</h4>
        </div>
        <div class="card-body">
            <form action="process_login.php" method="POST">
                <div class="mb-3">
                    <label>Admission Number</label>
                    <input type="text" name="admission" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Login</button>
                <div class="mt-3 text-center">
                    <a href="register.php">Don't have an account? Register</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>