<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: user_login.php");
    exit();
}
include '../db_connection.php';

// Fetch user data using email
$stmt = $conn->prepare("SELECT UserName, Email, Contact FROM Users WHERE Email = ?");
$stmt->bind_param("s", $_SESSION["email"]);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eef9ff;
        }
        .container-box {
            background-color: #fff;
            padding: 30px;
            margin-top: 40px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .sidebar {
            background-color: #0dcaf0;
            height: 100vh;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 sidebar">
            <?php include 'sidebar_user.php'; ?>
        </div>
        <div class="col-md-9">
            <div class="container container-box">
                <h3 class="text-center text-primary mb-4">Edit Your Profile</h3>

                <?php if (isset($_SESSION['updateMsg'])): ?>
                    <div class="alert alert-info"><?= $_SESSION['updateMsg']; unset($_SESSION['updateMsg']); ?></div>
                <?php endif; ?>

                <?php if ($userData): ?>
                <form action="update_profile.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username:</label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($userData['UserName']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($userData['Email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact:</label>
                        <input type="text" name="contact" class="form-control" value="<?= htmlspecialchars($userData['Contact']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password:</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter new password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                        <a href="welcome.php" class="btn btn-secondary mt-2">Cancel</a>
                    </div>
                </form>
                <?php else: ?>
                    <div class="alert alert-danger">User data not found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
