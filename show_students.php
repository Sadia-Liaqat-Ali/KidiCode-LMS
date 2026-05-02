<?php 
session_start();
include "../db_connection.php";

$sql = "SELECT id, username, email, contact, role 
        FROM users 
        WHERE role='student'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("SQL ERROR: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Show Students</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background:#f7f3f8;
    font-family: Arial;
}
.content {
    margin-left:260px;
    padding:20px;
}
.table-custom {
    width:100%;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 0 10px rgba(0,0,0,0.15);
}
.table-custom th {
    background:#E83C91;
    color:#fff;
    padding:12px;
}
.table-custom td {
    padding:10px;
    border-bottom:1px solid #ddd;
    text-align:center;
}
.btn-check {
    background:#001BB7;
    padding:5px 10px;
    color:white;
    border-radius:5px;
    text-decoration:none;
}
.btn-check:hover {
    background:#0046FF;
}
.modal-header {
    background:#E83C91;
    color:white;
}
</style>
</head>

<body>

<?php include "sidebar_admin.php"; ?>

<div class="content">
    <h2>All Students</h2>
    
    <table class="table-custom">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        <?php 
        $i=1;
        while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= htmlspecialchars($row['username']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['contact']); ?></td>
                <td>
                    <a href="#" 
                       class="btn-check" 
                       onclick="loadLearning(<?= $row['id'] ?>)" 
                       data-bs-toggle='modal' 
                       data-bs-target='#learningModal'>
                       Check Learning
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>


<!-- MODAL -->
<div class="modal fade" id="learningModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Student Learning Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="learningData">
        <p>Loading...</p>
      </div>

    </div>
  </div>
</div>

<script>
function loadLearning(studentID){
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "load_learning.php?student_id=" + studentID, true);
    xhr.onload = function(){
        document.getElementById("learningData").innerHTML = this.responseText;
    }
    xhr.send();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
