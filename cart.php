<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /adrenax/login.php");
    exit();
}

include($_SERVER['DOCUMENT_ROOT'] . '/adrenax/includes/db.php');
include "../includes/header.php";
?>

<link rel="stylesheet" href="/adrenax/assets/css/style.css">

<h2 style="padding:20px;">Your Cart</h2>

<div class="cart-container">

<?php
$uid = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT cart.*, products.name, products.price, products.image 
    FROM cart 
    JOIN products ON cart.product_id = products.id 
    WHERE cart.user_id = ?
");

$stmt->bind_param("i", $uid);
$stmt->execute();
$res = $stmt->get_result();

$total = 0;

if ($res && $res->num_rows > 0):

while ($row = $res->fetch_assoc()):
    $total += $row['price'] * $row['quantity'];

    // ✅ CORRECT IMAGE PATH (based on your DB)
    $imagePath = "/adrenax/uploads/" . $row['image'];

    // fallback if missing
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
        $imagePath = "/adrenax/assets/images/no-image.png";
    }
?>

<div class="cart-card">
    <img src="/adrenax/assets/uploads/<?php echo htmlspecialchars($row['image']); ?>" 
     alt="product"
     style="width:100px;height:100px;object-fit:cover;border-radius:8px;">

    <div class="cart-info">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p>₹<?php echo $row['price']; ?></p>

        <!-- ✅ WORKING QTY BUTTONS -->
        <div class="qty-box">
            <button onclick="updateQty(<?php echo $row['id']; ?>, 'dec')">➖</button>

            <span><?php echo $row['quantity']; ?></span>

            <button onclick="updateQty(<?php echo $row['id']; ?>, 'inc')">➕</button>
        </div>

        <!-- REMOVE -->
        <a class="remove-btn" href="/adrenax/actions/remove_cart.php?id=<?php echo $row['id']; ?>">
            Remove
        </a>
    </div>

</div>

<?php endwhile; ?>

</div>

<div class="cart-total">
    <h2>Total: ₹<?php echo $total; ?></h2>
    <a href="/adrenax/pages/checkout.php">
        <button>Checkout</button>
    </a>
</div>

<?php else: ?>

<p style="padding:20px;">Your cart is empty</p>

<?php endif; ?>

<!-- ✅ JS FOR BUTTONS -->
<script>
function updateQty(cartId, action) {
    fetch('/adrenax/actions/update_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'cart_id=' + cartId + '&action=' + action
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "ok") {
            location.reload();
        } else {
            console.log(data);
        }
    });
}
</script>