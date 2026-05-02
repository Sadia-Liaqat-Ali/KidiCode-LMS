<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include '../db_connection.php';
$oldEmail = $_SESSION['email'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $oldEmail);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST["username"];
    $contact  = $_POST["contact"];
    $email    = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("UPDATE users SET username = ?, contact = ?, email = ?, password = ? WHERE email = ?");
    $stmt->bind_param("sssss", $username, $contact, $email, $password, $oldEmail);
    if ($stmt->execute()) {
        $_SESSION['email'] = $email;
        $success = true;
        $user['username'] = $username;
        $user['contact'] = $contact;
        $user['email'] = $email;
        $user['password'] = $password;
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            margin: 0;
        }
        .main-content {
            margin-left: 220px;
            padding: 20px;
        }
        .form-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: auto;
        }
        .confirmation {
            background-color: #dff0d8;
            padding: 15px;
            border-radius: 10px;
            color: #3c763d;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <?php include 'sidebar_user.php'; ?>

    <div class="main-content">
        <div class="container mt-4">
            <div class="form-box">
                <h4 class="mb-3">Edit Profile</h4>
                <?php if ($success): ?>
                    <div class="confirmation">✅ Profile updated successfully!</div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $user['username']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact</label>
                        <input type="text" class="form-control" name="contact" value="<?php echo $user['contact']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" class="form-control" name="password" value="<?php echo $user['password']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
