<?php

session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel | Petrichoor Chocolate</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #ecf0f1;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Navbar */
    .navbar {
      background-color: #3b8dbc;
    }
    .navbar-brand {
      color: #fff !important;
      font-weight: bold;
    }
    .navbar .nav-link {
      color: #fff !important;
    }

    /* Sidebar */
    .sidebar {
      width: 220px;
      background-color: #222d32;
      position: fixed;
      top: 56px;
      bottom: 0;
      left: 0;
      padding-top: 20px;
      overflow-y: auto;
    }
    .sidebar a {
      display: block;
      color: #b8c7ce;
      padding: 10px 20px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #1e282c;
      color: #fff;
    }
    .sidebar h5 {
      color: #4b646f;
      padding: 0 20px;
      margin-bottom: 10px;
      font-size: 14px;
      text-transform: uppercase;
    }

    /* Content */
    .content {
      margin-left: 220px;
      padding: 30px;
    }
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .card-icon {
      font-size: 2rem;
      color: #00c0ef;
    }
    .card h6 {
      font-size: 14px;
      text-transform: uppercase;
      color: #7f8c8d;
    }
    .card .value {
      font-size: 22px;
      font-weight: bold;
      color: #013220;
    }
  </style>
</head>
<body>

  <!-- Top Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Petrichoor Admin</a>
      <div class="ms-auto text-white">Admin</div>
    </div>
  </nav>

  <!-- Sidebar -->
  <div class="sidebar">
    <h5>Main Navigation</h5>
    <a href="categories.php">📁 Categories</a>
    <a href="items.php">🍫 Items</a>
    <a href="jobs.php">🧾 Jobs</a>
    <a href="dashboard_products.php">🍫 Dashboard Products</a>
    <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>


  </div>

  <!-- Main Content -->
  <div class="content">
    <h3 class="mb-4">Dashboard</h3>
  </div>

</body>
</html>
