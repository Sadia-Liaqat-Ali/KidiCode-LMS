<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard | TutorFinder</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
    --primary:#6c63ff;
    --secondary:#4dabf7;
    --warning:#ffc107;
    --success:#28a745;
    --danger:#e63946;
    --info:#17a2b8;
    --dark:#1e1e2f;
    --gray:#6c757d;
    --light:#f8f9fa;
}
body{
    font-family:'Poppins',sans-serif;
    background:#f5f7fb;
    margin:0;
}
.main-content{
    margin-left:250px;
    padding:30px;
}
.dashboard-title{
    font-weight:700;
    display:flex;
    gap:15px;
    align-items:center;
}
.action-row{
    display:flex;
    flex-wrap:wrap;
    gap:25px;
    margin-bottom:25px;
}
.action-card{
    flex:1 1 calc(33.333% - 25px);
    min-width:300px;
    background:white;
    border-radius:12px;
    padding:25px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
    border-top:5px solid var(--primary);
    transition:.3s;
}
.action-card:hover{
    transform:translateY(-6px);
}
.action-icon{
    width:60px;
    height:60px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:26px;
    color:white;
    margin-bottom:20px;
}
.c1{background:linear-gradient(135deg,#6c63ff,#5649db);}
.c2{background:linear-gradient(135deg,#0d6efd,#4dabf7);}
.c3{background:linear-gradient(135deg,#28a745,#1e7e34);}
.c4{background:linear-gradient(135deg,#ffc107,#e0a800);}
.c5{background:linear-gradient(135deg,#e63946,#dc3545);}
.c6{background:linear-gradient(135deg,#17a2b8,#138496);}
.action-title{
    font-size:18px;
    font-weight:600;
}
.action-description{
    color:var(--gray);
    font-size:14px;
    margin-bottom:15px;
}
.action-btn{
    padding:11px;
    width:100%;
    border-radius:8px;
    text-align:center;
    display:block;
    text-decoration:none;
    color:white;
    font-weight:500;
    border:none;
    transition:.3s;
}
.b1{background:var(--primary);}
.b2{background:var(--secondary);}
.b3{background:var(--success);}
.b4{background:var(--warning); color:#111;}
.b5{background:var(--danger);}
.b6{background:var(--info);}
.action-btn:hover{
    opacity:.85;
}
</style>
</head>

<body>

<?php include 'sidebar_admin.php'; ?>

<div class="main-content">

<div class="dashboard-header mb-4">
    <h1 class="dashboard-title">
        <i class="fas fa-user-shield text-primary"></i> Admin Dashboard
    </h1>
    <div class="text-muted">
        <i class="fas fa-calendar-alt me-2"></i><?php echo date("F j, Y"); ?>
    </div>
</div>

<!-- === 6 CARDS DASHBOARD === -->
<div class="action-row">

    <!-- Instructors -->
    <div class="action-card">
        <div class="action-icon c1"><i class="fa fa-chalkboard-teacher"></i></div>
        <h3 class="action-title">Instructors</h3>
        <p class="action-description">Manage all instructors' data, info and account updates.</p>
        <a href="manage_instructors.php" class="action-btn b1">Manage Instructors</a>
    </div>

    <!-- Instructor Skills -->
    <div class="action-card">
        <div class="action-icon c2"><i class="fa fa-layer-group"></i></div>
        <h3 class="action-title">Instructor Skills</h3>
        <p class="action-description">Add or manage instructors' teaching skills & categories.</p>
        <a href="manage_skills.php" class="action-btn b2">Manage Skills</a>
    </div>

    <!-- Students -->
    <div class="action-card">
        <div class="action-icon c3"><i class="fa fa-users"></i></div>
        <h3 class="action-title">Students</h3>
        <p class="action-description">View and manage all registered student profiles.</p>
        <a href="show_students.php" class="action-btn b3">View Students</a>
    </div>

    <!-- Courses -->
    <div class="action-card">
        <div class="action-icon c4"><i class="fa fa-book-open"></i></div>
        <h3 class="action-title">Courses</h3>
        <p class="action-description">Add, update and manage all available courses.</p>
        <a href="manage_courses.php" class="action-btn b4">Manage Courses</a>
    </div>

    <!-- Vouchers -->
    <div class="action-card">
        <div class="action-icon c5"><i class="fa fa-file-invoice-dollar"></i></div>
        <h3 class="action-title">Vouchers</h3>
        <p class="action-description">Verify and validate student payment vouchers.</p>
        <a href="manage_voucher.php" class="action-btn b5">Check Vouchers</a>
    </div>

    <!-- Parent–Student Links -->
    <div class="action-card">
        <div class="action-icon c6"><i class="fa fa-link"></i></div>
        <h3 class="action-title">Parent-Student Links</h3>
        <p class="action-description">Approve or manage parent–student connection requests.</p>
        <a href="parent_child_links.php" class="action-btn b6">View Links</a>
    </div>

</div>

</div>

</body>
</html>
