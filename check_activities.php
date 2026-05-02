<?php
session_start();
include '../db_connection.php';

// Session check
if (!isset($_SESSION['instructor_name']) || !isset($_SESSION['instructor_id'])) {
    header("Location: instructor_login.php");
    exit();
}

$instructorId = $_SESSION['instructor_id'];

// GET params
if (!isset($_GET['student_id']) || !isset($_GET['course_id'])) {
    die("Student ID or Course ID missing.");
}

$student_id = intval($_GET['student_id']);
$course_id  = intval($_GET['course_id']);

// Verify instructor owns course
$sql_check = "SELECT id, course_title FROM courses WHERE id=$course_id AND instructor_id=$instructorId";
$res_check = mysqli_query($conn, $sql_check);
if (!$res_check) die("DB error: ".mysqli_error($conn));
if (mysqli_num_rows($res_check)==0) die("Invalid course or no access.");
$course_row = mysqli_fetch_assoc($res_check);
$course_title = htmlspecialchars($course_row['course_title']);

// Fetch student info
$sql_student = "SELECT username, email FROM users WHERE id=$student_id";
$res_student = mysqli_query($conn, $sql_student);
$student_row = mysqli_fetch_assoc($res_student);

// Fetch submissions
$sql_submission = "SELECT * FROM user_courses WHERE user_id=$student_id AND course_id=$course_id";
$res_submission = mysqli_query($conn, $sql_submission);
$submission = mysqli_fetch_assoc($res_submission);

// Fetch quizzes
$sql_quiz = "SELECT q.quiz_title, qr.total_marks, qr.obtained_marks
             FROM quizzes q
             LEFT JOIN quiz_results qr ON q.id=qr.quiz_id AND qr.user_id=$student_id
             WHERE q.course_id=$course_id";
$res_quiz = mysqli_query($conn, $sql_quiz);

// Calculate submission % for grading
$total_activities = 0;
$submitted_activities = 0;

// Attendance (50 marks)
$total_activities += 1;
$submitted_activities += $submission['attendance_marked'] ? 1 : 0;

// Assignment (40 marks)
$total_activities += 1;
$submitted_activities += !empty($submission['assignment_submitted']) ? 1 : 0;

// Challenge (10 marks)
$total_activities += 1;
$submitted_activities += !empty($submission['challenge_submitted']) ? 1 : 0;

// Quiz % for table only (not included in %)
$quiz_results = [];
$res_quiz = mysqli_query($conn, $sql_quiz);
while($quiz = mysqli_fetch_assoc($res_quiz)){
    $quiz_results[] = $quiz;
}

// Overall submission %
$submission_percent = round(($submitted_activities/$total_activities)*100,2);

// Handle manual grading form submit
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['manual_marks'])){
    $manual_marks = floatval($_POST['manual_marks']);
    mysqli_query($conn,"UPDATE user_courses SET final_grade=$manual_marks WHERE user_id=$student_id AND course_id=$course_id");
    header("Location: check_activities.php?student_id=$student_id&course_id=$course_id");
    exit();
}

// Ensure final_grade column exists
mysqli_query($conn,"ALTER TABLE user_courses ADD COLUMN IF NOT EXISTS final_grade FLOAT DEFAULT 0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Activities — <?php echo $course_title; ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family:'Poppins',sans-serif; background:#f0f2f5; }
.content { margin-left:260px; padding:22px; }
.card { background:#fff; border-radius:10px; padding:20px; box-shadow:0 0 10px rgba(0,0,0,0.06); }
h2 { color:#001BB7; font-weight:700; }
h3.badge-percent { color:#fff; background:#FF0046; padding:10px 15px; font-size:22px; font-weight:bold; border-radius:8px; display:inline-block; }
th { background:#001BB7; color:#fff; text-align:center; }
td { text-align:center; }
.btn-back { background:#6c757d; color:#fff; border-radius:6px; padding:6px 12px; text-decoration:none; }
.progress { height: 25px; }
.form-mini { max-width:120px; display:inline-block; }
</style>
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="content">
<div class="card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2>Student Activities</h2>
            <div style="color:#444;"><?php echo $student_row['username']; ?> — <?php echo $course_title; ?></div>
        </div>
        <a href="manage_courses.php" class="btn-back">← Back</a>
    </div>

    <div class="row">
        <!-- RHS: Overall % badge -->
        <div class="col-md-12 mb-3 text-end">
            <h3 class="badge-percent">Overall Student Submission: <?php echo $submission_percent; ?>%</h3>
        </div>

        <!-- Table -->
        <div class="col-md-12 mb-4">
            <h5>Submission Status</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Activity</th>
                    <th>Status</th>
                    <th>Download</th>
                </tr>
                <tr>
                    <td>Attendance (50%)</td>
                    <td><?php echo $submission['attendance_marked']?'Present':'Absent'; ?></td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Assignment (40%)</td>
                    <td><?php echo !empty($submission['assignment_submitted'])?'Submitted':'Not Submitted'; ?></td>
                    <td>
                    <?php if(!empty($submission['assignment_submitted'])): ?>
                        <a href="<?php echo htmlspecialchars($submission['assignment_submitted']); ?>" download class="btn btn-sm btn-success">Download</a>
                    <?php else: ?> - <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Challenge (10%)</td>
                    <td><?php echo !empty($submission['challenge_submitted'])?'Submitted':'Not Submitted'; ?></td>
                    <td>
                    <?php if(!empty($submission['challenge_submitted'])): ?>
                        <a href="<?php echo htmlspecialchars($submission['challenge_submitted']); ?>" download class="btn btn-sm btn-success">Download</a>
                    <?php else: ?> - <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Quizzes</td>
                    <td colspan="2">
                        <ul class="list-unstyled">
                        <?php foreach($quiz_results as $q): ?>
                            <li>Quiz Result : <?php echo intval($q['obtained_marks'])."/".intval($q['total_marks']); ?></li>
                        <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Bottom row: LHS Manual form / RHS Grading Scheme -->
        <div class="col-md-3">
            <form method="post">
                <label>Manual Marks (0-100)</label>
                <input type="number" name="manual_marks" class="form-control form-mini" min="0" max="100" required>
                <button type="submit" class="btn btn-primary mt-2 btn-sm">Update Grade</button>
            </form>
        </div>

        <div class="col-md-9">
            <h5>Grading Scheme</h5>
            <ul>
                <li>Attendance : 50 marks</li>
                <li>Assignment : 40 marks</li>
                <li>Challenge : 10 marks</li>
                <li>Quizzes : based on obtained marks</li>
                <li>Manual override : Instructor can adjust marks above</li>
            </ul>
            <h5>Final Grade: <?php echo $submission['final_grade']; ?> / 100</h5>
        </div>
    </div>
</div>
</div>
</body>
</html>
