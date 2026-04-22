<?php
include "../includes/auth.php";
include "../includes/db.php";
requireAdmin();
?>

<?php include "../admin/includes/header.php"; ?> 

<div class="admin-container">
<h1>Manage Orders</h1>

<?php
$orders = $conn->query("SELECT o.*, u.name, u.email 
                        FROM orders o
                        JOIN users u ON o.user_id = u.id");

while($order = $orders->fetch_assoc()) {
?>
<link rel="stylesheet" href="../assets/css/style.css">
<div class="order-box">

  <h3>Order #<?php echo $order['id']; ?></h3>

  <p><strong>User:</strong> <?php echo $order['name']; ?> (<?php echo $order['email']; ?>)</p>

  <div class="order-items">
    <strong>Items:</strong>

    <?php
    $items = $conn->query("
      SELECT oi.*, p.name 
      FROM order_items oi
      JOIN products p ON oi.product_id = p.id
      WHERE oi.order_id = ".$order['id']
    );

    while($item = $items->fetch_assoc()) {
      echo "<p>- ".$item['name']." x".$item['quantity']."</p>";
    }
    ?>
  </div>

  <p><strong>Total:</strong> ₹<?php echo $order['total']; ?></p>

  <form method="POST" action="../actions/update_order.php" class="order-form">
    <input type="hidden" name="id" value="<?php echo $order['id']; ?>">

    <select name="status">
      <option <?php if($order['status']=='Processing') echo 'selected'; ?>>Processing</option>
      <option <?php if($order['status']=='Shipped') echo 'selected'; ?>>Shipped</option>
      <option <?php if($order['status']=='Delivered') echo 'selected'; ?>>Delivered</option>
    </select>

    <button type="submit">Update</button>
  </form>

</div>

<?php } ?>

</div>

</body>
</html>