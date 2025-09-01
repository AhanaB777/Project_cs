<?php
include("../config/db_connect3.php");
session_start();


// Get semester from GET parameter or default
$semester = isset($_GET['semester']) ? intval($_GET['semester']) : 1;

// Fetch books for selected semester and that are not deleted
$query = "SELECT * FROM books WHERE semester = ? AND is_deleted = 0";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $semester);
$stmt->execute();
$result = $stmt->get_result();
//include header
include("../headnfoot/header.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Books</title>
    <link rel="stylesheet" href="view_books.css">
    <!-- <link rel="stylesheet" href="../homepage/css/styles.css"> --> 
    
</head>
<body>

<h2>Books for Semester <?= $semester ?></h2>

<div class="semester-selector">
    <form method="GET" action="">
        <label for="semester">Select Semester:</label>
        <select name="semester" id="semester" onchange="this.form.submit()">
            <?php for ($i = 1; $i <= 6; $i++): ?>
                <option value="<?= $i ?>" <?= ($i == $semester) ? 'selected' : '' ?>>Semester <?= $i ?></option>
            <?php endfor; ?>

        </select>
    </form>
    
</div>

<div class="books-container">
    <?php while ($book = $result->fetch_assoc()): ?>
        <div class="book-card">
            <?php
                $imagePath = "../" . $book['cover_image'];
                $filePath = isset($book['file']) ? "../" . $book['file'] : null;

                // Display image
                if (!empty($book['cover_image']) && file_exists($imagePath)) {
                    echo "<img src='$imagePath' alt='Book Cover'>";
                } else {
                    echo "<img src='../uploads/placeholder.jpg' alt='No Image'>";
                }

                $file_path = isset($book['file_path']) ? "../" . $book['file_path'] : null;

                 // Display book and author name
                echo "<h3>" . htmlspecialchars($book['title']) . "</h3>";
                echo "<p><strong>Author:</strong> " . htmlspecialchars($book['author']) . "</p>";
                
                // Display download button
                if (!empty($book['file_path']) && file_exists($file_path)) {
                    echo "<a class='download-btn' href='$file_path' download>Download Book</a>";
                } else {
                    echo "<p style='color:red'>Book file not available</p>";
                }
                

               
            ?>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
