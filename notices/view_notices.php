<?php  
include("../config/db_connect.php");  
session_start(); 
 

// 🟡 Handle Date Filtering
$dateFilter = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
$query = "SELECT * FROM notices WHERE status = 'active'";

if ($dateFilter) {
    $query .= " AND DATE(uploaded_at) = '$dateFilter'";
}

$query .= " ORDER BY uploaded_at DESC";

// ✅ Run query and handle failure
$result = mysqli_query($conn, $query);
if (!$result) {
    die("❌ Query Failed: " . mysqli_error($conn));
}
//including the header
include("../headnfoot/header.php");
?>

<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>📢 View Notices</title>  
    <link rel="stylesheet" href="notice.css">
    <script defer src="noticesss.js"></script>
</head>  
<body>  

<h1>📢 Notices</h1>  

<!-- 🔽 Filter Toggle Button -->
<button id="filter-toggle">🔽 Show Filters</button>

<!-- 📌 Hidden Filter Section -->
<div class="filter-section" id="filter-section" style="display: none;">
    <form method="GET">
        <label for="filter_date">Filter by Date:</label>
        <input type="date" name="filter_date" value="<?php echo htmlspecialchars($dateFilter); ?>">
        <button type="submit">Apply Filter</button>
    </form>
</div>

<!-- 📄 Notice Table -->
<table>
    <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Size</th>
        <th>Download</th>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'teacher') { ?>
            <th>Actions</th>
        <?php } ?>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['title']); ?></td>
        <td><?php echo date('d M Y', strtotime($row['uploaded_at'])); ?></td>
        <td><?php echo round($row['file_size'] / 1024, 2) . " KB"; ?></td>
        <td><a href="../<?php echo htmlspecialchars($row['file_path']); ?>" download>📥 Download</a></td>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'teacher') { ?>
            <td class="actions">
                <a href="delete_notice.php?id=<?php echo (int)$row['id']; ?>" class="delete">🗑 Delete</a>
            </td>
        <?php } ?>
    </tr>
    <?php } ?>
</table>

<!-- 🔄 Manage Buttons for Teachers -->

   


<!-- 🔁 JS for Filter Toggle -->
<script>
document.getElementById('filter-toggle').addEventListener('click', function () {
    const section = document.getElementById('filter-section');
    section.style.display = section.style.display === 'none' || section.style.display === '' ? 'flex' : 'none';
});
</script>

</body>  
</html>
