<?php
// Start session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../config/db_connect2.php"); // Ensure this file is correctly connected
// Fetch filters
$yearFilter = isset($_GET['year']) ? $_GET['year'] : '';
$subjectFilter = isset($_GET['subject']) ? $_GET['subject'] : '';
// Build query
$query = "SELECT * FROM question_papers";
$conditions = [];
if ($yearFilter) {
    $conditions[] = "year = " . intval($yearFilter);
}
if ($subjectFilter) {
    $conditions[] = "subject LIKE '%" . mysqli_real_escape_string($conn, $subjectFilter) . "%'";
}
if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}
$query .= " ORDER BY year DESC, subject ASC";
// Execute the query
$result = mysqli_query($conn, $query);
// Check if query failed
if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
// Include the header
include("../headnfoot/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Past Year Questions</title>
    <link rel="stylesheet" href="view_Style.css">
    <!--<link rel="stylesheet" href="../homepage/css/styles.css">-->
</head>
<body>

<h1>📜 Past Year Question Papers</h1>

<!-- 🔎 Search & Filter Form -->
<div class="container">
    <form method="GET">
        <label for="year">Filter by Year:</label>
        <input type="number" name="year" value="<?php echo htmlspecialchars($yearFilter); ?>">

        <label for="subject">Filter by Subject:</label>
        <input type="text" name="subject" value="<?php echo htmlspecialchars($subjectFilter); ?>">

        <button type="submit">Apply Filters</button>
        <a href="view_pyqs.php" class="reset-btn">Reset</a>
    </form>

    <table>
        <tr>
            <th>Subject</th>
            <th>Year</th>
            <th>Download</th>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'teacher') { ?>
                <th>Actions</th>
            <?php } ?>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['subject']); ?></td>
            <td><?php echo htmlspecialchars($row['year']); ?></td>
            <td>
                <a href="../<?php echo htmlspecialchars($row['file_url']); ?>" download>📥 Download</a>
            </td>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'teacher') { ?>
                <td>
                    <a href="delete_pyq.php?id=<?php echo intval($row['id']); ?>">🗑 Delete</a>
                </td>
            <?php } ?>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>