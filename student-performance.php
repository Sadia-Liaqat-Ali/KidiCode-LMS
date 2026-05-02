<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'parent') {
    header("Location: ../login.php");
    exit;
}

$parent_id = $_SESSION['user_id'];

/* fetch linked students */
$students_sql = "
SELECT u.id AS student_id, u.username, u.email
FROM parent_student_links psl
JOIN users u ON psl.student_id = u.id
WHERE psl.parent_id=? AND psl.status='approved'
";
$stmt = $conn->prepare($students_sql);
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$students = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
<title>Parent Student Overview</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:#f8f0f5;font-family:Arial}
.content{margin-left:260px;padding:30px}
.card{background:#fff;padding:20px;border-radius:12px;box-shadow:0 5px 15px rgba(0,0,0,0.1);margin-bottom:35px}
.table th{background:#001BB7;color:#fff;text-align:center}
.table td{text-align:center}
.badge-award{background:#0046FF;color:#fff;padding:4px 10px;border-radius:10px;font-size:13px}
.cert-award{background:#FF8040;color:#fff;padding:4px 10px;border-radius:10px;font-size:13px}
h2{color:#001BB7}
.award-box{margin-top:15px}
</style>
</head>
<body>

<?php include 'parent_sidebar.php'; ?>

<div class="content">
<h2>My Children & Their Progress</h2>

<?php if($students->num_rows>0): ?>
<?php while($student=$students->fetch_assoc()): ?>
<div class="card">

<h4><?= htmlspecialchars($student['username']); ?> (<?= htmlspecialchars($student['email']); ?>)</h4>

<?php
$student_id = $student['student_id'];
$courses_sql = "
SELECT c.course_title,
       uc.assignment_submitted,
       uc.challenge_submitted,
       uc.attendance_marked,
       uc.final_grade,
       q.quiz_title,
       IFNULL(qr.obtained_marks,0) AS obtained_marks,
       IFNULL(qr.total_marks,0) AS total_marks
FROM user_courses uc
JOIN courses c ON uc.course_id=c.id
LEFT JOIN quizzes q ON q.course_id=c.id
LEFT JOIN quiz_results qr ON qr.quiz_id=q.id AND qr.user_id=uc.user_id
WHERE uc.user_id=?
ORDER BY c.course_title ASC
";
$stmt2=$conn->prepare($courses_sql);
$stmt2->bind_param("i",$student_id);
$stmt2->execute();
$courses=$stmt2->get_result();
$stmt2->close();

$awards=[];
mysqli_data_seek($courses,0);
while($r=$courses->fetch_assoc()){
    if($r['final_grade']>=70){
        $awards[]=[
            "course"=>$r['course_title'],
            "badge"=>$r['final_grade']>=70,
            "cert"=>$r['final_grade']>=90
        ];
    }
}
mysqli_data_seek($courses,0);
?>

<?php if($courses->num_rows>0): ?>
<table class="table mt-3">
<thead>
<tr>
<th>Course</th>
<th>Assignment</th>
<th>Challenge</th>
<th>Attendance</th>
<th>Quiz</th>
<th>Quiz Score</th>
<th>Marks</th>
</tr>
</thead>
<tbody>
<?php while($row=$courses->fetch_assoc()):
$marks=$row['final_grade'];
$m_class=$marks>=70?'text-success':($marks>=40?'text-warning':'text-danger');
?>
<tr>
<td><?= htmlspecialchars($row['course_title']); ?></td>
<td><?= $row['assignment_submitted']?"<a href='../uploads/{$row['assignment_submitted']}' target='_blank'>View</a>":"-"; ?></td>
<td><?= $row['challenge_submitted']?"<a href='../uploads/{$row['challenge_submitted']}' target='_blank'>View</a>":"-"; ?></td>
<td><?= $row['attendance_marked']?'100%':'0%'; ?></td>
<td><?= htmlspecialchars($row['quiz_title'] ?? '-'); ?></td>
<td><?= $row['total_marks']>0?$row['obtained_marks']."/".$row['total_marks']:"-"; ?></td>
<td class="<?= $m_class; ?>"><?= $marks; ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<?php if(count($awards)>0): ?>
<div class="award-box">
<h5>🏆 Badges & Certificates</h5>
<?php foreach($awards as $a): ?>
<div>
<b><?= htmlspecialchars($a['course']); ?>:</b>
<?php if($a['badge']) echo "<span class='badge-award ms-2'>Badge</span>"; ?>
<?php if($a['cert']) echo "<span class='cert-award ms-2'>Certificate</span>"; ?>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<?php else: ?>
<p class="text-muted mt-3">No courses found.</p>
<?php endif; ?>

</div>
<?php endwhile; ?>
<?php else: ?>
<p class="text-muted">No approved children linked yet.</p>
<?php endif; ?>
</div>

<?php $conn->close(); ?>
</body>
</html>
