<?php
session_start();
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}
// File upload logic
if (isset($_POST['submit'])) {
    $file = $_FILES['file'];
    $fileName = time() . '_' . basename($file['name']);
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    // Get file extension
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    // Allowed file types
    $allowed = array('jpg', 'jpeg', 'pdf', 'png');
    
    // Check if the file type is allowed
    if (in_array($fileActualExt, $allowed)) {
        // Check for upload errors
        if ($fileError === 0) {
            // Check file size
            if ($fileSize < 100000000) {
                $uploadDir = 'uploads/materials/';

                // Create the directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Create directory with write permissions
                }

                // Destination path for the uploaded file
                $fileDestination = $uploadDir . $fileName;

                // Move the file to the destination folder
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    echo "Your file has been successfully uploaded!<br>";

                    // Check if the file exists after upload
                    if (file_exists($fileDestination)) {
                        echo "The file exists in the folder.";
                    } else {
                        echo "The file could not be found in the folder.";
                    }
                } else {
                    echo "There was an error moving the uploaded file.";
                }
            } else {
                echo "File is too big!";
            }
        } else {
            echo "There was an error uploading your file.";
        }
    } else {
        echo "Only PDF, JPG, JPEG, and PNG files are allowed.";
    }
}
include("../headnfoot/header.php");
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Upload Material</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
        background-color: #0f1117;
        color: #e0e0e0;
    }

    nav {
        background-color: #1a1f2b;
        padding: 12px 20px;
        box-shadow: 0 0 12px rgba(0, 255, 255, 0.05);
    }

    nav ul {
        list-style: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    nav li {
        padding: 10px 15px;
        font-size: 15px;
        color: #cdd7f1;
    }

    nav h1 {
        font-size: 20px;
        font-weight: bold;
        color: #c2e9fb;
        text-shadow: 0 0 6px rgba(0, 255, 255, 0.08);
    }

    nav a {
        color: #aad4ff;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    nav a:hover {
        color: #ffffff;
    }

    .sidebar {
        position: fixed;
        top: 0;
        right: 0;
        height: 100vh;
        width: 250px;
        background-color: #111827;
        backdrop-filter: blur(8px);
        box-shadow: -10px 0 20px rgba(0, 0, 0, 0.3);
        display: none;
        flex-direction: column;
        padding-top: 20px;
        z-index: 999;
    }

    .sidebar li {
        padding: 15px;
        text-align: left;
    }

    form {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 30px;
        border-radius: 16px;
        width: 400px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 0 20px rgba(0, 255, 255, 0.05);
    }

    form input[type="file"] {
        width: 100%;
        padding: 12px;
        border: none;
        background-color: #1e2838;
        color: #cdd7f1;
        border-radius: 6px;
        margin-bottom: 20px;
        cursor: pointer;
    }

    form button {
        background-color: #3fa9f5;
        border: none;
        border-radius: 6px;
        padding: 10px 16px;
        cursor: pointer;
        transition: background 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    form button:hover {
        background-color: #2669aa;
    }

    form svg {
        fill: white;
    }

    @media (max-width: 500px) {
        form {
            width: 90%;
        }
    }
    </style>

</head>
<body>
<div class="topnav">
    <nav>
        <ul class="sidebar">
            <li onclick="hideSidebar()">
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a>
            </li>
            <li><a href="dashboard.php">Back</a></li>
            <li><a href="upload_routine.php">Upload Routine</a></li>
            <li><a href="manage_notices.php">Manage Notices</a></li>
            <li><a href="manage_faq.php">Manage FAQs</a></li>
        </ul>
        <ul>
            <li><a href="dashboard.php">Go to dashboard</a></li>
            <li><h1>UPLOAD MATERIAL</h1></li>
            <li>Upload the material below</li>
            <li onclick="showSidebar()">
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a>
            </li>
        </ul>
    </nav>

    <form action="upload_material.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file"><br>
        <button type="submit" name="submit">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                <path d="M440-320v-326L336-542l-56-58 200-200 200 200-56 58-104-104v326h-80ZM240-160q-33 0-56.5-23.5T160-240v-120h80v120h480v-120h80v120q0 33-23.5 56.5T720-160H240Z"/>
            </svg>
        </button>
    </form>
</div>

<script>
    function showSidebar() {
        document.querySelector('.sidebar').style.display = 'flex';
    }
    function hideSidebar() {
        document.querySelector('.sidebar').style.display = 'none';
    }
</script>
</body>
</html>
