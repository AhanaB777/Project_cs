<?php
session_start();
include("../login/connect.php");

// Protect the page: only logged-in admins allowed
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit();
}
include("../headnfoot/header.php");

// Handle delete action
if (isset($_POST['delete_user']) && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Optional: Prevent admin from deleting their own account
    if ($user_id == $_SESSION['admin_id']) {
        $error = "You cannot delete your own account!";
    } else {
        $stmt = $conn->prepare("DELETE FROM admin_users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $success = "User deleted successfully!";
    }
}

// Fetch all users
$result = $conn->query("SELECT id, username, created_at FROM admin_users ORDER BY created_at DESC");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Admin Users</title>
    <style>
        body {
            background-color: #0e0e1a;
            font-family: 'Segoe UI', sans-serif;
            color: #ffffff;
            padding: 40px;
        }

        h2 {
            text-align: center;
            color: #00ffff;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        th {
            background-color: rgba(0, 255, 255, 0.1);
            color: #00ffff;
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.03);
        }

        .delete-btn {
            padding: 6px 12px;
            border: none;
            background-color: #ff5555;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #e60000;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            color: #00ffcc;
        }

        .error {
            color: #ff6666;
        }

        .back-link {
            text-align: center;
            margin-top: 30px;
        }

        .back-link a {
            color: #00ffff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>Manage Admin Users</h2>

    <?php if (isset($success)): ?>
        <p class="message"><?= $success ?></p>
    <?php elseif (isset($error)): ?>
        <p class="message error"><?= $error ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= $row['created_at'] ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                        <button type="submit" name="delete_user" class="delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="back-link">
        <p><a href="dashboard.php">← Back to Dashboard</a></p>
    </div>
</body>
</html>
