<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../UserLogin.php");
    exit();
}

$student_id = $_SESSION['user_id'];

// Fetch all courses enrolled by student along with instructor info (procedural)
$sql = "SELECT c.id as course_id, c.course_title, c.course_type, i.instructorName
        FROM user_courses uc
        JOIN courses c ON uc.course_id = c.id
        LEFT JOIN instructors i ON c.instructor_id = i.id
        WHERE uc.user_id = $student_id
        ORDER BY c.course_title ASC";
$result = mysqli_query($conn, $sql);
$enrolled_courses = [];
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $enrolled_courses[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Courses | KidiCode</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
:root {
    --pink: #ff69b4;
    --soft-pink: #ffe5f0;
    --gray: #f2f2f7;
    --white: #fff;
    --blue: #001BB7;
    --blue-light: #0046FF;
}
body { background: var(--gray); font-family: 'Poppins', sans-serif; margin:0; }
.sidebar { width:250px; background: var(--white); position: fixed; top:0; left:0; height:100vh; padding:20px; box-shadow:2px 0 10px rgba(0,0,0,0.1);}
.sidebar h2 { color: var(--pink); text-align:center; margin-bottom:30px; }
.sidebar a { display:block; color:#222; margin:10px 0; text-decoration:none; font-weight:500; padding:10px; border-radius:10px; transition:0.3s; }
.sidebar a:hover { background: var(--soft-pink); color: var(--pink); }

.main { margin-left:270px; padding:30px; }

.welcome-card { background: var(--pink); color: var(--white); padding:25px 30px; border-radius:18px; margin-bottom:30px; box-shadow:0 8px 20px rgba(255,105,180,0.3); }

.table-card { background: var(--white); padding:20px; border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,0.08); overflow-x:auto; }
.table th, .table td { vertical-align: middle; }
.btn-access { background: var(--blue); color:#fff; border:none; padding:6px 15px; border-radius:20px; transition:0.3s; }
.btn-access:hover { background: var(--blue-light); color:#fff; }
.alert-info { background: var(--soft-pink); color: var(--pink); border:none; }
</style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main">
    <div class="welcome-card">
        <h1>📚 Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Here are the courses you are enrolled in. Let's continue learning 🌟</p>
    </div>

    <div class="table-card">
        <?php if(count($enrolled_courses) > 0): ?>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Course Name</th>
                        <th>Instructor</th>
                        <th>Course Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($enrolled_courses as $index => $course): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($course['course_title']); ?></td>
                        <td><?php echo htmlspecialchars($course['instructorName'] ? $course['instructorName'] : 'Not Provided'); ?></td>
                        <td><?php echo htmlspecialchars($course['course_type']); ?></td>
                        <td>
                            <a href="course_material.php?id=<?php echo $course['course_id']; ?>" class="btn btn-outline-primary">Start Learning</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info mt-3">You have not enrolled in any courses yet.</div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
