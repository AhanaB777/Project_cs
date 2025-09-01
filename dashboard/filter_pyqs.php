<?php  
include("db_connect.php");

$semesterFilter = isset($_POST['semesters']) ? $_POST['semesters'] : [];
$subjectFilter = isset($_POST['subjects']) ? $_POST['subjects'] : [];
$yearFilter = isset($_POST['years']) ? $_POST['years'] : [];

$query = "SELECT * FROM pyqs WHERE status = 'active'";

// Filtering by semester
if (!empty($semesterFilter)) {
    $semesterFilter = array_map('intval', $semesterFilter);
    $query .= " AND semester IN (" . implode(",", $semesterFilter) . ")";
}

// Filtering by subject
if (!empty($subjectFilter)) {
    $subjectFilter = array_map(function ($subject) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $subject) . "'";
    }, $subjectFilter);
    $query .= " AND subject IN (" . implode(",", $subjectFilter) . ")";
}

// Filtering by year
if (!empty($yearFilter)) {
    $yearFilter = array_map('intval', $yearFilter);
    $query .= " AND year IN (" . implode(",", $yearFilter) . ")";
}

$query .= " ORDER BY year DESC, subject ASC";
$result = mysqli_query($conn, $query);
?>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['semester']; ?></td>
    <td><?php echo $row['subject']; ?></td>
    <td><?php echo $row['year']; ?></td>
    <td><a href="<?php echo $row['file_path']; ?>" download>📥 Download</a></td>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'teacher') { ?>
        <td><a href="delete_pyq.php?id=<?php echo $row['id']; ?>">🗑️ Delete</a></td>
    <?php } ?>
</tr>
<?php } ?>
