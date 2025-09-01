<?php
include("../config/db_connect2.php");
session_start();
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}
// Redirect if ID is not provided
if (!isset($_GET['id'])) {
    header("Location: manage_pyqs.php?msg=Invalid ID");
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM question_papers WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    echo "<p>❌ PYQ not found!</p>";
    exit();
}

$pyq = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];
    $file_url = $_POST['existing_file_url']; // Default to existing file

    // Handle new file upload if a new file is selected
    if (isset($_FILES['pyq_file']) && $_FILES['pyq_file']['error'] === 0) {
        $upload_dir = "../pyqs/pyq_files/";
        $file_name = time() . "_" . basename($_FILES['pyq_file']['name']);
        $target_path = $upload_dir . $file_name;

        // Create the directory if not exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['pyq_file']['tmp_name'], $target_path)) {
            $file_url = "pyqs/pyq_files/" . $file_name; // Save relative path to DB
        } else {
            echo "<p style='color:red;'>❌ File upload failed.</p>";
        }
    }

    // Update database
    $update_query = "UPDATE question_papers SET subject = ?, semester = ?, year = ?, file_url = ? WHERE id = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($update_stmt, "siisi", $subject, $semester, $year, $file_url, $id);

    if (mysqli_stmt_execute($update_stmt)) {
        header("Location: manage_pyqs.php?msg=PYQ updated successfully!");
        exit();
    } else {
        echo "<p>Error updating PYQ: " . mysqli_stmt_error($update_stmt) . "</p>";
    }
}
include("../headnfoot/header.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit PYQ</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0f1117;
            color: #e0e0e0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 26px;
            color: #c2e9fb;
            text-shadow: 0 0 5px rgba(0,255,255,0.2);
        }

        form {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 30px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.05);
        }

        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: 500;
            color: #a0c4ff;
        }

        select, input[type="number"], input[type="file"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 6px;
            background-color: #1e1e2f;
            color: #e0e0e0;
            font-size: 14px;
            outline: none;
            margin-bottom: 10px;
        }

        button {
            background: #1fb6ff;
            border: none;
            padding: 12px 20px;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 15px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background: #009ee0;
            transform: translateY(-2px);
        }

        p a {
            display: inline-block;
            margin-top: 20px;
            color: #89c2d9;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        p a:hover {
            color: #e0ffff;
        }
    </style>
</head>

<body>

<h2>Edit Past Year Question</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="existing_file_url" value="<?= htmlspecialchars($pyq['file_url']) ?>">

    <label for="subject">Subject:</label>
    <select name="subject" required>
        <?php
        $subjects = [
            "Programming in C", "Computer Architecture", "Programming in JAVA", "Discrete Mathematics",
            "Data Structures", "Operating System", "Computer Networks", "Python Programming",
            "Design and Analysis of Algorithms", "Software Engineering", "DBMS", "Matlab",
            "Internet Technology", "TOC", "Microprocessor", "Numerical Methods", "AI",
            "Computer Graphics", "Data Science"
        ];
        foreach ($subjects as $sub) {
            $selected = ($pyq['subject'] === $sub) ? 'selected' : '';
            echo "<option value='$sub' $selected>$sub</option>";
        }
        ?>
    </select>

    <label for="semester">Semester:</label>
    <select name="semester" required>
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <option value="<?= $i ?>" <?= ($pyq['semester'] == $i) ? 'selected' : '' ?>>Semester <?= $i ?></option>
        <?php endfor; ?>
    </select>

    <label for="year">Year:</label>
    <input type="number" name="year" value="<?= htmlspecialchars($pyq['year']) ?>" min="2019" max="<?= date('Y') ?>" required>

    <label for="pyq_file">Replace PDF (optional):</label>
    <input type="file" name="pyq_file" accept=".pdf">

    <br><br>
    <button type="submit">💾 Save Changes</button>
</form>

<p><a href="manage_pyqs.php">🔙 Back to Manage PYQs</a></p>

</body>
</html>
