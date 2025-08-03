<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Computer Science Department</title>
  <style>
    /* Reset & Base */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #0e1117;
      color: #e4ecf4;
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* Header */
    header {
      background: rgba(255,255,255,0.03);
      backdrop-filter: blur(10px);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 10px rgba(0, 255, 255, 0.05);
    }

    .logo-title {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .logo-title img {
      width: 40px;
      height: 40px;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 1.2rem;
    }

    nav a {
      text-decoration: none;
      color: #e0f7fa;
      font-weight: 500;
      padding: 8px 12px;
      border-radius: 6px;
      transition: all 0.3s ease-in-out;
    }

    nav a:hover {
      background-color: rgba(0, 255, 255, 0.1);
      box-shadow: 0 0 10px rgba(0, 255, 255, 0.2);
    }

    /* Main Section */
    .hero {
      text-align: center;
      padding: 80px 20px 40px;
      animation: fadeInUp 1s ease-in-out;
    }

    .hero h1 {
      font-size: 2.5rem;
      color: #00f7ff;
      text-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
    }

    .hero p {
      color: #ccc;
      margin-top: 10px;
      max-width: 600px;
      margin-inline: auto;
      font-size: 1.1rem;
    }

    /* Grid Cards */
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      padding: 40px 20px;
      max-width: 1200px;
      margin: auto;
    }

    .card {
      background: rgba(255, 255, 255, 0.04);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(0, 255, 255, 0.1);
      padding: 20px;
      border-radius: 12px;
      transition: transform 0.3s, box-shadow 0.3s;
      text-align: center;
      color: #e6f9ff;
      cursor: pointer;
      text-decoration: none;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
    }

    /* Uploaded Files */
    #uploaded-files {
      display: none;
      padding: 20px;
      text-align: center;
    }

    #uploaded-files ul {
      list-style: none;
      padding: 0;
    }

    #uploaded-files a {
      color: #00e5ff;
      text-decoration: none;
    }

    #uploaded-files a:hover {
      color: #80eaff;
    }

    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 600px) {
      .hero h1 { font-size: 2rem; }
    }
  </style>
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
      <?php if (!isset($_SESSION['admin_username'])): ?>
        <li><a href="login/login_page.php">Login</a></li>
      <?php endif; ?>
      <?php if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'teacher')): ?>
        <li><a href="dashboard/dashboard.php">Dashboard</a></li>
      <?php endif; ?>
      <?php if (isset($_SESSION['admin_username'])): ?>
        <li><a href="logout.php">Logout</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<section class="hero">
  <h1>COMPUTER SCIENCE PORTAL</h1>
  <p>Welcome to our own department portal for one-stop access to notices, previous year questions, books and more.</p>
</section>

<section class="grid">
  <a href="notices/view_notices.php" class="card">
    <h3>Notices</h3>
    <p>Get the latest updates from the Computer Science Departmen</p>
  </a>
  <a href="pyqs/view_pyqs.php" class="card">
    <h3>PYQs</h3>
    <p>Access previous years’ question papers</p>
  </a>
  <a href="books/view_books.php" class="card">
    <h3>Books</h3>
    <p>Find the best books for your courses</p>
  </a>
  <a href="faqView.php" class="card">
    <h3>FAQs</h3>
    <p>Find your commonly asked questions answered by the faculty</p>
  </a>
  <a href="faculty/faculty_details.php" class="card">
    <h3>Faculty</h3>
    <p>Meet our faculty members and their expertise.</p>
  </a>
  <a href="#" class="card" id="tba-link">
    <h3>Syllabus</h3>
    <p>View syllabus of CS or BCA</p>
  </a>
</section>

<div id="uploaded-files">
  <h3>Download Syllabus using the links below 🔽</h3>
  <ul>
    <?php
    $dir = "dashboard/uploads/materials/";
    if (is_dir($dir)) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            echo "<li><a href='$dir$file' download>$file</a></li>";
        }
    } else {
        echo "<li>No materials available.</li>";
    }
    ?>
  </ul>
</div>

<script>
  document.getElementById("tba-link").addEventListener("click", function(e) {
    e.preventDefault();
    const section = document.getElementById("uploaded-files");
    section.style.display = section.style.display === "block" ? "none" : "block";
    section.scrollIntoView({ behavior: "smooth" });
  });
</script>

</body>
</html>
