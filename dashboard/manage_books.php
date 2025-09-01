<?php

include("../config/db_connect3.php");  
session_start();  
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}
include("../headnfoot/header.php");

// Handle Delete (Soft Delete)
if (isset($_GET['delete'])) {
    $book_id = $_GET['delete'];
    $sql = "UPDATE books SET is_deleted = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
}

// Handle Restore
if (isset($_GET['restore'])) {
    $book_id = $_GET['restore'];
    $sql = "UPDATE books SET is_deleted = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
}

// Handle Permanent Delete
if (isset($_GET['permanent_delete'])) {
    $book_id = $_GET['permanent_delete'];
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
}

// Fetch Books
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <link rel="stylesheet" href="manage_books.css">
</head>
<body>
    <h1>Manage Books</h1>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Semester</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['author']); ?></td>
                <td><?php echo htmlspecialchars($row['semester']); ?></td>
                <td>
                   <?php if ($row['is_deleted'] == 0): ?>
                   <a class="action-btn delete-btn" href="../books/delete_book.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this book?');">
                         Delete book
                   </a>
                   <?php else: ?>
                   <a class="action-btn restore-btn" href="../books/restore_book.php?id=<?= $row['id']; ?>" onclick="return confirm('Restore this book?');">
                           Restore book
                   </a>
                   <?php endif; ?>
    |
                   <a class="action-btn permdelete-btn" href="../books/permanent_delete_book.php?id=<?= $row['id']; ?>" onclick="return confirm('This action is irreversible! Do you want to permanently delete this book?');">
                           Permanent Delete
                   </a>

                   <a href="edit_book.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">
                         Edit book
                   </a>

                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
