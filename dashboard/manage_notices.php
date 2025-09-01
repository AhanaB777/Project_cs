<?php
session_start();
require '../config/db_connect.php';
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['upload_notice'])) {
        $title = trim($_POST['title']);
        $file_path = NULL;
        $file_size = 0;

        $target_dir = "../notices/notice_files/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
            $file_name = time() . "_" . basename($_FILES['file']['name']);
            $target_file = $target_dir . $file_name;
            $file_size = $_FILES['file']['size'];

            if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                $file_path = "notices/notice_files/" . $file_name;
            } else {
                die("Error uploading file.");
            }
        }

        $query = "INSERT INTO notices (title, file_path, file_size) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $title, $file_path, $file_size);
        $stmt->execute();
        $stmt->close();

        header("Location: manage_notices.php");
        exit;
    }

    if (isset($_POST['delete_notice'])) {
        $id = $_POST['id'];
        $res = $conn->query("SELECT file_path FROM notices WHERE id = $id");
        if ($res && $res->num_rows > 0) {
            $file = $res->fetch_assoc()['file_path'];
            if (file_exists("../" . $file)) {
                unlink("../" . $file);
            }
        }
        $conn->query("DELETE FROM notices WHERE id = $id");

        header("Location: manage_notices.php");
        exit;
    }
}

$result = $conn->query("SELECT * FROM notices ORDER BY id DESC");
include("../headnfoot/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Notices</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: #fff;
            padding: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
        }

        form {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            max-width: 700px;
            margin: 0 auto 30px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        input[type="text"], input[type="file"], button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
        }

        input[type="text"], input[type="file"] {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        input::file-selector-button {
            padding: 8px;
            border: none;
            background-color: #3498db;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        button {
            background-color: #28a745;
            color: white;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        th {
            background-color: rgba(255,255,255,0.1);
        }

        td form {
            display: inline;
        }

        a {
            color: #00c3ff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .action-buttons input[type="text"] {
            width: 60%;
            display: inline-block;
        }

        .action-buttons button {
            width: auto;
            display: inline-block;
            margin-left: 5px;
        }

        .centered {
            text-align: center;
        }
    </style>
</head>
<body>

<h2>📂 Manage Notices</h2>

<!-- Upload Notice Form -->
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Enter notice title" required>
    <input type="file" name="file" accept=".pdf" required>
    <button type="submit" name="upload_notice">Upload Notice</button>
</form>

<!-- Notices Table -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>File</th>
            <th class="centered">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><a href="../<?= $row['file_path'] ?>" target="_blank">View</a></td>
                    <td class="action-buttons">
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete_notice" onclick="return confirm('Delete this notice?')">🗑️</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4" class="centered">No notices available.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
