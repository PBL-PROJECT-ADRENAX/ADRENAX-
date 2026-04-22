<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/adrenax/includes/db.php');

if (!isset($_SESSION['user_id'])) exit();

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$conn->query("DELETE FROM cart WHERE id = $id AND user_id = $user_id");

header("Location: /adrenax/pages/cart.php");