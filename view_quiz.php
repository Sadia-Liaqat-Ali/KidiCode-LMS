<?php
session_start();
include '../db_connection.php';

// Check user login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first.'); window.location='../login.php';</script>";
    exit();
}

$userID = $_SESSION['user_id'];

// Get user's enrolled courses
$sql_courses = "SELECT course_id FROM user_courses WHERE user_id = ?";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bind_param("i", $userID);
$stmt_courses->execute();
$result_courses = $stmt_courses->get_result();

$courseIDs = [];
while ($row = $result_courses->fetch_assoc()) {
    $courseIDs[] = $row['course_id'];
}

if (count($courseIDs) > 0) {
    $placeholders = implode(',', array_fill(0, count($courseIDs), '?'));

    $sql = "SELECT q.*, c.course_name, t.tutorName 
            FROM quizzes q 
            JOIN courses c ON q.course_id = c.id 
            JOIN tutors t ON q.tutor_id = t.id 
            WHERE q.course_id IN ($placeholders)";
    
    $stmt = $conn->prepare($sql);
    $types = str_repeat('i', count($courseIDs));
    $stmt->bind_param($types, ...$courseIDs);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Quizzes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<?php include 'sidebar_user.php'; ?>

<div class="content">
    <div class="card p-4">
        <h2 class="mb-4">My Quizzes</h2>

        <?php if ($result && $result->num_rows > 0) { ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Quiz Title</th>
                        <th>Description</th>
                        <th>Course</th>
                        <th>Tutor</th>
                        <th>Created Date</th>
                        <th>Submitted Date</th>
                        <th>My Progress</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    while ($quiz = $result->fetch_assoc()) {
                        $quizID = $quiz['id'];

                        // Check if user submitted
                        $stmt_result = $conn->prepare("SELECT * FROM quiz_results WHERE user_id = ? AND quiz_id = ?");
                        $stmt_result->bind_param("ii", $userID, $quizID);
                        $stmt_result->execute();
                        $res = $stmt_result->get_result();

                        $submitted_date = '-';
                        $progress = '';

                        if ($res->num_rows > 0) {
                            $row = $res->fetch_assoc();
                            $obtained = $row['obtained_marks'];
                            $total = $row['total_marks'];
                            $submitted_date = date('d-M-Y h:i A', strtotime($row['submitted_at']));
                            $percentage = round(($obtained / $total) * 100);
                            $progress = "
                                <div><strong>Score:</strong> $obtained/$total</div>
                                <div class='progress mt-2' style='height: 20px;'>
                                    <div class='progress-bar bg-success' role='progressbar' style='width: $percentage%;'>
                                        $percentage%
                                    </div>
                                </div>
                            ";
                        } else {
                            $progress = "<a href='start_quiz.php?quiz_id=$quizID' class='btn btn-sm btn-success'>Take Quiz</a>";
                        }
                    ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($quiz['quiz_title']); ?></td>
                            <td><?= htmlspecialchars($quiz['quiz_description']); ?></td>
                            <td><?= htmlspecialchars($quiz['course_name']); ?></td>
                            <td><span class="badge bg-gradient bg-info text-dark p-2 fs-6"><?= htmlspecialchars($quiz['tutorName']); ?></span></td>

                            <td><?= date('d-M-Y', strtotime($quiz['created_at'])) ?></td>
                            <td><?= $submitted_date ?></td>
                            <td><?= $progress ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-info">No quizzes found for your enrolled courses.</div>
        <?php } ?>
    </div>
</div>

</body>
</html>
