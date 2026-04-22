<?php
session_start();

// 🔥 Show real MySQL errors (REMOVE in production)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// DB connection
include($_SERVER['DOCUMENT_ROOT'] . '/adrenax/includes/db.php');

if (!$conn) {
    die("Database connection failed");
}

// 🔐 User must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /adrenax/login.php");
    exit();
}

$user_id   = (int) $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
$quantity   = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;
$size       = isset($_POST['size']) ? trim($_POST['size']) : 'M';

// ✅ Basic validation
if ($product_id <= 0) {
    die("Invalid product ID");
}

if ($quantity <= 0) {
    $quantity = 1;
}

// 🔍 Check if product already exists in cart
$stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ? AND `size` = ?");
$stmt->bind_param("iis", $user_id, $product_id, $size);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    // ✅ Product exists → UPDATE quantity
    $row = $result->fetch_assoc();
    $newQty = $row['quantity'] + $quantity;

    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    $stmt->bind_param("ii", $newQty, $row['id']);
    $stmt->execute();

} else {

    // ✅ New product → INSERT
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, `size`) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $user_id, $product_id, $quantity, $size);
    $stmt->execute();
}

// 🔁 Redirect to cart page
header("Location: /adrenax/pages/cart.php");
exit();
?>