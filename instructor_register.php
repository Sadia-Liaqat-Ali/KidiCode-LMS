<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name          = $_POST['instructorName'];
    $qualification = $_POST['instructorQualification'];
    $category      = $_POST['instructorCategory'];
    $experience    = $_POST['instructorExperience'];
    $address       = $_POST['instructorAddress'];
    $mobile        = $_POST['instructorMobile'];
    $password      = $_POST['instructorPassword'];
    $confirm       = $_POST['instructorConfirmPassword'];

    if ($password !== $confirm) {
        echo "<script>alert('Password does not match');</script>";
        exit;
    }

    $imagePath = '';
    if (isset($_FILES['instructorPicture']) && $_FILES['instructorPicture']['name'] != '') {
        if (!is_dir('img')) {
            mkdir('img', 0755, true);
        }
        $origName = basename($_FILES['instructorPicture']['name']);
        $safeName = 'instr_' . time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $origName);
        $imagePath = 'img/' . $safeName;
        move_uploaded_file($_FILES['instructorPicture']['tmp_name'], $imagePath);
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO instructors
        (instructorName, instructorQualification, instructorCategory, instructorExperience, instructorPicture, instructorAddress, instructorMobile, Password, status)
        VALUES
        ('$name', '$qualification', '$category', $experience, '$imagePath', '$address', '$mobile', '$hashed', 'pending')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Registration Submitted. Please wait for admin approval.');
                window.location = 'instructor_login.php';
              </script>";
        exit;
    } else {
        $err = mysqli_error($conn);
        echo "<script>alert('Database Error: $err');</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Instructor Registration</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="form-theme.css">
</head>

<body>

<div class="form-card">
    <h2><i class="fas fa-user-tie me-2"></i>Register New Instructor</h2>

    <form method="POST" enctype="multipart/form-data">

        <div class="row mb-3">
            <div class="col">
                <label>Instructor Name</label>
                <input type="text" class="form-control" name="instructorName" placeholder="Enter full name" required>
            </div>
            <div class="col">
                <label>Qualification</label>
                <input type="text" class="form-control" name="instructorQualification" placeholder="Enter qualification" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Category</label>
                <select class="form-control" name="instructorCategory" required>
                    <option value="" disabled selected>Select category</option>
                    <?php
                    $catRes = mysqli_query($conn, "SELECT category_name FROM categories");
                    if ($catRes) {
                        while ($crow = mysqli_fetch_assoc($catRes)) {
                            echo '<option value="'.$crow['category_name'].'">'.$crow['category_name'].'</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col">
                <label>Experience (years)</label>
                <input type="number" class="form-control" name="instructorExperience" min="0" placeholder="Enter years" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Picture</label>
                <input type="file" class="form-control" name="instructorPicture" required>
            </div>
            <div class="col">
                <label>Mobile Number</label>
                <input type="text" class="form-control" name="instructorMobile" placeholder="03XXXXXXXXX" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea class="form-control" name="instructorAddress" rows="2" placeholder="Enter complete address" required></textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Password</label>
                <input type="password" class="form-control" name="instructorPassword" placeholder="Enter password" required>
            </div>
            <div class="col">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="instructorConfirmPassword" placeholder="Re-enter password" required>
            </div>
        </div>

        <button type="submit" class="btn-submit">Register Instructor</button>

        <div class="login-link">
            Already have an account? <a href="instructor/instructor_login.php">Login here</a>
        </div>
       

    </form>
</div>

</body>
</html>
