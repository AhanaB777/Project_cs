<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CS Department</title>
  <link rel="stylesheet" href="/Project_cs/headnfoot/styles.css" />
</head>
<body>

  <!-- Header -->
  <header id="main-header">
    <div class="logo-title">
      <img src="/Project_cs/headnfoot/CS.png" alt="Logo" class="logo" />
      <h1>Computer Science Department</h1>
    </div>
    <nav class="top-nav">
      <ul>
        <li><a href="/Project_cs/index.php">Home</a></li>
        <li><a href="/Project_cs/notices/view_notices.php">Notice</a></li>
        <li><a href="/Project_cs/books/view_books.php">Books</a></li>
        <li><a href="/Project_cs/routineView.php">Routine</a></li>
        <li><a href="/Project_cs/faqView.php">FAQs</a></li>
        <?php if (isset($_SESSION['admin_username'])): ?>
          <li><a href="/Project_cs/login/logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="/Project_cs/login/login_page.php">Login</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <!-- Hamburger Icon -->
  <div class="hamburger" id="hamburger-btn">
    <span></span>
    <span></span>
    <span></span>
  </div>

  <!-- Background Overlay -->
  <div id="nav-overlay" class="overlay hidden"></div>

  <!-- Background Image -->
  <!-- <div class="background-container"> -->
   <!-- <img src="/cs-portal/headnfoot/background.jpg" alt="Background Image" /> -->
  <!--</div> -->

  <script src="/Project_cs/headnfoot/script.js" defer></script>
</body>
</html>