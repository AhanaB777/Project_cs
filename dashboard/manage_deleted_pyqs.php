<?php  
include("../config/db_connect2.php");
session_start();
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}

$query = "SELECT * FROM question_papers WHERE status = 'deleted' ORDER BY year DESC";  
$result = mysqli_query($conn, $query);

// Check if query execution was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>  

<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Deleted PYQs</title> 
    <link rel="stylesheet" href="manage.css"> 
</head>  
<body>  

<h1>🗑 Deleted PYQs</h1>  

<table>  
    <tr>  
        <th>Subject</th>  
        <th>Year</th>  
        <th>Restore</th>  
    </tr>  

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>  
    <tr>  
        <td><?php echo htmlspecialchars($row['subject']); ?></td>  
        <td><?php echo htmlspecialchars($row['year']); ?></td>  
        <td>  
            <a href="restore_pyq.php?id=<?php echo $row['id']; ?>">🔄 Restore</a>  
            <a href="delete_pyq.php?id=<?php echo $row['id']; ?>">🗑 Delete</a>
            <a href="permanent_delete_pyq.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Permanently delete this pyq?');">❌ Permanently Delete</a>
        </td>  
    </tr>  
    <?php } ?>  
</table>  

<a href="view_pyqs.php">🔙 View Active PYQs</a>

</body>  
</html>