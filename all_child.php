<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'parent') {
    header("Location: ../login.php");
    exit;
}

$parent_id = $_SESSION['user_id'];

// Handle delete pending request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt_del = $conn->prepare("DELETE FROM parent_student_links WHERE id=? AND parent_id=? AND status='pending'");
    $stmt_del->bind_param("ii", $delete_id, $parent_id);
    $stmt_del->execute();
    $stmt_del->close();
}

// Fetch all children and pending requests
$sql = "
SELECT 
    psl.id AS link_id,
    u.UserName,
    u.Email,
    psl.status,
    psl.requested_at,
    u.id AS student_id
FROM parent_student_links psl
JOIN Users u ON psl.student_id = u.id
WHERE psl.parent_id=?
ORDER BY psl.status ASC, u.UserName ASC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$results = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>All Children & Requests</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family: Arial, sans-serif; background:#f8f0f5; margin:230; }
.content { margin-left:260px; padding:30px; }
.table-custom { width:100%; border-collapse: collapse; background-color:white; box-shadow:0 0 10px rgba(0,0,0,0.1); border-radius:10px; }
.table-custom th, .table-custom td { padding:12px; text-align:center; border-bottom:1px solid #ccc; }
.table-custom th { background:#E83C91; color:#fff; }
.table-custom tr:hover { background:#ffe0f5; }
.btn-check { background:#001BB7; color:#fff; padding:5px 10px; border-radius:6px; text-decoration:none; }
.btn-check:hover { background:#0046FF; }
.btn-delete { background:#FF6B81; color:#fff; padding:5px 10px; border-radius:6px; text-decoration:none; }
.btn-delete:hover { background:#E83C91; }
h2 { margin-bottom:20px; }
</style>
</head>
<body>

<?php include 'parent_sidebar.php'; ?>

<div class="content">
    <h2>All Children & Requests</h2>
    <table class="table-custom">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Requested At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if($results->num_rows > 0): $i=1; ?>
                <?php while($row = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= htmlspecialchars($row['UserName']); ?></td>
                        <td><?= htmlspecialchars($row['Email']); ?></td>
                        <td><?= ucfirst($row['status']); ?></td>
                        <td><?= $row['requested_at']; ?></td>
                        <td>
                            <?php if($row['status']=='approved'): ?>
                                <a href="student_activity.php?student_id=<?= $row['student_id'] ?>" class="btn-check">Check Learning</a>
                            <?php else: ?>
                                <a href="?delete_id=<?= $row['link_id'] ?>" class="btn-delete" onclick="return confirm('Delete pending request?')">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding:20px;">No children or requests found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $conn->close(); ?>
</body>
</html>
v