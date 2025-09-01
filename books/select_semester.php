<?php 
  include("../headnfoot/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Semester</title>
    <link rel="stylesheet" href="books_styles.css"> 
    <!--<link rel="stylesheet" href="../homepage/css/styles.css">-->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #e0e0e0;
            text-align: center;
            padding: 30px 20px;
            min-height: 100vh;
        }

        h1 {
            font-size: 2.2rem;
            margin-bottom: 25px;
            color: #f0f0f0;
            font-weight: 500;
        }

        .semester-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            max-width: 900px;
            margin: 0 auto;
            
        }

        .sem-btn {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(6px);
            color: #e0e0e0;
            padding: 16px 32px;
            font-size: 1.2rem;
            font-weight: 500;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 180px;
            box-shadow: 0 0 10px #00bfff;
        }

        .sem-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: scale(1.03);
        }

        a {
            text-decoration: none;
        }
        
        header {
        box-shadow: none !important;
        background: rgba(30, 30, 47, 0.9) !important;
    }

    </style>
</head>
<body>

    <h1>Select Your Semester</h1>

    <div class="semester-container">
        <?php
        for ($i = 1; $i <= 6; $i++) {
            echo "<a href='view_books.php?semester=$i'><button class='sem-btn'>{$i} Semester</button></a>";
        }
        ?>
    </div>

</body>
</html>
