<?php
require_once "../includes/db.php";
require_once "../includes/header.php";
?>

<h1>All Products</h1>

<head>
    <link rel="stylesheet" href="/adrenax/assets/css/style.css">
</head>

<div class="products">

<?php
$result = $conn->query("SELECT * FROM products");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
        <div class="card">
            <img src="/adrenax/assets/uploads/<?php echo htmlspecialchars($row['image']); ?>" 
     alt="product"
     style="width:100%;height:200px;object-fit:cover;">
            <h3><?php echo $row['name']; ?></h3>
            <p>₹<?php echo $row['price']; ?></p>
            <a href="product.php?id=<?php echo $row['id']; ?>">View</a>
        </div>
<?php
    } // ✅ ONLY ONE closing bracket
} else {
    echo "<p>No products found</p>";
}
?>

</div>

<?php require_once "../includes/footer.php"; ?>