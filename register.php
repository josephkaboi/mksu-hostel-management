<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MKSU Hostel | Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .register-card { max-width: 400px; margin: 50px auto; }
    </style>
</head>
<body>
    <div class="card register-card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h4>MKSU Registration</h4>
        </div>
        <div class="card-body">
            <form action="process_register.php" method="POST">
                <div class="mb-3">
                    <label>Full Name</label>
                    <input type="text" name="fullname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Admission Number</label>
                    <input type="text" name="admission" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Choose Hostel</label>
                    <select name="hostel" class="form-select">
                        <option value="Hostel A">Hostel A</option>
                        <option value="Hostel B">Hostel B</option>
                        <option value="Hostel C">Hostel C</option>
                        <option value="Hostel D">Hostel D</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Create Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
        </div>
    </div>
</body>
</html>