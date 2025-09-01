<?php
session_start();
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}
$uploadDir = '../uploads/routines/';
$message = "";

// Ensure upload directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Handle Upload
if (isset($_POST['submit'])) {
    $file = $_FILES['file'];
    $fileName = time() . '_' . basename($file['name']);
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'pdf'];

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 100000000) {
                $destination = $uploadDir . $fileName;
                if (move_uploaded_file($fileTmpName, $destination)) {
                    $message = "✅ File uploaded successfully.";
                } else {
                    $message = "⚠️ Failed to move uploaded file.";
                }
            } else {
                $message = "❌ File is too large.";
            }
        } else {
            $message = "❌ Error while uploading file.";
        }
    } else {
        $message = "❌ Invalid file type. Only PDF, JPG, JPEG, PNG allowed.";
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $fileToDelete = basename($_GET['delete']);
    $fullPath = $uploadDir . $fileToDelete;
    if (file_exists($fullPath)) {
        unlink($fullPath);
        $message = "🗑️ File deleted successfully.";
    } else {
        $message = "❌ File not found.";
    }
}

// Get Uploaded Files
$files = is_dir($uploadDir) ? array_diff(scandir($uploadDir), ['.', '..']) : [];
//including header
include("../headnfoot/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Routine</title>
    <style>
        body {
            background-color: #1a1a1a;
            font-family: Arial, sans-serif;
            color: #eee;
            padding: 30px;
        }

       nav {
    background: linear-gradient(135deg, #2c2c2c, #1f1f1f);
    padding: 20px 30px;
    color: #00ffe7;
    font-size: 26px;
    font-weight: bold;
    text-align: center;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 255, 231, 0.2);
    letter-spacing: 1px;
    text-transform: uppercase;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin-bottom: 30px;
}


        .container {
            max-width: 850px;
            margin: auto;
            background-color: #2b2b2b;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #fff;
            margin-bottom: 20px;
            border-bottom: 1px solid #444;
            padding-bottom: 8px;
        }

        .message {
            margin-bottom: 20px;
            padding: 12px;
            background-color: #333;
            border-left: 4px solid #00b894;
            border-radius: 6px;
            color: #ccc;
        }

        form input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #444;
            background-color: #1e1e1e;
            color: #ddd;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        form button {
            padding: 10px 20px;
            background-color: #444;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        form button:hover {
            background-color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #444;
        }

        th {
            background-color: #3a3a3a;
            color: #fff;
        }

        td {
            background-color: #2d2d2d;
        }

        .action-links a {
            color: #1e90ff;
            text-decoration: none;
            margin-right: 15px;
        }

        .action-links a.delete {
            color: #ff5555;
        }

        .no-files {
            text-align: center;
            color: #888;
            padding: 15px;
        }
    </style>
</head>
<body>

<nav>
    📂 Routine Upload & Management
</nav>

<div class="container">
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <h2>Upload a New Routine</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit" name="submit">Upload</button>
    </form>

    <h2>Uploaded Routines</h2>
    <table>
        <thead>
            <tr>
                <th>File Name</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($files) > 0): ?>
                <?php foreach ($files as $file): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($file); ?></td>
                        <td><?php echo strtoupper(pathinfo($file, PATHINFO_EXTENSION)); ?></td>
                        <td class="action-links">
                            <a href="<?php echo $uploadDir . $file; ?>" target="_blank">View</a>
                            <a href="?delete=<?php echo urlencode($file); ?>" class="delete" onclick="return confirm('Delete this file?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3" class="no-files">No routines uploaded yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
