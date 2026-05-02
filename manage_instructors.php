<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../db_connection.php';

// Delete Instructor
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM instructors WHERE id = $id");
    echo "<script>alert('Instructor Deleted Successfully'); window.location='manage_instructors.php';</script>";
}

// Update Status
if (isset($_GET['status']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    $allowed = ['pending', 'approved', 'rejected'];
    if (in_array($status, $allowed)) {
        mysqli_query($conn, "UPDATE instructors SET status='$status' WHERE id=$id");
        echo "<script>alert('Status Updated Successfully'); window.location='manage_instructors.php';</script>";
    }
}

// Fetch Instructors
$instructors = [];
$result = mysqli_query($conn, "SELECT * FROM instructors");
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $instructors[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Instructors | Admin</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css"> <!-- Correct path -->
<style>
    :root {
    --primary: #E83C91;
    --primary-dark: #43334C;
    --bg: #F8F4EC;
    --light-gray: #e9ecef;
    --success: #28a745;
    --danger: #dc3545;
    --gray: #6c757d;
}
body { font-family: 'Poppins', sans-serif; background-color: var(--bg); margin: 0; }
/* Only minimal page-specific tweaks if needed */
.sidebar { width: 250px; position: fixed; top: 0; left: 0; height: 100%; }
.content { margin-left: 270px; padding: 20px; }
img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; }
.btn-sm { margin-bottom: 5px; }
.table-container { background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 20px; }
.table thead th { background-color: var(--primary); color: #fff; padding: 12px; border: none; }
.table tbody tr:hover { background-color: #f2e9f0; }
.table tbody td { padding: 12px; border-bottom: 1px solid var(--light-gray); vertical-align: middle; }
.form-control { border-radius: 8px; padding: 10px 15px; border: 1px solid var(--light-gray); margin-bottom: 10px; }
.form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 0.2rem rgba(232,60,145,0.25); }
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <?php include 'sidebar_admin.php'; ?>
</div>

<div class="content">
    <h2 class="text-center mb-4">Registered Instructors</h2>

    <div class="table-container">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Qualification</th>
                    <th>Category</th>
                    <th>Experience</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($instructors) > 0): ?>
                    <?php foreach($instructors as $row): ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><img src="../img/<?= $row['instructorPicture']; ?>" alt="Image"></td>
                        <td><?= $row['instructorName']; ?></td>
                        <td><?= $row['instructorQualification']; ?></td>
                        <td><?= $row['instructorCategory']; ?></td>
                        <td><?= $row['instructorExperience']; ?> yrs</td>
                        <td><?= $row['instructorMobile']; ?></td>
                        <td><?= ucfirst($row['status']); ?></td>
                        <td>
                            <a href="manage_instructors.php?status=approved&id=<?= $row['id']; ?>" class="btn btn-sm btn-success">Approve</a>
                            <a href="manage_instructors.php?status=rejected&id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Reject</a>
                            <a href="manage_instructors.php?status=pending&id=<?= $row['id']; ?>" class="btn btn-sm btn-secondary">Pending</a>
                            <a href="manage_instructors.php?delete=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this instructor?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="text-center">No instructors found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
