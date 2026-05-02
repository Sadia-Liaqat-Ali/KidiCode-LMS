<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['voucher_id'], $_POST['new_status'])) {
    $voucher_id = $_POST['voucher_id'];
    $new_status = $_POST['new_status'];

    $stmt = $conn->prepare("UPDATE uploadvoucher SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $voucher_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch all vouchers
$sql = "SELECT id, studentName, email, filename, status, uploaded_at, user_id FROM uploadvoucher ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Verify Vouchers</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body { background-color: #f0f2f5; font-family: Arial, sans-serif; }
.sidebar { width: 250px; background-color: #343a40; color: white; position: fixed; height: 100%; top: 0; left: 0; padding-top: 20px; }
.content { margin-left: 260px; padding: 30px; }

h2 { color: #003366; margin-bottom: 20px; }

.table-container {
    width: 100%;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.voucher-table {
    width: 100%;
    border-collapse: collapse;
}

.voucher-table th, .voucher-table td {
    padding: 12px 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.voucher-table th {
    background-color: #E83C91;
    color: #fff;
}

.voucher-table tr:hover {
    background-color: #eef;
}

.voucher-link { color: #007bff; text-decoration: none; }
.voucher-link:hover { text-decoration: underline; }

select { padding: 5px; border-radius: 5px; border: 1px solid #ccc; }
.btn-update {
    padding: 5px 10px;
    border-radius: 5px;
    border: none;
    background-color: #28a745;
    color: #fff;
    cursor: pointer;
}
.btn-update:hover { background-color: #218838; }

@media(max-width:768px) {
    .content { padding: 15px; margin-left: 0; }
    .voucher-table th, .voucher-table td { padding: 8px 10px; font-size: 14px; }
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <?php include 'sidebar_admin.php'; ?>
</div>

<!-- Content -->
<div class="content">
    <h2>Uploaded Student Vouchers</h2>
    <div class="table-container">
        <table class="voucher-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>User ID</th>
                    <th>Uploaded At</th>
                    <th>Voucher</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['studentName']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['user_id']); ?></td>
                        <td><?= htmlspecialchars($row['uploaded_at']); ?></td>
                        <td><a class="voucher-link" href="<?= htmlspecialchars($row['filename']); ?>" target="_blank">View</a></td>
                        <td><?= htmlspecialchars($row['status']); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="voucher_id" value="<?= $row['id']; ?>">
                                <select name="new_status">
                                    <option value="Pending" <?= $row['status']=='Pending'?'selected':'' ?>>Pending</option>
                                    <option value="Verify" <?= $row['status']=='Verify'?'selected':'' ?>>Verify</option>
                                    <option value="Cancel" <?= $row['status']=='Cancel'?'selected':'' ?>>Cancel</option>
                                </select>
                                <button type="submit" class="btn-update"><i class="fas fa-sync-alt"></i> Update</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7">No vouchers uploaded yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $conn->close(); ?>
</body>
</html>
