<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['instructor_id'])) {
    header("Location: instructor_login.php");
    exit();
}

$instructorId = $_SESSION['instructor_id'];

if (!isset($_GET['id'])) {
    header("Location: manage_courses.php");
    exit();
}

$course_id = intval($_GET['id']);

// FETCH COURSE + MATERIALS
$q = "SELECT c.*, m.video_path, m.assignment_path, m.reading_material_path 
      FROM courses c 
      LEFT JOIN course_materials m ON c.id = m.course_id
      WHERE c.id=$course_id AND c.instructor_id=$instructorId";

$r = mysqli_query($conn,$q);
if(mysqli_num_rows($r)!=1){
    echo "<script>alert('Course not found'); window.location='manage_courses.php';</script>";
    exit();
}
$course = mysqli_fetch_assoc($r);

// UPDATE
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $title = $_POST['course_title'];
    $desc = $_POST['course_description'];
    $age_group = $_POST['age_group'];
    $ctype = $_POST['course_type'];
    $scorm = isset($_POST['scorm']) ? 1 : 0;

    // existing files
    $assignmentFile = $course['assignment_path'];
    $readingFile    = $course['reading_material_path'];
    $videoFile      = $course['video_path'];
    $imageFile      = $course['course_image'];

    // -------- FILE UPLOADS ----------
    if(!empty($_FILES['assignment']['name'])){
        $newA = time()."_".$_FILES['assignment']['name'];
        move_uploaded_file($_FILES['assignment']['tmp_name'], "../uploads/".$newA);
        $assignmentFile = $newA;
    }

    if(!empty($_FILES['reading']['name'])){
        $newR = time()."_".$_FILES['reading']['name'];
        move_uploaded_file($_FILES['reading']['tmp_name'], "../uploads/".$newR);
        $readingFile = $newR;
    }

    if(!empty($_FILES['video']['name'])){
        $newV = time()."_".$_FILES['video']['name'];
        move_uploaded_file($_FILES['video']['tmp_name'], "../uploads/".$newV);
        $videoFile = $newV;
    }

    if(!empty($_FILES['image']['name'])){
        $newI = time()."_".$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$newI);
        $imageFile = $newI;
    }

    // UPDATE COURSE TABLE
    $upd = "UPDATE courses SET 
            course_title='$title',
            course_description='$desc',
            age_group='$age_group',
            course_type='$ctype',
            scorm_xapi_integration=$scorm,
            course_image='$imageFile'
            WHERE id=$course_id AND instructor_id=$instructorId";

    mysqli_query($conn,$upd);

    // UPDATE MATERIALS TABLE
    $check = mysqli_query($conn,"SELECT * FROM course_materials WHERE course_id=$course_id");

    if(mysqli_num_rows($check)==1){
        $u2 = "UPDATE course_materials SET 
                video_path='$videoFile',
                assignment_path='$assignmentFile',
                reading_material_path='$readingFile'
               WHERE course_id=$course_id";
        mysqli_query($conn,$u2);
    } else {
        $u3 = "INSERT INTO course_materials 
               (course_id, video_path, assignment_path, reading_material_path)
               VALUES ($course_id, '$videoFile', '$assignmentFile', '$readingFile')";
        mysqli_query($conn,$u3);
    }

    echo "<script>alert('Course updated successfully'); window.location='manage_courses.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Edit Course</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>

<style>
body{ background:#f2f2f7; font-family:'Poppins'; }
.content{ margin-left:260px; padding:20px; }
.box{
    background:#fff; padding:25px; border-radius:12px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
    max-width:850px; margin:auto;
}
h2{ color:#E83C91; font-weight:700; }
.file-preview{ font-size:14px; margin-top:5px; color:#555; }
</style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class='content'>
<div class='box'>
<h2>Edit Course</h2>

<form method='POST' enctype='multipart/form-data'>

    <div class='mb-3'>
        <label>Course Title</label>
        <input type='text' name='course_title' class='form-control'
        value='<?= htmlspecialchars($course['course_title']) ?>' required>
    </div>

    <div class='mb-3'>
        <label>Description</label>
        <textarea name='course_description' rows='5' class='form-control' required><?= htmlspecialchars($course['course_description']) ?></textarea>
    </div>

    <div class='mb-3'>
        <label>Age Group</label>
        <select name='age_group' class='form-select'>
            <option <?= $course['age_group']=='3-5'?'selected':'' ?>>3-5</option>
            <option <?= $course['age_group']=='5-7'?'selected':'' ?>>5-7</option>
            <option <?= $course['age_group']=='7-10'?'selected':'' ?>>7-10</option>
            <option <?= $course['age_group']=='10-12'?'selected':'' ?>>10-12</option>
        </select>
    </div>

    <div class='mb-3'>
        <label>Course Type</label>
        <select name='course_type' id='ct' class='form-select'>
            <option value='Free' <?= $course['course_type']=='Free'?'selected':'' ?>>Free</option>
            <option value='Premium' <?= $course['course_type']=='Premium'?'selected':'' ?>>Premium</option>
        </select>
    </div>

    <div class='mb-3 form-check'>
        <input type='checkbox' class='form-check-input' name='scorm'
        <?= $course['scorm_xapi_integration']?'checked':'' ?>>
        Enable SCORM/xAPI
    </div>

    <hr>

    <div class='mb-3'>
        <label>Course Image</label>
        <input type='file' name='image' class='form-control'>
        <?php if($course['course_image']): ?>
            <div class='file-preview'>Current: <?= $course['course_image'] ?></div>
        <?php endif; ?>
    </div>

    <div class='mb-3'>
        <label>Assignment File</label>
        <input type='file' name='assignment' class='form-control'>
        <?php if($course['assignment_path']): ?>
            <div class='file-preview'>Current: <?= $course['assignment_path'] ?></div>
        <?php endif; ?>
    </div>

    <div class='mb-3'>
        <label>Reading Material</label>
        <input type='file' name='reading' class='form-control'>
        <?php if($course['reading_material_path']): ?>
            <div class='file-preview'>Current: <?= $course['reading_material_path'] ?></div>
        <?php endif; ?>
    </div>

    <div class='mb-3'>
        <label>Recorded Video</label>
        <input type='file' name='video' class='form-control'>
        <?php if($course['video_path']): ?>
            <div class='file-preview'>Current: <?= $course['video_path'] ?></div>
        <?php endif; ?>
    </div>

    <button style=" background-color: #E83C91;" class='btn w-100'>Update Course</button>

</form>

</div>
</div>

</body>
</html>
