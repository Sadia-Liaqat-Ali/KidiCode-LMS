<?php
session_start();
include("../db_connection.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student'){
    header("Location: ../UserLogin.php");
    exit();
}

$student_id = intval($_SESSION['user_id']);
$course_name = isset($_GET['course']) ? $_GET['course'] : '';

// Fetch course info (procedural)
$course_name_safe = mysqli_real_escape_string($conn, $course_name);
$course_query = "SELECT id, course_title FROM courses WHERE course_title = '$course_name_safe' LIMIT 1";
$course_result = mysqli_query($conn, $course_query);
$course = mysqli_fetch_assoc($course_result);

if(!$course){
    die("Course not found.");
}

// Fetch user course details
$uc_query = "SELECT final_grade, assignment_submitted, challenge_submitted, attendance_marked FROM user_courses WHERE user_id=$student_id AND course_id={$course['id']} LIMIT 1";
$uc_result = mysqli_query($conn, $uc_query);
$uc = mysqli_fetch_assoc($uc_result);

if(!$uc){
    die("You have not completed this course yet.");
}

// Determine badge or certificate
$marks = $uc['final_grade'];
$earned_badge = $marks >= 70;
$earned_cert = $marks >= 90;

// Completion date
$completion_date = date("F j, Y");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Award Details - <?php echo htmlspecialchars($course['course_title']); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
body { font-family:'Poppins', sans-serif; background:#f2f4ff; padding:30px; }
.award-container { max-width:750px; margin:auto; background:#fff; border-radius:20px; padding:40px; box-shadow:0 10px 30px rgba(0,0,0,0.1); text-align:center; }
.award-container h2 { color:#001BB7; margin-bottom:20px; font-weight:bold; }
.award-box { display:inline-block; padding:25px 40px; border-radius:20px; margin:15px; font-size:22px; font-weight:bold; color:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.1); }
.badge { background:#0046FF; }
.certificate { background: linear-gradient(135deg,#FF8040,#FFB266); position:relative; overflow:hidden; }
.certificate::after { content:""; position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.1); transform:rotate(25deg); }
.details { margin-top:30px; text-align:left; font-size:16px; line-height:1.6; }
.details p { margin:8px 0; }
.signatures { margin-top:40px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; }
.signatures div { text-align:center; flex:1; margin:10px 0; }
.signatures .line { margin-top:50px; border-top:1px solid #000; width:180px; margin-left:auto; margin-right:auto; }
.signatures img { width:70px; height:70px; margin-top:10px; border-radius:50%; }
.institute-logo { margin-top:30px; width:160px; height:auto; }
.extra-content { margin-top:30px; background:#ffe5f0; padding:20px; border-radius:15px; color:#ff3399; font-weight:500; }
</style>
</head>
<body>

<div class="award-container">
    <h2>🎉 Congratulations, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

    <?php if($earned_cert): ?>
        <div class="award-box certificate">🏆 Certificate</div>
    <?php elseif($earned_badge): ?>
        <div class="award-box badge">🎖 Badge</div>
    <?php endif; ?>

    <div class="details">
        <p><b>Course:</b> <?php echo htmlspecialchars($course['course_title']); ?></p>
        <p><b>Student:</b> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <p><b>Completion Date:</b> <?php echo $completion_date; ?></p>
        <p><b>Final Grade:</b> <?php echo $marks; ?></p>
        <p><b>Assignment Submitted:</b> <?php echo $uc['assignment_submitted'] ? "<a href='../uploads/{$uc['assignment_submitted']}' target='_blank'>View</a>" : "-"; ?></p>
        <p><b>Coding Challenge Submitted:</b> <?php echo $uc['challenge_submitted'] ? "<a href='../uploads/{$uc['challenge_submitted']}' target='_blank'>View</a>" : "-"; ?></p>
        <p><b>Attendance:</b> <?php echo $uc['attendance_marked'] ? "100%" : "0%"; ?></p>
    </div>

    <div class="extra-content">
        Completing courses unlocks your skills and achievements! Keep progressing to earn more badges and certificates 🌟
    </div>

    <div class="signatures">
       
        <div>
            <img src="../img/director.png" alt="Director Icon">
            <div class="line"></div>
            Director
        </div>
    </div>

    
</div>

</body>
</html>
