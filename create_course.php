<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['instructor_name']) || !isset($_SESSION['instructor_id'])) {
    header("Location: instructor_login.php");
    exit();
}

$instructorName = $_SESSION['instructor_name'];
$instructorId = $_SESSION['instructor_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['course_title'];
    $age_group = $_POST['age_group']; // updated field
    $course_type = $_POST['course_type'];
    $scorm = isset($_POST['scorm']) ? 1 : 0;

    $course_image = '';
    if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] == 0) {
        $img_dir = 'uploads/images/';
        if (!is_dir($img_dir)) mkdir($img_dir, 0777, true);
        $course_image = $img_dir . time() . '_' . basename($_FILES['course_image']['name']);
        move_uploaded_file($_FILES['course_image']['tmp_name'], $course_image);
    }

    // Insert course without fee column
    $sql = "INSERT INTO courses (instructor_id, course_title, age_group, course_type, scorm_xapi_integration, course_image)
            VALUES ($instructorId, '$title', '$age_group', '$course_type', $scorm, '$course_image')";
    if (mysqli_query($conn, $sql)) {
        $courseId = mysqli_insert_id($conn);

        $video_path = $assignment_path = $reading_path = '';
        if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
            $video_path = 'uploads/videos/' . time() . '_' . basename($_FILES['video']['name']);
            move_uploaded_file($_FILES['video']['tmp_name'], $video_path);
        }
        if (isset($_FILES['assignment']) && $_FILES['assignment']['error'] == 0) {
            $assignment_path = 'uploads/assignments/' . time() . '_' . basename($_FILES['assignment']['name']);
            move_uploaded_file($_FILES['assignment']['tmp_name'], $assignment_path);
        }
        if (isset($_FILES['reading_material']) && $_FILES['reading_material']['error'] == 0) {
            $reading_path = 'uploads/materials/' . time() . '_' . basename($_FILES['reading_material']['name']);
            move_uploaded_file($_FILES['reading_material']['tmp_name'], $reading_path);
        }

        $sql2 = "INSERT INTO course_materials (course_id, video_path, assignment_path, reading_material_path)
                 VALUES ($courseId, '$video_path', '$assignment_path', '$reading_path')";
        mysqli_query($conn, $sql2);

        echo "<script>alert('Course created successfully!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Course | KidiCode</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root { --primary: #E83C91; --primary-dark: #C42B7A; }
body { font-family: 'Poppins', sans-serif; background: #f5f7fb; margin:0; }
.sidebar { width: 250px; position: fixed; height: 100%; background-color: #343a40; color: #fff; padding-top: 20px; }
.main-content { margin-left: 250px; padding: 30px; }
.container-form { max-width: 800px; background: #fff; padding: 30px; border-radius: 12px; box-shadow:0 5px 20px rgba(0,0,0,0.05); }
h2 { color: var(--primary); margin-bottom: 20px; }
.form-control, .form-select { border-radius: 8px; padding: 12px; }
.btn-submit { background-color: var(--primary); color: #fff; border:none; padding:10px; width:100%; border-radius:8px; }
.btn-submit:hover { background-color: var(--primary-dark); }
</style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="container-form">
        <h2>Create New Course</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Course Title</label>
                <input type="text" class="form-control" name="course_title" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Age Group</label>
                <select class="form-select" name="age_group" required>
                    <option value="3-5">3 to 5 years</option>
                    <option value="5-7">5 to 7 years</option>
                    <option value="7-9">7 to 9 years</option>
                    <option value="9-12">9 to 12 years</option>
                    <option value="12-15">12 to 15 years</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Course Type</label>
                <select class="form-select" name="course_type" required>
                    <option value="Free">Free</option>
                    <option value="Premium">Premium</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Course Image</label>
                <input type="file" class="form-control" name="course_image" accept="image/*">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="scorm" id="scorm">
                <label class="form-check-label" for="scorm">Enable SCORM/xAPI Integration</label>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Video Tutorial</label>
                <input type="file" class="form-control" name="video" accept="video/*">
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Assignment (Word)</label>
                <input type="file" class="form-control" name="assignment" accept=".doc,.docx">
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Reading Material (PDF)</label>
                <input type="file" class="form-control" name="reading_material" accept=".pdf">
            </div>

            <button type="submit" class="btn-submit">Create Course</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
