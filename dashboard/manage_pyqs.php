<?php

include("../config/db_connect2.php");  
session_start();  
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}

// Handle Delete (Soft Delete)
if (isset($_GET['delete'])) {
    $pyq_id = $_GET['delete'];
    $sql = "UPDATE question_papers SET status = 'deleted' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pyq_id);
    $stmt->execute();
}

// Handle Restore
if (isset($_GET['restore'])) {
    $pyq_id = $_GET['restore'];
    $sql = "UPDATE question_papers SET status = 'active' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pyq_id);
    $stmt->execute();
}

// Handle Permanent Delete
if (isset($_GET['permanent_delete'])) {
    $pyq_id = $_GET['permanent_delete'];
    $sql = "DELETE FROM question_papers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pyq_id);
    $stmt->execute();
}

// Fetch all PYQs
$sql = "SELECT * FROM question_papers ORDER BY year DESC, subject ASC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage PYQs</title>
    <link rel="stylesheet" href="manage_pyqs.css">
</head>
<body>
    <h1>Manage Past Year Question Papers</h1>
    <table border="1">
        <tr>
            <th>Subject</th>
            <th>Year</th>
            <th>Semester</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                <td><?php echo htmlspecialchars($row['year']); ?></td>
                <td><?php echo htmlspecialchars($row['semester']); ?></td>
                <td>
                   <?php if ($row['status'] === 'active'): ?>
                   <a class="action-btn delete-btn" href="delete_pyq.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this PYQ?');">
                         Delete
                   </a>
                   <?php else: ?>
                   <a class="action-btn restore-btn" href="restore_pyq.php?id=<?= $row['id']; ?>" onclick="return confirm('Restore this PYQ?');">
                           Restore
                   </a>
                   <?php endif; ?>
    |
                   <a class="action-btn permdelete-btn" href="permanent_delete_pyq.php?id=<?= $row['id']; ?>" onclick="return confirm('This action is irreversible! Permanently delete this PYQ?');">
                           Permanent Delete
                   </a>

                   <a href="edit_pyq.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">
                         Edit
                   </a>

                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
