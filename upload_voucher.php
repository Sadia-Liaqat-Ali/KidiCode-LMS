<?php
session_start();
include '../db_connection.php';
include 'sidebar_user.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentName = $_POST['studentName'];
    $tutorID = $_POST['tutorID'];
    $email = $_SESSION['email'];
    $user_id = $_SESSION['user_id']; // assume user_id is stored in session
    $status = 'Pending';

    if (isset($_FILES['voucher']) && $_FILES['voucher']['error'] === 0) {
        $file = $_FILES['voucher'];
        $filename = basename($file['name']);
        $targetDir = "../uploads/";
        $targetFile = $targetDir . time() . "_" . $filename;

        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                // Insert record into database with user_id
                $stmt = $conn->prepare("INSERT INTO uploadvoucher (studentName, tutorID, filename, email, user_id, status) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sissis", $studentName, $tutorID, $targetFile, $email, $user_id, $status);
                if ($stmt->execute()) {
                    echo "
                    <div style='margin-left: 270px; margin-top: 50px; display: flex; justify-content: center;'>
                        <div style='max-width: 600px; width: 100%; text-align: center; font-family: Arial, sans-serif; background-color: lightpink; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
                            <h2 style='color: #32CD32;'>🎉 Voucher Uploaded Successfully! 🎉</h2>
                            <p style='color: #4682B4;'>Your voucher has been successfully uploaded and is being processed 📝. Please wait while we verify your payment 💸 and assign the best tutor for you 👨‍🏫👩‍🏫.</p>
                            <p style='color: white;'>We will notify you once everything is confirmed. 🌟</p>
                            <a href='select-tutor.php?id=$tutorID' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go Back to Tutor Selection 🔙</a>
                        </div>
                    </div>
                    ";
                } else {
                    echo "Database error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Failed to upload file.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, or PDF allowed.";
        }
    } else {
        echo "No file uploaded or error occurred.";
    }
}
?>
