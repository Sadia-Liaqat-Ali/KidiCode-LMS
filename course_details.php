<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../UserLogin.php");
    exit();
}

$student_id = $_SESSION['user_id'];
$course_id  = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($course_id <= 0) {
    header("Location: courses.php");
    exit();
}

// Fetch course + instructor info (FIXED — ALWAYS SHOW)
$sql = "SELECT 
            c.*, 
            i.instructorName, 
            i.instructorPicture, 
            i.instructorMobile, 
            i.instructorQualification, 
            i.instructorCategory, 
            i.instructorExperience, 
            i.instructorAddress
        FROM courses c
        LEFT JOIN instructors i ON c.instructor_id = i.id
        WHERE c.id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$res = $stmt->get_result();
$course = $res->fetch_assoc();

if (!$course) {
    echo "<script>alert('Course not found'); window.location='courses.php';</script>";
    exit();
}

// Enrollment Check
$enrolled = false;
$accessMaterial = false;

$checkEnroll = $conn->prepare("SELECT * FROM user_courses WHERE user_id=? AND course_id=?");
$checkEnroll->bind_param("ii", $student_id, $course_id);
$checkEnroll->execute();
$checkResult = $checkEnroll->get_result();

if ($checkResult->num_rows > 0) {
    $enrolled = true;
    $accessMaterial = true;
}

// Enrollment Logic
if (isset($_POST['enroll'])) {

    if ($course['course_type'] == 'Free') {

        if (!$enrolled) {
            $insertEnroll = $conn->prepare("INSERT INTO user_courses (user_id,course_id) VALUES (?,?)");
            $insertEnroll->bind_param("ii", $student_id, $course_id);
            $insertEnroll->execute();
            $enrolled = true;
            $accessMaterial = true;
            $msg = "You successfully enrolled!";
        }

    } else { // premium

        $voucherCheck = $conn->prepare("SELECT * FROM uploadvoucher WHERE user_id=? AND status='verify'");
        $voucherCheck->bind_param("i", $student_id);
        $voucherCheck->execute();
        $voucherResult = $voucherCheck->get_result();

        if ($voucherResult->num_rows > 0) {

            if (!$enrolled) {
                $insertEnroll = $conn->prepare("INSERT INTO user_courses (user_id,course_id) VALUES (?,?)");
                $insertEnroll->bind_param("ii", $student_id, $course_id);
                $insertEnroll->execute();
                $enrolled = true;
                $accessMaterial = true;
                $msg = "You successfully enrolled!";
            }

        } else {
            echo "<script>alert('Please buy subscription plan first!'); window.location='plan.php';</script>";
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title><?= htmlspecialchars($course['course_title']) ?> | KidiCode</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    background:#f6f7fb;
    font-family:'Poppins', sans-serif;
}
.page-wrapper{
    margin-left:260px;
    padding:30px;
}

/* MAIN HEADER */
.course-banner{
    display:flex; 
    flex-wrap:wrap; 
    gap:35px;
    background:#fff; 
    padding:25px; 
    border-radius:18px; 
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
}
.course-image img{
    width:100%; 
    height:280px; 
    object-fit:cover; 
    border-radius:15px;
}
.course-title{
    font-size:28px;
    font-weight:700;
    color:#b10040;
}

/* TAGS */
.tag-pill{
    display:inline-block;
    background:#ffe6f0;
    color:#b10040;
    padding:6px 16px;
    border-radius:20px;
    margin:6px 6px 0 0;
    font-size:13px;
    font-weight:600;
}

/* INSTRUCTOR CARD */
.instructor-card{
    background:white;
    border-radius:15px;
    padding:25px;
    display:flex;
    align-items:center;
    gap:20px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
}
.instructor-card img{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #b10040;
}

/* LEARN SECTION */
.learn-section{
    margin-top:35px;
    background:white;
    padding:30px;
    border-radius:18px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
}
.learn-title{
    font-size:24px;
    font-weight:700;
    color:#b10040;
    margin-bottom:20px;
}
.tick-item{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:16px;
    margin-bottom:12px;
}
.tick-item i{
    color:green;
    font-size:22px;
}

/* FEATURES ICON GRID */
.feature-grid{
    margin-top:30px;
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:25px;
}
.feature-box{
    background:white;
    padding:25px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 5px 20px rgba(0,0,0,0.07);
    transition:0.3s;
}
.feature-box:hover{
    transform:translateY(-7px);
    box-shadow:0 12px 30px rgba(0,0,0,0.12);
}
.feature-box i{
    font-size:55px;
    color:#b10040;
    margin-bottom:12px;
}
.feature-box h6{
    font-weight:700;
    font-size:17px;
}
.feature-box p{
    font-size:14px;
    color:#666;
}
</style>

</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="page-wrapper">

<!-- COURSE HEADER -->
<div class="course-banner">

    <div class="course-image">
            <img src="../uploads/<?= htmlspecialchars($course['course_image'] ?: 'default_course.png') ?>" alt="Course Image">
    </div>

    <div class="course-info">
        <div class="course-title"><?= htmlspecialchars($course['course_title']) ?></div>
        <p><?= nl2br(htmlspecialchars($course['course_description'])) ?></p>

        <span class="tag-pill">Age Group: <?= $course['age_group'] ?></span>
        <span class="tag-pill"><?= $course['course_type']=='Free'?'Free Course':'Premium Course' ?></span>
        <span class="tag-pill"><?= $course['scorm_xapi_integration']?'SCORM/xAPI Enabled':'Standard Course' ?></span>
        <span class="tag-pill">Created: <?= date("M d, Y", strtotime($course['created_at'])) ?></span>

        <form method="POST" class="mt-4">
            <?php if($accessMaterial): ?>
                <a href="course_material.php?id=<?= $course_id ?>" class="btn btn-success">Access Material</a>
            <?php else: ?>
                <button name="enroll" class="btn btn-primary">Enroll Now</button>
            <?php endif; ?>
        </form>

        <?php if(isset($msg)): ?>
        <div class="alert alert-success mt-3"><?= $msg ?></div>
        <?php endif; ?>
    </div>

</div>

<!-- INSTRUCTOR CARD -->
<div class="instructor-card mt-4">
    <img src="../uploads/<?= $course['instructorPicture'] ?: 'default_user.png' ?>">
    <div>
        <h5><?= htmlspecialchars($course['instructorName'] ?: "Unknown Instructor") ?></h5>
        <p><b>Qualification:</b> <?= htmlspecialchars($course['instructorQualification']) ?></p>
        <p><b>Category:</b> <?= htmlspecialchars($course['instructorCategory']) ?></p>
        <p><b>Experience:</b> <?= htmlspecialchars($course['instructorExperience']) ?> years</p>
        <p><b>Mobile:</b> <?= htmlspecialchars($course['instructorMobile']) ?></p>
        <p><b>Address:</b> <?= htmlspecialchars($course['instructorAddress']) ?></p>
    </div>
</div>

<!-- WHAT YOU WILL LEARN -->
<div class="learn-section">
    <div class="learn-title">What You Will Learn</div>

    <div class="tick-item"><i class="fa-solid fa-check"></i> Interactive live classes every week.</div>
    <div class="tick-item"><i class="fa-solid fa-check"></i> Pre-class reminders & study material.</div>
    <div class="tick-item"><i class="fa-solid fa-check"></i> Real coding challenges & tasks.</div>
    <div class="tick-item"><i class="fa-solid fa-check"></i> Homework, quizzes & tests.</div>
    <div class="tick-item"><i class="fa-solid fa-check"></i> 6-month structured skill roadmap.</div>
    <div class="tick-item"><i class="fa-solid fa-check"></i> Earn badges, rewards & certificate.</div>
</div>

<!-- FEATURES GRID (UPDATED — BIGGER ICONS + 2 ROWS) -->
<div class="feature-grid">

    <div class="feature-box">
        <i class="fa-solid fa-medal"></i>
        <h6>Badges & Achievements</h6>
        <p>Unlock badges as you complete challenges.</p>
    </div>

    <div class="feature-box">
        <i class="fa-solid fa-certificate"></i>
        <h6>Official Certificate</h6>
        <p>Receive a verified certificate after completion.</p>
    </div>

    <div class="feature-box">
        <i class="fa-solid fa-laptop-code"></i>
        <h6>Coding Challenges</h6>
        <p>Improve coding skills with real problems.</p>
    </div>

    <div class="feature-box">
        <i class="fa-solid fa-book-open"></i>
        <h6>Full Course Access</h6>
        <p>All lessons & materials unlocked for you.</p>
    </div>

    <div class="feature-box">
        <i class="fa-solid fa-chart-line"></i>
        <h6>Progress Tracking</h6>
        <p>Your learning performance analysed in real-time.</p>
    </div>

    <div class="feature-box">
        <i class="fa-solid fa-globe"></i>
        <h6>SCORM/xAPI Support</h6>
        <p>Advanced LMS tracking for professional learning.</p>
    </div>

</div>

</div>

</body>
</html>
