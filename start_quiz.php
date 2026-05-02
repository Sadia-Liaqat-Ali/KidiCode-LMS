<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first.'); window.location='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['quiz_id'])) {
    echo "<script>alert('Quiz ID missing'); window.location='view_quiz.php';</script>";
    exit();
}

$quiz_id = intval($_GET['quiz_id']);

// Check if already attempted
$check_sql = "SELECT * FROM quiz_results WHERE user_id = ? AND quiz_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $user_id, $quiz_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo "<script>alert('You have already attempted this quiz.'); window.location='view_quiz.php';</script>";
    exit();
}

// Get all questions
$ques_sql = "SELECT * FROM quiz_questions WHERE quiz_id = ? ORDER BY id ASC";
$ques_stmt = $conn->prepare($ques_sql);
$ques_stmt->bind_param("i", $quiz_id);
$ques_stmt->execute();
$questions = $ques_stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$total_questions = count($questions);

// Handle submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_q = (int)$_POST['current_q'];
    $selected_option = $_POST['selected_option'] ?? '';

    if (!isset($_SESSION['quiz_data'])) {
        $_SESSION['quiz_data'] = [];
    }

    $_SESSION['quiz_data'][$current_q] = $selected_option;

    if ($current_q < $total_questions - 1) {
        $next_q = $current_q + 1;
        header("Location: start_quiz.php?quiz_id=$quiz_id&q=$next_q");
        exit();
    } else {
        // Calculate result
        $score = 0;
        for ($i = 0; $i < $total_questions; $i++) {
            $user_ans = $_SESSION['quiz_data'][$i] ?? '';
            $correct = $questions[$i]['correct_option'] ?? '';
            if ($user_ans === $correct) {
                $score++;
            }
        }

        $insert_sql = "INSERT INTO quiz_results (user_id, quiz_id, total_marks, obtained_marks) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iiii", $user_id, $quiz_id, $total_questions, $score);
        $insert_stmt->execute();

        unset($_SESSION['quiz_data']);

        echo "<script>alert('Quiz submitted. You scored $score out of $total_questions'); window.location='view_quiz.php';</script>";
        exit();
    }
}

// Current question index
$q = isset($_GET['q']) ? (int)$_GET['q'] : 0;

// Show error if no such question
if (!isset($questions[$q])) {
    echo "<script>alert('Invalid question number.'); window.location='view_quiz.php';</script>";
    exit();
}

$question = $questions[$q];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Take Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h4 class="mb-3">Question <?= $q + 1 ?> of <?= $total_questions ?></h4>
            <form method="POST">
                <input type="hidden" name="current_q" value="<?= $q ?>">
                <p class="mb-3"><strong><?= htmlspecialchars($question['question_text']) ?></strong></p>

                <?php if (!empty($question['option_a'])) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="selected_option" value="A" required>
                        <label class="form-check-label"><?= htmlspecialchars($question['option_a']) ?></label>
                    </div>
                <?php } ?>

                <?php if (!empty($question['option_b'])) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="selected_option" value="B" required>
                        <label class="form-check-label"><?= htmlspecialchars($question['option_b']) ?></label>
                    </div>
                <?php } ?>

                <?php if (!empty($question['option_c'])) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="selected_option" value="C" required>
                        <label class="form-check-label"><?= htmlspecialchars($question['option_c']) ?></label>
                    </div>
                <?php } ?>

                <?php if (!empty($question['option_d'])) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="selected_option" value="D" required>
                        <label class="form-check-label"><?= htmlspecialchars($question['option_d']) ?></label>
                    </div>
                <?php } ?>

                <button type="submit" class="btn btn-primary mt-3">Save and Next</button>
            </form>
        </div>
    </div>
</body>
</html>
