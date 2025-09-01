<?php
session_start();
require 'db_connect.php'; 
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_faq'])) {
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        $sql = "INSERT INTO faqs (question, answer) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $question, $answer);
        $stmt->execute();
    } elseif (isset($_POST['edit_faq'])) {
        $id = $_POST['id'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        $sql = "UPDATE faqs SET question = ?, answer = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $question, $answer, $id);
        $stmt->execute();
    } elseif (isset($_POST['delete_faq'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM faqs WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

$sql = "SELECT * FROM faqs";
$result = $conn->query($sql);
include("../headnfoot/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage FAQs</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
        background-color: #0f1117;
        color: #e0e0e0;
        padding: 20px;
    }

    nav {
        background-color: #1a1f2b;
        padding: 12px 20px;
        box-shadow: 0 0 12px rgba(0, 255, 255, 0.05);
    }

    nav ul {
        list-style: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    nav li {
        padding: 10px 15px;
        font-size: 15px;
        color: #cdd7f1;
    }

    nav a {
        color: #aad4ff;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    nav a:hover {
        color: #ffffff;
    }

    .sidebar {
        position: fixed;
        top: 0;
        right: 0;
        height: 100vh;
        width: 250px;
        background-color: #111827;
        backdrop-filter: blur(8px);
        box-shadow: -10px 0 20px rgba(0, 0, 0, 0.3);
        display: none;
        flex-direction: column;
        padding-top: 20px;
        z-index: 999;
    }

    .sidebar li {
        padding: 15px;
        text-align: left;
    }

    h1, h2 {
        text-align: center;
        color: #aad4ff;
        margin: 20px 0;
    }

    form {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 0 16px rgba(0, 255, 255, 0.03);
        margin: 20px auto;
        max-width: 600px;
    }

    form input, form textarea {
        width: 100%;
        margin-bottom: 15px;
        padding: 12px;
        font-size: 16px;
        background-color: #1e2838;
        color: #cdd7f1;
        border: 1px solid #394b61;
        border-radius: 6px;
    }

    form button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #3fa9f5;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
        color: white;
    }

    form button:hover {
        background-color: #2669aa;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(6px);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 255, 255, 0.03);
    }

    th, td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    th {
        background-color: #1f2937;
        color: #aad4ff;
    }

    td {
        color: #e0e0e0;
    }

    td form {
        margin: 5px 0;
        background: none;
        box-shadow: none;
        padding: 0;
    }

    td form input, td form textarea {
        width: 100%;
        margin-bottom: 8px;
        font-size: 14px;
    }

    td form button {
        width: 100%;
        padding: 8px;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        table, thead, tbody, th, td, tr {
            display: block;
        }
        tr {
            margin-bottom: 20px;
            border-bottom: 2px solid #1f2937;
        }
        td {
            padding: 10px;
        }
    }
    </style>

</head>
<body>
<div class="topnav">
        <nav>
            <ul class="sidebar">
            <li onclick=hideSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="upload_material.php">Upload Materials</a></li>
            <li><a href="upload_routine.php">Upload Routine</a></li>
            <li><a href="manage_notices.php">Manage Notices</a></li>
            <li><a href="logout.php">Logout</a></li>
            </ul>
            <ul>
            <li><a href="dashboard.php">Go to dashboard</a></li>
            <li>FAQs</li>
            <li onclick=showSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>
            </ul>
        </nav>

        <h1>Manage FAQs</h1>

        <form method="POST">
            <h2>Add FAQ</h2>
            <input type="text" name="question" placeholder="Enter question" required>
            <textarea name="answer" placeholder="Enter answer" required></textarea>
            <button type="submit" name="add_faq">Add FAQ</button>
        </form>

        <h2>Existing FAQs</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['question']; ?></td>
                        <td><?php echo $row['answer']; ?></td>
                        <td>
                        
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="question" value="<?php echo $row['question']; ?>" required>
                                <textarea name="answer" required><?php echo $row['answer']; ?></textarea>
                                <button type="submit" name="edit_faq">Edit</button>
                            </form>
                      
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_faq">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
           
</body>
</html>