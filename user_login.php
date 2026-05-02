<?php
session_start();
include '../db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT id, UserName, Password, role, Email FROM Users WHERE Email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['Password'])) {
            $_SESSION['user_id']  = $row['id'];
            $_SESSION['username'] = $row['UserName'];
            $_SESSION['role']     = $row['role'];
            $_SESSION['email']    = $row['Email'];

            if ($row['role'] == 'student') {
                header("Location: dashboard.php");
                exit;
            } elseif ($row['role'] == 'parent') {
                header("Location: ../parent/dashboard.php");
                exit;
            } else {
                echo "<script>alert('Unknown role');</script>";
            }
        } else {
            echo "<script>alert('Incorrect password');</script>";
        }
    } else {
        echo "<script>alert('Email not registered');</script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Login | KidiCode</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../form-theme.css">
</head>
<body>

<div class="form-card">
    <h2><i class="fas fa-user me-2"></i>Sign In</h2>

    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>

        <button type="submit" class="btn-submit"><i class="fas fa-sign-in-alt me-2"></i>Login</button>

        <div class="login-link">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
         <div class="login-link">
           <a href="../forgot_password.php">Forgot Password</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
