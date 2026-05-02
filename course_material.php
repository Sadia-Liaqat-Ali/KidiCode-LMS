<?php
session_start();
include("../db_connection.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student'){
    header("Location: ../UserLogin.php");
    exit();
}

$user_id   = $_SESSION['user_id'];
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($course_id <= 0){
    header("Location: courses.php");
    exit();
}

/* ===============================
   FETCH COURSE + STATUS
================================= */

$course = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT c.*, i.instructorName, i.instructorPicture 
    FROM courses c
    LEFT JOIN instructors i ON c.instructor_id = i.id
    WHERE c.id = $course_id
"));

$status = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM user_courses 
    WHERE user_id=$user_id AND course_id=$course_id
"));

$materials = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM course_materials WHERE course_id=$course_id
"));

$class_data = mysqli_query($conn,"
    SELECT * FROM class_links WHERE course_id=$course_id ORDER BY class_date DESC
");

/* FETCH QUIZZES */
$quiz_data = mysqli_query($conn,"
    SELECT * FROM quizzes WHERE course_id=$course_id ORDER BY id DESC
");

$alert = "";

/* ==========================
   SUBMIT ASSIGNMENT
=========================== */
if(isset($_POST['submit_assignment'])){
    $f = $_FILES['assignment_file']['name'];
    if($f!=""){
        $file = time()."_".$f;
        move_uploaded_file($_FILES['assignment_file']['tmp_name'], "../uploads/submitted_assignments/".$file);

        mysqli_query($conn,"
            UPDATE user_courses SET assignment_submitted='$file'
            WHERE user_id=$user_id AND course_id=$course_id
        ");

        $alert = "Assignment uploaded!";
        $status['assignment_submitted'] = $file;
    }
}

/* ==========================
   SUBMIT CHALLENGE
=========================== */
if(isset($_POST['submit_challenge'])){
    $f = $_FILES['challenge_file']['name'];
    if($f!=""){
        $file = time()."_".$f;
        move_uploaded_file($_FILES['challenge_file']['tmp_name'], "../uploads/submitted_challenges/".$file);

        mysqli_query($conn,"
            UPDATE user_courses SET challenge_submitted='$file'
            WHERE user_id=$user_id AND course_id=$course_id
        ");

        $alert = "Challenge uploaded!";
        $status['challenge_submitted'] = $file;
    }
}

/* ==========================
   MARK ATTENDANCE
=========================== */
if(isset($_POST['mark_attendance'])){
    mysqli_query($conn,"
        UPDATE user_courses SET attendance_marked=1
        WHERE user_id=$user_id AND course_id=$course_id
    ");

    $alert = "Attendance marked!";
    $status['attendance_marked'] = 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Course Material</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body{
        background:#f5f7fa;
        font-family:'Poppins',sans-serif;
    }

    .layout-wrapper{
        display:flex;
        gap:25px;
    }

    .left-side{
        width:72%;
    }

    .right-side{
        width:28%;
    }

    .box{
        background:white;
        padding:22px;
        border-radius:14px;
        box-shadow:0 4px 12px rgba(0,0,0,0.08);
        border:1px solid #e6e6e6;
        margin-bottom:25px;
    }

    h3,h4{
        font-weight:600;
        color:#1d2b3a;
    }

    .table thead{
        background:#ff4fa3;
        color:white;
    }

    .btn-main{
        background:#0046FF;
        color:white;
        border:none;
        border-radius:7px;
        padding:7px 16px;
        font-size:14px;
    }

    .btn-secondary{
        background:#001BB7;
        color:white;
        border:none;
        border-radius:7px;
        padding:7px 16px;
        font-size:14px;
    }

    .btn-download{
        background:#FF8040;
        text-decoration: none;
        color:white;
        border:none;
        border-radius:7px;
        padding:7px 16px;
        font-size:14px;
    }

    .status-badge{
        background:#001BB7;
        color:white;
        padding:6px 14px;
        border-radius:12px;
        font-size:13px;
    }

    .instruction-box{
        background:#fff1fb;
        border-left:6px solid #ff4fa3;
        padding:15px;
        border-radius:10px;
        margin-bottom:25px;
    }

    .instructor-card{
        text-align:center;
        padding:20px;
        background:#ffffff;
        border-radius:14px;
        box-shadow:0 4px 12px rgba(0,0,0,0.08);
        border:1px solid #e6e6e6;
    }

    .instructor-card img{
        width:110px;
        height:110px;
        object-fit:cover;
        border-radius:50%;
        margin-bottom:10px;
        border:3px solid #ff4fa3;
    }

</style>
</head>

<body>

<?php include 'sidebar.php'; ?>

<div style="margin-left:250px;" class="container">

<?php if($alert!=""){ ?>
<div class="alert alert-info">
    <?php echo $alert; ?>
</div>
<?php } ?>

<div class="layout-wrapper">

<!-- LEFT SIDE -->
<div class="left-side">

    <!-- RECORDED VIDEO -->
    <div class="box">
        <h4>Recorded Lecture</h4>
        <?php if($materials['video_path']){ ?>
        <video width="100%" controls>
            <source src="../uploads/<?php echo $materials['video_path']; ?>">
        </video>
        <?php }else{ echo "No video available."; } ?>
    </div>

    <!-- CLASS LINKS -->
    <div class="box">
        <h4>Live Class Sessions</h4>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Topic</th>
                    <th>Join</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row=mysqli_fetch_assoc($class_data)){ ?>
            <tr>
                <td><?php echo $row['class_date']; ?></td>
                <td><?php echo $row['class_time']; ?></td>
                <td><?php echo $row['topic']; ?></td>
                <td>
                    <a class="btn-main btn-sm" href="<?php echo $row['class_link']; ?>" target="_blank">Join</a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- READING -->
    <div class="box">
        <h4>Reading Material</h4>
        <?php if($materials['reading_material_path']){ ?>
            <a class="btn-download" href="../uploads/<?php echo $materials['reading_material_path']; ?>" download>Download Material</a>
        <?php } else { echo "No reading material."; } ?>
    </div>

    <!-- INSTRUCTIONS -->
    <div class="instruction-box">
        <p><b>Submission Rules:</b></p>
        <ul>
            <li>Every activity (Assignment, Challenge, Quiz) can be submitted once only.</li>
            <li>Re-submission is strictly not allowed.</li>
            <li>Download the file, study carefully, then submit.</li>
            <li>Your submission status will appear immediately after upload.</li>
        </ul>
    </div>

    <!-- ASSIGNMENT -->
    <div class="box">
        <h4>Assignment</h4>

        <?php if($status['assignment_submitted']){ ?>
            <span class="status-badge">Submitted</span>
            <br><br>
            <a class="btn-download" href="../uploads/submitted_assignments/<?php echo $status['assignment_submitted']; ?>" download>Download Submitted File</a>
        <?php } else { ?>
            <?php if($materials['assignment_path']){ ?>
                <a class="btn-main" href="../uploads/<?php echo $materials['assignment_path']; ?>" download>Download Assignment</a>
            <?php } ?>
            <form method="post" enctype="multipart/form-data" class="mt-3">
                <input type="file" class="form-control" name="assignment_file" required>
                <button type="submit" class="btn-secondary mt-2" name="submit_assignment">Submit Assignment</button>
            </form>
        <?php } ?>
    </div>

    <!-- CODING CHALLENGE -->
    <div class="box">
        <h4>Coding Challenge</h4>

        <?php if($status['challenge_submitted']){ ?>
            <span class="status-badge">Submitted</span>
            <br><br>
            <a class="btn-download" href="../uploads/submitted_challenges/<?php echo $status['challenge_submitted']; ?>" download>Download Submitted File</a>
        <?php } else { ?>

            <?php 
                $challenge_file = mysqli_fetch_assoc(mysqli_query($conn,"SELECT challenge_file FROM class_links WHERE course_id=$course_id AND challenge_file!='' LIMIT 1"));
            ?>

            <?php if($challenge_file){ ?>
                <a class="btn-main" href="../<?php echo $challenge_file['challenge_file']; ?>" download>Download Challenge</a>
            <?php } ?>

            <form method="post" enctype="multipart/form-data" class="mt-3">
                <input type="file" name="challenge_file" class="form-control" required>
                <button name="submit_challenge" class="btn-secondary mt-2">Submit Challenge</button>
            </form>

        <?php } ?>
    </div>

    <!-- QUIZZES -->
    <div class="box">
        <h4>Quizzes</h4>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Quiz</th>
                    <th>Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php while($q=mysqli_fetch_assoc($quiz_data)){ 
                $qid = $q['id'];
                $check = mysqli_fetch_assoc(mysqli_query($conn,"
                    SELECT * FROM quiz_results
                    WHERE quiz_id=$qid AND user_id=$user_id
                "));
            ?>
            <tr>
                <td><?php echo $q['quiz_title']; ?></td>
                <td><?php echo $q['quiz_description']; ?></td>

                <td>
                    <?php if($check){ ?>
                        <span class="status-badge">Submitted</span>
                        <a class="btn-main btn-sm mt-2" href="quiz_result.php?quiz_id=<?php echo $qid; ?>&course_id=<?php echo $course_id; ?>">View Result</a>
                    <?php } else { ?>
                        <a class="btn-secondary btn-sm" href="start_quiz.php?quiz_id=<?php echo $qid; ?>&course_id=<?php echo $course_id; ?>">Take Quiz</a>
                    <?php } ?>
                </td>

            </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>

</div>

<!-- RIGHT SIDE -->
<div class="right-side">

    <div class="instructor-card">
        <img src="../uploads/<?php echo $course['instructorPicture']; ?>">
        <h5><?php echo $course['instructorName']; ?></h5>
        <p style="margin:0; color:#555;">Course Instructor</p>
    </div>

</div>

</div>

</div>
</body>
</html>
