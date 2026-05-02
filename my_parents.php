<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit;
}

$student_id = $_SESSION['user_id'];
$message = "";

/* ------------------- HANDLE APPROVE / REJECT -------------------- */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && isset($_POST['link_id'])) {
        
        $link_id = intval($_POST['link_id']);
        $action  = $_POST['action'];

        if ($action == "approve") {
            $stmt = $conn->prepare("UPDATE parent_student_links SET status='approved' WHERE id=? AND student_id=?");
        } 
        else if ($action == "reject") {
            $stmt = $conn->prepare("UPDATE parent_student_links SET status='rejected' WHERE id=? AND student_id=?");
        }

        $stmt->bind_param("ii", $link_id, $student_id);

        if ($stmt->execute()) {
            $message = ($action == "approve") ? "Parent request approved!" : "Parent request rejected!";
        } else {
            $message = "Error updating request status.";
        }
        $stmt->close();
    }
}

/* ------------------- FETCH REQUESTS -------------------- */

$sql = "SELECT psl.id, psl.status, psl.requested_at, 
               u.UserName AS parent_name, u.Email AS parent_email
        FROM parent_student_links psl
        JOIN Users u ON psl.parent_id = u.id
        WHERE psl.student_id=?
        ORDER BY psl.requested_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$requests = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
<title>My Parents</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f8f7fc; }

/* Same as your subscription UI */
.content-area {
    margin-left:260px;
    padding:30px;
}

.card-box {
    background:#fff;
    border-radius:15px;
    padding:25px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    border-left:4px solid #ff2d75;
}

.title {
    color:#ff2d75;
    font-weight:bold;
}

.btn-approve {
    background:#28a745;
    color:#fff;
    border:none;
    padding:5px 15px;
    border-radius:20px;
}
.btn-approve:hover { background:#218838; }

.btn-reject {
    background:#dc3545;
    color:#fff;
    border:none;
    padding:5px 15px;
    border-radius:20px;
}
.btn-reject:hover { background:#c82333; }

.status-box {
    padding:5px 12px;
    border-radius:15px;
    color:#fff;
    font-size:14px;
}
.status-approved { background:#28a745; }
.status-rejected { background:#dc3545; }
.status-pending { background:#ffc107; color:#000; }
</style>
</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="content-area">

    <h2 class="text-center mb-4 title">Parent Requests</h2>

    <?php if ($message != ""): ?>
        <div class="alert alert-info text-center"><?= $message ?></div>
    <?php endif; ?>

    <?php if ($requests->num_rows == 0): ?>
        <div class="alert alert-secondary text-center">No parent requests yet!</div>
    <?php endif; ?>

    <?php while ($row = $requests->fetch_assoc()): ?>
        <div class="card-box mb-4">
            <h5><b><?= $row['parent_name'] ?></b></h5>
            <p>Email: <?= $row['parent_email'] ?></p>
            <p>Requested At: <?= $row['requested_at'] ?></p>

            <div class="d-flex justify-content-between align-items-center">

                <!-- Status -->
                <?php
                    $status = $row['status'];
                    $class = ($status == "approved") ? "status-approved" :
                             (($status == "rejected") ? "status-rejected" : "status-pending");
                ?>
                <span class="status-box <?= $class ?>">
                    <?= ucfirst($status) ?>
                </span>

                <!-- Buttons -->
                <?php if ($status == 'pending'): ?>
                    <form method="POST" class="d-flex gap-2">
                        <input type="hidden" name="link_id" value="<?= $row['id'] ?>">

                        <button type="submit" name="action" value="approve" class="btn-approve">
                            Approve
                        </button>

                        <button type="submit" name="action" value="reject" class="btn-reject">
                            Reject
                        </button>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    <?php endwhile; ?>

</div>

</body>
</html>
