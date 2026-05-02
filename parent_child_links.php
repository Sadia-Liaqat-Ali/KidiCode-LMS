<?php
session_start();
include "../db_connection.php";

// Fetch all parents with their linked students
$sql = "SELECT u.id AS parent_id, u.username AS parent_name, u.email AS parent_email, 
               GROUP_CONCAT(us.username SEPARATOR ', ') AS students
        FROM users u
        LEFT JOIN parent_student_links psl ON u.id = psl.parent_id AND psl.status='approved'
        LEFT JOIN users us ON psl.student_id = us.id
        WHERE u.role='parent'
        GROUP BY u.id
        ORDER BY u.id DESC";
$result = mysqli_query($conn, $sql);
if(!$result){ die("SQL Error: ".mysqli_error($conn)); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Parents & Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial; background: #f7f3f8; }
        .content { margin-left: 260px; padding: 30px; }
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.15); border-radius:10px; }
        th {  background:#E83C91; color: #fff; padding: 12px; text-align: center; }
        td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
        h2 { color: #001BB7; margin-bottom: 20px; }
    </style>
</head>
<body>

<?php include "sidebar_admin.php"; ?>

<div class="content">
    <h2>Parents & Their Linked Students</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Parent Name</th>
                <th>Parent Email</th>
                <th>Linked Students</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if($result->num_rows > 0){
            $i = 1;
            while($row = mysqli_fetch_assoc($result)){
                $students = $row['students'] ? $row['students'] : 'No linked students';
                echo "<tr>
                        <td>".$i++."</td>
                        <td>".$row['parent_name']."</td>
                        <td>".$row['parent_email']."</td>
                        <td>".$students."</td>
                      </tr>";
            }
        } else {
            echo '<tr><td colspan="4" style="text-align:center;">No parents found</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
