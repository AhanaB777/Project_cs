<?php  
include("../config/db_connect.php");  
session_start();
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}
// Check if ID is provided
if (!isset($_GET['id'])) {
    die("Invalid request! No ID provided.");
}

$id = (int)$_GET['id'];

// Fetch existing notice
$stmt = $conn->prepare("SELECT * FROM notices WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$notice = $result->fetch_assoc();
$stmt->close();

if (!$notice) {
    die("Notice not found!");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $file_path = $notice['file_path']; // Keep current file by default

    // Handle new file upload
    if (isset($_FILES['notice_file']) && $_FILES['notice_file']['error'] === 0) {
        $file_name = time() . '_' . basename($_FILES['notice_file']['name']);
        $target_dir = "../notices/notice_files/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . $file_name;
        $file_ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($file_ext === "pdf") {
            // Delete old file
            if ($file_path && file_exists("../" . $file_path)) {
                unlink("../" . $file_path);
            }

            // Move uploaded file
            if (move_uploaded_file($_FILES['notice_file']['tmp_name'], $target_file)) {
                $file_path = "notices/notice_files/" . $file_name;
            } else {
                echo "<p class='error'>Error uploading the new file.</p>";
            }
        } else {
            echo "<p class='error'>Only PDF files are allowed.</p>";
        }
    }

    // Update notice in the database
    $stmt = $conn->prepare("UPDATE notices SET title = ?, file_path = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $file_path, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Notice updated successfully!'); window.location.href='manage_notices.php';</script>";
        exit;
    } else {
        echo "<p class='error'>Error updating notice: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Notice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 40px;
        }
        .container {
            background: #fff;
            padding: 25px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
        }
        form label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        form input[type="text"],
        form input[type="file"],
        form button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }
        form button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background: #0056b3;
        }
        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

<div class="container">
    <h1>✏️ Edit Notice</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Notice Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($notice['title']); ?>" required>

        <label for="notice_file">Replace PDF (optional):</label>
        <input type="file" name="notice_file" accept=".pdf">

        <?php if ($notice['file_path']): ?>
            <p>📎 Current File: <a href="../<?php echo $notice['file_path']; ?>" target="_blank">View PDF</a></p>
        <?php else: ?>
            <p>No file uploaded.</p>
        <?php endif; ?>

        <button type="submit">Update Notice</button>
    </form>

    <a href="manage_notices.php">🔙 Back to Manage Notices</a>
</div>

</body>
</html>
