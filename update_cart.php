<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/adrenax/includes/db.php');

if (!isset($_SESSION['user_id'])) exit();

$user_id = $_SESSION['user_id'];
$cart_id = (int)$_POST['cart_id'];
$action  = $_POST['action'];

// validate ownership
$stmt = $conn->prepare("SELECT id FROM cart WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) exit();

if ($action === "inc") {
    $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE id = $cart_id");
}

if ($action === "dec") {
    $conn->query("UPDATE cart SET quantity = GREATEST(quantity - 1, 1) WHERE id = $cart_id");
}

echo "ok";