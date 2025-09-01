<?php
$uploadDir = 'uploads/routines/';
$files = is_dir($uploadDir) ? array_diff(scandir($uploadDir), ['.', '..']) : [];
include("headnfoot/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Routines</title>
    <style>
        body {
            background: #121212;
            font-family: 'Segoe UI', sans-serif;
            color: #e0e0e0;
            padding: 30px;
        }

        h1 {
            text-align: center;
            color: #00ffe7;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 28px;
            text-shadow: 0 0 5px #00ffe7;
        }

        .routine-box {
            background-color: #1f1f1f;
            margin: 20px auto;
            padding: 20px;
            max-width: 800px;
            box-shadow: 0 4px 15px rgba(0,255,231,0.05);
            border-left: 5px solid #00ffe7;
            border-radius: 8px;
        }

        .routine-box h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #ffffff;
        }

        .routine-box a {
            color: #00ffe7;
            text-decoration: none;
            font-weight: bold;
        }

        .routine-box a:hover {
            text-decoration: underline;
        }

        .no-files {
            text-align: center;
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1>📅 Class Routine </h1>

    <?php if (count($files) > 0): ?>
        <?php foreach ($files as $file): ?>
            <div class="routine-box">
                <h3>📂 <?php echo htmlspecialchars($file); ?></h3>
                <a href="<?php echo $uploadDir . $file; ?>" target="_blank">🔗 View File</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-files">No routines available right now.</p>
    <?php endif; ?>
</body>
</html>
