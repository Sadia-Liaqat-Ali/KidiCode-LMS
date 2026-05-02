<?php
session_start();
include("../db_connection.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student'){
    header("Location: ../UserLogin.php");
    exit();
}

$student_id = intval($_SESSION['user_id']);

// Fetch student results with attendance and quiz info
$query = "
    SELECT 
        c.course_title AS course_name,
        uc.assignment_submitted AS assignment_file,
        uc.challenge_submitted AS challenge_file,
        uc.attendance_marked AS attendance,
        uc.final_grade AS final_grade,
        q.quiz_title AS quiz_title,
        IFNULL(qr.obtained_marks, 0) AS quiz_obtained,
        IFNULL(qr.total_marks, 0) AS quiz_total
    FROM user_courses uc
    JOIN courses c ON uc.course_id = c.id
    LEFT JOIN quizzes q ON q.course_id = c.id
    LEFT JOIN quiz_results qr ON qr.quiz_id = q.id AND qr.user_id = uc.user_id
    WHERE uc.user_id = $student_id
    ORDER BY c.course_title ASC
";
$result = mysqli_query($conn, $query);

// Collect courses with badges/certificates for bottom showcase
$awards = [];
mysqli_data_seek($result, 0);
while($row = mysqli_fetch_assoc($result)) {
    $marks = $row['final_grade'];
    $badge = $marks >= 70;
    $cert = $marks >= 90;
    if($badge || $cert) {
        $awards[] = [
            "course" => $row['course_name'],
            "badge" => $badge,
            "cert" => $cert
        ];
    }
}
mysqli_data_seek($result, 0); // reset pointer for table
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../style.css" rel="stylesheet">
    <style>
        body { background:#f8f7fc; font-family:Arial; }
        .sidebar { width:260px; background:#001BB7; height:100vh; position:fixed; left:0; top:0; color:#fff; padding:20px; }
        .sidebar h3 { color:#FF8040; margin-bottom:30px; }
        .sidebar a { color:#fff; display:block; margin:10px 0; text-decoration:none; font-weight:bold; }
        .sidebar a:hover { text-decoration:none; }
        .content-area { margin-left:280px; padding:30px; }
        .results-table { background:#fff; padding:20px; border-radius:15px; box-shadow:0 5px 20px rgba(0,0,0,0.1); }
        table { width:100%; border-collapse:collapse; }
        th, td { padding:12px; border-bottom:1px solid #ddd; text-align:left; }
        th { background:#001BB7; color:#fff; }
        .marks-box { font-weight:bold; padding:4px 10px; border-radius:6px; display:inline-block; }
        .green { background:#d4f5d2; color:#0a7c00; }
        .orange { background:#ffe9cc; color:#d96f00; }
        .red { background:#ffd0d0; color:#c40000; }
        .badge { background:#0046FF; color:white; padding:5px 10px; border-radius:10px; font-size:14px; margin-top:5px; display:inline-block; }
        .certificate { background:#FF8040; color:white; padding:5px 10px; border-radius:10px; font-size:14px; margin-top:5px; display:inline-block; }
        .awards-showcase { margin-top:50px; display:flex; flex-wrap:wrap; gap:20px; justify-content:center; }
        .award-card { background:#fff; border-radius:15px; padding:30px; text-align:center; box-shadow:0 5px 20px rgba(0,0,0,0.1); width:220px; cursor:pointer; transition:0.3s; }
        .award-card:hover { transform:scale(1.05); }
        .award-icon { font-size:50px; margin-bottom:10px; }
        .grading-bottom { margin-top:30px; background:#f0f0f0; padding:20px; border-radius:15px; }
    </style>
</head>
<body>

<?php include 'sidebar.php' ?>
<div class="content-area">
    <h2 class="text-center mb-4">📘 My Course Results</h2>

    <div class="results-table">
        <table class="table">
            <tr>
                <th>Course</th>
                <th>Assignment</th>
                <th>Coding Challenge</th>
                <th>Attendance</th>
                <th>Quiz</th>
                <th>Quiz Score</th>
                <th>Marks</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)) {
                $marks = $row['final_grade'];
                if($marks >= 70) $m_class = "green";
                else if($marks >= 40) $m_class = "orange";
                else $m_class = "red";
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                <td><?php echo $row['assignment_file'] ? "<a href='../uploads/{$row['assignment_file']}' target='_blank'>View</a>" : "-"; ?></td>
                <td><?php echo $row['challenge_file'] ? "<a href='../uploads/{$row['challenge_file']}' target='_blank'>View</a>" : "-"; ?></td>
                <td><?php echo $row['attendance'] ? "100%" : "0%"; ?></td>
                <td><?php echo $row['quiz_title'] ? htmlspecialchars($row['quiz_title']) : "-"; ?></td>
                <td><?php echo $row['quiz_total'] > 0 ? $row['quiz_obtained']."/".$row['quiz_total'] : "-"; ?></td>
                <td><span class="marks-box <?php echo $m_class; ?>"><?php echo $marks; ?></span></td>
            </tr>
            <?php } ?>
        </table>

        <!-- Grading scheme at bottom -->
        <div class="grading-bottom">
            <h4>🎖 Grading Scheme</h4>
            <p><b>70+ Marks:</b> Earn a <span class="badge">Badge</span></p>
            <p><b>90+ Marks:</b> Earn a <span class="certificate">Certificate</span></p>
            <hr>
            <h5>Color Meaning:</h5>
            <p><span class="marks-box green">Green</span> Excellent</p>
            <p><span class="marks-box orange">Orange</span> Average</p>
            <p><span class="marks-box red">Red</span> Needs Improvement</p>
        </div>
    </div>

    <?php if(count($awards) > 0) { ?>
    <h3 class="text-center mt-5">🏆 Congratulations!</h3>
    <div class="awards-showcase">
        <?php foreach($awards as $award) { ?>
        <div class="award-card" onclick="window.open('award_detail.php?course=<?php echo urlencode($award['course']); ?>','_blank')">
            <div class="award-icon">
                <?php if($award['cert']) echo "📜"; else echo "🎖"; ?>
            </div>
            <h5><?php echo $award['course']; ?></h5>
            <div>
                <?php if($award['cert']) echo "<span class='certificate'>Certificate</span>"; ?>
                <?php if($award['badge']) echo "<span class='badge'>Badge</span>"; ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>

</div>
</body>
</html>
