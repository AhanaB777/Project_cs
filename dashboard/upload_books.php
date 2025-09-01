<?php
  // NOTE: Copied this file from books folder to dashboard folder 
include("../config/db_connect3.php");  
session_start();  
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $semester = $_POST['semester'];
    $subject = $_POST['subject'];

    // Handle Book PDF Upload
    $file_name = $_FILES['book_file']['name'];
    $file_tmp = $_FILES['book_file']['tmp_name'];
    $file_size = $_FILES['book_file']['size']; // Get file size
    $upload_dir = "../uploads/books/";
    $relative_file_path = "uploads/books/" . basename($file_name); // Fixed path for browser download
    $file_path = $upload_dir . basename($file_name);               // Full path for moving file

    // Handle Book Cover Image Upload
    $cover_name = $_FILES['cover_image']['name'];
    $cover_tmp = $_FILES['cover_image']['tmp_name'];
    $cover_size = $_FILES['cover_image']['size']; // Get cover image size
    $cover_upload_dir = "../uploads/covers/";
    $relative_cover_path = "uploads/covers/" . basename($cover_name); // Match for frontend
    $cover_path = $cover_upload_dir . basename($cover_name);          // Actual path

    // Validation for file types and sizes (Server-Side)
    $allowed_pdf_types = ['application/pdf'];
    $allowed_image_types = ['image/jpeg', 'image/png'];
    $max_file_size = 10 * 1024 * 1024; // Max size for PDF (10MB)
    $max_cover_size = 5 * 1024 * 1024; // Max size for Cover Image (5MB)

    // Check if the book file is PDF and within size limit
    if (!in_array($_FILES['book_file']['type'], $allowed_pdf_types)) {
        echo "<script>alert('Only PDF files are allowed for the book.');</script>";
    } elseif ($file_size > $max_file_size) {
        echo "<script>alert('The book file size must be less than 10MB.');</script>";
    }

    // Check if the cover image is JPG/PNG and within size limit
    elseif (!in_array($_FILES['cover_image']['type'], $allowed_image_types)) {
        echo "<script>alert('Only JPG and PNG images are allowed for the cover.');</script>";
    } elseif ($cover_size > $max_cover_size) {
        echo "<script>alert('The cover image size must be less than 5MB.');</script>";
    } else {
        // If all validations passed, move the files
        if (move_uploaded_file($file_tmp, $file_path) && move_uploaded_file($cover_tmp, $cover_path)) {
            // Insert into database using relative paths
            $sql = "INSERT INTO books (title, author, semester, subject, file_path, cover_image) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            // Check if the prepare statement was successful
            if (!$stmt) {
                die("SQL prepare failed: " . $conn->error);
            }

            // Ensure semester is an integer
            $semester = (int)$semester;

            $stmt->bind_param("ssisss", $title, $author, $semester, $subject, $relative_file_path, $relative_cover_path);

            if ($stmt->execute()) {
                echo "<script>alert('Book uploaded successfully!'); window.location.href='upload_books.php';</script>";
            } else {
                echo "<script>alert('Error uploading book.');</script>";
            }
        } else {
            echo "<script>alert('File upload failed.');</script>";
        }
    }
}
include("../headnfoot/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="upload_books.css"> <!-- Linked Stylesheet -->
    <!--<link rel="stylesheet" href="../homepage/css/styles.css"> -->
</head>
<body>
<div class="main-container">
<!-- HTML Form for Uploading Books with Cover Image -->
<form method="POST" enctype="multipart/form-data">
    <h2>Upload Books</h2>
    
    <label>Title:</label>
    <input type="text" name="title" required>

    <label>Author:</label>
    <input type="text" name="author" required>

    <label>Semester:</label>
    <select name="semester">
        <option value="1">1st Semester</option>
        <option value="2">2nd Semester</option>
        <option value="3">3rd Semester</option>
        <option value="4">4th Semester</option>
        <option value="5">5th Semester</option>
        <option value="6">6th Semester</option>
    </select>

    <label>Subject:</label>
    <input type="text" name="subject" required>

    <label>Upload Book (PDF only, max 10MB):</label>
    <input type="file" name="book_file" accept=".pdf" required>

    <label>Upload Cover Image (JPG/PNG only, max 5MB):</label>
    <input type="file" name="cover_image" accept="image/*" required>

    <button type="submit">Upload Book</button>
</form>
</div>
</body>
</html>
