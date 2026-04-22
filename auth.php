<?php
include_once "session.php";

// 🔒 Check if logged in
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /adrenax/pages/login.php");
        exit();
    }
}

// 🔒 Check admin
function requireAdmin() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: /adrenax/pages/login.php");
        exit();
    }
}
?>