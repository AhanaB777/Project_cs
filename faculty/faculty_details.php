<?php 
include("../headnfoot/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet The Faculties</title>
    <link rel="stylesheet" href="../faculty/faculty_details_styles.css">
</head>
<body>

    <header>
        <h1>Meet The Faculties</h1>
    </header>

    <div class="faculty-container">
        <button class="slide-btn left-btn">&#10094;</button>
        <div class="faculty-slider">
            <!-- Faculty Profiles (Dynamically Loaded) -->
        </div>
        <button class="slide-btn right-btn">&#10095;</button>
    </div>

    <script src="../faculty/faculty_details_script.js"></script>

</body>
</html>
