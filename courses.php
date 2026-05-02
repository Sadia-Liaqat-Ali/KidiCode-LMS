<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    echo "<script>alert('Access denied. Please login as Student.'); window.location='../UserLogin.php';</script>";
    exit();
}

$student_id = $_SESSION['user_id'];
$search = isset($_GET['search']) ? $_GET['search'] : '';

/* --------------------------------------
   FIXED SQL QUERY to match new table  
   difficulty → age_group
--------------------------------------- */

$sql = "SELECT id, course_title, course_description, age_group, course_type, course_image
        FROM courses
        WHERE course_title LIKE ?";

/* If prepare fails (returns false), show SQL error */
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL ERROR: " . $conn->error);
}

$searchTerm = "%$search%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<title>Courses | KidiCode</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>

<style>
body{
    background:#f7f7fa;
    font-family:'Poppins',sans-serif;
    margin:0;
    padding:0;
}
.main-wrapper{
    margin-left:260px; 
    padding:30px;
}
.main-container{
    width:100%;
    max-width:1400px;
}
.course-card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    transition:0.3s;
    position:relative;
    height:100%;
}
.course-card:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(0,0,0,0.12);
}
.course-img{
    height:180px;
    width:100%;
    object-fit:cover;
    transition:0.4s;
}
.course-card:hover .course-img{
    transform:scale(1.05);
}
.badge-label{
    position:absolute;
    top:12px;
    left:12px;
    background:red;
    color:white;
    padding:5px 12px;
    border-radius:6px;
    font-size:12px;
    font-weight:600;
    z-index:10;
}
.badge-label.free{
    background:green;
}
.level-tag{
    position:absolute;
    top:12px;
    right:12px;
    background:black;
    color:white;
    padding:5px 10px;
    font-size:12px;
    border-radius:6px;
    font-weight:600;
    z-index:10;
}
.course-body{
    padding:18px;
}
.course-title{
    font-weight:700;
    color:#b10040;
    font-size:17px;
}
.course-desc{
    font-size:14px;
    color:#555;
    margin:10px 0 15px 0;
}
.btn-details{
    background:#b10040!important;
    color:white!important;
    padding:8px 18px!important;
    border-radius:25px!important;
    border:none!important;
    font-size:14px!important;
    display:inline-block;
    text-decoration: none;
}
.btn-details:hover{
    background:#d80051!important;
}
.row > div {
    display:flex;
}
</style>
</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="main-wrapper">
<div class="main-container">

<h2 style="font-weight:700; color:#b10040;">Explore Courses</h2>

<form method='GET' class='mb-4'>
    <div class='input-group w-50'>
        <input type='text' class='form-control' name='search' placeholder='Search...' 
               value='<?= htmlspecialchars($search) ?>'>
        <button class='btn btn-primary'>Search</button>
    </div>
</form>

<div class='row g-4'>
<?php while($row = $result->fetch_assoc()): ?>
    <div class='col-lg-4 col-md-6 d-flex'>
        <div class='course-card'>

            <img src="../uploads/<?= htmlspecialchars($row['course_image']) ?>" class="course-img">

            <div class='badge-label <?= $row['course_type']=='Free'?'free':'' ?>'>
                <?= $row['course_type']=='Free'?'Free':'Premium' ?>
            </div>

            <!-- age_group instead of difficulty -->
            <div class="level-tag">
                Age <?= htmlspecialchars($row['age_group']) ?>
            </div>

            <div class='course-body'>
                <div class='course-title'><?= htmlspecialchars($row['course_title']) ?></div>
                <div class='course-desc'>
                    <?= htmlspecialchars(substr($row['course_description'],0,90)) ?>...
                </div>
                <a href="course_details.php?id=<?= $row['id'] ?>" class="btn-details">View Details</a>
            </div>

        </div>
    </div>
<?php endwhile; ?>
</div>

</div>
</div>

</body>
</html>
