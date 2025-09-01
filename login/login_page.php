<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | CS Portal</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <header>
  <div class="logo-title">
    <img src="CS.png" alt="Logo" />
    <h2>CS Department</h2>
  </div>
  <nav>
    <ul>
      <li><a href="notices/view_notices.php">Notice</a></li>
      <li><a href="pyqs/view_pyqs.php">PYQs</a></li>
      <li><a href="books/select_semester.php">Books</a></li>
      <li><a href="routineView.php">Routine</a></li>
      <li><a href="faqView.php">FAQs</a></li>
      <!--<//?php if (!isset($_SESSION['admin_username'])): ?>
        <li><a href="login/login_page.php">Login</a></li>
      <//?php endif; ?>
      <//?php if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'teacher')): ?>
        <li><a href="dashboard/dashboard.php">Dashboard</a></li>
      <//?php endif; ?>
      <//?php if (isset($_SESSION['admin_username'])): ?>
        <li><a href="logout.php">Logout</a></li>
      <//?php endif; ?>-->
    </ul>
  </nav>
</header>
  <div class="main-wrapper">
  <div class="title-card">
    <h1>Siliguri College</h1>
    <h2>Department of Computer Science</h2>
  </div>
  <div class="login-box">
    <h3>Admin Login</h3>
  <form action="process_login.php" method="POST">
    <input type="text" name="username" placeholder="Username" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Login</button>
    <?php if (isset($_SESSION['login_error'])): ?>
      <div class="error"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
    <?php endif; ?>
  </form>
  </div>
    </div>
  <footer>
    <p><a href="../index.php">Back to Homepage</a></p>
  </footer>
</body>
</html>
