<?php
session_start();
include "../db_connection.php";

// Fetch all courses, instructors, students for dropdowns
$courses = mysqli_query($conn, "SELECT id, course_title FROM courses ORDER BY course_title ASC");
$instructors = mysqli_query($conn, "SELECT id, instructorName FROM instructors ORDER BY instructorName ASC");
$students = mysqli_query($conn, "SELECT id, username FROM users WHERE role='student' ORDER BY username ASC");

// Handle report generation
$report_data = [];
if(isset($_POST['generate_report'])){
    $type = $_POST['report_type'];
    $id = intval($_POST['entity_id']);

    if($type == 'course'){
        $query = "SELECT c.course_title, u.username AS student_name, u.email AS student_email, uc.assignment_submitted, uc.challenge_submitted, uc.attendance_marked, uc.final_grade
                  FROM courses c
                  LEFT JOIN user_courses uc ON c.id = uc.course_id
                  LEFT JOIN users u ON uc.user_id = u.id
                  WHERE c.id = $id";
    } elseif($type == 'instructor'){
        $query = "SELECT i.instructorName, i.instructorQualification, i.instructorCategory, i.instructorExperience, c.course_title
                  FROM instructors i
                  LEFT JOIN courses c ON i.id = c.instructor_id
                  WHERE i.id = $id";
    } elseif($type == 'student'){
        $query = "SELECT u.username, u.email, u.contact, c.course_title, uc.assignment_submitted, uc.challenge_submitted, uc.attendance_marked, uc.final_grade
                  FROM users u
                  LEFT JOIN user_courses uc ON u.id = uc.user_id
                  LEFT JOIN courses c ON uc.course_id = c.id
                  WHERE u.id = $id";
    }

    $result = mysqli_query($conn, $query);
    if($result){ $report_data = mysqli_fetch_all($result, MYSQLI_ASSOC); }
    else { die("SQL Error: ".mysqli_error($conn)); }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Generate Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial; background: #f7f3f8; }
        .content { margin-left: 260px; padding: 30px; }
        .card { box-shadow: 0 0 15px rgba(0,0,0,0.1); margin-bottom: 20px; border-radius:10px; }
        .card-header {  background:#E83C91; color: #fff; font-weight: bold; }
        h2 { color: #001BB7; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top:10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th {  background:#E83C91; color: #fff; }
        .btn-print { margin-bottom: 20px; background: #FF8040; color:#fff; }
    </style>
</head>
<body>

<?php include "sidebar_admin.php"; ?>

<div class="content">
    <h2>Generate Reports</h2>
    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="report_type" class="form-label">Report Type</label>
            <select name="report_type" id="report_type" class="form-select" required onchange="updateDropdown(this.value)">
                <option value="">Select Type</option>
                <option value="course">Course</option>
                <option value="instructor">Instructor</option>
                <option value="student">Student</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="entity_id" class="form-label">Select</label>
            <select name="entity_id" id="entity_id" class="form-select" required>
                <option value="">Select...</option>
            </select>
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" name="generate_report" class="btn btn-primary">Generate</button>
        </div>
    </form>

    <?php if(!empty($report_data)){ ?>
        <button class="btn btn-print" onclick="window.print()">Print Report</button>
        <?php foreach($report_data as $row){ ?>
            <div class="card p-3">
                <div class="card-header">Report Details</div>
                <div class="card-body">
                    <table>
                        <tbody>
                        <?php foreach($row as $key=>$val){ ?>
                            <tr><th><?= ucfirst(str_replace('_',' ',$key)) ?></th><td><?= $val ?></td></tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

<script>
let courses = <?php echo json_encode(mysqli_fetch_all($courses, MYSQLI_ASSOC)); ?>;
let instructors = <?php echo json_encode(mysqli_fetch_all($instructors, MYSQLI_ASSOC)); ?>;
let students = <?php echo json_encode(mysqli_fetch_all($students, MYSQLI_ASSOC)); ?>;

function updateDropdown(type){
    let select = document.getElementById('entity_id');
    select.innerHTML = '<option value="">Select...</option>';
    let list = [];
    if(type=='course'){ list = courses; }
    else if(type=='instructor'){ list = instructors; }
    else if(type=='student'){ list = students; }

    list.forEach(item=>{
        select.innerHTML += `<option value="${item.id}">${item.course_title||item.instructorName||item.username}</option>`;
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
