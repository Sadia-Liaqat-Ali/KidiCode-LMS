<?php
session_start();
include '../db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT id, instructorName, Password FROM instructors WHERE instructorName='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['Password'])) {
            $_SESSION['instructor_id'] = $row['id'];
            $_SESSION['instructor_name'] = $row['instructorName'];

            header("Location: dashboard.php");
            exit;
        } else {
            echo "<script>alert('Incorrect password');</script>";
        }
    } else {
        echo "<script>alert('Username not registered');</script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Instructor Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- THEME CSS FILE (no internal css now) -->
<link rel="stylesheet" href="../form-theme.css">

</head>

<body>

<div class="form-card" style="max-width:450px;">
    <h2><i class="fas fa-chalkboard-teacher me-2"></i>Instructor Sign In</h2>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Enter username" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter password" required>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-sign-in-alt me-2"></i>Login
        </button>

        <div class="login-link">
            Don't have an account? <a href="../instructor_register.php">Register here</a>
        </div>
         <div class="login-link">
          <a href="../forgot_password.php">Forgot Password</a>
        </div>

    </form>
</div>

</body>
</html>
```
