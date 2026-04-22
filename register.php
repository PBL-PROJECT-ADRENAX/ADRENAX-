<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB
include($_SERVER['DOCUMENT_ROOT'] . '/adrenax/includes/db.php');

// REGISTER LOGIC
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        header("Location: /adrenax/pages/login.php");
        exit();
    } else {
        $error = "Registration failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="/adrenax/assets/css/style.css">
</head>

<body>

<div class="auth-wrapper">

    <div class="auth-box">

        <h2>Create Account</h2>

        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>

            <input type="email" name="email" placeholder="Email" required>

            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Register</button>

        </form>

        <p class="auth-link">
            Already have an account? 
            <a href="/adrenax/pages/login.php">Login</a>
        </p>

    </div>

</div>

<style>

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #000, #2b0057);
    color: white;
}

/* CENTER EVERYTHING */
.auth-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* CARD */
.auth-box {
    width: 350px;
    padding: 30px;
    background: #111;
    border-radius: 12px;
    text-align: center;
}

/* INPUTS */
.auth-box input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: none;
    border-radius: 6px;
}

/* BUTTON */
.auth-box button {
    width: 100%;
    padding: 12px;
    background: #9b5cff;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    margin-top: 10px;
}

/* LINK TEXT */
.auth-link {
    margin-top: 15px;
    font-size: 14px;
}

.auth-link a {
    color: #9b5cff;
    text-decoration: none;
}
</style>

</body>
</html>