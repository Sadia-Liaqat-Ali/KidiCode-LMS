<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['instructor_name']) || !isset($_SESSION['instructor_id'])) {
    header("Location: instructor_login.php");
    exit();
}

$instructorName = $_SESSION['instructor_name'];
$instructorId = $_SESSION['instructor_id'];

// Handle delete
if (isset($_GET['delete'])) {
    $course_id = intval($_GET['delete']);
    // Delete course materials first
    $sql_del_mat = "DELETE FROM course_materials WHERE course_id = $course_id";
    mysqli_query($conn, $sql_del_mat);
    // Delete course
    $sql_del = "DELETE FROM courses WHERE id = $course_id AND instructor_id = $instructorId";
    mysqli_query($conn, $sql_del);
    echo "<script>alert('Course deleted successfully'); window.location='manage_courses.php';</script>";
    exit();
}

// Fetch courses
$sql = "SELECT * FROM courses WHERE instructor_id = $instructorId";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Courses | KidiCode</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: #f0f2f5; font-family: 'Poppins', sans-serif; }
.content { margin-left: 260px; padding: 20px; }
.card { background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding:20px; }
h2 { font-weight: bold; margin-bottom: 20px; color:#E83C91; }
th { background-color: #E83C91; color: white; }
.btn-add { background-color: #E83C91; color: #fff; }
.btn-add:hover { background-color: #d32f70; }
.btn-edit { background: #ffc107; color: #212529; border:none; padding:5px 10px; border-radius:5px; }
.btn-edit:hover { background: #e0a800; color:#fff; }
.btn-delete { background: #dc3545; color:#fff; border:none; padding:5px 10px; border-radius:5px; }
.btn-delete:hover { background: #b02a37; }
</style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="content">
    <div class="card">
        <h2>My Courses</h2>
        <a href="create_course.php" class="btn btn-primary mb-3">+ Add New Course</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Actions</th>
                    <th>Students</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $count = 1;
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$count}</td>
                        <td>".htmlspecialchars($row['course_title'])."</td>
                        <td>".htmlspecialchars($row['course_type'])."</td>
                        <td>
                            <a href='edit_course.php?id={$row['id']}' class='btn btn-info'>Edit</a>
                            <a href='manage_courses.php?delete={$row['id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure to delete this course?\");'>Delete</a>
                        </td>
                        <td>
                        <a href='view_student.php?id={$row['id']}' class='btn btn-outline-success'>View Students</a>

</td>
                    </tr>";
                    $count++;
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No courses found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
