<?php
session_start(); // Start the session to access session variables

// If the user is not logged in, redirect to login
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login.php");
    exit();
}

// Handle logout action
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Outfit', sans-serif;
    }

    body {
      background: linear-gradient(145deg, #0e0e1a, #1a1a2e);
      color: #e0e0e0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
    }

    nav {
      background: rgba(0, 0, 0, 0.25);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    nav .logo {
      font-size: 1.5rem;
      font-weight: 600;
      color: #00ffff;
    }

    nav .nav-links a {
      color: #e0e0e0;
      margin-left: 2rem;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    nav .nav-links a:hover {
      color: #00d9ff;
    }

    .dashboard-title {
      text-align: center;
      margin: 3rem 0 2rem;
      font-size: 2rem;
      color: #ffffff;
      letter-spacing: 1px;
    }

    .buttons-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2rem;
      padding: 0 2rem 4rem;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
    }

    .button {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 15px;
      padding: 2rem;
      text-align: center;
      text-decoration: none;
      color: #ffffff;
      font-size: 1.1rem;
      font-weight: 500;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0, 255, 255, 0.05);
      backdrop-filter: blur(15px);
    }

    .button:hover {
      transform: translateY(-5px);
      border-color: #00d9ff;
      box-shadow: 0 6px 16px rgba(0, 217, 255, 0.2);
    }

    @media (max-width: 600px) {
      .nav-links a {
        margin-left: 1rem;
      }
    }
  </style>
</head>
<body>

  <nav>
    <div class="logo">Admin Dashboard</div>
    <div class="nav-links">
      <a href="../index.php">Homepage</a>
      <a href="dashboard.php?logout=1">Logout</a>
    </div>
  </nav>

  <h1 class="dashboard-title">Control Panel</h1>

  <div class="buttons-container">
    <a href="upload_notice.php" class="button">Upload Notice</a>
    <a href="upload_routine.php" class="button">Upload Routine</a>
    <a href="upload_pyq.php" class="button">Upload PYQs</a>
    <a href="upload_books.php" class="button">Upload Books</a>
    <a href="upload_material.php" class="button">Upload Material</a>
    <a href="manage_notices.php" class="button">Manage Notices</a>
    <a href="manage_faq.php" class="button">Manage FAQ</a>
    <a href="manage_pyqs.php" class="button">Manage PYQs</a>
    <a href="manage_books.php" class="button">Manage Books</a>
    <a href="manage_users.php" class="button">Manage Users</a>
  </div>

</body>
</html>
