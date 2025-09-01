<?php  
include("../config/db_connect.php");  
session_start(); 
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}
include("../headnfoot/header.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $title = $_POST['title'];  
    $file_path = NULL;  

    // Ensure upload directory exists  
    $target_dir = "../notices/notice_files/";  
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Handle file upload  
    if (isset($_FILES['notice_file']) && $_FILES['notice_file']['error'] === 0) {  
        $file_name = time() . "_" . basename($_FILES['notice_file']['name']);  
        $target_file = $target_dir . $file_name;  
        $file_size = $_FILES['notice_file']['size'];  

        if (move_uploaded_file($_FILES['notice_file']['tmp_name'], $target_file)) {  
            $file_path = "notices/notice_files/" . $file_name;
        } else {
            die("Error: File upload failed.");
        }
    }

    // Insert into database  
    $query = "INSERT INTO notices (title, file_path, file_size) VALUES (?, ?, ?)";  
    $stmt = mysqli_prepare($conn, $query);  
    mysqli_stmt_bind_param($stmt, "ssi", $title, $file_path, $file_size);  

    if (mysqli_stmt_execute($stmt)) {  
        echo "<script>alert('Notice added successfully!'); window.location.href='view_notices.php';</script>";
    } else {  
        echo "Error: " . mysqli_error($conn);  
    }  
}  
?>  

<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <title>Upload Notice</title>  
    <link rel="stylesheet" href="upload_notice.css">
</head>  
<body>  

<h1>Upload Notice</h1>  

<form action="add_notice.php" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to add this notice?');">  
    <label for="title">Notice Title:</label>  
    <input type="text" name="title" required>  

    <label for="notice_file">Upload PDF:</label>  
    <input type="file" name="notice_file" accept=".pdf" required>  

    <button type="submit">Upload Notice</button>  
</form>  

<a href="../notices/view_notices.php">🔙 View Notices</a>

</body>  
</html>
