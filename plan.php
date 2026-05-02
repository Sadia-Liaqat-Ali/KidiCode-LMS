<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID     = $_SESSION['user_id'];
$userName   = $_SESSION['username'];
$userEmail  = $_SESSION['email'];
$message    = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $plan      = $_POST['plan'];
    $price     = ($plan == "monthly") ? 500 : 5000;
    $file      = $_FILES['voucher']['name'];
    $tmp       = $_FILES['voucher']['tmp_name'];

    $uploadDir = "../uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $newName = time() . "_" . $file;
    $path    = $uploadDir . $newName;

    if (move_uploaded_file($tmp, $path)) {

        $query = "INSERT INTO uploadvoucher (studentName, instructorID, filename, email, status, user_id)
                  VALUES (?, NULL, ?, ?, 'Pending', ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $userName, $path, $userEmail, $userID);

        if ($stmt->execute()) {
            $message = "Your subscription request has been submitted!";
        } else {
            $message = "Database error!";
        }
    } else {
        $message = "File upload failed!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Subscription Plans</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f8f7fc; font-family:Arial; }

/* sidebar spacing fix */
.content-area {
    margin-left:260px; 
    padding:30px;
}

.plan-card {
    background:#fff; 
    border-radius:20px; 
    padding:25px; 
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    text-align:center;
    border:2px solid #ff80b0;
}

.plan-card h4 { color:#ff2d75; font-weight:bold; }
.plan-card p { color:#555; }

.price-tag {
    background:#ff2d75; 
    color:#fff; 
    padding:10px 20px; 
    border-radius:30px; 
    display:inline-block; 
    margin-bottom:15px;
}

.btn-sub {
    background:#ff2d75;
    color:#fff;
    border:none;
    padding:10px 20px;
    border-radius:25px;
}
.btn-sub:hover { background:#ff5b9c; }

.form-box {
    margin-top:40px; 
    padding:25px; 
    border-radius:15px; 
    background:#fff; 
    box-shadow:0 0 15px rgba(0,0,0,0.1);
}
</style>

</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="content-area">

    <h2 class="text-center mb-4">Choose Your Subscription Plan</h2>

    <?php if($message!=""){ echo "<div class='alert alert-info text-center'>$message</div>"; } ?>

    <div class="row g-4 justify-content-center">

        <div class="col-md-4">
            <div class="plan-card">
                <h4>Monthly Plan</h4>
                <div class="price-tag">Rs 500</div>
                <p>✔ Access to all basic courses</p>
                <p>✔ Track your learning progress</p>
                <p>✔ Participate in quizzes</p>
                <p>✔ Earn badges & rewards</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="plan-card">
                <h4>Yearly Plan</h4>
                <div class="price-tag">Rs 5000</div>
                <p>✔ All Monthly Plan Features</p>
                <p>✔ Access to premium courses</p>
                <p>✔ Priority support</p>
                <p>✔ Exclusive certificates</p>
            </div>
        </div>

    </div>

    <div class="form-box mt-5">
        <h4 class="mb-3">Complete Your Subscription</h4>

        <form method="POST" enctype="multipart/form-data">

            <label class="form-label"><b>Select Plan:</b></label>
            <select name="plan" class="form-select" required>
                <option value="">Select Plan</option>
                <option value="monthly">Monthly - Rs 500</option>
                <option value="yearly">Yearly - Rs 5000</option>
            </select>

            <label class="form-label mt-3"><b>Upload Payment Voucher:</b></label>
            <input type="file" name="voucher" class="form-control" required>

            <button type="submit" class="btn-sub mt-4">Submit Request</button>

        </form>
    </div>

</div>

</body>
</html>
