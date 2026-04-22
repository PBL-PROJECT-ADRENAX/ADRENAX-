<?php
include "../includes/session.php";
include "../includes/auth.php";
include('../includes/db.php'); // FIXED PATH

if (!$conn) {
    die("DB connection failed");
}


requireLogin();

// Fetch products safely
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include "../includes/header.php"; ?>

<link rel="stylesheet" href="../assets/css/style.css">

<!-- HERO SECTION -->
<div class="hero">
    <h1>ADRENAX</h1>
    <p>Unleash Your Street Power</p>
    <a href="shop.php"><button>Shop Now</button></a>
</div>

<!-- TRENDING PRODUCTS -->
<h2 style="padding:20px;">🔥 Trending</h2>

<div class="products">

<?php while($row = $result->fetch_assoc()): ?>

    <div class="card">
        <img src="../assets/uploads/<?php echo $row['image']; ?>" alt="product">

        <h3><?php echo $row['name']; ?></h3>
        <p>₹<?php echo $row['price']; ?></p>

        <a href="product.php?id=<?php echo $row['id']; ?>">
            <button>View</button>
        </a>
    </div>

<?php endwhile; ?>

</div>

</body>
</html>