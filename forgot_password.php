<?php
session_start();
include 'db_connection.php';

/* ---------- SAFE DEFAULTS (NO NOTICES) ---------- */
$step   = isset($_POST['step']) ? $_POST['step'] : 1;
$role   = isset($_POST['role']) ? $_POST['role'] : '';
$value  = isset($_POST['value']) ? $_POST['value'] : '';

$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm  = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

$error = '';
$success = '';

/* ---------- FORM LOGIC ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* STEP 1 : VERIFY USER */
    if ($step == 1) {

        if ($role === 'student' || $role === 'parent') {
            $sql = "SELECT id FROM users WHERE email='$value' AND role='$role'";
        } elseif ($role === 'instructor') {
            $sql = "SELECT id FROM instructors WHERE instructorName='$value'";
        } else {
            $sql = '';
        }

        if ($sql != '') {
            $res = mysqli_query($conn, $sql);
            if ($res && mysqli_num_rows($res) == 1) {
                $step = 2;
            } else {
                $error = "Account not found. Please check details.";
            }
        }
    }

    /* STEP 2 : RESET PASSWORD */
    if ($step == 2) {

        if ($password === '' || $confirm === '') {
            $error = "Please fill both password fields.";
        } elseif ($password !== $confirm) {
            $error = "Passwords do not match.";
        } else {

            $hash = password_hash($password, PASSWORD_DEFAULT);

            if ($role === 'student' || $role === 'parent') {
                $update = "UPDATE users SET password='$hash' WHERE email='$value' AND role='$role'";
            } elseif ($role === 'instructor') {
                $update = "UPDATE instructors SET password='$hash' WHERE instructorName='$value'";
            }

            if (mysqli_query($conn, $update)) {
                $success = "Password reset successful. You may login now.";
                $step = 1;
                $role = '';
                $value = '';
            } else {
                $error = "Database error occurred.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="form-theme.css">

<script>
function toggleField() {
    var role = document.getElementById("role").value;
    var label = document.getElementById("valueLabel");
    var input = document.getElementById("value");

    if (role === "instructor") {
        label.innerText = "Instructor Name";
        input.placeholder = "Enter instructor name";
    } else {
        label.innerText = "Email Address";
        input.placeholder = "Enter email address";
    }
}
</script>
</head>

<body>

<div class="form-card">
    <h2>🔐 Forgot Password</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">

        <?php if ($step == 1): ?>
            <input type="hidden" name="step" value="1">

            <div class="mb-3">
                <label>Select Role</label>
                <select name="role" id="role" class="form-control" onchange="toggleField()" required>
                    <option value="" disabled selected>Select role</option>
                    <option value="student">Student</option>
                    <option value="parent">Parent</option>
                    <option value="instructor">Instructor</option>
                </select>
            </div>

            <div class="mb-3">
                <label id="valueLabel">Email Address</label>
                <input type="text" name="value" id="value" class="form-control" required>
            </div>

            <button class="btn-submit">Verify Account</button>

        <?php else: ?>
            <input type="hidden" name="step" value="2">
            <input type="hidden" name="role" value="<?php echo $role; ?>">
            <input type="hidden" name="value" value="<?php echo $value; ?>">

            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>

            <button class="btn-submit">Reset Password</button>
        <?php endif; ?>

        <div class="login-link mt-3">
            Back to <a href="user/user_login.php">Login</a>
        </div>

    </form>
</div>

</body>
</html>
