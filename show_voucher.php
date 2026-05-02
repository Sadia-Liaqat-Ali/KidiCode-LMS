<?php
session_start();
include '../db_connection.php';
include 'sidebar_user.php';

$email = $_SESSION['email'];

$sql = "SELECT studentName, tutorID, filename, status FROM uploadvoucher WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Vouchers</title>
    <style>
        .content-wrapper {
            margin-left: 270px;
            padding: 40px;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            min-height: 100vh;
        }

        .voucher-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .voucher-table th,
        .voucher-table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }

        .voucher-table th {
            background-color: #004080;
            color: white;
        }

        .voucher-table tr:hover {
            background-color: #f1f1f1;
        }

        .status-pending {
            color: orange;
            font-weight: bold;
        }

        .status-approved {
            color: green;
            font-weight: bold;
        }

        .status-rejected {
            color: red;
            font-weight: bold;
        }

        .voucher-link {
            color: #007bff;
            text-decoration: none;
        }

        .voucher-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
            <?php include 'sidebar_user.php'; ?>

<div class="content-wrapper">
    <h2>Your Uploaded Vouchers</h2>
    <table class="voucher-table">
        <tr>
            <th>Student Name</th>
            <th>Tutor ID</th>
            <th>Voucher File</th>
            <th>Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $statusClass = strtolower($row['status']) == 'pending' ? 'status-pending' :
                               (strtolower($row['status']) == 'approved' ? 'status-approved' : 'status-rejected');

                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['studentName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['tutorID']) . "</td>";
                echo "<td><a class='voucher-link' href='" . htmlspecialchars($row['filename']) . "' target='_blank'>View Voucher</a></td>";
                echo "<td class='$statusClass'>" . htmlspecialchars($row['status']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No vouchers uploaded yet.</td></tr>";
        }
        ?>
    </table>
</div>

<?php
$stmt->close();
$conn->close();
?>

</body>
</html>
