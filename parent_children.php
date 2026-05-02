<?php
/* =========================
   parent_children.php
   ========================= */
session_start();
include '../db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'parent') {
    echo "<script>alert('Please login as parent'); window.location='../login.php';</script>";
    exit;
}

$parent_id = $_SESSION['user_id'];

$students = mysqli_query($conn,"
    SELECT u.id, u.username, u.email
    FROM parent_student_links p
    JOIN users u ON u.id = p.student_id
    WHERE p.parent_id='$parent_id' AND p.status='approved'
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Parent Dashboard</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
body{background:#f5f1dc}
.sidebar{width:250px;position:fixed;top:0;left:0;height:100vh;background:#001BB7;padding:20px;color:#fff}
.main{margin-left:270px;padding:30px}
.card{margin-bottom:25px;border-radius:12px}
th{background:#0046FF;color:#fff}
h2{color:#001BB7}
</style>
</head>
<body>

<div class="sidebar">
<?php include 'parent_sidebar.php'; ?>
</div>

<div class="main">
<h2>My Children</h2>

<?php if(mysqli_num_rows($students)>0){ ?>
<?php while($stu=mysqli_fetch_assoc($students)){ ?>

<div class="card p-3">
<h4><?= $stu['username']; ?> (<?= $stu['email']; ?>)</h4>

<?php
$courses = mysqli_query($conn,"
    SELECT c.id,c.course_title
    FROM user_courses uc
    JOIN courses c ON c.id=uc.course_id
    WHERE uc.user_id='{$stu['id']}'
");
?>

<?php if(mysqli_num_rows($courses)>0){ ?>
<table class="table mt-3">
<tr>
<th>Course</th>
<th>Action</th>
</tr>
<?php while($c=mysqli_fetch_assoc($courses)){ ?>
<tr>
<td><?= $c['course_title']; ?></td>
<td>
<a class="btn btn-sm btn-primary"
href="student-performance.php?student_id=<?= $stu['id']; ?>&course_id=<?= $c['id']; ?>">
View Performance
</a>
</td>
</tr>
<?php } ?>
</table>
<?php }else{ ?>
<p>No courses enrolled.</p>
<?php } ?>

</div>
<?php } ?>
<?php }else{ ?>
<p>No approved children linked yet.</p>
<?php } ?>
</div>
</body>
</html>
