<?php
include(__DIR__ . "/../config/db_connect3.php");
 
session_start();
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Delete the book permanently
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        echo "<script>alert('Book permanently deleted!'); window.location.href='manage_books.php';</script>";
    } else {
        echo "<script>alert('Failed to delete book permanently.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>
