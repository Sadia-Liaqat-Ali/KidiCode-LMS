<?php
session_start();
include '../db_connection.php';

// AUTH CHECK
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    echo "<script>alert('Access denied. Please login as Student.'); window.location='../UserLogin.php';</script>";
    exit();
}

$student_name = $_SESSION['username'];
$student_id = $_SESSION['user_id'];

// FETCH STUDENT DATA
$totalCourses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM user_courses WHERE user_id='$student_id'"))['total'];
$completedAssignments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM user_courses WHERE user_id='$student_id' AND assignment_submitted IS NOT NULL"))['total'];
$completedChallenges = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM user_courses WHERE user_id='$student_id' AND challenge_submitted IS NOT NULL"))['total'];
$quizzesTaken = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM quiz_results WHERE user_id='$student_id'"))['total'];

$overallAttendanceData = mysqli_query($conn, "SELECT attendance_marked FROM user_courses WHERE user_id='$student_id'");
$totalAttendanceRows = mysqli_num_rows($overallAttendanceData);
$marked = 0;
while($row = mysqli_fetch_assoc($overallAttendanceData)){
    if($row['attendance_marked'] == 1){ $marked++; }
}
$attendancePercent = $totalAttendanceRows > 0 ? round(($marked / $totalAttendanceRows) * 100) : 0;

// Parent info
$parents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM parent_student_links WHERE student_id='$student_id' AND status='approved'"))['total'];

// Uploaded vouchers
$voucherCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM uploadvoucher WHERE user_id='$student_id'"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Dashboard | KidiCode</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --pink: #ff69b4;
    --soft-pink: #ffe5f0;
    --gray: #f2f2f7;
    --black: #222;
    --white: #ffffff;
}
body {
    background: var(--gray);
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
}
.sidebar {
    width: 250px;
    height: 100vh;
    background: var(--white);
    position: fixed;
    left: 0;
    top: 0;
    padding: 20px;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
}
.sidebar h2 {
    font-weight: 700;
    color: var(--pink);
    text-align: center;
    margin-bottom: 30px;
}
.sidebar a {
    display: block;
    padding: 12px;
    margin: 8px 0;
    color: var(--black);
    text-decoration: none;
    font-weight: 500;
    border-radius: 10px;
    transition: 0.3s;
}
.sidebar a:hover {
    background: var(--soft-pink);
    color: var(--pink);
}
.main {
    margin-left: 270px;
    padding: 30px;
}
.welcome-card {
    background: var(--pink);
    color: var(--white);
    padding: 30px;
    border-radius: 18px;
    margin-bottom: 30px;
    box-shadow: 0 8px 20px rgba(255,105,180,0.3);
}
.feature-card {
    background: var(--white);
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    text-align: center;
    transition: 0.3s;
}
.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.12);
}
.feature-card i {
    font-size: 35px;
    color: var(--pink);
    margin-bottom: 15px;
}
.feature-card p {
    font-size: 28px;
    font-weight: bold;
    margin-top: 10px;
    color: var(--pink);
}
</style>
</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="main">

    <div class="welcome-card">
        <h1>Hello, <?php echo $student_name; ?> 👋</h1>
        <p>Welcome back! Here’s a quick snapshot of your learning journey 🌟</p>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="feature-card">
                <i class="fa fa-book"></i>
                <h4>Enrolled Courses</h4>
                <p><?php echo $totalCourses; ?></p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card">
                <i class="fa fa-paperclip"></i>
                <h4>Assignments Submitted</h4>
                <p><?php echo $completedAssignments; ?></p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card">
                <i class="fa fa-bolt"></i>
                <h4>Challenges Submitted</h4>
                <p><?php echo $completedChallenges; ?></p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card">
                <i class="fa fa-lightbulb"></i>
                <h4>Quizzes Taken</h4>
                <p><?php echo $quizzesTaken; ?></p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card">
                <i class="fa fa-user-friends"></i>
                <h4>Parents Linked</h4>
                <p><?php echo $parents; ?></p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card">
                <i class="fa fa-percent"></i>
                <h4>Attendance %</h4>
                <p><?php echo $attendancePercent; ?>%</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card">
                <i class="fa fa-file-upload"></i>
                <h4>Vouchers Uploaded</h4>
                <p><?php echo $voucherCount; ?></p>
            </div>
        </div>

    </div>

</div>

</body>
</html>
