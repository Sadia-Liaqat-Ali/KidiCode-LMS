<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'parent') {
    header("Location: ../login.php");
    exit;
}

$parent_id = $_SESSION['user_id'];
$message = "";

// Handle send request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_email'])) {
    $student_email = $_POST['student_email'];

    $stmt = $conn->prepare("SELECT id FROM Users WHERE Email=? AND role='student'");
    $stmt->bind_param("s", $student_email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        $student = $res->fetch_assoc();
        $student_id = $student['id'];

        // Check how many parents already sent request to this student
        $stmtCheck = $conn->prepare("SELECT COUNT(*) as cnt FROM parent_student_links WHERE student_id=?");
        $stmtCheck->bind_param("i", $student_id);
        $stmtCheck->execute();
        $countRes = $stmtCheck->get_result()->fetch_assoc();
        $stmtCheck->close();

        if ($countRes['cnt'] >= 2) {
            $message = "Cannot send request: Maximum 2 parents already linked to this student.";
        } else {
            $stmt2 = $conn->prepare("INSERT INTO parent_student_links (parent_id, student_id) VALUES (?, ?)");
            $stmt2->bind_param("ii", $parent_id, $student_id);
            if ($stmt2->execute()) {
                $message = "Request sent successfully!";
            } else {
                $message = "Request already sent or error occurred.";
            }
            $stmt2->close();
        }

    } else {
        $message = "Student email not found!";
    }
    $stmt->close();
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM parent_student_links WHERE id=? AND parent_id=? AND status='pending'");
    $stmt->bind_param("ii", $delete_id, $parent_id);
    if ($stmt->execute()) {
        $message = "Pending request deleted successfully!";
    } else {
        $message = "Unable to delete request.";
    }
    $stmt->close();
}

// Fetch all sent requests
$req_sql = "SELECT psl.id, u.UserName, u.Email, psl.status, psl.requested_at
            FROM parent_student_links psl
            JOIN Users u ON psl.student_id = u.id
            WHERE psl.parent_id=?";
$stmt = $conn->prepare($req_sql);
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$requests = $stmt->get_result();
$stmt->close();
?>
