```
<?php
session_start();
include("../db_connection.php");

// ==== FETCH ANALYTICS ====

$students = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='student'"))['total'];
$parents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='parent'"))['total'];
$instructors = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM instructors"))['total'];
$courses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM courses"))['total'];
$freeCourses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM courses WHERE course_type='Free'"))['total'];
$premiumCourses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM courses WHERE course_type='Premium'"))['total'];
$quizzes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM quizzes"))['total'];
$quizAttempts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM quiz_results"))['total'];
$assignments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM user_courses WHERE assignment_submitted IS NOT NULL"))['total'];
$challenges = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM user_courses WHERE challenge_submitted IS NOT NULL"))['total'];

$attendanceData = mysqli_query($conn, "SELECT attendance_marked FROM user_courses");
$totalAttendanceRows = mysqli_num_rows($attendanceData);
$marked = 0;

while($row = mysqli_fetch_assoc($attendanceData)){
    if($row['attendance_marked'] == 1){ $marked++; }
}

$attendancePercent = $totalAttendanceRows > 0 ? round(($marked / $totalAttendanceRows) * 100) : 0;
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Analytics</title>

<!-- ICONS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    margin:0;
    background:#f2f4ff;
    font-family: "Poppins", sans-serif;
    display:flex;
}



/* ===== MAIN AREA ===== */
.main{
    margin-left:280px;
    width:calc(100% - 280px);
}

.header{
    background: linear-gradient(135deg,#4c00ff,#9e52ff);
    padding:18px;
    text-align:center;
    color:white;
    font-size:28px;
    font-weight:bold;
    letter-spacing:1px;
}

.wrapper{
    width:92%;
    margin:auto;
    margin-top:30px;
}

.card-grid{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:25px;
}

.card{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 0 12px rgba(0,0,0,0.08);
    transition:0.3s;
    text-align:center;
    position:relative;
    overflow:hidden;
}

.card:hover{
    transform:translateY(-5px);
}

/* multi-color icon circles */
.icon-box{
    width:65px;
    height:65px;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:28px;
    margin:auto;
    margin-bottom:10px;
    color:white;
}
.c1{ background:#ff6b6b; }
.c2{ background:#ffa600; }
.c3{ background:#05c46b; }
.c4{ background:#0097e6; }
.c5{ background:#8c7ae6; }
.c6{ background:#e84393; }
.c7{ background:#3ae374; }
.c8{ background:#00cec9; }
.c9{ background:#fdcb6e; }
.c10{ background:#e17055; }
.c11{ background:#6c5ce7; }

.card h3{
    font-size:20px;
    color:#333;
}

.card p{
    font-size:34px;
    font-weight:bold;
    margin-top:10px;
    color:#4c00ff;
}

.footer{
    margin-top:40px;
    padding:18px;
    text-align:center;
    background:#e6d9ff;
    color:#4c0099;
    font-weight:bold;
    border-top:4px solid #6c35ff;
}
</style>
</head>

<body>
    <?php include 'sidebar_admin.php'; ?>

<div class="main">

<div class="header">Admin Analytics Dashboard</div>

<div class="wrapper">

<div class="card-grid">

    <div class="card">
        <div class="icon-box c1"><i class="fa fa-user-graduate"></i></div>
        <h3>Total Students</h3>
        <p><?php echo $students; ?></p>
    </div>

    <div class="card">
        <div class="icon-box c2"><i class="fa fa-users"></i></div>
        <h3>Total Parents</h3>
        <p><?php echo $parents; ?></p>
    </div>

    <div class="card">
        <div class="icon-box c3"><i class="fa fa-chalkboard-teacher"></i></div>
        <h3>Total Instructors</h3>
        <p><?php echo $instructors; ?></p>
    </div>

    <div class="card">
        <div class="icon-box c4"><i class="fa fa-book"></i></div>
        <h3>Total Courses</h3>
        <p><?php echo $courses; ?></p>
    </div>

    <div class="card">
        <div class="icon-box c5"><i class="fa fa-circle-check"></i></div>
        <h3>Free Courses</h3>
        <p><?php echo $freeCourses; ?></p>
    </div>

    <div class="card">
        <div class="icon-box c6"><i class="fa fa-crown"></i></div>
        <h3>Premium Courses</h3>
        <p><?php echo $premiumCourses; ?></p>
    </div>

    <div class="card">
        <div class="icon-box c7"><i class="fa fa-file-alt"></i></div>
        <h3>Total Quizzes</h3>
        <p><?php echo $quizzes; ?></p>
    </div>

    <div class="card">
        <div class="icon-box c8"><i class="fa fa-edit"></i></div>
        <h3>Quiz Attempts</h3>
        <p><?php echo $quizAttempts; ?></p>
    </div>

    <div class="card">
        <div class="icon-box c9"><i class="fa fa-paperclip"></i></div>
        <h3>Assignments Submitted</h3>
        <p><?php echo $assignments; ?></p>
    </div>

    <div class="card">
        <div class="icon-box c10"><i class="fa fa-bolt"></i></div>
        <h3>Challenges Submitted</h3>
        <p><?php echo $challenges; ?></p>
    </div>

    <div class="card">
        <div class="icon-box c11"><i class="fa fa-percent"></i></div>
        <h3>Overall Attendance %</h3>
        <p><?php echo $attendancePercent; ?>%</p>
    </div>

</div>

</div>

<div class="footer">
    Kidicode LMS – Analytics Overview
</div>

</div>

</body>
</html>
```
