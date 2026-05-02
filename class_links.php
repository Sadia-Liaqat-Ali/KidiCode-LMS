<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['instructor_id'])) {
    echo "<script>alert('Please login first.'); window.location='instructor_login.php';</script>";
    exit();
}

$instructorID = $_SESSION['instructor_id'];
$success = false;
$deleted = false;
$edited = false;

// Handle delete request
if (isset($_GET['delete_id'])) {
    $deleteID = intval($_GET['delete_id']);
    $del_sql = "DELETE FROM class_links WHERE id = $deleteID AND instructor_id = $instructorID";
    mysqli_query($conn, $del_sql);
    $deleted = true;
}

// Handle edit request
if (isset($_POST['edit_id'])) {
    $editID = intval($_POST['edit_id']);
    $course_id = intval($_POST['course_id']);
    $class_date = $_POST['class_date'];
    $class_time = $_POST['class_time'];
    $topic = $_POST['topic'];
    $class_link = $_POST['class_link'];
    $challenge_title = $_POST['challenge_title'];
    $instructions = $_POST['instructions'];

    // File upload handling
    $file_path = '';
    if (isset($_FILES['challenge_file']) && $_FILES['challenge_file']['error'] === 0) {
        $targetDir = "../uploads/challenges/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $file_path = $targetDir . basename($_FILES['challenge_file']['name']);
        move_uploaded_file($_FILES['challenge_file']['tmp_name'], $file_path);
    }

    $update_sql = "UPDATE class_links SET 
        course_id=$course_id, class_date='$class_date', class_time='$class_time', 
        topic='$topic', class_link='$class_link', challenge_title='$challenge_title', 
        instructions='$instructions', challenge_file='$file_path' 
        WHERE id=$editID AND instructor_id=$instructorID";
    mysqli_query($conn, $update_sql);
    $edited = true;
}

// Add new class link with optional coding challenge
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['edit_id'])) {
    $course_id = intval($_POST['course_id']);
    $class_date = $_POST['class_date'];
    $class_time = $_POST['class_time'];
    $topic = $_POST['topic'];
    $class_link = $_POST['class_link'];
    $challenge_title = $_POST['challenge_title'];
    $instructions = $_POST['instructions'];

    $file_path = '';
    if (isset($_FILES['challenge_file']) && $_FILES['challenge_file']['error'] === 0) {
        $targetDir = "../uploads/challenges/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $file_path = $targetDir . basename($_FILES['challenge_file']['name']);
        move_uploaded_file($_FILES['challenge_file']['tmp_name'], $file_path);
    }

    $sql_insert = "INSERT INTO class_links (instructor_id, course_id, class_date, class_time, topic, class_link, challenge_title, instructions, challenge_file) 
                   VALUES ($instructorID, $course_id, '$class_date', '$class_time', '$topic', '$class_link', '$challenge_title', '$instructions', '$file_path')";
    mysqli_query($conn, $sql_insert);
    $success = true;
}

// Fetch courses for dropdown
$courses_sql = "SELECT id, course_title FROM courses WHERE instructor_id = $instructorID";
$courses_result = mysqli_query($conn, $courses_sql);

// Fetch all classes
$sql_classes = "SELECT cl.*, c.course_title 
                FROM class_links cl 
                JOIN courses c ON cl.course_id = c.id 
                WHERE cl.instructor_id = $instructorID 
                ORDER BY cl.class_date DESC, cl.class_time DESC";
$result_classes = mysqli_query($conn, $sql_classes);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Instructor Class Scheduler</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: #f0f2f5; }
.content { margin-left: 260px; padding: 20px; }
.card { background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding:20px; }
th { background-color: #E83C91; color: white; }
.btn-copy { background:#28a745; color:#fff; border:none; padding:5px 10px; border-radius:5px; }
.btn-delete { background:#dc3545; color:#fff; border:none; padding:5px 10px; border-radius:5px; }
</style>
<script>
function copyToClipboard(link) {
    navigator.clipboard.writeText(link).then(() => { alert("Link copied to clipboard!"); });
}
function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this class link?")) {
        window.location.href = "?delete_id=" + id;
    }
}
function showShareOptions(link, btn) {
    const shareDiv = btn.nextElementSibling;
    if (shareDiv.classList.contains('d-none')) {
        shareDiv.querySelectorAll("a")[0].href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(link)}`;
        shareDiv.querySelectorAll("a")[1].href = `https://wa.me/?text=${encodeURIComponent(link)}`;
        shareDiv.querySelectorAll("a")[2].href = `https://twitter.com/intent/tweet?url=${encodeURIComponent(link)}`;
        shareDiv.classList.remove('d-none');
    } else { shareDiv.classList.add('d-none'); }
}
</script>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="content">
    <div class="card p-4">
        <h2 class="mb-4">Add & Schedule Classes</h2>

        <?php if ($success) echo '<div class="alert alert-success">Class link scheduled successfully.</div>'; ?>
        <?php if ($deleted) echo '<div class="alert alert-danger">Class link deleted successfully.</div>'; ?>
        <?php if ($edited) echo '<div class="alert alert-info">Class link updated successfully.</div>'; ?>

        <form method="POST" class="row g-3 mb-4" enctype="multipart/form-data">
            <div class="col-md-3">
                <label class="form-label">Course</label>
                <select name="course_id" class="form-select" required>
                    <option value="">Select Course</option>
                    <?php while($course = mysqli_fetch_assoc($courses_result)) { ?>
                        <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['course_title']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2"><label class="form-label">Class Date</label><input type="date" name="class_date" class="form-control" required></div>
            <div class="col-md-2"><label class="form-label">Class Time</label><input type="time" name="class_time" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Topic</label><input type="text" name="topic" class="form-control" placeholder="Topic" required></div>
            <div class="col-md-2"><label class="form-label">Class Link</label><input type="url" name="class_link" class="form-control" placeholder="https://zoom.com" required></div>
            
            <div class="col-md-4"><label class="form-label">Challenge Title</label><input type="text" name="challenge_title" class="form-control" placeholder="Optional"></div>
            <div class="col-md-4"><label class="form-label">Instructions / Announcement</label><textarea name="instructions" class="form-control" placeholder="Optional"></textarea></div>
            <div class="col-md-4"><label class="form-label">Upload File (.txt)</label><input type="file" name="challenge_file" class="form-control" accept=".txt"></div>
            
            <div class="col-12"><button style="background-color: #E83C91; color: white;" type="submit" class="btn mt-2">Add Class Link</button></div>
        </form>

        <h4 class="mt-4">Scheduled Classes</h4>
        <?php if(mysqli_num_rows($result_classes) > 0) { ?>
            <table class="table table-bordered table-striped mt-2">
                <thead style="background: #E83C91;">
                    <tr>
                        <th>#</th><th>Course</th><th>Date</th><th>Time</th><th>Topic</th>
                        <th>Link</th><th>Challenge</th><th>Instructions</th><th>File</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; while($row = mysqli_fetch_assoc($result_classes)) { ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['course_title']) ?></td>
                        <td><?= $row['class_date'] ?></td>
                        <td><?= $row['class_time'] ?></td>
                        <td><?= htmlspecialchars($row['topic']) ?></td>
                        <td><a href="<?= $row['class_link'] ?>" target="_blank">Join</a></td>
                        <td><?= htmlspecialchars($row['challenge_title']) ?></td>
                        <td><?= htmlspecialchars($row['instructions']) ?></td>
                        <td>
                            <?php if($row['challenge_file']) { ?>
                                <a href="<?= $row['challenge_file'] ?>" download>Download</a>
                            <?php } ?>
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm" onclick="copyToClipboard('<?= $row['class_link'] ?>')">Copy</button>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['id'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-info">No classes scheduled yet.</div>
        <?php } ?>
    </div>
</div>
</body>
</html>
