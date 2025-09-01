<?php
include_once('config/db_connect.php');

$sql = "SELECT question, answer FROM faqs ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
//including header
include("headnfoot/header.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Frequently Asked Questions</title>
    <style>
        body {
            background: #0f172a; /* Dark slate */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px 20px;
            color: #f1f5f9;
        }
        h1 {
            text-align: center;
            color: #38bdf8; /* Sky blue */
            font-size: 2.5em;
            margin-bottom: 40px;
        }
        .faq-box {
            background: #1e293b; /* Darker card */
            margin: 20px auto;
            padding: 25px 30px;
            max-width: 800px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
            transition: transform 0.2s;
        }
        .faq-box:hover {
            transform: translateY(-4px);
        }
        .faq-box h3 {
            color: #22d3ee; /* Cyan */
            font-size: 1.3em;
            margin-bottom: 10px;
        }
        .faq-box p {
            color: #cbd5e1; /* Light gray */
            font-size: 1.05em;
            line-height: 1.6;
        }
        @media (max-width: 600px) {
            .faq-box {
                padding: 20px;
                margin: 15px 10px;
            }
            h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <h1>Frequently Asked Questions</h1>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='faq-box'>";
            echo "<h3>Q: " . htmlspecialchars($row['question']) . "</h3>";
            echo "<p>A: " . nl2br(htmlspecialchars($row['answer'])) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No FAQs available.</p>";
    }
    ?>
</body>
</html>
