<?php
session_start();
include '../db_connection.php'; // DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Simple procedural query
    $sql = "SELECT * FROM Admin WHERE Emailid='$email' AND Password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $email;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Incorrect email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KidiCode Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../form-theme.css"> <!-- your shared theme -->
</head>
<body>

<div class="form-card">
    <h2><i class="fas fa-user-shield me-2"></i>Admin Login</h2>

    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="post">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="admin@kidicode.com" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>

        <button type="submit" class="btn-submit"><i class="fas fa-sign-in-alt me-2"></i>Login</button>

        <div class="login-link">
            <a href="forgot_password.php">Forgot Password?</a>
        </div>
    </form>
</div>

</body>
</html>
