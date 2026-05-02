<?php
session_start();
include '../db_connection.php';

// Check if tutor is logged in
if (!isset($_SESSION['tutor_id'])) {
    echo "<script>alert('Please login first.'); window.location='tutor_login.php';</script>";
    exit();
}

$tutorID = $_SESSION['tutor_id'];

// Check if quiz ID is provided
if (!isset($_GET['id'])) {
    echo "<script>alert('No quiz ID provided.'); window.location='view_quizzes.php';</script>";
    exit();
}

$quizID = intval($_GET['id']);

// Delete related quiz questions first
$deleteQuestions = $conn->prepare("DELETE FROM quiz_questions WHERE quiz_id = ?");
$deleteQuestions->bind_param("i", $quizID);
$deleteQuestions->execute();
$deleteQuestions->close();

// Delete the quiz
$deleteQuiz = $conn->prepare("DELETE FROM quizzes WHERE id = ? AND tutor_id = ?");
$deleteQuiz->bind_param("ii", $quizID, $tutorID);
$deleteQuiz->execute();
$deleteQuiz->close();

echo "<script>alert('Quiz deleted successfully.'); window.location='all_quiz.php';</script>";
exit();
?>
