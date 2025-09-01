<?php
include("../config/db_connect2.php");
session_start();
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];
    $file_path = NULL;

    // File upload path (relative to current file location)
    $target_dir = "../pyqs/pyq_files/";

    // Create folder if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Handle file upload
    if (isset($_FILES['pyq_file']) && $_FILES['pyq_file']['error'] === 0) {
        $file_name = time() . "_" . basename($_FILES['pyq_file']['name']);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['pyq_file']['tmp_name'], $target_file)) {
            // File path to be saved in DB (relative to root)
            $file_path = "pyqs/pyq_files/" . $file_name;
        } else {
            echo "<p class='error'>Error: File upload failed.</p>";
            exit();
        }
    }

    // Insert into database with status field
    $query = "INSERT INTO question_papers (subject, semester, year, file_url, status) VALUES (?, ?, ?, ?, 'active')";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "siis", $subject, $semester, $year, $file_path);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../pyqs/view_pyqs.php?msg=PYQ uploaded successfully!");
            exit();
        } else {
            echo "<p class='error'>Database Execution Error: " . mysqli_stmt_error($stmt) . "</p>";
        }
    } else {
        echo "<p class='error'>Query Prepare Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PYQ</title>
    <link rel="stylesheet" href="upload_pyq.css">
</head>
<body>

<h1>Upload Past Year Question Paper</h1>

<div class="container">
    <form action="upload_pyq.php" method="POST" enctype="multipart/form-data">
        <label for="semester">Semester:</label>
        <select name="semester">
            <?php for ($i = 1; $i <= 6; $i++) {
                echo "<option value='$i'>Semester $i</option>";
            } ?>
        </select>

        <label for="subject">Subject:</label>
        <select name="subject">
            <?php
            $subjects = [
                "Programming in C", "Computer Architecture", "Programming in JAVA", "Discrete Mathematics",
                "Data Structures", "Operating System", "Computer Networks", "Python Programming",
                "Design and Analysis of Algorithms", "Software Engineering", "DBMS", "Matlab",
                "Internet Technology", "TOC", "Microprocessor", "Numerical Methods", "AI",
                "Computer Graphics", "Data Science"
            ];
            foreach ($subjects as $sub) {
                echo "<option value='$sub'>$sub</option>";
            }
            ?>
        </select>

        <label for="year">Year:</label>
        <input type="number" name="year" min="2019" max="<?php echo date('Y'); ?>" required>

        <label for="pyq_file">Upload PDF:</label>
        <input type="file" name="pyq_file" accept=".pdf" required>

        <button type="submit">Upload</button>
    </form>

    <p><a href="../pyqs/view_pyqs.php">🔙 View PYQs</a></p>
    <div class="upload-manage-container">
        <a href="Project_cs/dashboard/upload_pyq.php" class="upload-btn">➕ Upload New PYQ (Teachers Only)</a>
        <a href="Project_cs/pyqs/manage_deleted_pyqs.php" class="manage-btn">🗑 Manage Deleted PYQs</a>
    </div>
</div>

</body>
</html>