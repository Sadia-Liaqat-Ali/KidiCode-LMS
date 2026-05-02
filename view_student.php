<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['instructor_name']) || !isset($_SESSION['instructor_id'])) {
    header("Location: instructor_login.php");
    exit();
}

$instructorId = $_SESSION['instructor_id'];

if (!isset($_GET['id'])) {
    die("Course ID missing.");
}

$course_id = intval($_GET['id']);

// verify instructor owns this course
$sql_check = "SELECT id, course_title FROM courses WHERE id = $course_id AND instructor_id = $instructorId";
$res_check = mysqli_query($conn, $sql_check);
if (!$res_check) {
    die("DB error: " . mysqli_error($conn));
}
if (mysqli_num_rows($res_check) === 0) {
    die("Invalid course or no access.");
}

$course_row   = mysqli_fetch_assoc($res_check);
$course_title = htmlspecialchars($course_row['course_title']);

// fetch enrolled students
$sql_students = "
    SELECT 
        uc.user_id,
        u.username,
        u.email
    FROM user_courses uc
    JOIN users u ON u.id = uc.user_id
    WHERE uc.course_id = $course_id
    ORDER BY u.username ASC
";
$result_students = mysqli_query($conn, $sql_students);
if (!$result_students) {
    die("DB error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Enrolled Students — <?php echo $course_title; ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f0f2f5; font-family:'Poppins',sans-serif; }
.content { margin-left:260px; padding:22px; }
.card { background:#fff; border-radius:10px; padding:20px; box-shadow:0 0 10px rgba(0,0,0,0.06); }
h2 { color:#E83C91; font-weight:700; }
th { background:#E83C91; color:#fff; text-align:center; }
td { text-align:center; }

.btn-back { background:#6c757d; color:#fff; border-radius:6px; padding:6px 12px; text-decoration:none; }
.btn-activity { background:#0046FF; color:#fff; border-radius:6px; padding:6px 12px; text-decoration:none; }
</style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="content">
    <div class="card">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2>Enrolled Students</h2>
                <div style="color:#444;"><?php echo $course_title; ?></div>
            </div>
            <a href="manage_courses.php" class="btn-back">← Back</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr class="text-center">
                        <th style="width:60px">ID</th>
                        <th style="width:200px">Name</th>
                        <th style="width:250px">Email</th>
                        <th style="width:180px">Check Activities</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                if (mysqli_num_rows($result_students) > 0) {
                    while ($row = mysqli_fetch_assoc($result_students)) {
                        $sid   = intval($row['user_id']);
                        $name  = htmlspecialchars($row['username']);
                        $email = htmlspecialchars($row['email']);

                        echo "
                        <tr>
                            <td>{$sid}</td>
                            <td>{$name}</td>
                            <td>{$email}</td>
                            <td>
                                <a href='check_activities.php?student_id={$sid}&course_id={$course_id}' 
                                   class='btn-activity btn-sm'>
                                   View Activities
                                </a>
                            </td>
                        </tr>";
                    }
                } 
                else {
                    echo "<tr><td colspan='4'>No students enrolled yet.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>
