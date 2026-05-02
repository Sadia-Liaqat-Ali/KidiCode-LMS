<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

include '../db_connection.php';

// Add new skill
if (isset($_POST['add_skill'])) {
    $skill_name = trim($_POST['skill_name']);
    if ($skill_name != '') {
        $stmt = $conn->prepare("INSERT INTO instructor_skills (skill_name) VALUES (?)");
        $stmt->bind_param("s", $skill_name);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Skill added successfully'); window.location='manage_skills.php';</script>";
    }
}

// Delete skill
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM instructor_skills WHERE id=$id");
    echo "<script>alert('Skill deleted successfully'); window.location='manage_skills.php';</script>";
}

// Update skill
if (isset($_POST['update_skill'])) {
    $id = intval($_POST['skill_id']);
    $skill_name = trim($_POST['skill_name']);
    if ($skill_name != '') {
        $stmt = $conn->prepare("UPDATE instructor_skills SET skill_name=? WHERE id=?");
        $stmt->bind_param("si", $skill_name, $id);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Skill updated successfully'); window.location='manage_skills.php';</script>";
    }
}

// Fetch all skills
$skills = $conn->query("SELECT * FROM instructor_skills ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Instructor Skills | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
    --primary: #E83C91;
    --primary-dark: #43334C;
    --bg: #F8F4EC;
    --light-gray: #e9ecef;
    --success: #28a745;
    --danger: #dc3545;
    --gray: #6c757d;
}
body { font-family: 'Poppins', sans-serif; background-color: var(--bg); margin: 0; }
.main-content { margin-left: 250px; padding: 30px; }
.dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.dashboard-title { font-weight: 700; color: var(--primary-dark); display: flex; align-items: center; gap: 10px; }
.dashboard-title i { color: var(--primary); }
.table-container { background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 20px; }
.table thead th { background-color: var(--primary); color: #fff; padding: 12px; border: none; }
.table tbody tr:hover { background-color: #f2e9f0; }
.table tbody td { padding: 12px; border-bottom: 1px solid var(--light-gray); vertical-align: middle; }
.form-control { border-radius: 8px; padding: 10px 15px; border: 1px solid var(--light-gray); margin-bottom: 10px; }
.form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 0.2rem rgba(232,60,145,0.25); }
.editable { background-color: #fffbe7; }
.btn-sm { padding: 6px 12px; font-size: 0.85rem; border-radius: 6px; margin-bottom: 4px; }
.btn-success { background-color: var(--success); border-color: var(--success); }
.btn-danger { background-color: var(--danger); border-color: var(--danger); }
.btn-success:hover { background-color: #218838; border-color: #1e7e34; }
.btn-danger:hover { background-color: #c82333; border-color: #bd2130; }
.add-skill-form { margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap; }
.add-skill-form button { flex-shrink: 0; }
.no-data { text-align: center; padding: 20px; color: var(--gray); }
@media (max-width: 992px) { .main-content { margin-left: 0; padding: 20px; } }
</style>
</head>
<body>

<?php include 'sidebar_admin.php'; ?>

<div class="main-content">
    <div class="dashboard-header">
        <h1 class="dashboard-title"><i class="fas fa-tools"></i> Manage Instructor Skills</h1>
        <div class="text-muted"><i class="fas fa-calendar-alt me-2"></i> <?= date('F j, Y'); ?></div>
    </div>

    <!-- Add new skill -->
    <form method="POST" class="add-form">
        <input type="text" name="skill_name" class="form-control" placeholder="Enter new skill" required>
        <button type="submit" name="add_skill" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Add Skill</button>
    </form>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Skill Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($skills && $skills->num_rows > 0): $i=1; ?>
                    <?php while ($row = $skills->fetch_assoc()): ?>
                        <tr>
                            <form method="POST">
                                <td><?= $i++; ?></td>
                                <td>
                                    <input type="text" name="skill_name" class="form-control editable" value="<?= htmlspecialchars($row['skill_name']); ?>" required>
                                    <input type="hidden" name="skill_id" value="<?= $row['id']; ?>">
                                </td>
                                <td>
                                    <button type="submit" name="update_skill" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Update</button>
                                    <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this skill?');"><i class="fas fa-trash-alt"></i> Delete</a>
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="3" class="text-center">No skills found. Add new skill above.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
