<?php
// Include database connection file
include '../db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email    = $_POST["email"];
    $password = $_POST["password"];
    $contact  = $_POST["contact"];
    $role     = $_POST["role"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users (UserName, Password, Email, Contact, role) 
            VALUES ('$username', '$hashed_password', '$email', '$contact', '$role')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Registration Successful. You can now login.');
                window.location='user_login.php';
              </script>";
    } else {
        echo "<script>alert('Registration Failed: " . mysqli_error($conn) . "');</script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Registration | KidiCode</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../form-theme.css"> <!-- linked shared theme -->
</head>
<body>

<div class="form-card">
    <h2><i class="fas fa-user-graduate me-2"></i>Create Your Account</h2>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter username" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="example@kidicode.com" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="text" name="contact" class="form-control" placeholder="03XXXXXXXXX" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="" disabled selected>Select Role</option>
                <option value="student">Student</option>
                <option value="parent">Parent</option>
            </select>
        </div>

        <button type="submit" class="btn-submit"><i class="fas fa-user-plus me-2"></i>Register Now</button>

        <div class="login-link">
            Already have an account? <a href="user_login.php">Login here</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
