<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /adrenax/pages/login.php");
    exit();
}

include($_SERVER['DOCUMENT_ROOT'] . '/adrenax/includes/db.php');
include "../includes/header.php";

$uid = $_SESSION['user_id'];

// Fetch orders
$orders = $conn->prepare("
    SELECT * FROM orders 
    WHERE user_id = ? 
    ORDER BY id DESC
");
$orders->bind_param("i", $uid);
$orders->execute();
$res = $orders->get_result();
?>

<link rel="stylesheet" href="/adrenax/assets/css/style.css">

<h2 style="padding:20px;">My Orders</h2>

<div class="orders-container">

<?php if ($res && $res->num_rows > 0): ?>

<?php while ($order = $res->fetch_assoc()): 

    $status = $order['status'] ?? 'Pending';

    // status colors
    $statusColor = '#999';
    if ($status == 'Pending') $statusColor = '#ff9800';
    if ($status == 'Shipped') $statusColor = '#03a9f4';
    if ($status == 'Delivered') $statusColor = '#4caf50';

    $date = new DateTime($order['created_at']);
?>

<div class="order-card">

    <h3>Order #<?php echo $order['id']; ?></h3>

    <p>Total: ₹<?php echo number_format($order['total'], 2); ?></p>

    <p>
        Order placed on 
        <?php echo $date->format('d/m/Y'); ?> 
        at 
        <?php echo $date->format('h:i A'); ?>
    </p>

    <!-- 🔥 STATUS -->
    <p>
        Status: 
        <span style="color:<?php echo $statusColor; ?>; font-weight:bold;">
            <?php echo $status; ?>
        </span>
    </p>

    <!-- 🔥 PROGRESS BAR -->
    <div class="progress-bar">
        <div class="step active">Ordered</div>
        <div class="step <?php if($status=='Shipped' || $status=='Delivered') echo 'active'; ?>">Shipped</div>
        <div class="step <?php if($status=='Delivered') echo 'active'; ?>">Delivered</div>
    </div>

    <!-- 🔥 ORDER ITEMS -->
    <ul class="order-items">
        <?php
        $oid = $order['id'];

        $items = $conn->query("
            SELECT order_items.*, products.name 
            FROM order_items 
            JOIN products ON order_items.product_id = products.id 
            WHERE order_items.order_id = $oid
        ");

        if ($items && $items->num_rows > 0):
            while ($item = $items->fetch_assoc()):
        ?>
            <li>
                <?php echo htmlspecialchars($item['name']); ?> 
                × <?php echo $item['quantity']; ?>
            </li>
        <?php endwhile; else: ?>
            <li>No items found</li>
        <?php endif; ?>
    </ul>

</div>

<?php endwhile; ?>

<?php else: ?>

<p style="padding:20px;">No orders found</p>

<?php endif; ?>

</div>

<style>

.order-card {
    background:#111;
    padding:20px;
    margin:20px;
    border-radius:12px;
    color:white;
}

/* Progress bar */
.progress-bar {
    display:flex;
    gap:10px;
    margin:15px 0;
}

.step {
    flex:1;
    text-align:center;
    padding:8px;
    border-radius:6px;
    background:#333;
    color:#aaa;
    font-size:14px;
}

.step.active {
    background:#9b5cff;
    color:white;
}

.order-items {
    margin-top:10px;
    padding-left:20px;
}

.order-items li {
    margin-bottom:5px;
}

</style>