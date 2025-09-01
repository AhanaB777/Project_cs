<?php
include("../config/db_connect3.php");
session_start();
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$book_id = $_GET['id'];

// Fetch book details
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    echo "Book not found.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $semester = $_POST['semester'];
    $cover_image = $book['cover_image']; // Keep old image by default

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = "../uploads/";
        $new_image_name = basename($_FILES['image']['name']);
        $target_path = $upload_dir . $new_image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            // Save relative path for database
            $cover_image = "uploads/" . basename($new_image_name);

        } else {
            echo "<p style='color:red;'>Failed to upload image.</p>";
        }
    }

    // Update book
    $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, semester = ?, cover_image = ? WHERE id = ?");
    $stmt->bind_param("ssisi", $title, $author, $semester, $cover_image, $book_id);
    $stmt->execute();

    header("Location: manage_books.php?success=updated");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0e1117;
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
            text-shadow: 0 0 5px rgba(0,255,255,0.15);
        }

        form {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border-radius: 10px;
            padding: 30px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.05);
        }

        label {
            display: block;
            margin: 15px 0 6px;
            font-weight: 500;
            color: #a0c4ff;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            background-color: #1e1e2f;
            border: none;
            border-radius: 6px;
            color: #e0e0e0;
            font-size: 14px;
            margin-bottom: 15px;
            outline: none;
        }

        img.preview {
            max-width: 100%;
            margin: 10px 0 20px;
            border: 1px solid #333;
            border-radius: 8px;
        }

        button {
            background: #1fb6ff;
            border: none;
            padding: 12px 20px;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.2s ease;
            display: inline-block;
        }

        button:hover {
            background: #009ee0;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <h2>Edit Book Details</h2>

    <form method="POST" enctype="multipart/form-data">
        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

        <label>Author</label>
        <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>

        <label>Semester</label>
        <input type="number" name="semester" value="<?= $book['semester'] ?>" required min="1" max="6">

        <label>Current Image</label><br>
        <img class="preview" src="../<?= $book['cover_image'] ?>" alt="Current Cover Image">

        <label>Upload New Image (optional)</label>
        <input type="file" name="image">

        <button type="submit">Update Book</button>
    </form>

</body>
</html>
