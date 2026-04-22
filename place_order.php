<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /adrenax/login.php");
    exit();
}

include($_SERVER['DOCUMENT_ROOT'] . '/adrenax/includes/db.php');

$user_id = $_SESSION['user_id'];

// ✅ FETCH CART WITH PRICE
$stmt = $conn->prepare("
    SELECT cart.product_id, cart.quantity, products.price 
    FROM cart 
    JOIN products ON cart.product_id = products.id 
    WHERE cart.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Cart is empty");
}

$total = 0;
$items = [];

while ($row = $result->fetch_assoc()) {
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
    $items[] = $row;
}

// 🔥 DEBUG (remove later)
if ($total <= 0) {
    die("Total calculation failed");
}

// ✅ INSERT ORDER (MAKE SURE COLUMN NAME MATCHES YOUR DB)
$stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $total);
$stmt->execute();

$order_id = $conn->insert_id;

// ✅ INSERT ORDER ITEMS
foreach ($items as $item) {
    $stmt = $conn->prepare("
        INSERT INTO order_items (order_id, product_id, quantity)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("iii", $order_id, $item['product_id'], $item['quantity']);
    $stmt->execute();
}

// ✅ CLEAR CART
$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

// redirect
header("Location: /adrenax/pages/orders.php");
exit();