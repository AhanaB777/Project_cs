<?php session_start();
include("../headnfoot/header.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PYQ Manager</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link id="tab-style" rel="stylesheet" href="upload_pyq.css">

  <style>
    body {
      margin: 0;
      background: #0f0c29;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h1 {
      text-align: center;
      color: cyan;
      margin-top: 20px;
      font-size: 2rem;
    }

    .tabs {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin: 20px auto;
    }

    .tabs button {
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      background-color: rgba(0,255,255,0.1);
      color: #00ffff;
      border: 1px solid #00ffff;
      transition: all 0.3s ease;
    }

    .tabs button:hover,
    .tabs button.active {
      background-color: #00ffff;
      color: #000;
    }

    .tab-content iframe {
      width: 95%;
      height: 80vh;
      border: none;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,255,255,0.2);
      margin: auto;
      display: block;
    }
  </style>
</head>
<body>

  <h1>Past Year Question Paper Module</h1>

  <div class="tabs">
    <button class="tab-btn active" onclick="switchTab('upload_pyq.php', 'upload_pyq.css', this)">Upload PYQ</button>
    <button class="tab-btn" onclick="switchTab('manage_pyqs.php', 'manage_pyqs.css', this)">Manage PYQs</button>
  </div>

  <div class="tab-content">
    <iframe id="tab-frame" src="upload_pyq.php"></iframe>
  </div>

  <script>
    function switchTab(page, cssFile, btn) {
      // Change iframe source
      document.getElementById('tab-frame').src = page;

      // Change CSS
      document.getElementById('tab-style').href = cssFile;

      // Toggle button states
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
    }
  </script>

</body>
</html>
