<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /adrenax/pages/login.php");
    exit();
}

include($_SERVER['DOCUMENT_ROOT'] . '/adrenax/includes/db.php');

// 🔥 STATS
$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$orders = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];
$products = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];
$revenue = $conn->query("SELECT SUM(total) as total FROM orders")->fetch_assoc()['total'] ?? 0;

// 🔥 RECENT ORDERS
$recentOrders = $conn->query("
    SELECT orders.*, users.name 
    FROM orders 
    JOIN users ON orders.user_id = users.id 
    ORDER BY orders.id DESC 
    LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="/adrenax/assets/css/style.css">

<style>
body {
    background: linear-gradient(135deg,#0f0c29,#302b63,#24243e);
    color: white;
    font-family: Arial;
}

/* SIDEBAR */
.sidebar {
    width: 220px;
    position: fixed;
    height: 100%;
    background: #111;
    padding: 20px;
}

.sidebar h2 { color:#9b5cff; }

.sidebar a {
    display:block;
    color:white;
    padding:10px;
    margin:10px 0;
    text-decoration:none;
}

.sidebar a:hover { background:#9b5cff; }

/* MAIN */
.main {
    margin-left:240px;
    padding:20px;
}

/* CARDS */
.cards {
    display:grid;
    grid-template-columns: repeat(4,1fr);
    gap:20px;
}

.card {
    background:#111;
    padding:20px;
    border-radius:12px;
    text-align:center;
}

.card h3 { color:#9b5cff; }

/* TABLE */
table {
    width:100%;
    margin-top:30px;
    border-collapse:collapse;
}

table th, table td {
    padding:12px;
    border-bottom:1px solid #333;
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin</h2>
    <a href="/adrenax/admin/dashboard.php">Dashboard</a>
    <a href="/adrenax/admin/add_product.php">Products</a>
    <a href="/adrenax/admin/manage_orders.php">Orders</a>
    <a href="/adrenax/admin/manage_users.php">Users</a>  
    <a href="/adrenax/actions/logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<h1>Dashboard</h1>

<!-- STATS -->
<div class="cards">

<div class="card">
    <h3>Users</h3>
    <h2><?php echo $users; ?></h2>
</div>

<div class="card">
    <h3>Orders</h3>
    <h2><?php echo $orders; ?></h2>
</div>

<div class="card">
    <h3>Products</h3>
    <h2><?php echo $products; ?></h2>
</div>

<div class="card">
    <h3>Revenue</h3>
    <h2>₹<?php echo $revenue; ?></h2>
</div>

</div>

<!-- RECENT ORDERS -->
<h2 style="margin-top:40px;">Recent Orders</h2>

<table>
<tr>
    <th>ID</th>
    <th>User</th>
    <th>Total</th>
    <th>Date</th>
</tr>

<?php while($row = $recentOrders->fetch_assoc()): ?>
<tr>
    <td>#<?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td>₹<?php echo $row['total']; ?></td>
    <td><?php echo $row['created_at']; ?></td>
</tr>
<?php endwhile; ?>

</table>

</div>

</body>
</html>