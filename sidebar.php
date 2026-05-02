<!-- student_sidebar.php -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    .sidebar {
        height: 100vh;
        width: 250px;
        position: fixed;
        background-color: #43334C; /* same dark purple as admin */
        padding-top: 30px;
        border-top-right-radius: 16px;
        border-bottom-right-radius: 16px;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }

    .sidebar h4 {
        color: #FF8FB7; /* same pink light */
        text-align: center;
        margin-bottom: 30px;
        font-weight: 700;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        color: #fff;
        padding: 12px 20px;
        text-decoration: none;
        border-radius: 8px;
        margin: 5px 10px;
        font-weight: 500;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .sidebar a:hover {
        background-color: #E83C91; /* same pink dark hover */
        transform: translateX(5px);
        color: #fff;
    }

    .sidebar i {
        margin-right: 10px;
        font-size: 18px;
    }
</style>

<div class="sidebar">
    <h4><i class="fas fa-user-graduate"></i> Student Panel</h4>
    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="plan.php"><i class="fas fa-book"></i> Buy Plan</a>
    <a href="courses.php"><i class="fas fa-book"></i> All Courses</a>
    <a href="my_courses.php"><i class="fas fa-book"></i> My Courses</a>
    <a href="my_parents.php"><i class="fas fa-users"></i> My Parents</a>
    <a href="my_result.php"><i class="fas fa-ticket-alt"></i> My Result</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>
