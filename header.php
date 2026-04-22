<?php include "session.php"; ?>

<div class="navbar">
  <h2>AdrenaX</h2>

  <div>
    <?php if(isset($_SESSION['user_id'])): ?>

        <?php if($_SESSION['role'] === 'admin'): ?>
            <a href="/adrenax/admin/dashboard.php">Dashboard</a>
            <a href="/adrenax/admin/manage_products.php">Products</a>
            <a href="/adrenax/admin/manage_orders.php">Orders</a>
        <?php else: ?>
            <a href="/adrenax/pages/home.php">Home</a>
            <a href="/adrenax/pages/shop.php">Shop</a>
            <a href="/adrenax/pages/orders.php">Orders</a>
            <a href="/adrenax/pages/cart.php">cart</a>
        <?php endif; ?>

        <a href="/adrenax/actions/logout.php">Logout</a>

    <?php else: ?>
        <a href="/adrenax/pages/login.php">Login</a>
    <?php endif; ?>
  </div>
</div>