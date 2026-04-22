<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔐 ADMIN AUTH
if (!isset($_SESSION['is_admin'])) {
    header("Location: ../pages/login.php");
    exit();
}
?>

<link rel="stylesheet" href="../assets/style.css">

<div class="navbar">
  <h2 style="color:#8a2be2;">AdrenaX Admin</h2>

  <div>
    <a href="dashboard.php">Dashboard</a>
    <a href="manage_products.php">Products</a>
    <a href="manage_orders.php">Orders</a>
    <a href="../pages/home.php">View Site</a>
    <a href="../pages/logout.php">Logout</a>
  </div>
</div>

<!-- HTML BELOW -->

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
  <h2>AdrenaX Admin</h2>

  <div>
    <a href="/adrenax/admin/dashboard.php">Dashboard</a>
    <a href="/adrenax/admin/products.php">Products</a>
    <a href="/adrenax/admin/orders.php">Orders</a>
    <a href="/adrenax/pages/home.php">View Site</a>
    <a href="/adrenax/pages/logout.php">Logout</a>
  </div>
</div>