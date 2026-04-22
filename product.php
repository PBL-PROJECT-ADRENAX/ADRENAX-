<?php include "../includes/header.php"; 
include('../includes/db.php');

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
?>
<head>
    <link rel="stylesheet" href="/adrenax/assets/css/style.css">
</head>
<div class="product-page">

  <!-- LEFT: IMAGE -->
  <div class="product-image">
    <img src="/adrenax/assets/uploads/<?php echo $product['image']; ?>">
  </div>

  <!-- RIGHT: DETAILS -->
  <div class="product-details">
    <h1><?php echo $product['name']; ?></h1>
    <h2>₹<?php echo $product['price']; ?></h2>

    <form action="/adrenax/actions/add_to_cart.php" method="POST">

    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

    <label>Size</label>
    <select name="size">
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
    </select>

    <label>Quantity</label>
    <input type="number" name="quantity" value="1" min="1">

    <button type="submit">Add to Cart</button>

</form>

    <p class="desc"><?php echo $product['description']; ?></p>
  </div>

</div>