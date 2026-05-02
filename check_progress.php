<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['tutor_id'])) {
    echo "<script>alert('Please login first.'); window.location='tutor_login.php';</script>";
    exit();
}

$tutorID = $_SESSION['tutor_id'];

if (!isset($_GET['quiz_id'])) {
    echo "<script>alert('Quiz not specified.'); window.location='view_quizzes.php';</script>";
    exit();
}

$quiz_id = $_GET['quiz_id'];

// Fetch quiz title
$stmt_quiz = $conn->prepare("SELECT quiz_title FROM quizzes WHERE id = ? AND tutor_id = ?");
$stmt_quiz->bind_param("ii", $quiz_id, $tutorID);
$stmt_quiz->execute();
$result_quiz = $stmt_quiz->get_result();

if ($result_quiz->num_rows == 0) {
    echo "<script>alert('Invalid quiz ID.'); window.location='view_quizzes.php';</script>";
    exit();
}

$quiz = $result_quiz->fetch_assoc();

// Fetch attempted users
$stmt_users = $conn->prepare("
    SELECT qr.*, u.name, u.email 
    FROM quiz_results qr
    JOIN users u ON qr.user_id = u.id
    WHERE qr.quiz_id = ?
");
$stmt_users->bind_param("i", $quiz_id);
$stmt_users->execute();
$result_users = $stmt_users->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Progress for <?= htmlspecialchars($quiz['quiz_title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'tutor_sidebar.php'; ?>

<div class="content p-4" style="margin-left: 260px;">
    <div class="card p-4">
        <h3>Progress: <?= htmlspecialchars($quiz['quiz_title']); ?></h3>
        <hr>
        <?php if ($result_users->num_rows > 0) { ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Score</th>
                        <th>Total Questions</th>
                        <th>Percentage</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($row = $result_users->fetch_assoc()) {
                        $percentage = ($row['score'] / $row['total_questions']) * 100;
                    ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= $row['score']; ?></td>
                            <td><?= $row['total_questions']; ?></td>
                            <td><?= round($percentage, 2); ?>%</td>
                            <td><?= $row['created_at']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-info">No user has attempted this quiz yet.</div>
        <?php } ?>
    </div>
</div>

</body>
</html>
