<?php
session_start();

// 🔒 ADMIN PROTECTION
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /adrenax/pages/login.php");
    exit();
}

// DB
include($_SERVER['DOCUMENT_ROOT'] . '/adrenax/includes/db.php');
include "includes/header.php";

// 🗑 DELETE USER
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // prevent deleting self
    if ($id != $_SESSION['user_id']) {
        $conn->query("DELETE FROM users WHERE id = $id");
    }

    header("Location: manage_users.php");
    exit();
}

// 📊 FETCH USERS
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<h1>Manage Users</h1>

<table class="admin-table">

<tr>
    <th>ID</th>
    <th>Email</th>
    <th>Role</th>
    <th>Created</th>
    <th>Action</th>
</tr>

<?php while($u = $users->fetch_assoc()): ?>

<tr>
    <td>#<?php echo $u['id']; ?></td>
    <td><?php echo htmlspecialchars($u['email']); ?></td>

    <td>
        <span class="role-badge <?php echo $u['role']; ?>">
            <?php echo ucfirst($u['role']); ?>
        </span>
    </td>

    <td>
        <?php 
        if (!empty($u['created_at'])) {
            $date = new DateTime($u['created_at']);
            echo $date->format('d/m/Y h:i A');
        } else {
            echo "—";
        }
        ?>
    </td>

    <td>
        <?php if ($u['id'] != $_SESSION['user_id']): ?>
            <a href="?delete=<?php echo $u['id']; ?>" 
               onclick="return confirm('Delete this user?')">
               Delete
            </a>
        <?php else: ?>
            <span style="color:#888;">You</span>
        <?php endif; ?>
    </td>

</tr>

<?php endwhile; ?>

</table>

<style>

.admin-table {
    width:100%;
    margin-top:20px;
    border-collapse:collapse;
}

.admin-table th, .admin-table td {
    padding:12px;
    border-bottom:1px solid #333;
}

/* 🔥 ROLE COLORS */
.role-badge {
    padding:5px 10px;
    border-radius:6px;
    font-size:12px;
}

.role-badge.admin {
    background:#ff5252;
    color:white;
}

.role-badge.user {
    background:#9b5cff;
    color:white;
}

a {
    color:#ff5252;
    text-decoration:none;
}

</style>