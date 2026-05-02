<?php
session_start();
include '../db_connection.php';

// -------------------------------------
// CHECK LOGIN
// -------------------------------------
if (!isset($_SESSION['instructor_id'])) {
    echo "<script>alert('Please login first.'); window.location='instructor_login.php';</script>";
    exit();
}

$instructorId = $_SESSION['instructor_id'];

// -------------------------------------
// DELETE QUIZ REQUEST
// -------------------------------------
if (isset($_GET['delete_id'])) {

    $quiz_id = intval($_GET['delete_id']);

    // ----- delete quiz questions first -----
    $sql1 = "DELETE FROM quiz_questions WHERE quiz_id = ?";
    $stmt_q = $conn->prepare($sql1);

    if (!$stmt_q) {
        die("Query Error (quiz_questions): " . $conn->error . " | SQL: " . $sql1);
    }

    $stmt_q->bind_param("i", $quiz_id);
    $stmt_q->execute();

    // ----- delete quiz -----
    $sql2 = "DELETE FROM quizzes WHERE id = ? AND instructor_id = ?";
    $stmt_quiz = $conn->prepare($sql2);

    if (!$stmt_quiz) {
        die("Query Error (quizzes delete): " . $conn->error . " | SQL: " . $sql2);
    }

    $stmt_quiz->bind_param("ii", $quiz_id, $instructorId);
    $stmt_quiz->execute();

    echo "<script>alert('Quiz deleted successfully.'); window.location='view_quizzes.php';</script>";
    exit();
}


// -------------------------------------
// FETCH QUIZZES BY INSTRUCTOR
// -------------------------------------
$sql = "
SELECT 
    quizzes.id,
    quizzes.quiz_title,
    quizzes.quiz_description,
    quizzes.course_id,
    courses.course_title
FROM 
    quizzes
JOIN 
    courses ON quizzes.course_id = courses.id
WHERE 
    quizzes.instructor_id = ?
";

$stmt = $conn->prepare($sql);

// CHECK PREPARE ERROR
if (!$stmt) {
    die("Query Error (fetch quizzes): " . $conn->error . " | SQL: " . $sql);
}

$stmt->bind_param("i", $instructorId);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Quizzes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f0f2f5; }
        .content { margin-left: 260px; padding: 20px; }
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        th {
        background-color: #E83C91; color: white;
        }
    </style>
</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="content">
    <div class="card">
        <h2 class="mb-4">My Quizzes</h2>

        <?php if ($result->num_rows > 0) { ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="background-color: #E83C91; color: white;">#</th>
                        <th style="background-color: #E83C91; color: white;">Quiz Title</th>
                        <th style="background-color: #E83C91; color: white;">Description</th>
                        <th style="background-color: #E83C91; color: white;">Course</th>
                        <th style="background-color: #E83C91; color: white;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; while ($quiz = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($quiz['quiz_title']); ?></td>
                        <td><?php echo htmlspecialchars($quiz['quiz_description']); ?></td>
                        <td><?php echo htmlspecialchars($quiz['course_title']); ?></td>

                        <td>
                            <a href="check_progress.php?quiz_id=<?php echo $quiz['id']; ?>" 
                               class="btn btn-sm btn-warning">
                               Check Progress
                            </a>

                            <a href="view_quizzes.php?delete_id=<?php echo $quiz['id']; ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to delete this quiz?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        <?php } else { ?>

            <div class="alert alert-info">No quizzes found.</div>

        <?php } ?>

    </div>
</div>

</body>
</html>
