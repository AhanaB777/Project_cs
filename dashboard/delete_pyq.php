<?php  
include("../config/db_connect2.php");
session_start();  
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}
if (isset($_GET['id'])) {  
    $id = $_GET['id'];  
    $query = "UPDATE question_papers SET status = 'deleted' WHERE id = ?";  
    $stmt = mysqli_prepare($conn, $query);  
    mysqli_stmt_bind_param($stmt, "i", $id);  
    mysqli_stmt_execute($stmt);  
}  

header("Location: ../pyqs/manage_pyqs.php?msg=PYQ deleted successfully!");
exit();
?>
