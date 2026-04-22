<?php
include "../includes/auth.php";
include("../includes/db.php");
requireAdmin();
?>

<?php include "../includes/header.php"; ?>
<link rel="stylesheet" href="../assets/css/style.css">
<div class="admin-container">

<h1>Manage Orders</h1>

<table class="admin-table">

<tr>
  <th>Order ID</th>
  <th>Total</th>
  <th>Status</th>
  <th>Action</th>
</tr>

<?php
$res = $conn->query("SELECT * FROM orders");

while($row = $res->fetch_assoc()) {
?>

<tr>
  <td>#<?php echo $row['id']; ?></td>
  <td>₹<?php echo $row['total']; ?></td>
  <td>
    <form method="POST" action="../actions/update_order.php" style="display:flex; gap:10px;">
      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

      <select name="status">
        <option <?php if($row['status']=='Processing') echo 'selected'; ?>>Processing</option>
        <option <?php if($row['status']=='Shipped') echo 'selected'; ?>>Shipped</option>
        <option <?php if($row['status']=='Delivered') echo 'selected'; ?>>Delivered</option>
      </select>
  </td>

  <td>
      <button type="submit">Update</button>
    </form>
  </td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>