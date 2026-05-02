<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['instructor_name']) || !isset($_SESSION['instructor_id'])) {
    header("Location: instructor_login.php");
    exit();
}

$instructorName = $_SESSION['instructor_name'];
$instructorId   = $_SESSION['instructor_id'];  // ✔ correct variable name

// -------------------------------
// FIXED QUERY
// -------------------------------
$sql_courses = "SELECT id, course_title FROM courses WHERE instructor_id = $instructorId";
$result_courses = mysqli_query($conn, $sql_courses);

if (!$result_courses) {
    die("Course Query Error: " . mysqli_error($conn));
}

if (isset($_POST['create_quiz'])) {

    $course_id        = $_POST['course_id'];
    $quiz_title       = $_POST['quiz_title'];
    $quiz_description = $_POST['quiz_description'];
    $total_questions  = $_POST['total_questions'];

    $sql_quiz = "INSERT INTO quizzes (instructor_id, course_id, quiz_title, quiz_description)
                 VALUES ($instructorId, $course_id, '$quiz_title', '$quiz_description')";
    mysqli_query($conn, $sql_quiz);

    if (mysqli_insert_id($conn)) {

        $quiz_id = mysqli_insert_id($conn);

        for ($i = 1; $i <= $total_questions; $i++) {

            $question_text = $_POST["question_text_$i"];
            $option_a      = $_POST["option_a_$i"];
            $option_b      = $_POST["option_b_$i"];
            $option_c      = $_POST["option_c_$i"];
            $correct       = $_POST["correct_option_$i"];

            $sql_q = "INSERT INTO quiz_questions 
                      (quiz_id, question_text, option_a, option_b, option_c, correct_option)
                      VALUES ($quiz_id, '$question_text', '$option_a', '$option_b', '$option_c', '$correct')";
            mysqli_query($conn, $sql_q);
        }

        echo "<script>alert('Quiz created successfully!');window.location='generate_quiz.php';</script>";
    } else {
        echo "<script>alert('Failed to create quiz');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Quiz</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body{background:#f0f2f5}
    .content{margin-left:260px;padding:20px}
    .card{background:#fff;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,.1);padding:20px;max-width:700px;margin:auto}
    h2{font-weight:bold}
    .q-box{border:1px solid #ddd;padding:15px;border-radius:8px;background:#fafafa;margin-bottom:20px}
</style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="content">
<div class="card">
<h2 class="mb-4 text-center">Create Quiz</h2>

<form action="" method="POST">

    <div class="mb-3">
        <label class="form-label">Select Course</label>
        <select name="course_id" class="form-select" required>
            <option value="">-- Select --</option>

            <!-- FIXED LOOP -->
            <?php while ($c = mysqli_fetch_assoc($result_courses)) { ?>
                <option value="<?= $c['id'] ?>"><?= $c['course_title'] ?></option>
            <?php } ?>

        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Quiz Title</label>
        <input type="text" name="quiz_title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Quiz Description</label>
        <textarea name="quiz_description" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Number of Questions</label>
        <input type="number" min="1" max="50" value="5" name="total_questions" id="total_questions" class="form-control" required>
    </div>

    <button type="button" onclick="generateInputs()" style="background-color: #E83C91; color: white;" 
    class="btn w-100 mb-3">Generate Question Fields</button>

    <div id="questions_container"></div>

    <div class="text-center">
        <button type="submit" name="create_quiz" class="btn btn-success w-50">Create Quiz</button>
    </div>

</form>
</div>
</div>

<script>
function generateInputs() {
    let total = document.getElementById("total_questions").value;
    let box = document.getElementById("questions_container");
    box.innerHTML = "";

    for(let i=1; i<=total; i++){
        box.innerHTML += `
        <div class="q-box">
            <h5>Question ${i}</h5>
            <input type="text" name="question_text_${i}" class="form-control mb-2" placeholder="Question Text" required>

            <input type="text" name="option_a_${i}" class="form-control mb-1" placeholder="Option A" required>
            <input type="text" name="option_b_${i}" class="form-control mb-1" placeholder="Option B" required>
            <input type="text" name="option_c_${i}" class="form-control mb-1" placeholder="Option C" required>

            <select name="correct_option_${i}" class="form-select mt-2" required>
                <option value="A">Correct: A</option>
                <option value="B">Correct: B</option>
                <option value="C">Correct: C</option>
            </select>
        </div>`;
    }
}
</script>

</body>
</html>
